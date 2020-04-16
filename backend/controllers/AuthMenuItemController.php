<?php

namespace backend\controllers;

use Yii;
use common\models\AuthMenuItem;
use backend\models\AuthMenuItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controlador que permite administrar el modelo AuthMenuItem
 * 
 * El controlador permite realizar las siguientes acciones sobre el modelo AuthMenuItem:
 * listar, crear, ver y eliminar
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class AuthMenuItemController extends Controller {
    /**
     * Leer documentación de Yii2
     * 
     * @link http://www.yiiframework.com/doc-2.0/guide-concept-behaviors.html
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'create', 'view', 'delete'],
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['index', 'create', 'view', 'delete'],
                        'roles' => ['p-auth-menu-item-all'],
                    ],
                ],
            ],            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lista todos los modelos AuthMenuItem
     * 
     * @return view la vista 'index'
     */
    public function actionIndex() {
        $searchModel = new AuthMenuItemSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Permite ver el detalle y actualizar el modelo AuthMenuItem
     * 
     * Redirecciona siempre a la vista 'view'
     * 
     * @param string $id identificador único
     * @return mixed muestra la vista 'view' con los detalles
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Menú actualizado correctamente');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Crea un nuevo modelo AuthMenuItem
     * 
     * Redirecciona a la vista 'view' si se creó correctamente
     * 
     * @return mixed retorna la vista 'view' si se creó; de lo contrario retorna
     * la vista 'create'
     */
    public function actionCreate() {
        $model = new AuthMenuItem;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Menú creado correctamente');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Elimina un modelo AuthMenuItem
     * 
     * Redirecciona siempre a la vista 'index' con un mensaje del estado de la eliminación
     * 
     * @param int $id identificador único
     * @return mixed redirecciona a la vista 'index'
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $modelTmp = $model;
        
        if($model->delete()){
            Yii::$app->session->setFlash("success", 'Se eliminó el menú: '
                    . $modelTmp->name .' correctamente');
        } else {
            Yii::$app->session->setFlash("error", 'Problema al eliminar el menú');
        }
        
        return $this->redirect(['index']);
    }
    
    /**
     * Busca un modelo AuthMenuItem
     * 
     * La busqueda la hace basado en el valor de su llave primaria. Si el modelo 
     * no existe, se lanza una excepción HTTP 404.
     * 
     * @param int $id identificador único
     * @return AuthMenuItem el modelo AuthMenuItem
     * @throws NotFoundHttpException si el modelo no existe
     */
    protected function findModel($id) {
        if (($model = AuthMenuItem::findOne($id)) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }
}
