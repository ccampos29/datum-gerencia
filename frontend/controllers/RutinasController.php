<?php

namespace frontend\controllers;

use frontend\models\Repuestos;
use Yii;
use frontend\models\Rutinas;
use frontend\models\RutinasRepuestos;
use frontend\models\RutinasSearch;
use frontend\models\RutinasTrabajos;
use frontend\models\Trabajos;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * RutinasController implements the CRUD actions for Rutinas model.
 */
class RutinasController extends Controller
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
                        'roles' => ['p-rutinas-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-rutinas-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-rutinas-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-rutinas-eliminar'],
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
     * Lists all Rutinas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RutinasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rutinas model.
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
     * Creates a new Rutinas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rutinas();
        $tieneRutinaTrabajo = false;
        $model->costo_total = 0;
        if ($model->load(Yii::$app->request->post())) {
            $model->periodico = 0;
            // echo '<pre>';
            // print_r(Yii::$app->request->post());
            // die();
            $model->save();
            $model->asociarTrabajos(Yii::$app->request->post()['Rutinas']['trabajosFormulario']);
            return $this->redirect(['insumos-repuestos', 'idRutina' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'tieneRutinaTrabajo' => $tieneRutinaTrabajo
        ]);
    }

    public function actionInsumosRepuestos($idRutina)
    {
        $model = $this->findModel($idRutina);
        $trabajosRutina = $model->rutinasTrabajos;
        // print_r(count($trabajosRutina));
        // die();
        $arrayTrabajos = [];
        // $prueba = ArrayHelper::map(RutinasTrabajos::find()->where(['rutina_id' => $model->id])->all(),'id','trabajo_id');
        // print_r($prueba);
        // die();
        foreach ($trabajosRutina as $index => $trabajoRut) {
            $trabajo = Trabajos::findOne($trabajoRut->trabajo_id);
            $arrayTrabajos[$trabajoRut->id] = $trabajo->nombre;
        }
        Yii::$app->session->setFlash("success", 'Rutina almacenada con éxito.');
        return $this->render('_forms/FormInsumosRepuestos', ['model' => $model, 'arrayTrabajos' => $arrayTrabajos]);
    }

    public function actionAsociarInsumosRepuestos($idRutina)
    {
        $model = $this->findModel($idRutina);
        $model->scenario = Rutinas::ESCENARIOREPUESTOSINSUMOS;
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                if (!empty($model->rutinasRepuestos)) {
                    $model->actualizarRepuestos(Yii::$app->request->post()['Rutinas']['repuestos']);
                } else {
                    $model->asociarRepuestos(Yii::$app->request->post()['Rutinas']['repuestos']);
                }

                Yii::$app->session->setFlash("success", 'Insumos y repuestos almacenados con éxito.');
                $repuestos = RutinasRepuestos::find()->where(['rutina_id' => $model->id])->all();
                foreach ($repuestos as $repuesto1) {
                    $repuesto = Repuestos::findOne(['id' => $repuesto1->repuesto_id]);
                    $model->costo_total = $model->costo_total + ($repuesto->precio * $repuesto1->cantidad);
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $trabajosRutina = $model->rutinasTrabajos;
                $arrayTrabajos = [];
                foreach ($trabajosRutina as $trabajoRut) {
                    $trabajo = Trabajos::findOne($trabajoRut->trabajo_id);
                    $arrayTrabajos = [$trabajoRut->id => $trabajo->nombre];
                }
                return $this->render('_forms/FormInsumosRepuestos', ['model' => $model, 'arrayTrabajos' => $arrayTrabajos]);
            }
        }
    }

    /**
     * Updates an existing Rutinas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $tieneRutinaTrabajo = true)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->actualizarTrabajos(Yii::$app->request->post()['Rutinas']['trabajosFormulario']);
            $model->save();
            return $this->redirect(['insumos-repuestos', 'idRutina' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'tieneRutinaTrabajo' => $tieneRutinaTrabajo
        ]);
    }

    /**
     * Deletes an existing Rutinas model.
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
     * Finds the Rutinas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rutinas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rutinas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Método que guarda los respuestos de la rutina
     */
    public function actionGuardarRutinaRespuesto()
    {
        $rutina_repuesto = new RutinasRepuestos();
        $request_rut = Yii::$app->request->post();
        $rutina_repuesto = exit();
    }

    public function getRepuestos($idInventariable)
    {
        $repuestos = Repuestos::find()->where(['inventariable' => $idInventariable])->all();
        $arrayRepuestos = [];
        foreach ($repuestos as $repuesto) {
            $arrayRepuestos[] = [
                'id' => $repuesto->id,
                'name' => $repuesto->nombre
            ];
        };
        return $arrayRepuestos;
    }

    public function actionRepuestos()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $idInventariable = $parents[0];
                $out = self::getRepuestos($idInventariable);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionActualizarTrabajos()
    {
        echo '<pre>';
        print_r($_POST);
        die();
        /**
         * Eliminar los trabajos que ya existen
         * Organizar el array que entra por post
         * Crear nuevos rutinastrabajos
         */
        //Si rutina_id viene vacio es porque es un registro nuevo
        if (!empty($_POST['arrayInformacionCompleta'][0]['rutina_id'])) {
            $this->eliminarTrabajos($_POST['arrayInformacionCompleta'][0]['rutina_id']);
        }
        for ($i = 0; $i < count($_POST['arrayInformacionCompleta']); $i = $i + 5) {
            $rutinaTrabajo = new RutinasTrabajos();
            $rutinaTrabajo->rutina_id = $_POST['arrayInformacionCompleta'][0]['rutina_id'];
            $rutinaTrabajo->trabajo_id = $_POST['arrayInformacionCompleta'][$i + 1]['trabajo_id'];
            $rutinaTrabajo->cantidad = $_POST['arrayInformacionCompleta'][$i + 2]['cantidad'];
            $rutinaTrabajo->observacion = $_POST['arrayInformacionCompleta'][$i + 3]['observacion'];
            $rutinaTrabajo->save();
        }
        print_r($_POST);
        die();
    }

    public function eliminarTrabajos($id)
    {
        $model = Rutinas::findOne($id);
        $trabajos = $model->rutinasTrabajos;

        foreach ($trabajos as $trabajo) {
            $trabajo->delete();
        }
    }


    /**
     * Ajax para la carga de los trabajos en el select2 que esta 
     * en el formulario de Mantenimientos, Novedades Mantenimientos
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionRutinasList($q = null, $id = null)
    {
        return Yii::$app->ayudante->getSelectAjax($q, $id, 'id, nombre AS text', 'rutinas');
    }
}
