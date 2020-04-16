<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Cotizaciones;
use frontend\models\CotizacionesRepuestos;
use frontend\models\CotizacionesSearch;
use frontend\models\CotizacionesTrabajos;
use frontend\models\OrdenesCompras;
use frontend\models\OrdenesComprasRepuestos;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CotizacionesController implements the CRUD actions for Cotizaciones model.
 */
class CotizacionesController extends Controller
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
                    'index', 'view', 'create', 'update', 'delete',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'update'
                        ],
                        'roles' => ['p-cotizaciones-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-cotizaciones-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-cotizaciones-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-cotizaciones-eliminar'],
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
     * Lists all Cotizaciones models.
     * @return mixed
     */
    public function actionIndex($idSolicitud)
    {
        $searchModel = new CotizacionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idSolicitud);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idSolicitud' => $idSolicitud
        ]);
    }


    public function actionCotizacionesConsulta()
    {

        $searchModel = new CotizacionesSearch();
        $dataProvider = $searchModel->searchCotizacionesConsulta(Yii::$app->request->queryParams);

        return $this->render('consultas/cotizaciones', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }

    /**
     * Displays a single Cotizaciones model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $trabajos = CotizacionesTrabajos::find()->where(['cotizacion_id' => $id])->all();
        $repuestos = CotizacionesRepuestos::find()->where(['cotizacion_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'trabajos' => $trabajos,
            'repuestos' => $repuestos,
        ]);
    }

    /**
     * Creates a new Cotizaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSolicitud)
    {
        $model = new Cotizaciones();
        $model->asociarItems($idSolicitud);
        if ($model->load(Yii::$app->request->post())) {
            $model->estado = 'Pendiente';
            if ($model->validate()) {
                $model->save();
                if (Yii::$app->request->post()['Cotizaciones']['repuestos'][0]['cantidad'] != null) {
                    $model->asociarRepuestos(Yii::$app->request->post()['Cotizaciones']['repuestos']);
                } else {
                    $model->asociarTrabajos(Yii::$app->request->post()['Cotizaciones']['trabajos']);
                }
                Yii::$app->session->setFlash("success", 'Cotizacion creada con éxito.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'idSolicitud' => $idSolicitud
        ]);
    }

    /**
     * Updates an existing Cotizaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->post()['Cotizaciones']['repuestos'][0]['cantidad'] != null) {
                $model->asociarRepuestos(Yii::$app->request->post()['Cotizaciones']['repuestos']);
            } else {
                $model->asociarTrabajos(Yii::$app->request->post()['Cotizaciones']['trabajos']);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cotizaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Cotizaciones::findOne($id);
        $model->antesDelete();
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'idSolicitud' => $model->solicitud_id]);
    }

    /**
     * Finds the Cotizaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cotizaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cotizaciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAnular($idCotizacion)
    {
        $model = Cotizaciones::findOne($idCotizacion);
        $model->estado = 'Anulada';
        $model->save();
        return $this->redirect(['index', 'idSolicitud' => $model->solicitud_id]);
    }


    public function actionCrearOrdenCompra($idCotizacion)
    {
        $cotizacion = Cotizaciones::findOne($idCotizacion);
        $cotizacion->estado = 'Aprobada';
        $cotizacion->save();
        if (!$cotizacion->save()) {
            print_r($cotizacion->getErrors());
            die();
        }
        $ordenesCompras = OrdenesCompras::find()->all();
        $repuestos = CotizacionesRepuestos::find()->where(['cotizacion_id' => $idCotizacion])->all();
        $ordenCompra = new OrdenesCompras();
        $ordenCompra->fecha_hora_orden = date('Y-m-d H:i:s');
        $ordenCompra->proveedor_id = $cotizacion->proveedor_id;
        $ordenCompra->consecutivo = count($ordenesCompras) + 1;
        $ordenCompra->direccion = $cotizacion->proveedor->direccion;
        $ordenCompra->proviene_de = 'Cotizaciones';
        $ordenCompra->save();
        if (!$ordenCompra->save()) {
            print_r($ordenCompra->getErrors());
            die();
        }
        foreach ($repuestos as $repuesto) {
            $repuestoOrden = new OrdenesComprasRepuestos();
            $repuestoOrden->orden_compra_id = $ordenCompra->id;
            $repuestoOrden->repuesto_id = $repuesto->repuesto_id;
            $repuestoOrden->cantidad = $repuesto->cantidad;
            $repuestoOrden->valor_unitario = $repuesto->valor_unitario;
            $repuestoOrden->tipo_descuento = $repuesto->tipo_descuento;
            $repuestoOrden->descuento_unitario = $repuesto->descuento_unitario;
            $repuestoOrden->tipo_impuesto_id = $repuesto->tipo_impuesto_id;
            $repuestoOrden->observacion = $repuesto->observacion;
            $repuestoOrden->save();
            if (!$repuestoOrden->save()) {
                print_r($repuestoOrden->getErrors());
                die();
            }
        }
        Yii::$app->session->setFlash("success", 'Orden de Compra creada con éxito.');
        return $this->redirect(['ordenes-compras/index']);
    }


    /**
     * Método para llenar un select-ajax
     * @param string $q Valor a buscar
     * @param array query resultado 
     * @return array Resultados encontrados según la búsqueda 
     */
    public function actionCotizacionesList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, id AS text', 'cotizaciones', 'id');
    }


    public function actionPdf($id)
    {
        $this->layout = 'pdf';
        $modelos = $this->findModel($id);
        $trabajos = CotizacionesTrabajos::find()->where(['cotizacion_id' => $id])->all();
        $repuestos = CotizacionesRepuestos::find()->where(['cotizacion_id' => $id])->all();

        $encabezado = 'Cotizacion';

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
            'filename' => "cotizacion.pdf",
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

    public function actionEnviarCorreoProveedor($idCotizacion)
    {
        $cotizacion = Cotizaciones::findOne($idCotizacion);
        Yii::$app->notificador->enviarCorreoProveedor($cotizacion);
        Yii::$app->session->setFlash("success", 'Correo enviado con exito');
                return $this->redirect(['index', 'idSolicitud' => $cotizacion->solicitud_id]);
    }
}
