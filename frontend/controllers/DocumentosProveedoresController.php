<?php

namespace frontend\controllers;

use Yii;
use frontend\models\DocumentosProveedores;
use frontend\models\DocumentosProveedoresSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DocumentosProveedoresController implements the CRUD actions for DocumentosProveedores model.
 */
class DocumentosProveedoresController extends Controller
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
                        'roles' => ['p-documentos-proveedores-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-documentos-proveedores-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-documentos-proveedores-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-documentos-proveedores-eliminar'],
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
     * Lists all DocumentosProveedores models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new DocumentosProveedoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocumentosProveedores model.
     * @param string $id
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
     * Creates a new DocumentosProveedores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new DocumentosProveedores();

        if ($model->load(Yii::$app->request->post())) {
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseArchivos'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaArchivosProveedores'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $archivo = UploadedFile::getInstance($model, 'documento');
            if (!empty($archivo)) {
                $model->nombre_archivo_original = $archivo->name;
                $model->proveedor_id = $id;
                $model->nombre_archivo = uniqid('proveedor_' . $model->proveedor_id . '_') . "." . $archivo->getExtension();
                $rutaCarpetaDocumento = $rutaCarpeta . 'proveedor' . $model->proveedor_id . '/';
                if (!file_exists($rutaCarpetaDocumento)) {
                    mkdir($rutaCarpetaDocumento);
                }
                $model->ruta_archivo = $rutaCarpetaDocumento . $model->nombre_archivo;
                if (!$model->save()) {
                    print_r($model->getErrors());
                    die();
                }
                $guardoBien = $archivo->saveAs($model->ruta_archivo);
                $model->nombre_archivo = 'proveedor' . $model->proveedor_id . "/" . $model->nombre_archivo;
                $model->save();
                if (!$guardoBien) {
                    $model->delete();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'proveedor_id' => $id
        ]);
    }

    /**
     * Updates an existing DocumentosProveedores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseArchivos'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaArchivosProveedores'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $archivo = UploadedFile::getInstance($model, 'documento');
            
            if (!empty($archivo) and !empty($_FILES['DocumentosProveedores']['name']['documento'])) {
                $model->nombre_archivo_original = $archivo->name;
                $model->proveedor_id = $id;
                
                $model->nombre_archivo = uniqid('proveedor_' . $model->proveedor_id . '_') . "." . $archivo->getExtension();
                $rutaCarpetaDocumento = $rutaCarpeta . 'proveedor' . $model->proveedor_id . '/';
                if (!file_exists($rutaCarpetaDocumento)) {
                    mkdir($rutaCarpetaDocumento);
                }
                $model->ruta_archivo = $rutaCarpetaDocumento . $model->nombre_archivo;
                if (!$model->save()) {
                    print_r($model->getErrors());
                    die();
                }
                $guardoBien = $archivo->saveAs($model->ruta_archivo);
                $model->nombre_archivo = 'proveedor' . $model->proveedor_id . "/" . $model->nombre_archivo;
                $model->save();
                if (!$guardoBien) {
                    $model->delete();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumentosProveedores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['//proveedores/index']);
    }

    /**
     * Finds the DocumentosProveedores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DocumentosProveedores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumentosProveedores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
