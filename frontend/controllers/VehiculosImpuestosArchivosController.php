<?php

namespace frontend\controllers;

use Yii;
use frontend\models\VehiculosImpuestosArchivos;
use frontend\models\VehiculosImpuetosArchivosSearch;
use yii\db\IntegrityException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * VehiculosImpuestosArchivosController implements the CRUD actions for VehiculosImpuestosArchivos model.
 */
class VehiculosImpuestosArchivosController extends Controller
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
                        'roles' => ['p-vehiculos-impuestos-archivos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-vehiculos-impuestos-archivos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-vehiculos-impuestos-archivos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-vehiculos-impuestos-archivos-eliminar'],
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
     * Lists all VehiculosImpuestosArchivos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehiculosImpuetosArchivosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VehiculosImpuestosArchivos model.
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
     * Creates a new VehiculosImpuestosArchivos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VehiculosImpuestosArchivos();

        if ($model->load(Yii::$app->request->post())) {
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImpuestos'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaArchivosImpuestos'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }


            $archivo = UploadedFile::getInstance($model, 'impuesto');
            if (!empty($archivo)) {
                
                $model->nombre_archivo_original = $archivo->name;
                $model->nombre_archivo = uniqid('vehiculo'.$_GET['idv'].'_impuesto_'.$_GET['idImpuesto']. '_') . "." . $archivo->getExtension();
                $rutaCarpetaDocumento = $rutaCarpeta . 'vehiculo'.$_GET['idv'].'_impuesto_'.$_GET['idImpuesto']. '/';
                if (!file_exists($rutaCarpetaDocumento)) {
                    mkdir($rutaCarpetaDocumento);
                }
                $model->ruta_archivo = $rutaCarpetaDocumento . $model->nombre_archivo;
                if (!$model->save()) {
                    print_r($model->getErrors());
                    print_r("wenas");
                    die();
                }
                $guardoBien = $archivo->saveAs($model->ruta_archivo);
                $model->nombre_archivo = 'vehiculo'.$_GET['idv'].'_impuesto_'.$_GET['idImpuesto']. "/" . $model->nombre_archivo;
                $model->save();
                if (!$guardoBien) {
                    $model->delete();
                }
            }
            return $this->redirect(['view', 'id' => $model->id, 'idv'=>$_GET['idv'], 'idImpuesto'=>$_GET['idImpuesto']]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VehiculosImpuestosArchivos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'idv'=>$_GET['idv'], 'idImpuesto'=>$_GET['idImpuesto']]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VehiculosImpuestosArchivos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->findModel($id)->delete();
            $transaction->commit();
            Yii::$app->session->setFlash('success','El registro fue eliminado correctamente.');
            return $this->redirect(['index', 'idv'=>$_GET['idv'], 'idImpuesto'=>$_GET['idImpuesto']]);
    
        } catch (IntegrityException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error','No puede eliminar este registro, se deben eliminar los registros asociados antes.');
            return $this->redirect(['index', 'idv'=>$_GET['idv'], 'idImpuesto'=>$_GET['idImpuesto']]);
    
        }catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error','No se puede eliminar este registro.');
            return $this->redirect(['index', 'idv'=>$_GET['idv'], 'idImpuesto'=>$_GET['idImpuesto']]);
        }      

        
    }

    /**
     * Finds the VehiculosImpuestosArchivos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VehiculosImpuestosArchivos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VehiculosImpuestosArchivos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
