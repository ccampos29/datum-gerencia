<?php

namespace backend\controllers;

use Yii;
use backend\models\AuthAssignment;
use backend\models\AuthAssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\User;
use yii\filters\VerbFilter;

/**
 * Controlador que permite administrar el modelo AuthAssignment
 * 
 * El controlador permite realizar las siguientes acciones sobre el modelo AuthAssignment:
 * listar, crear y eliminar
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class AuthAssignmentController extends Controller {
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
                'only' => ['index', 'create', 'delete'],
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['index', 'create', 'delete'],
                        'roles' => ['p-auth-assignment-all'],
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
     * Lista todos los modelos AuthAssignment
     * 
     * @return view la vista 'index'
     */
    public function actionIndex() {
        $searchModel = new AuthAssignmentSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Crea un nuevo modelo AuthAssignment
     * 
     * Redirecciona a la vista 'index' con un mensaje del estado de la creación
     * 
     * @return mixed retorna la vista 'index' si se creó; de lo contrario retorna
     * la vista 'create'
     */
    public function actionCreate() {
        $model = new AuthAssignment;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se asigno el permiso/rol: '
                    . $model->item_name . ' al usuario: ' 
                    . User::findOne(['id' => $model->user_id])->username .' correctamente');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                    'model' => $model,
            ]);
        }
    }
 
     /**
     * Elimina un modelo AuthAssignment
     * 
     * Redirecciona siempre a la vista 'index' con un mensaje del estado de la eliminación
     * 
     * @param string $item_name nombre del rol/permiso
     * @param string $user_id identificador único del usuario
     * @return mixed redirecciona a la vista 'index'
     */
    public function actionDelete($item_name, $user_id) {
        $model = $this->findModel($item_name, $user_id);
        $modelTmp = $model;
        
        if($model->delete()){
            Yii::$app->session->setFlash("success", 'Se eliminó el permiso/rol: '
                    . $modelTmp->item_name . ' al usuario: ' 
                    . User::findOne(['id' => $modelTmp->user_id])->username .' correctamente');
        } else {
            Yii::$app->session->setFlash("error", 'Problema al eliminar el permiso/rol');
        }

        return $this->redirect(['index']);
    }

    /**
     * Busca un modelo AuthAssignment
     * 
     * La busqueda la hace basado en el valor de su llave primaria. Si el modelo 
     * no existe, se lanza una excepción HTTP 404.
     * 
     * @param string $item_name nombre del rol/permiso
     * @param string $user_id identificador único del usuario
     * @return AuthAssignment el modelo AuthAssignment
     * @throws NotFoundHttpException si el modelo no existe
     */
    protected function findModel($item_name, $user_id) {
        if (($model = AuthAssignment::findOne(['item_name' => $item_name, 'user_id' => $user_id])) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }
}
