<?php

namespace frontend\controllers;

use Yii;
use frontend\models\SemaforosTrabajos;
use frontend\models\SemaforosTrabajosSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SemaforosTrabajosController implements the CRUD actions for SemaforosTrabajos model.
 */
class SemaforosTrabajosController extends Controller
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
                        'roles' => ['p-semaforos-trabajos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-semaforos-trabajos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-semaforos-trabajos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-semaforos-trabajos-eliminar'],
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
     * Lists all SemaforosTrabajos models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new SemaforosTrabajosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SemaforosTrabajos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   /*  public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
 */
    /**
     * Creates a new SemaforosTrabajos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SemaforosTrabajos();

        $indicadores = ['Muy Eficiente'=>['color'=>'darkgreen'],'Eficiente'=>['color'=>'green'],'Deficiente'=>['color'=>'orange'],'Muy Deficiente'=>['color'=>'red']];
        
        $semaforos = $this->createBasedIndicators($indicadores);
        
        if ($model->load(Yii::$app->request->post())) {

            $request     = Yii::$app->request;
            $indicads    = $request->post()['SemaforosTrabajos']['indicador'];
            
            foreach($semaforos as $key=>$semaforo){
                $semaforo->indicador = $indicads[$key];
                $semaforo->desde     = $request->post()['SemaforosTrabajos']['desde'][$key];
                $semaforo->hasta     = $request->post()['SemaforosTrabajos']['hasta'][$key];
                if(!$semaforo->save()){
                    echo Yii::$app->ayudante->getErroresSave($model); 
                }
            } 

            return $this->redirect(['index']);
        }
        
        return $this->render('create', [
            'model' => $model,
            'indicadores'=>$indicadores,
            'semaforos' =>$semaforos 
        ]);
    }

    /**
     * Crea la base para los indicadores
     */
    protected static function createBasedIndicators($indicadores){
        $semaforos   = SemaforosTrabajos::find()->all();

        if(empty($semaforos)){
            foreach($indicadores as $key=>$indicador){
                $model            = new SemaforosTrabajos();
                $model->indicador = $key;
                $model->desde     = 0;
                $model->hasta     = 0;
                if(!$model->save()){
                        echo Yii::$app->ayudante->getErroresSave($model);    
                }
            }
            return SemaforosTrabajos::find()->all();
        }

        return $semaforos;
    }
    /**
     * Updates an existing SemaforosTrabajos model.
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
     * Deletes an existing SemaforosTrabajos model.
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
     * Finds the SemaforosTrabajos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SemaforosTrabajos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SemaforosTrabajos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
