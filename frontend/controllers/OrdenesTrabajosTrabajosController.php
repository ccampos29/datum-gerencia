<?php

namespace frontend\controllers;

use frontend\models\OrdenesTrabajos;
use Yii;
use frontend\models\OrdenesTrabajosTrabajos;
use frontend\models\OrdenesTrabajosTrabajosSearch;
use frontend\models\PropiedadesTrabajos;
use frontend\models\TiposMantenimientos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * OrdenesTrabajosTrabajosController implements the CRUD actions for OrdenesTrabajosTrabajos model.
 */
class OrdenesTrabajosTrabajosController extends Controller
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
                        'roles' => ['p-ordenes-trabajos-trabajos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-ordenes-trabajos-trabajos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-ordenes-trabajos-trabajos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-ordenes-trabajos-trabajos-eliminar'],
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
     * Lists all OrdenesTrabajosTrabajos models.
     * @return mixed
     */
    public function actionIndex($idOrden)
    {
        $searchModel = new OrdenesTrabajosTrabajosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idOrden);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idOrden' => $idOrden
        ]);
    }

    /**
     * Displays a single OrdenesTrabajosTrabajos model.
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
     * Creates a new OrdenesTrabajosTrabajos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idOrden)
    {
        $model = new OrdenesTrabajosTrabajos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->sumarValorOrdenTrabajo($idOrden, $model->costo_mano_obra, $model->cantidad);
            Yii::$app->session->setFlash("success", 'Trabajo agregado con éxito.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'idOrden' => $idOrden
        ]);
    }

    /**
     * Updates an existing OrdenesTrabajosTrabajos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $valorViejo = $model->costo_mano_obra;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->actualizarValorOrdenTrabajo($model->orden_trabajo_id, $model->costo_mano_obra, $valorViejo, $model->cantidad);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OrdenesTrabajosTrabajos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = OrdenesTrabajosTrabajos::findOne($id);
        $this->findModel($id)->delete();
        $model->restarValorOrdenTrabajo($model->orden_trabajo_id, $model->costo_mano_obra, $model->cantidad);

        return $this->redirect(['index', 'idOrden' => $model->orden_trabajo_id]);
    }

    /**
     * Finds the OrdenesTrabajosTrabajos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrdenesTrabajosTrabajos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrdenesTrabajosTrabajos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionConsultaTrabajo($idTrabajo, $idVehiculo, $busca=null)
    {
        $vehiculo = Vehiculos::findOne($idVehiculo);
        $trabajo = Trabajos::findOne($idTrabajo);
        $propiedad = PropiedadesTrabajos::findOne(['trabajo_id' => $idTrabajo, 'tipo_vehiculo_id' => $vehiculo->tipo_vehiculo_id]);
        if(!empty($propiedad) || $busca == null){
        $manoObra = $propiedad->costo_mano_obra;
        $cantidad = $propiedad->cantidad_trabajo;
        //$data = json_decode($trabajo, true);
        $data = ['tipoMantenimiento' => $trabajo->tipo_mantenimiento_id, 'manoObra' => $manoObra, 'cantidad' => $cantidad];
        return Json::encode($data);
        }
        else {
            $data = ['tipoMantenimiento' => 'Sin datos para el tipo de vehiculo', 'manoObra' => 'Sin datos para el tipo de vehiculo', 'cantidad' => 'Sin datos para el tipo de vehiculo'];
        return Json::encode($data);
        }
    }

    public function actionConsultaTipoMantenimiento($idTipoMantenimiento)
    {
        $tipoMantenimiento = TiposMantenimientos::findOne($idTipoMantenimiento);
        if(!empty($tipoMantenimiento)){
        //$data = json_decode($trabajo, true);
        $data = ['nombre' => $tipoMantenimiento->nombre];
        return Json::encode($data);
        }
        else {
            $data = ['nombre' => 'Sin datos para el tipo de vehiculo'];
            return Json::encode($data);
        }
    }
}
