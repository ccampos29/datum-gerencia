<?php

namespace frontend\controllers;

use Exception;
use frontend\models\CalificacionesChecklist;
use Yii;
use frontend\models\Checklist;
use frontend\models\ChecklistSearch;
use frontend\models\EstadosChecklistConfiguracion;
use frontend\models\GruposNovedades;
use frontend\models\ImagenesChecklist;
use frontend\models\ImagenesCombustibles;
use frontend\models\ImagenesVehiculos;
use frontend\models\NovedadesChecklist;
use frontend\models\NovedadesTiposChecklist;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Vehiculos;
use frontend\models\VehiculosSeguros;
use kartik\mpdf\Pdf;
use SoapClient;
use yii\helpers\Json;
use SoapHeader;
use yii\db\IntegrityException;
use yii\filters\AccessControl;

/**
 * ChecklistController implements the CRUD actions for Checklist model.
 */
class ChecklistController extends Controller
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
                    'index', 'view', 'create', 'update', 'delete', 'calification'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'update'
                        ],
                        'roles' => ['p-checklist-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-checklist-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-checklist-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-checklist-eliminar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['calification'],
                        'roles' => ['p-checklist-calification']
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
     * Lists all Checklist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChecklistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionConsulta()
    {
        $model = new ChecklistSearch();

        $searchModel = new ChecklistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    /**
     * Displays a single Checklist model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelImagenes  = ImagenesChecklist::find()->where(['checklist_id' => $id])->orderBy(['id'=>SORT_DESC])->one();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'imagenes' => $modelImagenes
        ]);
    }
    /**
     * Displays a single Checklist model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCalification($id)
    {
        $model = CalificacionesChecklist::find()->where(['checklist_id' => $id])->all();
        $imagenes = ImagenesChecklist::find()->where(['checklist_id' => $id])->all();

        if (!empty($model)) {
            return $this->render('calification', [
                'model' => $this->findModel($id),
                'value' => 1,
            ]);
        } else {
            return $this->render('calification', [
                'model' => $this->findModel($id),

                //'imagenes' => $imagenes
            ]);
        }
    }

    /**
     * Creates a new Checklist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Checklist();
        $i = 0;
        $j = 0;
        if ($model->load(Yii::$app->request->post())) {
            $model->consecutivo = count(Checklist::find()->all()) + 1;
            $novedadesTiposChecklist = NovedadesTiposChecklist::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->all();
            if (empty(EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->all())) {
                $model->delete();
                Yii::$app->session->setFlash('danger', 'Se deben configurar los estados del para el tipo del checklist ' . $model->tipoChecklist->nombre . ' antes de proceder. No se guardo el checklist.');
                return $this->redirect(['checklist/index']);
            }
            if (!empty($novedadesTiposChecklist)) {
                if (count($novedadesTiposChecklist) < (int) EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->andWhere(['estado_checklist_id' => 4])->one()->cantidad_maxima_crit) {
                    $model->delete();
                    Yii::$app->session->setFlash('danger', 'La cantidad maxima configurada para los estados del checklist rechazado/critico supera el numero de novedades (' . count($novedadesTiposChecklist) . ') que tiene este tipo de checklist, por favor, cambie la configuracion de los estados para el tipo de checklist ' . $model->tipoChecklist->nombre . ', no se guardo el checklist.');
                    return $this->redirect(['checklist/index']);
                }
                foreach ($novedadesTiposChecklist as $noveTipo) {
                    $novedadesChecklist = NovedadesChecklist::find()->where(['novedad_id' => $noveTipo->novedad_id])->all();
                    foreach ($novedadesChecklist as $noveCheck) {
                        if (empty($noveCheck->calificacion)) {
                            $array[] = $noveCheck->novedad->nombre;
                            $i++;
                        }
                        if ($noveCheck->calificacion != 1 && (empty($noveCheck->trabajo) || empty($noveCheck->prioridad))) {
                            $array[] = $noveCheck->novedad->nombre;
                            $i++;
                        }
                    }
                }
                if ($i > 0 || $j>0) {
                    $model->delete();
                    Yii::$app->session->setFlash('danger', 'Se deben adicionar todos los estados, los trabajos y las prioridades a las novedades ' . implode(', ', array_unique($array)) . ' seleccionadas para este tipo de checklist antes de proceder. No se guardo el checklist.');
                    return $this->redirect(['checklist/index']);
                }
                if ($model->save()) {
                    $medicion = $this->actionConsultaMedicion($model->vehiculo_id);
                    $medicion = Json::decode($medicion);
                    $model->almacenarMedicion($medicion, $model->vehiculo_id);
                    Yii::$app->session->setFlash("success", 'Checklist generado con exito.');
                    return $this->redirect(['calificaciones-checklist/create', 'idChecklist' => $model->id, 'idv' => $model->vehiculo_id, 'idTipo' => $model->tipo_checklist_id]);
                } else {
                    echo Yii::$app->ayudante->getErroresSave($model);
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Debe asignar al menos una novedad para el tipo de checklist ' . $model->tipoChecklist->nombre . ' y adicionarle los detalles antes de proceder. No se guardo el checklist.');
                return $this->redirect(['checklist/index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing Checklist model.
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
     * Deletes an existing Checklist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->findModel($id)->antesDelete();
            $this->findModel($id)->delete();
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'El registro fue eliminado correctamente.');
            return $this->redirect(['index']);
        } catch (IntegrityException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'No puede eliminar este registro, se deben eliminar los registros asociados antes.');
            return $this->redirect(['index']);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'No se puede eliminar este registro.');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Checklist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Checklist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Checklist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /*
    * Metodo que permite la consulta de una medicion via web service.
    */
    public function actionConsultaMedicion($idVehiculo)
    {
        $vehiculo = new Vehiculos;

        $vehiculo = Vehiculos::findOne($idVehiculo);
        $username = 'wsdatumpos';
        $password = 'Ddatum_pepe123*';
        $placas = $vehiculo->placa;
        ini_set('default_socket_timeout', 60);
        $soapURL = "http://190.143.101.58:2998/VideoData.asmx?WSDL";

        $client = new SoapClient($soapURL, array());

        $auth = array(
            'sUser' => $username,
            'sPassw' => $password,
            'sPlate' => $placas,
        );

        if ($vehiculo->tipo_medicion == 'KMS') {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithOdometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithOdometer($auth)->GetLastPositionWithOdometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Odometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa" => $vehiculo->placa, "function" => 'odom'];

            return Json::encode($val);
        } else {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithHorometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithHorometer($auth)->GetLastPositionWithHorometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Horometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa" => $vehiculo->placa, "function" => 'horom'];

            return Json::encode($val);
        }
    }

    public function actionAsociarEstados($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            Yii::$app->session->setFlash("success", 'Estado actualizado con exito.');
        }
        return $this->render('calification', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionEnvioEmailSiguienteChecklist()
    {
        foreach (Checklist::find()->all() as $key) {
            $medicion = $this->actionConsultaMedicion($key->vehiculo_id);
            $medicion = Json::decode($medicion);
            Yii::$app->notificador->enviarCorreoSiguienteChecklist($key, $medicion);
        }
    }

    public function actionPdf($id)
    {
        $this->layout = 'pdf';
        $model = Checklist::findOne($id);
        $checklist = Checklist::find()->where(['vehiculo_id' => $model->vehiculo->id])->all();
        $calificacion = CalificacionesChecklist::find()->where(['checklist_id' => $id])->all();
        if ($model->id > 1) {
            foreach ($checklist as $check) {

                $array[] = $check->id;
                if ($check->id == $model->id) {
                    try {
                        $var = $array[count($array) - 2];
                    } catch (Exception $ex) {
                        $var = 0;
                    }
                }
            }
        }
        $imagen_vehiculo  = ImagenesVehiculos::find()->where(['vehiculo_id' => $model->vehiculo->id])->orderBy(['id'=>SORT_DESC])->one();

        if(!empty($imagen_vehiculo)){
            $imagen_vehiculo = Yii::$app->urlManager->createUrl('../..' . Yii::$app->params['rutaImagenesVehiculos'].'vehiculo'.$imagen_vehiculo->vehiculo_id.'/'.$imagen_vehiculo->nombre_archivo);
        }

        $estadosConfigurados = EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->all();
        if ($var > 0) {
            $checklistPast = Checklist::findOne($var);
            $calificacionPast = CalificacionesChecklist::find()->where(['checklist_id' => $var])->all();
        } else {
            $checklistPast = 0;
            $calificacionPast = 0;
        }
        
        $novedad = NovedadesChecklist::find()->all();
        $seguros = VehiculosSeguros::find()->where(['vehiculo_id' => $model->vehiculo->id])->all();


        $encabezado = 'Calificacion del Checklist Nro: ' . $model->id;

        $piePagina = '<div class="" style="text-align:right;">{PAGENO}/{nbpg}</div>';

        $content = $this->render('pdf', ['model' => $model, 'checklist' => $checklistPast, 'calificacion' => $calificacion, 'calificacionPast' => $calificacionPast, 'novedad' => $novedad, 'seguros' => $seguros, 'estadosConfigurados' => $estadosConfigurados,'imagen'=>$imagen_vehiculo]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => "css/pdf/general.css",
            'filename' => "calificacion-del-checklist-" . $model->id . ".pdf",
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

    /**
     * Ajax para la carga de los checklist en el select2 que esta 
     * en el formulario de Checklist
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionChecklistList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, id AS text', 'checklist', 'id');
    }
}
