<?php

namespace backend\controllers;

use Yii;
use backend\models\AuthItem;
use backend\models\AuthItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controlador que permite administrar el modelo AuthItem
 * 
 * El controlador permite realizar las siguientes acciones sobre el modelo AuthItem:
 * listar, crear, ver y eliminar
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class AuthItemController extends Controller {
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
                        'roles' => ['p-auth-item-all'],
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
     * Lista todos los modelos AuthItem
     * 
     * @return view la vista 'index'
     */
    public function actionIndex() {
        $searchModel = new AuthItemSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Permite ver el detalle y actualizar el modelo AuthItem
     * 
     * Redirecciona siempre a la vista 'view'
     * 
     * @param string $id identificador único
     * @return mixed muestra la vista 'view' con los detalles
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $model->validate();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Rol/Permiso actualizado correctamente');
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Crea un nuevo modelo AuthItem
     * 
     * Redirecciona a la vista 'view' si se creó correctamente
     * 
     * @return mixed retorna la vista 'view' si se creó; de lo contrario retorna
     * la vista 'create'
     */
    public function actionCreate() {
        $model = new AuthItem;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Rol/Permiso creado correctamente');
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Elimina un modelo AuthItem
     * 
     * Redirecciona siempre a la vista 'index' con un mensaje del estado de la eliminación
     * 
     * @param string $id identificador único
     * @return mixed redirecciona a la vista 'index'
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
    
        if($model->sePuedeEliminar()){
            $modelTmp = $model;
            $model->delete();
            Yii::$app->session->setFlash("success", 'Se eliminó el rol/permiso: '
                    . $modelTmp->name .' correctamente');
        } else {
            $detalle = $model->objetosRelacionados();
            Yii::$app->session->setFlash("error", $model->name." no se puede "
                    . "eliminar porque se encuentra relacionado con: <br/>". $detalle);
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Busca un modelo AuthItem
     * 
     * La busqueda la hace basado en el valor de su llave primaria. Si el modelo 
     * no existe, se lanza una excepción HTTP 404.
     * 
     * @param string $id identificador único
     * @return AuthItem el modelo AuthItem
     * @throws NotFoundHttpException si el modelo no existe
     */
    protected function findModel($id) {
        if (($model = AuthItem::findOne($id)) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }
}
