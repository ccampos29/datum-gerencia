<?php

namespace frontend\controllers\Api;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use frontend\models\Departamentos;
use frontend\models\Municipios;
use frontend\models\Proveedores;
use frontend\models\TiposCombustibles;
use frontend\models\Combustibles;
use frontend\models\CentrosCostos;
use frontend\models\Vehiculos;
use SoapHeader;
use SoapClient;
use yii\db\Query;
use yii\helpers\Json;
use Yii;

class CombustibleController extends ActiveController
{
    public $modelClass = 'frontend\models\Combustibles';

    public function actions(){
        $actions = parent::actions();
        // unset($actions['create']);
        return $actions;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
           'class' => HttpBearerAuth::className(),
           'except' => ['options', 'authenticate'],
        ];
        return $behaviors;
    }

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    public function actionGetdepartamentos($id_pais){
        $departamentos = Departamentos::find()->where(['pais_id' => $id_pais])->all();
        $arrayDepartamentos = [];
        foreach ($departamentos as $departamento) {
            $arrayDepartamentos[] = [
                'id' => $departamento->id,
                'name' => $departamento->nombre
            ];
        };
        return $arrayDepartamentos;
    }

    public function actionGetmunicipios($id_departamento){
        $municipios = Municipios::find()->where(['departamento_id' => $id_departamento])->all();
        $arrayMunicipios = [];
        foreach ($municipios as $municipio) {
            $arrayMunicipios[] = [
                'id' => $municipio->id,
                'name' => $municipio->nombre
            ];
        };
        return $arrayMunicipios;
    }

    public function actionCreatecombustible($id_empresa, $id_user){
        $proveedores = Proveedores::find()->where(['empresa_id' => $id_empresa])->all();
        $arrayProveedores = [];
        foreach ($proveedores as $proveedor) {
            $arrayProveedores[] = [
                'id' => $proveedor->id,
                'name' => $proveedor->nombre
            ];
        };
        $response['proveedores'] = $arrayProveedores;

        $combustibles = TiposCombustibles::find()->where(['empresa_id' => $id_empresa])->all();
        $arrayCombustibles = [];
        foreach ($combustibles as $combustible) {
            $arrayCombustibles[] = [
                'id' => $combustible->id,
                'name' => $combustible->nombre
            ];
        };
        $response['combustibles'] = $combustibles;

        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select('id, nombre AS text')
            ->from('grupos_vehiculos')
            ->where(['empresa_id' => $id_empresa])
            ->andWhere(['codigo' => 1])
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $response['grupoVehiculos'] = array_values($data);

        $centros = CentrosCostos::find()->where(['empresa_id' => $id_empresa])->all();
        $arrayCentros = [];
        foreach ($centros as $centro) {
            $arrayCentros[] = [
                'id' => $centro->id,
                'name' => $centro->nombre
            ];
        };
        $response['centrosCostos'] = $arrayCentros;

        return $response;
    }

    public function actionStorecombustible(){
        //1 => 'Si', 0 => 'No'
        $params = Yii::$app->request->post();
        $model = new Combustibles();
        $model->load($params);

        $valMedicionFicticio = $params['Combustibles']['medicion_compare'];//es la que viene del web service
        $valMedicion = $params['Combustibles']['medicion_actual'];//es la que digita el usuario

        if($valMedicionFicticio < $valMedicion){
            $response['status'] = "error";
            $response['message'] = "El valor de la medicion no puede ser mayor al reportado por web service.";
        }else{
            if ($model->save()) {
                $model->almacenarImagenes($model->id);
                $medicion = $this->actionConsultaMedicion($model->vehiculo_id);
                $medicion = Json::decode($medicion);
                $model->almacenarMedicion($medicion, $model->vehiculo_id);

                $response['status'] = "success";
                $response['message'] = "Tanqueo registrado con éxito.";
            }
            else{
                $response['status'] = "error";
                $response['message'] = "No se registro el tanqueo.";
            }
        }
        return $response;
    }

    public function actionConsultaMedicion($idVehiculo){
        $vehiculo = new Vehiculos;

        $vehiculo = Vehiculos::findOne($idVehiculo);
        $username = 'wsdatumpos';
        $password = 'Ddatum_pepe123*';
        $placas = $vehiculo->placa;

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
            $val = ["valor" => $value['Odometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa"=>$vehiculo->placa, "function" => 'odom'];

            return Json::encode($val);
        } else {
            $head = new SoapHeader('http://190.143.101.58:2998/', 'GetLastPositionWithHorometerResult', $auth, false);
            $client->__setSoapHeaders($head);


            /* Executing a fuction GETLASTPOSITION*/
            $resultado = $client->GetLastPositionWithHorometer($auth)->GetLastPositionWithHorometerResult;
            $value = json_decode($resultado, true);
            $val = ["valor" => $value['Horometro'], "estado" => $value['NEvento'], "fecha" => $value['Fecha'], "hora" => $value['Hora'], "tipo" => $vehiculo->tipo_medicion, "placa"=>$vehiculo->placa, "function" => 'horom'];

            return Json::encode($val);
        }

    }
}