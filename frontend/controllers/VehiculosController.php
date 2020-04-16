<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Vehiculos;
use frontend\models\VehiculosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Departamentos;
use frontend\models\GruposVehiculos;
use frontend\models\Municipios;
use yii\db\Query;
use frontend\models\ImagenesVehiculos;
use frontend\models\MedicionesSearch;
use frontend\models\VehiculosConductoresSearch;
use yii\filters\AccessControl;
use frontend\models\OtrosGastosSearch;
use frontend\models\OtrosIngresosSearch;
use frontend\models\VehiculosConductores;
use frontend\models\VehiculosDocumentosArchivosSearch;
use frontend\models\VehiculosDocumentosSearch;
use frontend\models\VehiculosGruposVehiculos;
use frontend\models\VehiculosImpuestos;
use frontend\models\VehiculosImpuestosSearch;
use frontend\models\VehiculosImpuetosArchivosSearch;
use frontend\models\VehiculosOtrosDocumentos;
use frontend\models\VehiculosSeguros;
use frontend\models\VehiculosSegurosArchivosSearch;
use frontend\models\VehiculosSegurosSearch;
use kartik\mpdf\Pdf;
use SoapClient;
use SoapHeader;
use yii\base\ErrorException;
use yii\db\IntegrityException;
use yii\helpers\Json;

/**
 * VehiculosController implements the CRUD actions for Vehiculos model.
 */
