<?php

namespace frontend\controllers;

use frontend\models\Compras;
use frontend\models\ComprasRepuestos;
use Yii;
use frontend\models\OrdenesCompras;
use frontend\models\OrdenesComprasRepuestos;
use frontend\models\OrdenesComprasSearch;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdenesComprasController implements the CRUD actions for OrdenesCompras model.
 */
class OrdenesComprasController extends Controller
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
                    'index', 'view', 'create', 'update', 'delete', 'guardar',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'update'
                        ],
                        'roles' => ['p-ordenes-compras-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-ordenes-compras-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-ordenes-compras-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-ordenes-compras-eliminar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['guardar'],
                        'roles' => ['p-ordenes-compras-guardar'],
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
     * Lists all OrdenesCompras models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdenesComprasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrdenesCompras model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $repuestos = OrdenesComprasRepuestos::find()->where(['orden_compra_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'repuestos' => $repuestos,
        ]);
    }

    /**
     * Creates a new OrdenesCompras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrdenesCompras();
        $ordenes = OrdenesCompras::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->proviene_de = 'Manualmente';
            $model->consecutivo = count($ordenes) + 1;
            $model->estado = 1;
            if (!$model->save()) {
                print_r($model->getErrors());
                die();
            }
            $model->asociarRepuestos(Yii::$app->request->post()['OrdenesCompras']['repuestos']);
            Yii::$app->session->setFlash("success", 'Orden de compra creada con éxito.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OrdenesCompras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->asociarRepuestos(Yii::$app->request->post()['OrdenesCompras']['repuestos']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OrdenesCompras model.
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
     * Finds the OrdenesCompras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrdenesCompras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrdenesCompras::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGuardar($idOrdenCompra)
    {
        $model = OrdenesCompras::findOne($idOrdenCompra);
        $model->estado = 0;
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionCrearCompra($idOrdenCompra)
    {
        $orden = OrdenesCompras::findOne($idOrdenCompra);
        $repuestos = OrdenesComprasRepuestos::find()->where(['orden_compra_id' => $orden->id])->all();
        if ($repuestos != null) {
            return $this->redirect(['compras/create?idOrdenCompra='.$idOrdenCompra]);
        } else {
            Yii::$app->session->setFlash("danger", 'La Orden de Compra no tiene insumos asociados.');
            return $this->redirect(['index']);
        }
    }

    public function actionPdf($id)
    {
        $this->layout = 'pdf';
        $modelos = $this->findModel($id);
        $repuestos = OrdenesComprasRepuestos::find()->where(['orden_compra_id' => $id])->all();

        $encabezado = 'Orden de Compra';

        $piePagina = '<div class="" style="text-align:right;">{PAGENO}/{nbpg}</div>';

        $content = $this->render('pdf', [
            'model' => $modelos,
            'repuestos' => $repuestos,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => "css/pdf/general.css",
            'filename' => "orden-compra" . $modelos->consecutivo . ".pdf",
            'marginTop' => 20,
            'marginBottom' => 30,
            'marginLeft' => 20,
            'marginRight' => 20,
            'options' => [],
            'methods' => [
                'SetHeader' => [$encabezado],
                'SetFooter' => [$piePagina],
                'SetProtection' => [
                    ['copy', 'print']
                ],
            ],
        ]);

        return $pdf->render();
    }
}
