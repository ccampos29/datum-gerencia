<?php

namespace frontend\controllers;

use frontend\models\Departamentos;
use frontend\models\DocumentosProveedores;
use frontend\models\Municipios;
use Yii;
use yii\db\Query;
use frontend\models\Proveedores;
use frontend\models\ProveedoresSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * ProveedorController implements the CRUD actions for Proveedor model.
 */
class ProveedoresController extends Controller
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
                        'roles' => ['p-proveedores-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-proveedores-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-proveedores-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-proveedores-eliminar'],
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
     * Lists all Proveedor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProveedoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proveedor model.
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
     * Creates a new Proveedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Proveedores();
        $modelDocumentos = new DocumentosProveedores();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Proveedor creado correctamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            echo Yii::$app->ayudante->getErroresSave($model);
        }

        return $this->render('create', [
            'model' => $model,
            'modelDocumentos'=>$modelDocumentos
        ]);
    }

    /**
     * Updates an existing Proveedor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDocumentos = new DocumentosProveedores();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelDocumentos'=>$modelDocumentos
        ]);
    }

    /**
     * Deletes an existing Proveedor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (yii\db\Exception $e) {
            Yii::$app->session->setFlash('danger', 'No puede eliminar este registro, se deben eliminar los registros asociados antes.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Proveedor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Proveedor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proveedores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Método que obtiene el listado de los departamentos según el pais
     * 
     * @param integer $idPais id del país a buscar
     * 
     * @return html Retorna opciones del departamento 
     *//**
     * Ajax para la carga de los centro de costo en el select2 que esta 
     * en el formulario de Contrato
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionTiposSegurosList($q = null, $id = null) {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, nombre AS text','tipos_seguros');
    }
    
    public function actionListadoDepartamento($idPais) {
        $municipios = Departamentos::find()->where(['pais_id' => $idPais])->all();
        $opciones = '';
        if (count($municipios) > 0) {
            foreach ($municipios as $municipio) {
                $opciones .= "<option value='" . $municipio->id . "'>" . $municipio->nombre . "</option>";
            }
        } else {
            $opciones .= '<option>-</option>';
        }
        
        return $opciones;
    }
    /**
     * Método que obtiene el listado de las ciudades según el depto
     * 
     * @param integer $idDepto id del depto a buscar
     * 
     * @return html Retorna opciones de la ciudad 
     */    
    public function actionListadoCiudad($idDepto) {
        $municipios = Municipios::find()->where(['departamento_id' => $idDepto])->all();
        $opciones = '';
        if (count($municipios) > 0) {
            foreach ($municipios as $municipio) {
                $opciones .= "<option value='" . $municipio->id . "'>" . $municipio->nombre . "</option>";
            }
        } else {
            $opciones .= '<option>-</option>';
        }
        
        return $opciones;
    }

    /**
     * Ajax para la carga de los proveedores en el select2 que esta 
     * en el formulario de Ordenes de Trabajos
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionProveedoresList($q = null, $id = null) {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, nombre AS text','proveedores');
    }
    /**
     * Método para llenar un select-ajax
     * @param string $q Valor a buscar
     * @param array query resultado 
     * @return array Resultados encontrados según la búsqueda 
     */
    public function actionTiposProveedoresList($q = null, $id = null) {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, nombre AS text','tipos_proveedores');

    }
}
