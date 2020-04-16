<?php

namespace frontend\controllers;

use Yii;
use frontend\models\CalificacionesChecklist;
use frontend\models\CalificacionesChecklistSearch;
use frontend\models\Checklist;
use frontend\models\ImagenesChecklist;
use frontend\models\NovedadesChecklist;
use Swift_TransportException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalificacionesChecklistController implements the CRUD actions for CalificacionesChecklist model.
 */
class CalificacionesChecklistController extends Controller
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
                        'roles' => ['p-calificaciones-checklist-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-calificaciones-checklist-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-calificaciones-checklist-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-calificaciones-checklist-eliminar'],
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
     * Lists all CalificacionesChecklist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalificacionesChecklistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CalificacionesChecklist model.
     * @param string $id
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
     * Creates a new CalificacionesChecklist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idChecklist,$idv,$idTipo)
    {
        $model = new CalificacionesChecklist();
        $null=0;
        if ($model->load(Yii::$app->request->post())) {
            foreach (Yii::$app->request->post()['CalificacionesChecklist']['novedadesCalificadas'] as $key) {
                foreach ($key as $k) {
                    if($k==null){
                        $null++;
                    }
                    $array[] = [intval($k)];
                }
            }
            if($null==0 || true){
                foreach (Yii::$app->request->post()['CalificacionesChecklist']['novedadesCalificadas'] as $key) {
                    foreach ($key as $k) {
                        $array[] = [intval($k)];
                    }

                    $model->almacenarImagenes($idChecklist);
                    $model->asociarCalificacion($key);
                    $model->asociarNovedadesMantenimientos($key);
                    
                }
                try {
                    Yii::$app->notificador->enviarCorreoenviarCorreoNuevoChecklist($idChecklist);
                }
                catch(Swift_TransportException $exception) {
                    Yii::$app->session->setFlash("danger", 'Se intentara nuevamente el envio del email');
                    Yii::$app->notificador->enviarCorreoenviarCorreoNuevoChecklist($idChecklist);
                }
                Yii::$app->session->setFlash("success", 'Calificacion generada con éxito.');
                return $this->redirect(['checklist/calification/', 'id'=> $idChecklist]);
            }else{
                Yii::$app->session->setFlash("danger", 'Debe completar todas las calificaciones antes de proceder.'); 
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'idChecklist' => $idChecklist,
            'idv' => $idv,
            'idTipo' => $idTipo,
        ]);
    }

    /**
     * Updates an existing CalificacionesChecklist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing CalificacionesChecklist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CalificacionesChecklist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CalificacionesChecklist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CalificacionesChecklist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
