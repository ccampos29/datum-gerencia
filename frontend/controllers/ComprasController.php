<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Compras;
use frontend\models\ComprasRepuestos;
use frontend\models\ComprasSearch;
use frontend\models\OrdenesCompras;
use frontend\models\RepuestosInventariables;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComprasController implements the CRUD actions for Compras model.
 */
class ComprasController extends Controller
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
                        'roles' => ['p-compras-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-compras-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-compras-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-compras-eliminar'],
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
     * Lists all Compras models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComprasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Compras model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $repuestos = ComprasRepuestos::find()->where(['compra_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'repuestos' => $repuestos,
        ]);
    }

    /**
     * Creates a new Compras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idOrdenCompra=null)
    {
        $model = new Compras();
        if($idOrdenCompra != null){
            $compras = Compras::find()->all();
            $orden = OrdenesCompras::findOne($idOrdenCompra);
            $model->proveedor_id = $orden->proveedor_id;
            $model->fecha_hora_hoy = date('Y-m-d H:i');
            $model->numero_remision = count($compras) + 1;
            $model->asociarItems($orden);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $model->asociarRepuestos(Yii::$app->request->post()['Compras']['repuestos']);
            RepuestosInventariables::sumarCompra($model->id);
            if($idOrdenCompra != null){
                $orden->estado = 0;
                $orden->save();
            }
            Yii::$app->session->setFlash("success", 'Compra creada con éxito.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Compras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->asociarRepuestos(Yii::$app->request->post()['Compras']['repuestos']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Compras model.
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
     * Finds the Compras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Compras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compras::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCancelar($idCompra)
    {
        $model = Compras::findOne($idCompra);
        $model->estado = 0;
        $model->save();
        return $this->redirect(['index']);
    }
}
