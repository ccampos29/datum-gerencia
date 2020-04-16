<?php

namespace frontend\controllers;

use Yii;
use frontend\models\VehiculosDocumentosArchivos;
use frontend\models\VehiculosDocumentosArchivosSearch;
use yii\db\IntegrityException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * VehiculosDocumentosArchivosController implements the CRUD actions for VehiculosDocumentosArchivos model.
 */
class VehiculosDocumentosArchivosController extends Controller
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
                        'roles' => ['p-vehiculos-documentos-archivos-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-vehiculos-documentos-archivos-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-vehiculos-documentos-archivos-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-vehiculos-documentos-archivos-eliminar'],
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
     * Lists all VehiculosDocumentosArchivos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehiculosDocumentosArchivosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VehiculosDocumentosArchivos model.
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
     * Creates a new VehiculosDocumentosArchivos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VehiculosDocumentosArchivos();

        if ($model->load(Yii::$app->request->post())) {
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseDocumentosV'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaArchivosDocumentosV'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }


            $archivo = UploadedFile::getInstance($model, 'documento');
            if (!empty($archivo)) {
                
                $model->nombre_archivo_original = $archivo->name;
                $model->nombre_archivo = uniqid('vehiculo'.$_GET['idv'].'_documento_'.$_GET['idDocumento']. '_') . "." . $archivo->getExtension();
                $rutaCarpetaDocumento = $rutaCarpeta . 'vehiculo'.$_GET['idv'].'_documento_'.$_GET['idDocumento']. '/';
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
                $model->nombre_archivo = 'vehiculo'.$_GET['idv'].'_documento_'.$_GET['idDocumento']. "/" . $model->nombre_archivo;
                $model->save();
                if (!$guardoBien) {
                    $model->delete();
                }
            }
            return $this->redirect(['view', 'id' => $model->id, 'idv'=>$_GET['idv'], 'idDocumento'=>$_GET['idDocumento']]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VehiculosDocumentosArchivos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'idv'=>$_GET['idv'], 'idDocumento'=>$_GET['idDocumento']]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VehiculosDocumentosArchivos model.
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
            return $this->redirect(['index', 'idv'=>$_GET['idv'], 'idDocumento'=>$_GET['idDocumento']]);
    
        } catch (IntegrityException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error','No puede eliminar este registro, se deben eliminar los registros asociados antes.');
            return $this->redirect(['index', 'idv'=>$_GET['idv'], 'idDocumento'=>$_GET['idDocumento']]);
    
        }catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error','No se puede eliminar este registro.');
            return $this->redirect(['index', 'idv'=>$_GET['idv'], 'idDocumento'=>$_GET['idDocumento']]);
        }        
    }

    /**
     * Finds the VehiculosDocumentosArchivos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VehiculosDocumentosArchivos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VehiculosDocumentosArchivos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