class VehiculosController extends Controller
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
                        'roles' => ['p-vehiculos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-vehiculos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            
                            'create'
                        ],
                        'roles' => ['p-vehiculos-crear'],
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
                        'roles' => ['p-vehiculos-eliminar'],
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
     * Otros Gastos agrupados por Vehiculo
     */
    public function actionOtrosGastos()
    {

        $searchModel = new OtrosGastosSearch();
        $dataProvider = $searchModel->searchOtrosGastosVehiculo(Yii::$app->request->queryParams);

        return $this->render('consultas/otros_gastos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }

    /**
     * Otros Ingresos agrupados por Vehiculo
     */
    public function actionOtrosIngresos()
    {

        $searchModel = new OtrosIngresosSearch();
        $dataProvider = $searchModel->searchOtrosIngresosVehiculo(Yii::$app->request->queryParams);

        return $this->render('consultas/otros_ingresos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
        ]);
    }

    /**
     * Seguros, Impuestos y Documentos agrupados por Vehiculo
     */
    public function actionGestionDocumental()
    {

        $searchModelSeguros = new VehiculosSegurosSearch();
        $dataProviderSeguros = $searchModelSeguros->searchSegurosVehiculo(Yii::$app->request->queryParams);

        $searchModelImpuestos = new VehiculosImpuestosSearch();
        $dataProviderImpuestos = $searchModelImpuestos->searchImpuestosVehiculo(Yii::$app->request->queryParams);

        $searchModelDocumentos = new VehiculosDocumentosSearch();
        $dataProviderDocumentos = $searchModelDocumentos->searchDocumentosVehiculo(Yii::$app->request->queryParams);


        return $this->render('consultas/gestion_documental', [
            'searchModelSeguros' => $searchModelSeguros,
            'dataProviderSeguros' => $dataProviderSeguros,
            'modelSeguros' => $searchModelSeguros,

            'searchModelImpuestos' => $searchModelImpuestos,
            'dataProviderImpuestos' => $dataProviderImpuestos,
            'modelImpuestos' => $searchModelImpuestos,

            'searchModelDocumentos' => $searchModelDocumentos,
            'dataProviderDocumentos' => $dataProviderDocumentos,
            'modelDocumentos' => $searchModelDocumentos,

        ]);
    }

    /**
     * Lists all Vehiculos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehiculosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'array' => $array
        ]);
    }

    /**
     * Displays a single Vehiculos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /*return $this->render('view', [
            'model' => $this->findModel($id),
            'modelImagenes' => $this->findImagenesVehiculos($id),
        ]);*/

        $modelImagenes  = ImagenesVehiculos::find()->where(['vehiculo_id' => $id])->orderBy(['id'=>SORT_DESC])->one();
        $modelGrupos = VehiculosGruposVehiculos::find()->where(['vehiculo_id' => $id])->all();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'imagenes' => $modelImagenes,
            'grupos' => $modelGrupos,
        ]);
    }


    /**
     * Creates a new Vehiculos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Vehiculos();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model->almacenarImagenes($model->id);
                
                if(isset(Yii::$app->request->post()['Vehiculos']['grupos'])){
                    $model->asociarGrupos($model->id, Yii::$app->request->post()['Vehiculos']['grupos']);
                }
               
                //die();
                Yii::$app->session->setFlash("success", 'Vehiculo registrado con exito.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('danger', 'Algunos campos obligatorios no han sido llenados, por favor revise todas las pestañas para encontrar el error');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Vehiculos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $model->almacenarImagenes($model->id);
            if(isset(Yii::$app->request->post()['Vehiculos']['grupos'])){
                $model->asociarGrupos($model->id, Yii::$app->request->post()['Vehiculos']['grupos']);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionRecorridoVehiculos()
    {

        $searchModel = new VehiculosSearch();
        $dataProvider = $searchModel->searchRecorridoVehiculos(Yii::$app->request->queryParams);

        return $this->render('consultas/trabajo_vehiculos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }
    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionCostosMedicion()
    {

        $searchModel = new VehiculosSearch();
       
        if ($searchModel->load(Yii::$app->request->get())) {
            $request = Yii::$app->request->get()['VehiculosSearch'];
            $dataProvider = $searchModel->searchCostosMedicion(Yii::$app->request->queryParams,$request['fecha_1'],$request['fecha_2'],@$request['placa']);
        }else{
            $dataProvider = $searchModel->searchCostosMedicion(Yii::$app->request->queryParams);
        }
//var_dump($dataProvider);
        return $this->render('consultas/costos_medicion', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }
    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionFlotaConductores()
    {

        $searchModel = new VehiculosConductoresSearch();
        $dataProvider = $searchModel->searchFlotaConductores(Yii::$app->request->queryParams);

        return $this->render('consultas/flota_conductores', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionFlotaMediciones()
    {

        $searchModel = new MedicionesSearch();
        $dataProvider = $searchModel->searchFlotaMediciones(Yii::$app->request->queryParams);

        return $this->render('consultas/flota_mediciones', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Combustibles agrupados por vehiculo y proveedor
     */
    public function actionFlotaGeneral()
    {

        $searchModel = new VehiculosSearch();
        $dataProvider = $searchModel->searchFlotaGeneral(Yii::$app->request->queryParams);

        return $this->render('consultas/flota_general', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Deletes an existing Vehiculos model.
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
            Yii::$app->session->setFlash('success','El registro fue eliminado correctamente.');
            return $this->redirect(['index']);
    
        } catch (IntegrityException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error','No puede eliminar este registro, se deben eliminar los registros asociados antes.');
            return $this->redirect(['index']);
    
        }catch (\Exception $e) {
    
            $transaction->rollBack();
            Yii::$app->session->setFlash('error','No se puede eliminar este registro.');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Vehiculos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vehiculos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vehiculos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Vehiculos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vehiculos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findImagenesVehiculos($id)
    {
        if (($modelImagenes = ImagenesVehiculos::findOne($id)) !== null) {
            return $modelImagenes;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getDepartamentos($idPais)
    {
        $departamentos = Departamentos::find()->where(['pais_id' => $idPais])->all();
        $arrayDepartamentos = [];
        foreach ($departamentos as $departamento) {
            $arrayDepartamentos[] = [
                'id' => $departamento->id,
                'name' => $departamento->nombre
            ];
        };
        return $arrayDepartamentos;
    }

    public function actionDepartamentos()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $idPais = $parents[0];
                $out = self::getDepartamentos($idPais);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Trae los municipios de acuerdo al departamento mandado
     * @param int $idDepartamento
     * @return array $arrayMunicipios
     */
    public function getMunicipios($idDepartamento)
    {
        $municipios = Municipios::find()->where(['departamento_id' => $idDepartamento])->all();
        $arrayMunicipios = [];
        foreach ($municipios as $municipio) {
            $arrayMunicipios[] = [
                'id' => $municipio->id,
                'name' => $municipio->nombre
            ];
        };
        return $arrayMunicipios;
    }


    /**
     * Se usa para el DepDrop de los municipios
     * @return array $out
     */
    public function actionMunicipios()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $idDepartamento = $parents[0];
                $out = self::getMunicipios($idDepartamento);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Método para llenar un select-ajax
     * @param string $q Valor a buscar
     * @param array query resultado 
     * @return array Resultados encontrados según la búsqueda 
     */
    public function actionVehiculosList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, placa AS text', 'vehiculos', 'placa');
    }

    /**
     * Ajax para la carga de los centro de costo en el select2 que esta 
     * en el formulario de Contrato
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionVehiculosEquiposList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select('id, placa AS text')
            ->from('vehiculos')
            ->andFilterWhere(['like', 'placa', $q])
            ->where(['empresa_id' => Yii::$app->user->identity->empresa_id])
            ->andWhere(['vehiculo_equipo' => 1])
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
        return $out;
    }

    public function actionVehiculosEquipos($id){
        $model = Vehiculos::find()->where(['vehiculo_equipo'=>1])->andWhere(['id'=>$id])->all();
        if(!empty($model)){
            return $this->redirect(['vehiculos-equipos/index', 'idv' => $id]);
        }else{
            Yii::$app->session->setFlash('danger','No puede asignar un equipo a este vehiculo.');
            return $this->redirect(['index']);
        }
       
        
    }

    //metodo para asociar medicion

    public function actionPdf($id)
    {
        $this->layout = 'pdf';
        $model = Vehiculos::findOne($id);
        $function = new Vehiculos();
        $arrays=$function->actionConsultaMedicion($model->id);
        $array = json_decode($arrays, True);
        if($array['function']=='odom'){
            $value[0]=$array['valor'];
            $value[1]=$array['fecha'];
        }else{
            $value[0]=round($array['valor']/60);
            $value[1]=$array['fecha'];
        }
        $conductor = VehiculosConductores::find()->where(['vehiculo_id'=>$model->id])->orderBy(['id'=>SORT_DESC])->one();
        $seguros = VehiculosSeguros::find()->where(['vehiculo_id'=>$model->id])->all();
        $documentos = VehiculosOtrosDocumentos::find()->where(['vehiculo_id'=>$model->id])->all();
        $impuestos = VehiculosImpuestos::find()->where(['vehiculo_id'=>$model->id])->all();
        $imagenes  = ImagenesVehiculos::find()->where(['vehiculo_id' => $id])->orderBy(['id'=>SORT_DESC])->one();
        $encabezado = 'Vehiculo: '.$model->placa;
        $grupos = VehiculosGruposVehiculos::find()->where(['vehiculo_id'=>$model->id])->all();
        $i=0;
        if(!empty($grupos)){
            foreach($grupos as $grupo){
                $group[$i] = GruposVehiculos::findOne($grupo->grupo_vehiculo_id)->nombre;
                $i++;
            }
        }else{
            $group='No hay informacion asociada';
        }
        

        $piePagina = '<div class="" style="text-align:right;">{PAGENO}/{nbpg}</div>';

        $content = $this->render('pdf', ['model' => $model, 'seguros' => $seguros, 'documentos'=>$documentos, 'impuetos'=>$impuestos, 'imagenes' => $imagenes, 'grupos'=>$group, 'wservice' => $value, 'conductor'=>$conductor]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => "css/pdf/general.css",
            'filename' => "vehiculo-".$model->id.".pdf",
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
