<?php

namespace backend\controllers;

use Yii;
use backend\models\AuthItemChild;
use backend\models\AuthItemChildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controlador que permite administrar el modelo AuthItemChild
 * 
 * El controlador permite realizar las siguientes acciones sobre el modelo AuthItemChild:
 * listar, crear y eliminar
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class AuthItemChildController extends Controller {
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
                        'roles' => ['p-auth-item-child-all'],
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
     * Lista todos los modelos AuthItemChild
     * 
     * @return view la vista 'index'
     */
    public function actionIndex() {
        $searchModel = new AuthItemChildSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Crea un nuevo modelo AuthItemChild
     * 
     * Redirecciona a la vista 'index' con un mensaje del estado de la creación
     * 
     * @return mixed retorna la vista 'index' si se creó; de lo contrario retorna
     * la vista 'create'
     */
    public function actionCreate() {
        $model = new AuthItemChild();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $authManager = Yii::$app->authManager;
            $authManager->addChild($model->padre, $model->hijo);
            Yii::$app->session->setFlash('success', 'Se creó la relación: '
                    . $model->parent . ' y ' . $model->child .' correctamente');
            return $this->redirect(['index']);
        } 
        
        return $this->render('create', [
                'model' => $model,
        ]);
    }
    
    /**
     * Elimina un modelo AuthItemChild
     * 
     * Redirecciona siempre a la vista 'index' con un mensaje del estado de la eliminación
     * 
     * @param string $parent nombre del rol/permiso padre
     * @param string $child nombre del rol/permiso hijo
     * @return mixed redirecciona a la vista 'index'
     */
    public function actionDelete($parent, $child) {
        $model = $this->findModel($parent, $child);
        $modelTmp = $model;
        
        if($model->delete()){
            Yii::$app->session->setFlash("success", 'Se eliminó la relación: '
                    . $modelTmp->parent . ' y ' . $modelTmp->child .' correctamente');
        } else {
            Yii::$app->session->setFlash("error", 'Problema al eliminar la relación');
        }

        return $this->redirect(['index']);
    }

    /**
     * Busca un modelo AuthItemChild
     * 
     * La busqueda la hace basado en el valor de su llave primaria. Si el modelo 
     * no existe, se lanza una excepción HTTP 404.
     * 
     * @param string $parent nombre del rol/permiso padre
     * @param string $child nombre del rol/permiso hijo
     * @return AuthItemChild el modelo AuthItemChild
     * @throws NotFoundHttpException si el modelo no existe
     */
    protected function findModel($parent, $child) {
        if (($model = AuthItemChild::findOne(['parent' => $parent, 'child' => $child])) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }
}
