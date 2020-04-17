<?php

namespace frontend\controllers\Api;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use frontend\models\Checklist;
use frontend\models\User;
use frontend\models\TiposVehiculos;
use frontend\models\GruposNovedades;
use frontend\models\VehiculosConductores;
use frontend\models\Vehiculos;
use frontend\models\TiposChecklist;
use frontend\models\NovedadesChecklist;
use frontend\models\NovedadesTiposChecklist;
use frontend\models\ChecklistSearch;
use frontend\models\EstadosChecklistConfiguracion;
use frontend\models\CriteriosEvaluacionesDetalle;
use frontend\models\CalificacionesChecklist;
use SoapHeader;
use SoapClient;
use yii\helpers\Json;
use Yii;

class ChecklistController extends ActiveController
{
    public $modelClass = 'frontend\models\Checklist';

    public function actions(){
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;

    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
           'class' => HttpBearerAuth::className(),
           'except' => ['options', 'authenticate', 'subirfotochecklist'],
        ];
        return $behaviors;
    }

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    public function actionGetvehiclebyuser($user_id){
        $conductorVehiculos = VehiculosConductores::find()->where(['conductor_id'=>$user_id])->all();

        $response = array();
        $vehiculos = array();
        foreach($conductorVehiculos as $conductorVehiculo){
            $vehiculo = Vehiculos::find()->where(['id' => $conductorVehiculo->vehiculo_id])->one();
            array_push($vehiculos, $vehiculo);
        }

        if(count($vehiculos) == 0){
            return ["status"=>"error"];
        }else{
            $response['status'] = "success";
            $response['vehiculos'] = $vehiculos;
        }

        return $response;
    }

    /*
    * Metodo que permite la consulta de una medicion via web service.
    */
    public function actionConsultamedicion($idVehiculo)
    {
        $vehiculo = new Vehiculos;

        $vehiculo = Vehiculos::findOne($idVehiculo);

        if(!isset($vehiculo))
            return ["status"=>"error"];

        $username = 'wsdatumpos';
        $password = 'Ddatum_pepe123*';
        $placas = $vehiculo->placa;
        ini_set('default_socket_timeout', 60);
        $soapURL = "http://190.143.101.58:2998/VideoData.asmx?WSDL";

        $client = new SoapClient($soapURL, array());

        $auth = array(
            'sUser' => $username,
            'sPassw' => $password,
            'sPlate' => $placas,
        );

        if ($vehiculo->tipo_medicion == 'KMS') {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithOdometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithOdometer($auth)->GetLastPositionWithOdometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Odometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa" => $vehiculo->placa, "function" => 'odom'];
            $response['status'] = "success";
            $response['data'] = $val;
            return $response;
        } else {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithHorometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithHorometer($auth)->GetLastPositionWithHorometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Horometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa" => $vehiculo->placa, "function" => 'horom'];
            $response['status'] = "success";
            $response['data'] = $val;
            return $response;
        }
    }

    public function actionTiposchecklist($id_vehiculo){
        $vehiculo = Vehiculos::findOne($id_vehiculo);
        if(!isset($vehiculo))
            return ["status"=>"error"];
        $tiposChecklist = TiposChecklist::find()->where(['tipo_vehiculo_id' => $vehiculo->tipo_vehiculo_id])->all();
        $arrayTipoChecklist = [];
        $response["status"] = "success";
        foreach ($tiposChecklist as $tipoChecklist){
            $arrayTipoChecklist[] = ['id' => $tipoChecklist->id,
                                  'name' => $tipoChecklist->nombre];
        };
        $response["tipos_checklist"] = $arrayTipoChecklist;
        return $response;
    }

    public function actionObtenerperiodicidadchecklist() {
        $params=json_decode(file_get_contents("php://input"), false);

        @$id_tipo_checklist=$params->id_tipo_checklist;
        @$fechaActual=$params->fecha_actual;
        @$odometroActual=$params->odometro_actual;

        $tipoChecklist = TiposChecklist::findOne($id_tipo_checklist);

        if(!isset($tipoChecklist)){
            return ["status"=>"error"];
        }
        $atributos = $tipoChecklist->getAttributes();

        $dia = $atributos['dias'];
        $horas = $atributos['horas'];
        $odometro = $atributos['odometro'];
        if(isset($dia))
            $response['fecha_siguiente'] = $this->calcularPorTiempo($fechaActual, $dia, "Día");
        if(isset($horas))
            $response['fecha_siguiente'] = $this->calcularPorTiempo($fechaActual, $horas, "Hora");
        if(isset($odometro))
            $response['odometro_siguiente'] = $this->calcularPorDistancia($odometroActual, $odometro);
        return $response;
    }

    public function calcularPorTiempo($fechaActual, $cantidad, $periodicidad) {
        if($periodicidad == 'Día'){
            $fechaCalculada = date("Y-m-d", strtotime($fechaActual."+ ".$cantidad." days")); 
        }else if($periodicidad == 'Hora'){
            $fechaCalculada = date("Y-m-d", strtotime($fechaActual."+ ".$cantidad." hours")); 
        }
        return($fechaCalculada);
    }

    public function calcularPorDistancia($medicionActual, $cantidad) {
        $medicionCalculada = $medicionActual + $cantidad;
        return $medicionCalculada;
    }

    /**
     * Creates a new Checklist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model = new Checklist();
        $i = 0;
        $j = 0;
        if ($model->load(Yii::$app->request->post())) {
            $model->consecutivo = count(Checklist::find()->all()) + 1;
            $novedadesTiposChecklist = NovedadesTiposChecklist::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->all();
            if (empty(EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->all())) {
                $model->delete();
                $response['status'] = "error";
                $response['message'] = 'Se deben configurar los estados para el tipo del checklist ' . $model->tipoChecklist->nombre . ' antes de proceder. No se guardo el checklist.';
                return $response;
            }
            if (!empty($novedadesTiposChecklist)) {
                if (count($novedadesTiposChecklist) < (int) EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->andWhere(['estado_checklist_id' => 4])->one()->cantidad_maxima_crit) {
                    $model->delete();
                    $response['status'] = "error";
                    $response['message'] = 'La cantidad maxima configurada para los estados del checklist rechazado/critico supera el numero de novedades (' . count($novedadesTiposChecklist) . ') que tiene este tipo de checklist, por favor, cambie la configuracion de los estados para el tipo de checklist ' . $model->tipoChecklist->nombre . ', no se guardo el checklist.';
                    return $response;
                }
                foreach ($novedadesTiposChecklist as $noveTipo) {
                    $novedadesChecklist = NovedadesChecklist::find()->where(['novedad_id' => $noveTipo->novedad_id])->all();
                    foreach ($novedadesChecklist as $noveCheck) {
                        if (empty($noveCheck->calificacion)) {
                            $array[] = $noveCheck->novedad->nombre;
                            $i++;
                        }
                        if ($noveCheck->calificacion != 1 && (empty($noveCheck->trabajo) || empty($noveCheck->prioridad))) {
                            $array[] = $noveCheck->novedad->nombre;
                            $i++;
                        }
                    }
                }                
                if ($i > 0 || $j>0) {
                    $model->delete();
                    $response['status'] = "error";
                    $response['message'] = 'Se deben adicionar todos los estados, los trabajos y las prioridades a las novedades ' . implode(', ', array_unique($array)) . ' seleccionadas para este tipo de checklist antes de proceder. No se guardo el checklist.';
                    return $response;
                }
                if ($model->save()) {
                    $medicion = $this->actionConsultaMedicion($model->vehiculo_id);
                    $medicion = $medicion['data'];
                    $model->almacenarMedicion($medicion, $model->vehiculo_id);

                    $response['status'] = "success";
                    $response['message'] = "Checklist generado con exito.";
                    $response['id_checklist'] = $model->id;
                    $response['id_vehiculo'] = $model->vehiculo_id;
                    $response['id_tipo_checklist'] = $model->tipo_checklist_id;

                    // return $this->redirect(['calificaciones-checklist/create', 'idChecklist' => $model->id, 'idv' => $model->vehiculo_id, 'idTipo' => $model->tipo_checklist_id]);

                    return $response;
                } else {
                    $response['status'] = "error";
                }
            } else {
                $model->delete();
                $response['status'] = "error";
                $response['message'] = 'Debe asignar al menos una novedad para el tipo de checklist ' . $model->tipoChecklist->nombre . ' y adicionarle los detalles antes de proceder. No se guardo el checklist.';
                return $response;
            }
        }
    }

    public function actionCalificacioneschecklist(){
        $params = json_decode(file_get_contents("php://input"), false);

        @$idChecklist = $params->id_checklist;
        @$idv = $params->id_vehiculo;
        @$idTipo = $params->id_tipo_checklist;

        $checklist = Checklist::findOne($idChecklist);
        $user = User::findOne($checklist->usuario_id);
        $vehiculo = Vehiculos::findOne($checklist->vehiculo_id);
        $creador = User::findOne($checklist->creado_por);
        $tipoVehiculo = TiposVehiculos::findOne($vehiculo->tipo_vehiculo_id);
        $gruposNovedades = GruposNovedades::find()->all();
        $noveCheck = NovedadesTiposChecklist::find()->where(['tipo_checklist_id' => $idTipo])->all();

        $grupos = [];
        foreach ($gruposNovedades as $grupo) {
            $j = 0;
            foreach ($noveCheck as $novedad) {
                if ($j == 0 && $novedad->novedad->grupoNovedad->id == $grupo->id) {
                    $arrGrupo = ["grupo" => 
                        [
                            "id" => $grupo->id, "nombre" => $grupo->nombre, "codigo" => $grupo->codigo, "comentario" => $grupo->comentario,
                            "empresa_id" => $grupo->empresa_id,"creado_por" => $grupo->creado_por,"creado_el" => $grupo->creado_el,
                            "actualizado_por" => $grupo->actualizado_por,"actualizado_el" => $grupo->actualizado_el,"novedades" => [],
                        ]
                    ];
                    $grupos[] = $arrGrupo;
                }
                if ($novedad->novedad->grupoNovedad->id == $grupo->id) {$j+=3;}
            }
        }

        $newGrupos = [];
        foreach($grupos as $grupo){
            foreach ($noveCheck as $novedad) {
                if ($novedad->novedad->grupoNovedad->id == $grupo['grupo']['id']) {

                    $detalles = ArrayHelper::map(CriteriosEvaluacionesDetalle::find()
                            ->where(['tipo_criterio_id' => $novedad->novedad->criterioEvaluacion->id])
                            ->all(), 'id', 'detalle');

                    $criterioEvaluacion = ["id" => $novedad->novedad->criterioEvaluacion->id,"nombre" => $novedad->novedad->criterioEvaluacion->nombre,
                    "tipo" => $novedad->novedad->criterioEvaluacion->tipo,"estado" => $novedad->novedad->criterioEvaluacion->estado,
                    "creado_por" => $novedad->novedad->criterioEvaluacion->creado_por, "creado_el" => $novedad->novedad->criterioEvaluacion->creado_el,
                    "actualizado_por" => $novedad->novedad->criterioEvaluacion->actualizado_por,"actualizado_el" => $novedad->novedad->criterioEvaluacion->actualizado_el,
                    "empresa_id" => $novedad->novedad->criterioEvaluacion->empresa_id, "detalles_evaluacion" => $detalles];

                    $arrNov = ["novedad" => ["id" => $novedad->novedad->id, "nombre" => $novedad->novedad->nombre, "grupo_novedad_id" => $novedad->novedad->grupo_novedad_id, 
                                            "criterio_evaluacion_id" => $novedad->novedad->criterio_evaluacion_id,"observacion" => $novedad->novedad->observacion, 
                                            "genera_novedades" => $novedad->novedad->genera_novedades,"activo" => $novedad->novedad->activo, 
                                            "creado_por" => $novedad->novedad->creado_por, "creado_el" => $novedad->novedad->creado_el, 
                                            "actualizado_por" => $novedad->novedad->actualizado_por, "actualizado_el" => $novedad->novedad->actualizado_el,
                                            "empresa_id" => $novedad->novedad->empresa_id, "criterioEvaluacion" => $criterioEvaluacion]];

                    $grupo['grupo']["novedades"][] = $arrNov;
                }
            }
            $newGrupos[] = $grupo;
        }
        return $newGrupos;
    }

    public function actionCalificarchecklist(){
        $params = json_decode(file_get_contents("php://input"), false);
        
        @$data = $params->data;
        @$idChecklist = $params->id_checklist;

        $model = new CalificacionesChecklist();
        $null=0;

        foreach ($data->novedadesCalificadas as $key) {
            foreach ($key as $k) {
                if($k==null){
                    $null++;
                }
                $array[] = [intval($k)];
            }
        }
        
        if($null == 0){
            foreach ($data->novedadesCalificadas as $key) {
                foreach ($key as $k) {
                    $array[] = [intval($k)];
                }
                if($model->almacenarImagenes($idChecklist)){
                    $model->almacenarImagenes($idChecklist);
                }
                $model->asociarCalificacion($key);
                $model->asociarNovedadesMantenimientos($key);         
            }
            try {
                Yii::$app->notificador->enviarCorreoenviarCorreoNuevoChecklist($idChecklist);
            }
            catch(Swift_TransportException $exception) {
                Yii::$app->notificador->enviarCorreoenviarCorreoNuevoChecklist($idChecklist);
            }

            $model = Checklist::find()->where(['id' => $idChecklist])->one();

            $estadosConfigurados = EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id' => $model->tipo_checklist_id])->all();
            $calificacion = CalificacionesChecklist::find()->where(['checklist_id' => $idChecklist])->all();
            $novedad = NovedadesChecklist::find()->all();
            $rechazadoCritico = 0;
            $aprobado = 0;
            $rechazado = 0;
            $equipoMalo = 0;
            $pendiente = 0;
            $var = 0;
            $texto = 'Rechazado';

            foreach ($calificacion as $estado) {
                foreach ($novedad as $nove) {
                    if ($nove->calificacion0 != null) {
                        if ($nove->novedad_id == $estado->novedad->id && $nove->criterioEvaluacionDet->id == $estado->valor_texto_calificacion) {
                            if (strtolower($nove->calificacion0->estado) == "aprobado") {
                                $aprobado++;
                            } elseif (strtolower($nove->calificacion0->estado) == "rechazado") {
                                $rechazado++;
                            } elseif (strtolower($nove->calificacion0->estado) == "rechazado critico") {
                                $rechazadoCritico++;
                            }
                        }
                    }
                }
            }
            
            $total = $aprobado + $rechazado + $rechazadoCritico;
            $porcentajeAprobado = 0;
            $porcentajeRechazado = 0;
            $porcentajeCritico = 0;
            if ($aprobado != 0) {
                $porcentajeAprobado = ($aprobado * 100) / $total;
                $porcentajeAprobado = round($porcentajeAprobado, 2);
            }
            if ($rechazado != 0) {
                $porcentajeRechazado = ($rechazado * 100) / $total;
                $porcentajeRechazado = round($porcentajeRechazado, 2);
            }
            if ($rechazadoCritico != 0) {
                $porcentajeCritico = ($rechazadoCritico * 100) / $total;
                $porcentajeCritico = round($porcentajeCritico, 2);
            }


            $mayor = max($porcentajeAprobado, $porcentajeRechazado, $porcentajeCritico);

            $i=0;
            foreach ($estadosConfigurados as $config) {
                $arrayEstados[$i]['rechazado'] = $config->porcentaje_maximo_rej;
                $arrayEstados[$i]['critico'] = $config->cantidad_maxima_crit;
                $i++;
            }

            foreach ($estadosConfigurados as $config) {
                if($mayor != $porcentajeCritico){
                    if (($mayor == $porcentajeAprobado) && ($rechazadoCritico <= $arrayEstados[0]['critico']) && ($porcentajeRechazado <= $arrayEstados[0]['rechazado']) && ($config->estado_checklist_id == 1)) {
                        $texto = "Aprobado";
                    } elseif (($mayor == $porcentajeRechazado) && ($rechazadoCritico >= $arrayEstados[0]['critico']) && ($rechazadoCritico <= $arrayEstados[1]['critico']) && ($porcentajeRechazado >= $arrayEstados[0]['rechazado']) && ($porcentajeRechazado <= $arrayEstados[1]['rechazado']) && ($config->estado_checklist_id == 3)) {
                        $texto = "Rechazado";
                    }elseif (($rechazadoCritico >= $arrayEstados[2]['critico'])  && ($porcentajeRechazado >= $arrayEstados[2]['rechazado']) && ($config->estado_checklist_id == 3)) {
                        $texto = "Rechazado/Critico";
                    }
                } else{
                    $texto = "Rechazado/Critico";
                }
            }

            $response['nombre_checklist'] = $model->tipoChecklist->nombre;
            $response['creador_checklist'] = $model->creadoPor->name . ' ' . $model->creadoPor->surname;
            $response['vehiculo'] = $model->vehiculo->placa;
            $response['estado_checklist'] = $texto;

            $response['procentaje_aprobado'] = $aprobado . "(" . $porcentajeAprobado . "%)";
            $response['procentaje_rechazado'] = $rechazado . "(" . $porcentajeRechazado . "%)";
            $response['procentaje_rechazado_critico'] = $rechazadoCritico . "(" . $porcentajeCritico . "%)";
            $response['total'] = $total;
            $response['status'] = "success";
        }else{
            $response['status'] = "error";
        }   
        return $response;
    }

    public function actionSubirfotochecklist(){
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesChecklist'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }

        header('Access-Control-Allow-Origin:*');

        $rutaCarpetaDocumento = $rutaCarpeta . 'checklist' . "holamundo" . '/';
        if (!file_exists($rutaCarpetaDocumento)) {
            mkdir($rutaCarpetaDocumento);
        }

        $file = time(). "_" . basename($_FILES['photo']['name']);
        $tmp_name = $_FILES['photo']['tmp_name'];

        if(move_uploaded_file($tmp_name, $rutaCarpetaDocumento . $file)){
            echo json_encode([
                "Message" => "The file has been uploaded",
                "Status" => "OK"
            ]);
        }
    }
}