<?php

namespace frontend\controllers;

use frontend\models\Mantenimientos;
use frontend\models\Novedades;
use frontend\models\NovedadesMantenimientos;
use frontend\models\NovedadesMantenimientosSearch;
use Yii;
use frontend\models\OrdenesTrabajos;
use frontend\models\OrdenesTrabajosRepuestos;
use frontend\models\OrdenesTrabajosSearch;
use frontend\models\OrdenesTrabajosTrabajos;
use frontend\models\Trabajos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\models\Vehiculos;
use kartik\mpdf\Pdf;
use SoapClient;
use SoapHeader;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * OrdenesTrabajosController implements the CRUD actions for OrdenesTrabajos model.
 */
class OrdenesTrabajosController extends Controller
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
                    'index', 'view', 'create', 'update', 'delete', 'formulario-novedades', 'cambiar-estado-novedad', 'formulario-mantenimiento', 'cambiar-estado-mantenimiento', 'cerrar'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'update'
                        ],
                        'roles' => ['p-ordenes-trabajos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-ordenes-trabajos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-ordenes-trabajos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-ordenes-trabajos-eliminar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['formulario-novedades'],
                        'roles' => ['p-ordenes-trabajos-formulario-novedades'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['cambiar-estado-novedad'],
                        'roles' => ['p-ordenes-trabajos-cambiar-estado-novedad'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['formulario-mantenimiento'],
                        'roles' => ['p-ordenes-trabajos-formulario-mantenimiento'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['cambiar-estado-mantenimiento'],
                        'roles' => ['p-ordenes-trabajos-cambiar-estado-mantenimiento'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['cerrar'],
                        'roles' => ['p-ordenes-trabajos-cerrar'],
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
     * Lists all OrdenesTrabajos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdenesTrabajosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrdenesTrabajos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $trabajos = OrdenesTrabajosTrabajos::find()->where(['orden_trabajo_id' => $id])->all();
        $repuestos = OrdenesTrabajosRepuestos::find()->where(['orden_trabajo_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'trabajos' => $trabajos,
            'repuestos' => $repuestos,
        ]);
    }

    /**
     * Creates a new OrdenesTrabajos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idVehiculo = null, $idMantenimiento = null, $idNovedad=null)
    {
        $model = new OrdenesTrabajos();
        if($idVehiculo !== null){
            $model->vehiculo_id = $idVehiculo;
        }
        $ordenes = OrdenesTrabajos::find()->all();

        if ($model->load(Yii::$app->request->post())) {
                $model->consecutivo = count($ordenes) + 1;
                $model->save();
                if ($model->save()) {
                    $medicion = $this->actionConsultaMedicion($model->vehiculo_id);
                    $medicion = Json::decode($medicion);
                    $model->almacenarMedicion($medicion, $model->vehiculo_id);
                    //Yii::$app->notificador->enviarCorreoNuevaOrdenTrabajo($model);
                    if($idMantenimiento !== null){
                        $model->asociarTrabajo($model,$idMantenimiento,null);
                    }
                    if($idNovedad !== null){
                        $model->asociarTrabajo($model,null,$idNovedad);
                    }
                    Yii::$app->session->setFlash("success", 'Orden de trabajo creada con éxito.');
                }
                return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCronOrdenTrabajo($q)
    {
        $auth = sha1("datumgerencia123");
        if ($auth == $q)
            Yii::$app->notificador->enviarCorreoVencimientoOrdenTrabajo();
    }

    /**
     * Updates an existing OrdenesTrabajos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OrdenesTrabajos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash("success", 'Se eliminó la orden de trabajo');

        return $this->redirect(['index']);
    }

    /**
     * Finds the OrdenesTrabajos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrdenesTrabajos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrdenesTrabajos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Consulta las mediciones del Odometro o Horometro dependiendo el tipo de vehiculo
     * @param integer $idVehiculo
     * @return varchar $medicion
     */
    public function actionConsultaMedicion($idVehiculo)
    {
        $vehiculo = Vehiculos::findOne($idVehiculo);

        $username = 'wsdatumpos';
        $password = 'Ddatum_pepe123*';
        $placa = $vehiculo->placa;



        $soapURL = "http://190.143.101.58:2998/VideoData.asmx?WSDL";

        $client = new SoapClient($soapURL, array());

        $auth = array(
            'sUser' => $username,
            'sPassw' => $password,
            'sPlate' => $placa,
        );
        if ($vehiculo->tipo_medicion == 'KMS') {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithOdometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithOdometer($auth)->GetLastPositionWithOdometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Odometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa"=>$vehiculo->placa, "function" => 'odom'];

            return Json::encode($val);
        } else {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithHorometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithHorometer($auth)->GetLastPositionWithHorometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Horometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa"=>$vehiculo->placa, "function" => 'horom'];

            return Json::encode($val);
        }
    }

    /**
     * Metodo que dirige a la vista de las novedades mantenimientos asociadas
     * a un vehículo
     * @param int $vehiculoId
     * @param boolean $cambioEstado
     */
    public function actionFormularioNovedades($idOrden, $cambioEstado = false)
    {
        $orden = OrdenesTrabajos::findOne($idOrden);
        $novedadesMantenimiento = NovedadesMantenimientos::find()->where(['orden_trabajo_id' =>$idOrden])->all();
        if (!$cambioEstado) {
            if ($novedadesMantenimiento != null) {
                $searchModel = new NovedadesMantenimientosSearch();
                $dataProvider = $searchModel->searchNovedadesOrden(Yii::$app->request->queryParams, $idOrden);
                return $this->render('forms/FormNovedades', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $searchModel,
                ]);
            } else {
                Yii::$app->session->setFlash("danger", 'No hay novedades asociadas a la orden ' . $orden->consecutivo);
                return $this->redirect(['index']);
            }
        } else {
            if ($novedadesMantenimiento != null) {
                Yii::$app->session->setFlash("success", 'Novedad actualizada con éxito.');
                $searchModel = new NovedadesMantenimientosSearch();
                $dataProvider = $searchModel->searchNovedadesOrden(Yii::$app->request->queryParams, $idOrden);
                return $this->render('forms/FormNovedades', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $searchModel,
                ]);
            } else {
                Yii::$app->session->setFlash("danger", 'No hay novedades asociadas a la orden.');
                return $this->redirect(['index']);
            }
        }
    }

    /**
     * Método para llenar un select-ajax
     * @param string $q Valor a buscar
     * @param array query resultado 
     * @return array Resultados encontrados según la búsqueda 
     */
    public function actionOrdenesTrabajosList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, consecutivo AS text', 'ordenes_trabajos', 'consecutivo');
    }

    /**
     * Método para cambiar el estado de la novedad
     * @param int $novedadId
     */
    public function actionCambiarEstadoNovedad($novedadId)
    {
        $novedad = NovedadesMantenimientos::findOne($novedadId);
        $novedad->estado = 'Solucionada';
        $novedad->fecha_solucion = date('Y-m-d');
        $novedad->save();
        return $this->redirect(['formulario-novedades', 'idOrden' => $novedad->orden_trabajo_id, 'cambioEstado' => true]);
    }

    public function actionCerrar($idOrden)
    {
        $model = OrdenesTrabajos::findOne($idOrden);
        $model->estado_orden = 0;
        $model->fecha_hora_cierre = date('Y-m-d H:i:s');
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Metodo que dirige a la vista de los mantenimientos asociados
     * a un vehículo
     * @param int $vehiculoId
     * @param boolean $cambioEstado
     */
    public function actionFormularioMantenimientos($vehiculoId, $cambioEstado = false)
    {
        $vehiculo = Vehiculos::findOne(['id' => $vehiculoId]);
        $mantenimientos = Mantenimientos::find()->where(['vehiculo_id' => $vehiculoId])->all();
        if (!$cambioEstado) {
            if ($mantenimientos != null) {
                return $this->render('forms/FormMantenimientos', [
                    'model' => $mantenimientos,
                ]);
            } else {
                Yii::$app->session->setFlash("danger", 'No hay mantenimientos asociados al vehiculo ' . $vehiculo->placa);
                return $this->redirect(['index']);
            }
        } else {
            if ($mantenimientos != null) {
                Yii::$app->session->setFlash("success", 'Mantenimiento actualizado con éxito.');
                return $this->render('forms/FormMantenimientos', [
                    'model' => $mantenimientos,
                ]);
            } else {
                Yii::$app->session->setFlash("danger", 'No hay mantenimiento asociado al vehiculo.');
                return $this->redirect(['index']);
            }
        }
    }

    /**
     * Método para cambiar el estado del mantenimiento
     * @param int $mantenimientoId
     */
    public function actionCambiarEstadoMantenimiento($mantenimientoId)
    {
        $mantenimiento = Mantenimientos::findOne($mantenimientoId);
        $mantenimiento->estado = 'Solucionado';
        $mantenimiento->fecha_hora_ejecucion = date('Y-m-d H:i:s');
        $mantenimiento->save();
        return $this->redirect(['formulario-mantenimientos', 'vehiculoId' => $mantenimiento->vehiculo_id, 'cambioEstado' => true]);
    }

    public function actionPdf($id)
    {
        $this->layout = 'pdf';
        $modelos = $this->findModel($id);
        $trabajos = OrdenesTrabajosTrabajos::find()->where(['orden_trabajo_id' => $id])->all();
        $repuestos = OrdenesTrabajosRepuestos::find()->where(['orden_trabajo_id' => $id])->all();

        $encabezado = 'Orden de Trabajo';

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
            'filename' => "orden-trabajo" . $modelos->consecutivo . ".pdf",
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

    public function actionCrearNovedad ($idTrabajo){
        $trabajo = OrdenesTrabajosTrabajos::findOne($idTrabajo);
        $orden = OrdenesTrabajos::findOne($trabajo->orden_trabajo_id);
        $novedad = new NovedadesMantenimientos();
        $novedad->vehiculo_id = $orden->vehiculo_id;
        $novedad->fecha_hora_reporte = date('Y-m-d H:m:s');
        $novedad->usuario_reporte_id = Yii::$app->user->identity->id;
        $novedad->prioridad_id = 2;
        $novedad->medicion = $orden->medicion;
        $novedad->trabajo_id = $trabajo->trabajo_id;
        $novedad->estado = 'Pendiente';
        $novedad->proviene_de = 'Ordenes de Trabajo';
        $novedad->orden_trabajo_id = $orden->id;
        if($novedad->save()){
            Yii::$app->session->setFlash("success", 'Novedad creada con éxito.');
            $trabajo->delete();
        }
        else {
            print_r($novedad->getErrors());
            die();
        }
        return $this->redirect(['ordenes-trabajos-trabajos/index?idOrden='. $orden->id]);
    }
}
