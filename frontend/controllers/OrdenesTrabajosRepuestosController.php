<?php

namespace frontend\controllers;

use Yii;
use frontend\models\OrdenesTrabajosRepuestos;
use frontend\models\OrdenesTrabajosRepuestosSearch;
use frontend\models\Repuestos;
use frontend\models\RepuestosProveedores;
use frontend\models\TiposImpuestos;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * OrdenesTrabajosRepuestosController implements the CRUD actions for OrdenesTrabajosRepuestos model.
 */
class OrdenesTrabajosRepuestosController extends Controller
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
                        'roles' => ['p-ordenes-trabajos-repuestos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-ordenes-trabajos-repuestos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-ordenes-trabajos-repuestos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-ordenes-trabajos-repuestos-eliminar'],
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
     * Lists all OrdenesTrabajosRepuestos models.
     * @return mixed
     */
    public function actionIndex($idOrden)
    {
        $searchModel = new OrdenesTrabajosRepuestosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idOrden);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idOrden' => $idOrden
        ]);
    }

    /**
     * Displays a single OrdenesTrabajosRepuestos model.
     * @param integer $id
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
     * Creates a new OrdenesTrabajosRepuestos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idOrden)
    {
        $model = new OrdenesTrabajosRepuestos();

        if ($model->load(Yii::$app->request->post())) {
            $model->sumarValorOrdenTrabajo($idOrden, $model->costo_unitario, $model->cantidad);
            $model->save();
            Yii::$app->session->setFlash("success", 'Repuesto agregado con éxito.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'idOrden' => $idOrden
        ]);
    }

    /**
     * Updates an existing OrdenesTrabajosRepuestos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $valorViejo = $model->costo_unitario;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->actualizarValorOrdenTrabajo($model->orden_trabajo_id, $model->costo_unitario,$model->cantidad, $valorViejo);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OrdenesTrabajosRepuestos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = OrdenesTrabajosRepuestos::findOne($id);
        $this->findModel($id)->delete();
        $model->restarValorOrdenTrabajo($model->orden_trabajo_id, $model->costo_unitario,$model->cantidad);

        return $this->redirect(['index', 'idOrden' => $model->orden_trabajo_id]);
    }

    /**
     * Finds the OrdenesTrabajosRepuestos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrdenesTrabajosRepuestos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrdenesTrabajosRepuestos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionConsultaRepuesto($idRepuesto, $idProveedor=null)
    {
        $proveedores = RepuestosProveedores::find()->where(['repuesto_id' => $idRepuesto])->andWhere(['proveedor_id' => $idProveedor])->all();
        foreach ($proveedores as $proveedor){
            $costo_unitario = $proveedor->valor;
            $impuesto = $proveedor->impuesto_id;
            $descuento = $proveedor->descuento_repuesto;
            $tipoDescuento = $proveedor->tipo_descuento;
            $cantidad = 1;
        }
        //$data = json_decode($trabajo, true);
        $data = ['costoUnitario' => $costo_unitario, 'cantidad' => $cantidad, 'impuesto' => $impuesto, 'descuento' => $descuento, 'tipoDescuento' => $tipoDescuento];
        return Json::encode($data);
        }
}
