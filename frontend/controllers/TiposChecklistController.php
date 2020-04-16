<?php

namespace frontend\controllers;

use Yii;
use frontend\models\TiposChecklist;
use frontend\models\TiposChecklistDetalle;
use frontend\models\TiposChecklistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Vehiculos;
use yii\filters\AccessControl;

/**
 * TiposChecklistController implements the CRUD actions for TiposChecklist model.
 */
class TiposChecklistController extends Controller
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
                        'roles' => ['p-tipos-checklist-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-tipos-checklist-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-tipos-checklist-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-tipos-checklist-eliminar'],
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
     * Lists all TiposChecklist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TiposChecklistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TiposChecklist model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TiposChecklist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TiposChecklist();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $request     = Yii::$app->request->post();
            $t_vehiculos = $request["TiposChecklist"]["tipo_vehiculo_id"];

            foreach ($t_vehiculos as $tipoVehi) {
                $tipoChecklistDetalle = new TiposChecklistDetalle();
                $tipoChecklistDetalle->tipo_checklist_id = $model->id;
                $tipoChecklistDetalle->tipo_vehiculo_id  = $tipoVehi;
                if ($tipoChecklistDetalle->validate()) {
                    $tipoChecklistDetalle->save();
                } else {
                    var_dump($tipoChecklistDetalle->errors);
                    exit();
                }
            }

            Yii::$app->session->setFlash('success', 'Tipo de Checklist creado correctamente.');
            return $this->redirect(['index']);
        } else {
            echo Yii::$app->ayudante->getErroresSave($model);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TiposChecklist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $request     = Yii::$app->request->post();
            $t_vehiculos = $request["TiposChecklist"]["tipo_vehiculo_id"];

            $delete_tipos = TiposChecklistDetalle::deleteAll('tipo_checklist_id = :tipo_checklist_id', ['tipo_checklist_id' => $model->id]);

            foreach ($t_vehiculos as $tipoVehi) {
                $tipoChecklistDetalle = new TiposChecklistDetalle();
                $tipoChecklistDetalle->tipo_checklist_id = $model->id;
                $tipoChecklistDetalle->tipo_vehiculo_id  = $tipoVehi;
                if ($tipoChecklistDetalle->validate()) {
                    $tipoChecklistDetalle->save();
                } else {
                    var_dump($tipoChecklistDetalle->errors);
                    exit();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TiposChecklist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (yii\db\Exception $e) {
            Yii::$app->session->setFlash('danger', 'No puede eliminar este registro, se deben eliminar los registros asociados antes.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the TiposChecklist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TiposChecklist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TiposChecklist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @author Jorge
     *
     */
    public function getTipo($idVehiculo)
    {
        $vehiculo = Vehiculos::findOne($idVehiculo)->tipo_vehiculo_id;
        $tiposChecklist = TiposChecklistDetalle::find()->where(['tipo_vehiculo_id' => $vehiculo])->all();
        $arrayTipoChecklist = [];
        foreach ($tiposChecklist as $tipoChecklist) {
            $arrayTipoChecklist[] = [
                'id' => $tipoChecklist->tipo_checklist_id,
                'name' => $tipoChecklist->tipoChecklist->nombre
            ];
        };
        return $arrayTipoChecklist;
    }

    public function actionTipo()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $idVehiculo = $parents[0];
                $out = self::getTipo($idVehiculo);
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
     * Ajax para la carga de los sistemas en el select2 que esta 
     * en el formulario de repuestos
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionTiposChecklistList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, nombre AS text', 'tipos_checklist');
    }


    public function actionObtenerPeriodicidadChecklist($idTipoChecklist)
    {
        $tipoChecklist = TiposChecklist::findOne($idTipoChecklist);
        return json_encode($tipoChecklist->getAttributes());
    }


    public function actionCalcularTiempo($fechaActual, $cantidad, $periodicidad)
    {
        if ($periodicidad == 'Día') {
            $fechaCalculada = date("Y-m-d", strtotime($fechaActual . "+ " . $cantidad . " days"));
        } else if ($periodicidad == 'Hora') {
            $fechaCalculada = date("Y-m-d", strtotime($fechaActual . "+ " . $cantidad . " hours"));
        }
        return ($fechaCalculada);
    }
}
