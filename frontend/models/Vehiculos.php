<?php

namespace frontend\models;

use common\models\User;
use frontend\models\VehiculosGruposVehiculos;
use Yii;
use frontend\models\MarcasMotores;
use frontend\models\ImagenesVehiculos;
use SoapClient;
use SoapHeader;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * This is the model class for table "vehiculos".
 *
 * @property int $id
 * @property string $placa Placa del vehiculo
 * @property int $modelo Modelo del vehiculo
 * @property string $color Color del vehiculo
 * @property float $distancia_maxima Distancia maxima recorrida por un vehiculo
 * @property float|null $distancia_promedio Distancia promedio recorrida por un vehiculo
 * @property float|null $horas_dia Horas de actividad diarias de un vehiculo
 * @property string|null $observaciones Observacion sobre el vehiculo cargado
 * @property string $propietario_vehiculo Nombre del propietario del vehiculo
 * @property string $numero_chasis Numero de serie del chasis de un vehiculo
 * @property string $numero_serie Numero de serie de un vehiculo
 * @property string $tipo_carroceria Nombre de la carroceria de un vehiculo
 * @property int $cantidad_sillas Cantidad de sillas que tiene un vehiculo
 * @property float|null $toneladas_carga Toneladas de carga que tiene un vehiculo
 * @property string $codigo_fasecolda Codigo generado por fasecolda
 * @property string $fecha_compra Fecha de compra de un vehiculo
 * @property float|null $medicion_compra Medicion con la que un vehiculo es adquirido
 * @property float|null $precio_accesorios Precio de los accesorios con los que fue adquirido un vehiculo
 * @property string|null $nombre_vendedor Nombre del vendedor del vehiculo
 * @property string|null $numero_importacion Numero de importacion de un vehiculo
 * @property string|null $fecha_importacion Fecha de importacion de un vehiculo
 * @property string|null $vehiculo_imei_gps Imei que posee el gps de un vehiculo
 * @property int $marca_vehiculo_id Dato intermedio entre vehiculos y marcas_vehiculos
 * @property int $linea_vehiculo_id Dato intermedio entre vehiculos y lineas_marcas
 * @property int $motor_id Dato intermedio entre vehiculos y motores
 * @property int $linea_motor_id Dato intermedio entre vehiculos y lineas_motores
 * @property int $tipo_vehiculo_id Dato intermedio entre vehiculos y tipos_vehiculos
 * @property string $tipo_medicion Dato correspondiente al tipo de medicion
 * @property string $tipo_servicio Servicios de los vehiculos
 * @property string $tipo_trabajo Trabajos de los vehiculos
 * @property int $tipo_combustible_id Dato intermedio entre vehiculos y tipos_combustibles
 * @property int $centro_costo_id Dato intermedio entre vehiculos y centros_costos
 * @property int $vehiculo_equipo Dato que varia entre Si/No para informar si se permite instalar un equipo nuevo al vehiculo
 * @property string|null $vehiculo_equipo_observacion Observacion de la vinculacion de un equipo nuevo para un vehiculo de la plataforma
 * @property int $municipio_id Dato intermedio entre vehiculos y municipios
 * @property int $departamento_id Dato intermedio entre vehiculos y departamentos
 * @property int $pais_id Dato intermedio entre vehiculos y pais
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 * @property int $precio_compra Precio de compra del vehiculo
 * @property string $identificacion_auxiliar
 *
 * @property CalificacionesChecklist[] $calificacionesChecklists
 * @property Checklist[] $checklists
 * @property Combustibles[] $combustibles
 * @property ImagenesVehiculos[] $imagenesVehiculos
 * @property Mantenimientos[] $mantenimientos
 * @property Mediciones[] $mediciones
 * @property NovedadesMantenimientos[] $novedadesMantenimientos
 * @property OrdenesTrabajos[] $ordenesTrabajos
 * @property OtrosGastos[] $otrosGastos
 * @property OtrosIngresos[] $otrosIngresos
 * @property PeriodicidadesRutinas[] $periodicidadesRutinas
 * @property PeriodicidadesTrabajos[] $periodicidadesTrabajos
 * @property User $creadoPor
 * @property CentrosCostos $centroCosto
 * @property Pais $pais
 * @property Departamentos $departamento
 * @property Municipios $municipio
 * @property Empresas $empresa
 * @property LineasMarcas $lineaVehiculo
 * @property User $actualizadoPor
 * @property MarcasVehiculos $marcaVehiculo
 * @property MarcasMotores $motor
 * @property LineasMotores $lineaMotor
 * @property TiposVehiculos $tipoVehiculo
 * @property TiposCombustibles $tipoCombustible
 * @property VehiculosConductores[] $vehiculosConductores
 * @property VehiculosDesvincular[] $vehiculosDesvinculars
 * @property VehiculosDocumentosArchivos[] $vehiculosDocumentosArchivos
 * @property VehiculosGruposVehiculos[] $vehiculosGruposVehiculos
 * @property VehiculosImpuestos[] $vehiculosImpuestos
 * @property VehiculosImpuestosArchivos[] $vehiculosImpuestosArchivos
 * @property VehiculosOtrosDocumentos[] $vehiculosOtrosDocumentos
 * @property VehiculosSeguros[] $vehiculosSeguros
 * @property VehiculosSegurosArchivos[] $vehiculosSegurosArchivos
 */
