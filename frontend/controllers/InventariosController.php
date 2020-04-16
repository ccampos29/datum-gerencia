<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Inventarios;
use frontend\models\InventariosAjustes;
use frontend\models\InventariosRepuestos;
use frontend\models\InventariosSearch;
use frontend\models\RepuestosInventariables;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InventariosController implements the CRUD actions for Inventarios model.
 */
class InventariosController extends Controller
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
                        'roles' => ['p-inventarios-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-inventarios-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-inventarios-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-inventarios-eliminar'],
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
     * Lists all Inventarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inventarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $repuestos = InventariosRepuestos::find()->where(['inventario_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'repuestos' => $repuestos,
        ]);
    }

    /**
     * Creates a new Inventarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inventarios();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                $model->asociarRepuestos(Yii::$app->request->post()['Inventarios']['repuestos']);
                Yii::$app->session->setFlash("success", 'Inventario creado con éxito.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                print_r($model->getErrors());
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Inventarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->asociarRepuestos(Yii::$app->request->post()['Inventarios']['repuestos']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Inventarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->antesDelete();
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Inventarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inventarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCambiarEstado($idInventario)
    {
        $model = Inventarios::findOne($idInventario);
        if ($model->estado == 1) {
            $model->estado = 0;
        } else {
            $model->estado = 1;
        }
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionEnviarCorreoRepuestoInferiorInventario()
    {
        Yii::$app->notificador->enviarCorreoRepuestoInferiorInventario();
    }

    public function actionAjustar($idRepuesto)
    {
        $inventario = InventariosRepuestos::findOne($idRepuesto);
        $repuesto = RepuestosInventariables::findOne(['repuesto_id' => $inventario->repuesto_id]);
        if ($repuesto != null) {
            if ($repuesto->cantidad >= $inventario->cantidad_fisica) {
                $cantidadRestar = $repuesto->cantidad - $inventario->cantidad_fisica;
                $repuesto->cantidad = $inventario->cantidad_fisica;
                $repuesto->save();
                if ($repuesto->save()) {
                    $ajuste = new InventariosAjustes();
                    $ajuste->repuesto_id = $repuesto->repuesto_id;
                    $ajuste->ubicacion_inventario_id = $inventario->inventario->ubicacion_insumo_id;
                    $ajuste->cantidad_repuesto = $cantidadRestar;
                    $ajuste->concepto_id = 8;
                    $ajuste->observaciones = '';
                    $ajuste->fecha_ajuste = date('Y-m-d H:i:s');
                    $ajuste->usuario_id = Yii::$app->user->identity->id;
                    $ajuste->save();
                    if ($ajuste->save()) {
                        Yii::$app->session->setFlash("success", 'Ajuste generado con éxito.');
                    }
                    else {
                        print_r($ajuste->getErrors());
                        die();
                    }
                }
            }
            else {
                $cantidadSumar = $inventario->cantidad_fisica - $repuesto->cantidad;
                $repuesto->cantidad = $inventario->cantidad_fisica;
                $repuesto->save();
                if ($repuesto->save()) {
                    $ajuste = new InventariosAjustes();
                    $ajuste->repuesto_id = $repuesto->repuesto_id;
                    $ajuste->ubicacion_inventario_id = $inventario->inventario->ubicacion_insumo_id;
                    $ajuste->cantidad_repuesto = $cantidadSumar;
                    $ajuste->concepto_id = 3;
                    $ajuste->observaciones = '';
                    $ajuste->fecha_ajuste = date('Y-m-d H:i:s');
                    $ajuste->usuario_id = Yii::$app->user->identity->id;
                    $ajuste->save();
                    if ($ajuste->save()) {
                        Yii::$app->session->setFlash("success", 'Ajuste generado con éxito.');
                    }
                    else {
                        print_r($ajuste->getErrors());
                        die();
                    }
                }
            }
        }
        $repuestos = InventariosRepuestos::find()->where(['inventario_id' => $inventario->inventario_id])->all();
        return $this->render('view', [
            'model' => $this->findModel($inventario->inventario_id),
            'repuestos' => $repuestos,
        ]);
    }

    public function actionCrearRepuesto($idRepuesto){
        $repuesto = InventariosRepuestos::findOne($idRepuesto);
        $inventariable = new RepuestosInventariables();
        $inventariable->repuesto_id = $repuesto->repuesto_id;
        $inventariable->ubicacion_id = $repuesto->inventario->ubicacion_insumo_id;
        $inventariable->cantidad = $repuesto->cantidad_fisica;
        $inventariable->valor_unitario = $repuesto->repuesto->precio;
        $inventariable->cantidad_minima = 1;
        $inventariable->cantidad_maxima = $repuesto->cantidad_fisica;
        $inventariable->save();
        if($inventariable->save()){
            Yii::$app->session->setFlash("success", 'Repuesto añadido con éxito.');
        }
        $repuestos = InventariosRepuestos::find()->where(['inventario_id' => $repuesto->inventario_id])->all();
        return $this->render('view', [
            'model' => $this->findModel($repuesto->inventario_id),
            'repuestos' => $repuestos,
        ]);  
    }
}
