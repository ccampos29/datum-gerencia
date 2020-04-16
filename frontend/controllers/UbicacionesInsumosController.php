<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UbicacionesInsumos;
use frontend\models\UbicacionesInsumosSearch;
use frontend\models\UbicacionesInsumosUsuarios;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UbicacionesInsumosController implements the CRUD actions for UbicacionesInsumos model.
 */
class UbicacionesInsumosController extends Controller
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
                        'roles' => ['p-ubicaciones-insumos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-ubicaciones-insumos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-ubicaciones-insumos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-ubicaciones-insumos-eliminar'],
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
     * Lists all UbicacionesInsumos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UbicacionesInsumosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UbicacionesInsumos model.
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
     * Creates a new UbicacionesInsumos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UbicacionesInsumos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $usuarios = Yii::$app->request->post()['UbicacionesInsumos']['usuario_id'];
            
            if(!empty($usuarios)){
                foreach($usuarios as $usuario){
                    $ubicacion_usuario = new UbicacionesInsumosUsuarios();
                    $ubicacion_usuario->usuario_id = $usuario;
                    $ubicacion_usuario->ubicacion_insumo_id = $model->id;
                    if(!$ubicacion_usuario->save()){
                        echo Yii::$app->ayudante->getErroresSave($ubicacion_usuario);
                        return;
                    }
                }
            }
            
            
            Yii::$app->session->setFlash('success', 'Ubicación de Insumo creado correctamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            echo Yii::$app->ayudante->getErroresSave($model);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UbicacionesInsumos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $usuarios = Yii::$app->request->post()['UbicacionesInsumos']['usuario_id'];

            $delete_tipos = UbicacionesInsumosUsuarios::deleteAll('ubicacion_insumo_id = :ubicacion_insumo_id',['ubicacion_insumo_id'=>$id]);

            if(!empty($usuarios)){
                foreach($usuarios as $usuario){
                    $ubicacion_usuario = new UbicacionesInsumosUsuarios();
                    $ubicacion_usuario->usuario_id = $usuario;
                    $ubicacion_usuario->ubicacion_insumo_id = $model->id;
                    if(!$ubicacion_usuario->save()){
                        echo Yii::$app->ayudante->getErroresSave($ubicacion_usuario);
                        return;
                    }
                }
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UbicacionesInsumos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
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
     * Finds the UbicacionesInsumos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UbicacionesInsumos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UbicacionesInsumos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Ajax para la carga de las ubicaciones en el select2 que esta 
     * en el formulario de Inventarios Ajustes
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionUbicacionesInsumosList($q = null, $id = null) {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, nombre AS text', 'ubicaciones_insumos');
    }
}