class Vehiculos extends \common\models\MyActiveRecord
{
    
    public $medicion;
    public $fotoVehiculo;
    public $grupos;
    public $fecha_1, $fecha_2, $fecha2_1, $fecha2_2;
    public $kms_recorrido;
    public $odometro;
    public $total_valor_trabajo,$total_valor_repuesto,$total_combustible,$total_otros_gastos,$costo_total,$recorrido,$costo_por_unidad;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos';
    }
    /**
     * Registra y/o Modifica la empresa en el modelo, según la empresa del usuario logueado
     * @param string $insert Query de inserción
     * @return mixed[]
     */
    public function beforeSave($insert) {
        $this->empresa_id = Yii::$app->user->identity->empresa_id;
        return parent::beforeSave($insert);
    }
    /**
     * Sobreescritura del método find para que siempre filtre por la empresa del usuario logueado
     * @return array Arreglo filtrado por empresa
     */
    public static function find()
    {
        return parent::find()->andFilterWhere(['vehiculos.empresa_id'=>@Yii::$app->user->identity->empresa_id]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['placa', 'modelo', 'color', 'distancia_maxima', 'propietario_vehiculo', 'numero_chasis', 'numero_serie', 'tipo_carroceria', 'cantidad_sillas', 'codigo_fasecolda', 'fecha_compra', 'marca_vehiculo_id', 'linea_vehiculo_id', 'motor_id', 'linea_motor_id', 'tipo_vehiculo_id', 'tipo_medicion', 'tipo_servicio', 'tipo_trabajo', 'tipo_combustible_id', 'centro_costo_id', 'vehiculo_equipo', 'municipio_id', 'departamento_id', 'pais_id', 'precio_compra', 'identificacion_auxiliar', 'fecha_importacion', 'vehiculo_imei_gps', 'nombre_vendedor', 'numero_importacion'], 'required'],
            [['modelo', 'cantidad_sillas', 'marca_vehiculo_id', 'linea_vehiculo_id', 'motor_id', 'linea_motor_id', 'tipo_vehiculo_id', 'tipo_combustible_id', 'centro_costo_id', 'vehiculo_equipo', 'municipio_id', 'departamento_id', 'pais_id', 'creado_por', 'actualizado_por', 'empresa_id', 'precio_compra'], 'integer'],
            [['distancia_maxima', 'distancia_promedio', 'horas_dia', 'toneladas_carga', 'medicion_compra', 'precio_accesorios'], 'number'],
            [['observaciones', 'tipo_medicion', 'tipo_servicio', 'tipo_trabajo', 'vehiculo_equipo_observacion'], 'string'],
            [['fecha_compra', 'fecha_importacion', 'creado_el', 'actualizado_el'], 'safe'],
            [['placa', 'color', 'propietario_vehiculo', 'numero_chasis', 'numero_serie', 'tipo_carroceria', 'codigo_fasecolda', 'nombre_vendedor', 'numero_importacion', 'vehiculo_imei_gps', 'identificacion_auxiliar'], 'string', 'max' => 255],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['centro_costo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CentrosCostos::className(), 'targetAttribute' => ['centro_costo_id' => 'id']],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['municipio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['municipio_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['linea_vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => LineasMarcas::className(), 'targetAttribute' => ['linea_vehiculo_id' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['marca_vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarcasVehiculos::className(), 'targetAttribute' => ['marca_vehiculo_id' => 'id']],
            [['motor_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarcasMotores::className(), 'targetAttribute' => ['motor_id' => 'id']],
            [['linea_motor_id'], 'exist', 'skipOnError' => true, 'targetClass' => LineasMotores::className(), 'targetAttribute' => ['linea_motor_id' => 'id']],
            [['tipo_vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposVehiculos::className(), 'targetAttribute' => ['tipo_vehiculo_id' => 'id']],
            [['tipo_combustible_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposCombustibles::className(), 'targetAttribute' => ['tipo_combustible_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'placa' => 'Placa',
            'modelo' => 'Modelo',
            'color' => 'Color',
            'distancia_maxima' => 'Distancia maxima',
            'distancia_promedio' => 'Distancia promedio',
            'horas_dia' => 'Horas dia',
            'observaciones' => 'Observaciones',
            'propietario_vehiculo' => 'Propietario vehiculo',
            'numero_chasis' => 'Numero chasis',
            'numero_serie' => 'Numero serie',
            'tipo_carroceria' => 'Tipo carroceria',
            'cantidad_sillas' => 'Cantidad sillas',
            'toneladas_carga' => 'Toneladas carga',
            'codigo_fasecolda' => 'Codigo fasecolda',
            'fecha_compra' => 'Fecha compra',
            'medicion_compra' => 'Medicion compra',
            'precio_accesorios' => 'Precio accesorios',
            'nombre_vendedor' => 'Nombre vendedor',
            'numero_importacion' => 'Numero importacion',
            'fecha_importacion' => 'Fecha importacion',
            'vehiculo_imei_gps' => 'Vehiculo imei gps',
            'marca_vehiculo_id' => 'Marca vehiculo',
            'linea_vehiculo_id' => 'Linea vehiculo',
            'motor_id' => 'Motor',
            'linea_motor_id' => 'Linea motor',
            'tipo_vehiculo_id' => 'Tipo vehiculo',
            'tipo_medicion' => 'Tipo medicion',
            'tipo_servicio' => 'Tipo servicio',
            'tipo_trabajo' => 'Tipo trabajo',
            'tipo_combustible_id' => 'Tipo combustible',
            'centro_costo_id' => 'Centro costo',
            'vehiculo_equipo' => 'Vehiculo equipo',
            'vehiculo_equipo_observacion' => 'Vehiculo equipo observacion',
            'municipio_id' => 'Municipio',
            'departamento_id' => 'Departamento',
            'pais_id' => 'Pais',
            'creado_por' => 'Creado por',
            'creado_el' => 'Creado el',
            'actualizado_por' => 'Actualizado por',
            'actualizado_el' => 'Actualizado el',
            'empresa_id' => 'Empresa',
            'precio_compra' => 'Precio compra',
            'identificacion_auxiliar' => 'Identificacion auxiliar',
            'medicion' => 'Medicion del vehiculo'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionesChecklists()
    {
        return $this->hasMany(CalificacionesChecklist::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklists()
    {
        return $this->hasMany(Checklist::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCombustibles()
    {
        return $this->hasMany(Combustibles::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenesVehiculos()
    {
        return $this->hasMany(ImagenesVehiculos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantenimientos()
    {
        return $this->hasMany(Mantenimientos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediciones()
    {
        return $this->hasMany(Mediciones::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadesMantenimientos()
    {
        return $this->hasMany(NovedadesMantenimientos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajos()
    {
        return $this->hasMany(OrdenesTrabajos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOtrosGastos()
    {
        return $this->hasMany(OtrosGastos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOtrosIngresos()
    {
        return $this->hasMany(OtrosIngresos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodicidadesRutinas()
    {
        return $this->hasMany(PeriodicidadesRutinas::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodicidadesTrabajos()
    {
        return $this->hasMany(PeriodicidadesTrabajos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCosto()
    {
        return $this->hasOne(CentrosCostos::className(), ['id' => 'centro_costo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamentos::className(), ['id' => 'departamento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipio()
    {
        return $this->hasOne(Municipios::className(), ['id' => 'municipio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineaVehiculo()
    {
        return $this->hasOne(LineasMarcas::className(), ['id' => 'linea_vehiculo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcaVehiculo()
    {
        return $this->hasOne(MarcasVehiculos::className(), ['id' => 'marca_vehiculo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotor()
    {
        return $this->hasOne(MarcasMotores::className(), ['id' => 'motor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineaMotor()
    {
        return $this->hasOne(LineasMotores::className(), ['id' => 'linea_motor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoVehiculo()
    {
        return $this->hasOne(TiposVehiculos::className(), ['id' => 'tipo_vehiculo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoCombustible()
    {
        return $this->hasOne(TiposCombustibles::className(), ['id' => 'tipo_combustible_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosConductores()
    {
        return $this->hasMany(VehiculosConductores::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosDesvinculars()
    {
        return $this->hasMany(VehiculosDesvincular::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosDocumentosArchivos()
    {
        return $this->hasMany(VehiculosDocumentosArchivos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosGruposVehiculos()
    {
        return $this->hasMany(VehiculosGruposVehiculos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosImpuestos()
    {
        return $this->hasMany(VehiculosImpuestos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosImpuestosArchivos()
    {
        return $this->hasMany(VehiculosImpuestosArchivos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosOtrosDocumentos()
    {
        return $this->hasMany(VehiculosOtrosDocumentos::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosSeguros()
    {
        return $this->hasMany(VehiculosSeguros::className(), ['vehiculo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosSegurosArchivos()
    {
        return $this->hasMany(VehiculosSegurosArchivos::className(), ['vehiculo_id' => 'id']);
    }

   
    /**
     * Asocia los trabajos a las rutinas
     * @param array $trabajos
     */
    public function asociarGrupos($param,$grupos)
    {
        //$this->eliminarTrabajos();
        foreach ($grupos as $grupo) {
            if($grupo != null){
                $gruposVehiculos = new VehiculosGruposVehiculos();
                $gruposVehiculos->vehiculo_id = $param;
                $gruposVehiculos->grupo_vehiculo_id = $grupo;
                if (!$gruposVehiculos->save()) {
                    print_r($gruposVehiculos->getErrors());
                    die();
                }
            }
            
            //print_r($var);
        }
    }

    /*public function getImageUrl(){

        return \yii\helpers\Url::to('@web/imagenes/vehiculos/vehiculo'.$this->id, true);
    }*/

    /**
     * Realiza la asociación de la imagen con la empresa
     */
    public function almacenarImagenes($idVehiculo) {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesVehiculos'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }


        $archivo = UploadedFile::getInstance($this, 'fotoVehiculo');
        if (!empty($archivo)) {
            $imagen = new ImagenesVehiculos();
            $imagen->nombre_archivo_original = $archivo->name;
            $imagen->nombre_archivo = uniqid('vehiculo_' . $idVehiculo . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'vehiculo' . $idVehiculo . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagen->ruta_archivo = $rutaCarpetaDocumento . $imagen->nombre_archivo;
            $imagen->vehiculo_id = $idVehiculo;
            if (!$imagen->save()) {
                Yii::$app->session->setFlash('warning', 'La imagen del vehiculo no fue almacenada correctamente');
            }
            $guardoBien = $archivo->saveAs($imagen->ruta_archivo);
            $imagen->nombre_archivo = 'vehiculo' . $idVehiculo . "/" . $imagen->nombre_archivo;
            $imagen->save();
            if (!$guardoBien) {
                $imagen->delete();
            }
        }
    }

    public function antesDelete() {
        $imagenes = ImagenesVehiculos::find()->where(['vehiculo_id'=>$this->id])->all();
        foreach ($imagenes as $imagen) {
            if(!empty($imagen)){
                $imagen->delete();
            }
            
        }
        $grupos = VehiculosGruposVehiculos::find()->where(['vehiculo_id' => $this->id])->all();
        foreach ($grupos as $grupo) {
            if(!empty($grupo)){
                $grupo->delete();
            }
        }
    }

    /*
    * Metodo que permite la consulta de una medicion via web service.
    */
    public function actionConsultaMedicion($idVehiculo)
    {
        $vehiculo = new Vehiculos;

        $vehiculo = Vehiculos::findOne($idVehiculo);
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
