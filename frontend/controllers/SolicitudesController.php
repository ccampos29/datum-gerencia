<?php

namespace frontend\controllers;

use frontend\models\RepuestosInventariables;
use Yii;
use frontend\models\Solicitudes;
use frontend\models\SolicitudesRepuestos;
use frontend\models\SolicitudesSearch;
use frontend\models\SolicitudesTrabajos;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SolicitudesController implements the CRUD actions for Solicitudes model.
 */
class SolicitudesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index', 'view', 'create', 'update', 'delete', 'anular', 'cerrar', 'aprobar'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'view', 'create', 'update', 'anular', 'cerrar', 'aprobar'
                        ],
                        'roles' => ['p-solicitudes-ver', 'p-solicitudes-crear', 'p-solicitudes-actualizar', 'p-solicitudes-anular', 'p-solicitudes-cerrar', 'p-solicitudes-aprobar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'index'
                        ],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'delete'
                        ],
                        'roles' => ['p-solicitudes-eliminar'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all Solicitudes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SolicitudesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSolicitudesConsulta()
    {

        $searchModel = new SolicitudesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/solicitudes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }

    /**
     * Displays a single Solicitudes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $trabajos = SolicitudesTrabajos::find()->where(['solicitud_id' => $id])->all();
        $repuestos = SolicitudesRepuestos::find()->where(['solicitud_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'trabajos' => $trabajos,
            'repuestos' => $repuestos,
        ]);
    }

    /**
     * Creates a new Solicitudes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idVehiculo = null)
    {
        $model = new Solicitudes();
        if ($idVehiculo != null) {
            $model->vehiculo_id = $idVehiculo;
        }
        $solicitudes = Solicitudes::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->estado = 'Pendiente';
            if ($model->validate()) {
                $model->consecutivo = count($solicitudes) + 1;
                $model->save();
                if (Yii::$app->request->post()['Solicitudes']['repuestos'][0]['cantidad'] != null) {
                    $model->asociarRepuestos(Yii::$app->request->post()['Solicitudes']['repuestos']);
                } else {
                    $model->asociarTrabajos(Yii::$app->request->post()['Solicitudes']['trabajos']);
                }
                Yii::$app->session->setFlash("success", 'Solicitud creada con éxito.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                print_r($model->errors);
                die();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Solicitudes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->post()['Solicitudes']['repuestos'][0]['cantidad'] != null) {
                $model->asociarRepuestos(Yii::$app->request->post()['Solicitudes']['repuestos']);
            } else {
                $model->asociarTrabajos(Yii::$app->request->post()['Solicitudes']['trabajos']);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Solicitudes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->sePuedeEliminar()) {
            $modelTmp = $model;
            //$model->delete();
            $model->antesDelete();
            $model->delete();
            Yii::$app->session->setFlash("success", 'Se eliminó la Solicitud N°: '
                . $modelTmp->consecutivo . ' correctamente');
        } else {
            $detalle = $model->objetosRelacionados();
            Yii::$app->session->setFlash("error", 'La Solicitud N° ' . $model->consecutivo .
                " no se puede eliminar porque primero: <br/>" . $detalle);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Solicitudes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solicitudes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Solicitudes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCerrar($idSolicitud)
    {
        $model = Solicitudes::findOne($idSolicitud);
        $model->estado = 'Cerrada';
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionAnular($idSolicitud)
    {
        $model = Solicitudes::findOne($idSolicitud);
        $model->estado = 'Anulada';
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionAprobar($idSolicitud)
    {
        $model = Solicitudes::findOne($idSolicitud);
        $model->estado = 'Aprobada';
        $model->actualizado_por = Yii::$app->user->identity->id;
        $model->save();
        return $this->redirect(['index']);
    }
    public function actionDescargar($idSolicitud)
    {
        $model = Solicitudes::findOne($idSolicitud);
        $solicitudes = SolicitudesRepuestos::find()->where(['solicitud_id' => $idSolicitud])->all();
        $model->estado = 'Aprobada y Descargada';
        $model->save();
        if ($model->save()) {
            if ($solicitudes != null) {
                foreach ($solicitudes as $solicitud) {
                    $repuesto = RepuestosInventariables::findOne(['repuesto_id' => $solicitud->repuesto_id]);
                    if ($repuesto != null) {
                        if ($repuesto->cantidad >= $solicitud->cantidad) {
                            $repuesto->cantidad = $repuesto->cantidad - $solicitud->cantidad;
                            $repuesto->save();
                            if ($repuesto->save()) {
                                $solicitud->estado = 'Descargada';
                                $solicitud->save();
                                Yii::$app->session->setFlash("success", 'Descargue aprobado');
                            }
                        } else {
                            Yii::$app->session->setFlash("danger", 'Cantidad insuficiente en el inventario');
                        }
                    } else {
                        Yii::$app->session->setFlash("danger", 'Elemento no encontrado en el inventario');
                    }
                }
            }
        }
        return $this->redirect(['index']);
    }

    public function actionDescargarRepuesto($idRepuesto)
    {
        $solicitud = SolicitudesRepuestos::findOne($idRepuesto);
        $repuesto = RepuestosInventariables::findOne(['repuesto_id' => $solicitud->repuesto_id]);
        if ($repuesto != null) {
            if ($repuesto->cantidad >= $solicitud->cantidad) {
                $repuesto->cantidad = $repuesto->cantidad - $solicitud->cantidad;
                $repuesto->save();
                if ($repuesto->save()) {
                    $solicitud->estado = 'Descargada';
                    $solicitud->save();
                    Yii::$app->session->setFlash("success", 'Descargue aprobado');
                    $repuestos = SolicitudesRepuestos::find()->where(['solicitud_id' => $solicitud->solicitud_id, 'estado' => 'Sin Descargue'])->all();
                    if ($repuestos == null) {
                        $model = Solicitudes::findOne($solicitud->solicitud_id);
                        $model->estado = 'Aprobada y Descargada';
                        $model->save();
                    }
                }
            } else {
                Yii::$app->session->setFlash("danger", 'Cantidad insuficiente en el inventario');
            }
        } else {
            Yii::$app->session->setFlash("danger", 'Elemento no encontrado en el inventario');
        }
        $repuestos = SolicitudesRepuestos::find()->where(['solicitud_id' => $solicitud->solicitud_id, 'estado' => 'Sin Descargue'])->all();
        if ($repuestos == null) {
            $model = Solicitudes::findOne($solicitud->solicitud_id);
            $model->estado = 'Aprobada y Descargada';
            $model->save();
        }
        $trabajos = SolicitudesTrabajos::find()->where(['solicitud_id' => $solicitud->solicitud_id])->all();
        $repuestos = SolicitudesRepuestos::find()->where(['solicitud_id' => $solicitud->solicitud_id])->all();
        return $this->render('view', [
            'model' => $this->findModel($solicitud->solicitud_id),
            'trabajos' => $trabajos,
            'repuestos' => $repuestos,
        ]);
    }


    /**
     * Método para llenar un select-ajax
     * @param string $q Valor a buscar
     * @param array query resultado 
     * @return array Resultados encontrados según la búsqueda 
     */
    public function actionSolicitudesList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, id AS text', 'solicitudes', 'id');
    }

    public function actionPdf($id)
    {
        $this->layout = 'pdf';
        $modelos = $this->findModel($id);
        $trabajos = SolicitudesTrabajos::find()->where(['solicitud_id' => $id])->all();
        $repuestos = SolicitudesRepuestos::find()->where(['solicitud_id' => $id])->all();

        $encabezado = 'Solicitud';

        $piePagina = '<div class="" style="text-align:right;">{PAGENO}/{nbpg}</div>';

        $content = $this->render('pdf', [
            'model' => $modelos,
            'trabajos' => $trabajos,
            'repuestos' => $repuestos,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => "css/pdf/general.css",
            'filename' => "solicitud " . $modelos->consecutivo . ".pdf",
            'marginTop' => 20,
            'marginBottom' => 30,
            'marginLeft' => 20,
            'marginRight' => 20,
            'options' => [],
            'methods' => [
                'SetHeader' => [$encabezado],
                'SetFooter' => [$piePagina],
                'SetProtection' => [
                    ['copy', 'print']
                ],
            ],
        ]);

        return $pdf->render();
    }
}
