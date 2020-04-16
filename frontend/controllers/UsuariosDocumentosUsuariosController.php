<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UsuariosDocumentosUsuarios;
use frontend\models\UsuariosDocumentosUsuariosSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UsuariosDocumentosUsuariosController implements the CRUD actions for UsuariosDocumentosUsuarios model.
 */
class UsuariosDocumentosUsuariosController extends Controller
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
                        'roles' => ['p-usuarios-documentos-usuarios-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-usuarios-documentos-usuarios-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-usuarios-documentos-usuarios-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-usuarios-documentos-usuarios-eliminar'],
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
     * Lists all UsuariosDocumentosUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosDocumentosUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuariosDocumentosUsuarios model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            //'iUs' => $iUs
        ]);
    }

    /**
     * Creates a new UsuariosDocumentosUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($iUs)
    {
        $model = new UsuariosDocumentosUsuarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseArchivos'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaArchivosDocumentosUsuarios'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $archivo = UploadedFile::getInstance($model, 'documento');
            if (!empty($archivo)) {
                $model->nombre_archivo_original = $archivo->name;
                $model->usuario_id = $_GET['iUs'];
                $model->nombre_archivo = uniqid('documentoUsuario_' . $model->usuario_id . '_') . "." . $archivo->getExtension();
                $rutaCarpetaDocumento = $rutaCarpeta . 'usuario' . $model->usuario_id . '/';
                if (!file_exists($rutaCarpetaDocumento)) {
                    mkdir($rutaCarpetaDocumento);
                }
                $model->ruta_archivo = $rutaCarpetaDocumento . $model->nombre_archivo;
                if (!$model->save()) {
                    print_r($model->getErrors());
                    die();
                }
                $guardoBien = $archivo->saveAs($model->ruta_archivo);
                $model->nombre_archivo = 'usuario' . $model->usuario_id . "/" . $model->nombre_archivo;
                $model->save();
                if (!$guardoBien) {
                    $model->delete();
                }
            Yii::$app->session->setFlash('success', 'Documento cargado correctamente');
            return $this->redirect(['view', 'id' => $model->id, 'iUs' => $_GET['iUs']]);
        }}

        return $this->render('create', [
            'model' => $model,
            //'iUs' => $iUs
        ]);
    }

    /**
     * Updates an existing UsuariosDocumentosUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $iUs)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseArchivos'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaArchivosDocumentosUsuarios'];
            if (!file_exists($rutaCarpeta)) {
                mkdir($rutaCarpeta);
            }
            $archivo = UploadedFile::getInstance($model, 'documento');
            if (!empty($archivo)) {
                $model->nombre_archivo_original = $archivo->name;
                $model->usuario_id = $_GET['iUs'];
                $model->nombre_archivo = uniqid('documentoUsuario_' . $model->usuario_id . '_') . "." . $archivo->getExtension();
                $rutaCarpetaDocumento = $rutaCarpeta . 'usuario' . $model->usuario_id . '/';
                if (!file_exists($rutaCarpetaDocumento)) {
                    mkdir($rutaCarpetaDocumento);
                }
                $model->ruta_archivo = $rutaCarpetaDocumento . $model->nombre_archivo;
                if (!$model->save()) {
                    print_r($model->getErrors());
                    die();
                }
                $guardoBien = $archivo->saveAs($model->ruta_archivo);
                $model->nombre_archivo = 'usuario' . $model->usuario_id . "/" . $model->nombre_archivo;
                $model->save();
                if (!$guardoBien) {
                    $model->delete();
                }
            return $this->redirect(['view', 'id' => $model->id, 'iUs' => $_GET['iUs']]);
        }}

        return $this->render('update', [
            'model' => $model,
            'iUs' => $iUs
        ]);
    }

    /**
     * Deletes an existing UsuariosDocumentosUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $iUs)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'iUs'=>$_GET['iUs']]);
    }

    /**
     * Finds the UsuariosDocumentosUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsuariosDocumentosUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuariosDocumentosUsuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionEnvioEmailVencimientoDocumentoUsuario(){
            Yii::$app->notificador->enviarCorreoVencimientoDocumentoUsuario();
         
    }
}
