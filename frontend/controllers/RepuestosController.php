<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Repuestos;
use frontend\models\RepuestosSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RepuestosController implements the CRUD actions for Repuestos model.
 */
class RepuestosController extends Controller
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
                        'roles' => ['p-repuestos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-repuestos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-repuestos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-repuestos-eliminar'],
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
     * Lists all Repuestos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RepuestosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionRepuestosConsulta()
    {
        $searchModel = new RepuestosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/repuestos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel
        ]);
    }

    public function actionUbicacionRepuestosConsulta()
    {
        $searchModel = new RepuestosSearch();
        $dataProvider = $searchModel->searchUbicacionRepuestos(Yii::$app->request->queryParams);

        return $this->render('consultas/ubicacion-insumos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $searchModel
        ]);
    }

    /**
     * Displays a single Repuestos model.
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
     * Creates a new Repuestos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Repuestos();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash("success", 'Repuesto creado con éxito.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing Repuestos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Repuestos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->sePuedeEliminar()) {
            $modelTmp = $model;
            //$model->delete();
            $model->antesDelete();
            $model->delete();
            Yii::$app->session->setFlash("success", 'Se eliminó el Repuesto: '
                . $modelTmp->nombre . ' correctamente');
        } else {
            $detalle = $model->objetosRelacionados();
            Yii::$app->session->setFlash("error", 'El Repuesto ' . $model->nombre .
                " no se puede eliminar porque primero: <br/>" . $detalle);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Repuestos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Repuestos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Repuestos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Ajax para la carga de los repuestos en el select2 que esta 
     * en el formulario de Inventarios Ajustes
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionRepuestosList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, nombre AS text', 'repuestos');
    }

    /**
     * Obtiene el valor del repuesto para ser mostrado en el formulario de asociar
     * insumos y repuestos de esa misma vista en las rutinas
     */
    public function actionObtenerPrecioMultiplicado($idRepuesto, $cantidad)
    { 
        $repuesto = $this->findModel($idRepuesto);
        $valorTotal =  $repuesto->precio * $cantidad;
        return $valorTotal;
    }
    
}
