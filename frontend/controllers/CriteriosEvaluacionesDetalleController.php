<?php

namespace frontend\controllers;

use Yii;
use frontend\models\CriteriosEvaluacionesDetalle;
use frontend\models\CriteriosEvaluacionesDetalleSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CriteriosEvaluacionesDetalleController implements the CRUD actions for CriteriosEvaluacionesDetalle model.
 */
class CriteriosEvaluacionesDetalleController extends Controller
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
                        'roles' => ['p-criterios-evaluaciones-detalle-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-criterios-evaluaciones-detalle-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-criterios-evaluaciones-detalle-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-criterios-evaluaciones-detalle-eliminar'],
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
     * Lists all CriteriosEvaluacionesDetalle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CriteriosEvaluacionesDetalleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CriteriosEvaluacionesDetalle model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $idCriterio)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'idCriterio'=>$idCriterio
        ]);
    }

    /**
     * Creates a new CriteriosEvaluacionesDetalle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idCriterio)
    {
        $model = new CriteriosEvaluacionesDetalle();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,  'idCriterio' => $idCriterio]);
        }

        return $this->render('create', [
            'model' => $model,
            'idCriterio' => $idCriterio
        ]);
    }

    /**
     * Updates an existing CriteriosEvaluacionesDetalle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$idCriterio)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,  'idCriterio' => $idCriterio]);
        }

        return $this->render('update', [
            'model' => $model,
            'idCriterio' => $idCriterio
        ]);
    }

    /**
     * Deletes an existing CriteriosEvaluacionesDetalle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $idCriterio)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index','idCriterio'=>$idCriterio]);
    }

    /**
     * Finds the CriteriosEvaluacionesDetalle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CriteriosEvaluacionesDetalle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CriteriosEvaluacionesDetalle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Ajax para la carga de los centro de costo en el select2 que esta 
     * en el formulario de Contrato
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionDetallesList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query();
        $query->select('id, detalle AS text')
            ->from('criterios_evaluaciones_detalle')
            ->andFilterWhere(['like', 'detalle', $q])
            ->where(['empresa_id' => Yii::$app->user->identity->empresa_id])
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
        return $out;
    }
}
