<?php

namespace frontend\controllers;

use Yii;
use frontend\models\EstadosChecklistConfiguracion;
use frontend\models\EstadosChecklistConfiguracionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstadosChecklistConfiguracionController implements the CRUD actions for EstadosChecklistConfiguracion model.
 */
class EstadosChecklistConfiguracionController extends Controller
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
                        'roles' => ['p-estados-checklist-configuracion-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-estados-checklist-configuracion-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-estados-checklist-configuracion-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-estados-checklist-configuracion-eliminar'],
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
     * Lists all EstadosChecklistConfiguracion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstadosChecklistConfiguracionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EstadosChecklistConfiguracion model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = EstadosChecklistConfiguracion::findOne(['tipo_checklist_id'=>$id]);

        return $this->render('view', [
            'model' => $this->findModel($model),
        ]);
    }

    /**
     * Creates a new EstadosChecklistConfiguracion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EstadosChecklistConfiguracion();

        if ($model->load(Yii::$app->request->post())) {
           
            $request = Yii::$app->request->post();
            $estado_checklists = $request['EstadosChecklistConfiguracion']['estado_checklist_id'];
            $tipo_ck           = $request['EstadosChecklistConfiguracion']['tipo_checklist_id'];
            $validate          = EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id'=>$tipo_ck])->all();
           
            if(!empty($validate)){
                Yii::$app->session->setFlash('danger', "Ya se encuentra creado la configuración para este tipo de checklist.");
            }else{
                foreach ($estado_checklists as $key=>$estados) {
                    $model = new EstadosChecklistConfiguracion();
                    $model->tipo_checklist_id     = $tipo_ck;
                    $model->estado_checklist_id   = $estados;
                    $model->porcentaje_maximo_rej = @$request['EstadosChecklistConfiguracion']['porcentaje_maximo_rej'][$key];
                    $model->cantidad_maxima_crit  = @$request['EstadosChecklistConfiguracion']['cantidad_maxima_crit'][$key];
                    $model->descripcion           = @$request['EstadosChecklistConfiguracion']['descripcion'][$key];
                    if (!$model->save()){
                        echo Yii::$app->ayudante->getErroresSave($model);
                        exit();
                    } 
                }
                return $this->redirect(['view', 'id' => $model->tipo_checklist_id]);

            }   

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EstadosChecklistConfiguracion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = EstadosChecklistConfiguracion::findOne(['tipo_checklist_id'=>$id]);

        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->post();
            $tipo_ck = $request['EstadosChecklistConfiguracion']['tipo_checklist_id'];

            $estado_checklists = $request['EstadosChecklistConfiguracion']['id'];
            foreach ($estado_checklists as $key=>$estados) {
                $model = EstadosChecklistConfiguracion::findOne($estados);
                $model->tipo_checklist_id     = $tipo_ck;
                $model->estado_checklist_id   = @$request['EstadosChecklistConfiguracion']['estado_checklist_id'][$key];
                $model->porcentaje_maximo_rej = @$request['EstadosChecklistConfiguracion']['porcentaje_maximo_rej'][$key];
                $model->cantidad_maxima_crit  = @$request['EstadosChecklistConfiguracion']['cantidad_maxima_crit'][$key];
                $model->descripcion           = @$request['EstadosChecklistConfiguracion']['descripcion'][$key];
                if (!$model->save()){
                    echo Yii::$app->ayudante->getErroresSave($model);
                    exit();
                }
            }
            return $this->redirect(['view', 'id' => $model->tipo_checklist_id]);
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EstadosChecklistConfiguracion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            EstadosChecklistConfiguracion::deleteAll(['tipo_checklist_id'=>$id]);
        } catch (yii\db\Exception $e) {
            Yii::$app->session->setFlash('danger', 'No puede eliminar este registro, se deben eliminar los registros asociados antes.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the EstadosChecklistConfiguracion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EstadosChecklistConfiguracion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EstadosChecklistConfiguracion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
