<?php

namespace frontend\controllers;

use frontend\models\CriteriosEvaluaciones;
use Yii;
use frontend\models\Novedades;
use frontend\models\NovedadesChecklist;
use frontend\models\NovedadesSearch;
use frontend\models\NovedadesTiposChecklist;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NovedadesController implements the CRUD actions for Novedades model.
 */
class NovedadesController extends Controller
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
                        'roles' => ['p-novedades-actualizar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'view'
                        ],
                        'roles' => ['p-novedades-ver'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create'
                        ],
                        'roles' => ['p-novedades-crear'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['p-novedades-eliminar'],
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
     * Lists all Novedades models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NovedadesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Novedades model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $novedades_carga = NovedadesChecklist::find()->where(['novedad_id' => $id])->all();

        foreach ($novedades_carga as $novedad) {
            $model->prioridad[] = $novedad->prioridad;
            $model->trabajo[] = $novedad->trabajo_id;
            $model->calificacion[] = $novedad->calificacion;
        }
        return $this->render('view', [
            'model' => $model,
            'novedades_carga' => $novedades_carga
        ]);
    }

    /**
     * Creates a new Novedades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Novedades();

        if ($model->load(Yii::$app->request->post())) {
            $request   = Yii::$app->request;
            $tipos_check = $request->post()["Novedades"]["tipo_checklist_id"];
            if (empty($tipos_check)) {

                Yii::$app->session->setFlash('danger', 'Por favor seleccione tipos de checklist');
            } else {
                if ($model->save()) {
                    foreach ($tipos_check as $tipo) {

                        $create_tipos = new NovedadesTiposChecklist();
                        $create_tipos->novedad_id = $model->id;
                        $create_tipos->tipo_checklist_id = $tipo;
                        if (!$create_tipos->save())  echo Yii::$app->ayudante->getErroresSave($create_tipos);
                    }

                    Yii::$app->session->setFlash('success', 'Novedad creada correctamente.');
                    return $this->redirect(['update', 'id' => $model->id]);
                } else {
                    echo Yii::$app->ayudante->getErroresSave($model);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Novedades model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $novedades_carga = NovedadesChecklist::find()->where(['novedad_id' => $id])->all();

        foreach ($novedades_carga as $novedad) {
            $model->prioridad[] = $novedad->prioridad;
            $model->trabajo[] = $novedad->trabajo_id;
            $model->calificacion[] = $novedad->calificacion;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $request     = Yii::$app->request;
            $detail      = $request->post()['Novedades']['novedades_checklist'];
            $tipos_check = $request->post()["Novedades"]["tipo_checklist_id"];

            if (empty($tipos_check)) {

                Yii::$app->session->setFlash('danger', 'Por favor seleccione tipos de checklist');

            } else {

                $delete_nv_ck    = NovedadesChecklist::deleteAll('novedad_id = :b', ['b' => $id]);

                foreach ($detail as $key => $det) {
                    $id_crit                       = $request->post()['Novedades']['novedades_checklist'][$key];
                    $novedades_check               = new NovedadesChecklist();
                    $novedades_check->calificacion = @$request->post()['Novedades']['calificacion'][$key];
                    $novedades_check->trabajo_id   = @$request->post()['Novedades']['trabajo'][$key];
                    $novedades_check->prioridad    = @$request->post()['Novedades']['prioridad'][$key] ?: NULL;
                    $novedades_check->id_criterio_evaluacion_det    = $id_crit;
                    $novedades_check->novedad_id    = $id;

                    if (!$novedades_check->save()) {
                        echo Yii::$app->ayudante->getErroresSave($novedades_check);
                        exit();
                    }

                }

                $delete_tipos = NovedadesTiposChecklist::deleteAll('novedad_id = :novedad', ['novedad' => $id]);
                
                foreach ($tipos_check as $tipo) {
                    $create_tipos = new NovedadesTiposChecklist();
                    $create_tipos->novedad_id = $model->id;
                    $create_tipos->tipo_checklist_id = $tipo;
                    if (!$create_tipos->save()) {
                        echo Yii::$app->ayudante->getErroresSave($create_tipos);
                        exit();
                    }
                }
            }


            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Novedades model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Finds the Novedades model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Novedades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Novedades::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getNovedad($idGrupo)
    {
        $novedades = Novedades::find()->where(['grupo_novedad_id' => $idGrupo])->all();
        $arrayNovedades = [];
        foreach ($novedades as $novedad) {
            $arrayNovedades[] = [
                'id' => $novedad->id,
                'name' => $novedad->nombre
            ];
        };
        return $arrayNovedades;
    }

    public function actionNovedad()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $idGrupo = $parents[0];
                $out = self::getNovedad($idGrupo);
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

    public function getCriterio($idGrupo)
    {
        $novedades = CriteriosEvaluaciones::find()->all();
        $arrayNovedades = [];
        foreach ($novedades as $novedad) {
            $arrayNovedades[] = [
                'id' => $novedad->id,
                'name' => $novedad->nombre
            ];
        };
        return $arrayNovedades;
    }

    public function actionCriterio()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $idGrupo = $parents[0];
                $out = self::getCriterio($idGrupo);
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

    public function actionObtenerCriterios($idNovedad)
    {
        $novedades = Novedades::findOne($idNovedad);
        return json_encode($novedades->getAttributes());
    }
}
