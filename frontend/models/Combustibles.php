<?php

namespace frontend\models;

use common\models\User;
use Yii;
use frontend\models\GruposVehiculos;
use yii\web\UploadedFile;

/**
 * This is the model class for table "combustibles".
 *
 * @property int $id
 * @property string $fecha Fecha del tanqueo
 * @property string $hora Hora del tanqueo
 * @property int $tanqueo_full Boolean usado para definir si se tanqueo por completo un vehiculo
 * @property float $costo_por_galon Costo por galon de combustible
 * @property int $cantidad_combustible Cantidad de galones de combustible
 * @property string|null $observacion Observación del gasto cargado
 * @property int|null $numero_tiquete Codigo/numero del tiquete de pago del combustible
 * @property int $vehiculo_id Dato intermedio entre combustibles y vehiculos
 * @property int $tipo_combustible_id Dato intermedio entre combustibles y tipos_combustibles
 * @property int $proveedor_id Dato intermedio entre combustibles y proveedores
 * @property int $usuario_id Dato intermedio entre combustibles y empleados
 * @property int $centro_costo_id Dato intermedio entre combustibles y centros_costos
 * @property int $municipio_id Dato intermedio entre combustibles y municipios
 * @property int $departamento_id Dato intermedio entre combustibles y ciudades
 * @property int $grupo_vehiculo_id Dato intermedio entre combustibles y grupos_vehiculos
 * @property int $medicion_actual Dato intermedio entre combustibles y mediciones
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 * @property int $pais_id Relación con pais
 *
 * @property Vehiculos $vehiculo
 * @property Empresas $empresa
 * @property Pais $pais
 * @property TiposCombustibles $tipoCombustible
 * @property Proveedores $proveedor
 * @property CentrosCostos $centroCosto
 * @property Municipios $municipio
 * @property GruposVehiculos $grupoVehiculo
 * @property Departamentos $departamento
 * @property User $usuario
 */
class Combustibles extends \common\models\MyActiveRecord
{
    public $imagenCombustible;
    public $grupos;
    public $test;
    public $total_cost;
    public $total_cant;
    public $fecha_1, $fecha_2;
    public $kms_recorrido, $km_volumen;
    public $medicion_compare;
    public $dias_recorridos, $promedio_dias_recorridos;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'combustibles';
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
        return parent::find()->andFilterWhere(['combustibles.empresa_id' =>@Yii::$app->user->identity->empresa_id]);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'hora', 'tanqueo_full', 'costo_por_galon', 'cantidad_combustible', 'vehiculo_id', 'tipo_combustible_id', 'proveedor_id', 'usuario_id', 'centro_costo_id', 'municipio_id', 'departamento_id', 'grupo_vehiculo_id', 'medicion_actual', 'pais_id'], 'required'],
            [['fecha', 'hora', 'creado_el', 'actualizado_el'], 'safe'],
            [['tanqueo_full', 'cantidad_combustible', 'numero_tiquete', 'vehiculo_id', 'tipo_combustible_id', 'proveedor_id', 'usuario_id', 'centro_costo_id', 'municipio_id', 'departamento_id', 'grupo_vehiculo_id', 'medicion_actual', 'creado_por', 'actualizado_por', 'empresa_id', 'pais_id'], 'integer'],
            [['costo_por_galon'], 'number'],
            [['observacion'], 'string'],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['pais_id' => 'id']],
            [['tipo_combustible_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposCombustibles::className(), 'targetAttribute' => ['tipo_combustible_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['centro_costo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CentrosCostos::className(), 'targetAttribute' => ['centro_costo_id' => 'id']],
            [['municipio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['municipio_id' => 'id']],
            [['grupo_vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposVehiculos::className(), 'targetAttribute' => ['grupo_vehiculo_id' => 'id']],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha del tanqueo',
            'hora' => 'Hora del tanqueo',
            'tanqueo_full' => 'Tanqueo full',
            'costo_por_galon' => 'Costo por galon',
            'cantidad_combustible' => 'Galones cargados',
            'observacion' => 'Observacion',
            'numero_tiquete' => 'Numero del tiquete',
            'vehiculo_id' => 'Vehiculo',
            'tipo_combustible_id' => 'Tipo de combustible',
            'proveedor_id' => 'Proveedor',
            'usuario_id' => 'Usuario',
            'centro_costo_id' => 'Centro de costos',
            'municipio_id' => 'Municipio',
            'departamento_id' => 'Departamento',
            'grupo_vehiculo_id' => 'Grupo del vehiculo',
            'medicion_actual' => 'Medicion actual',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa',
            'pais_id' => 'Pais',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::className(), ['id' => 'vehiculo_id']);
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
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'pais_id']);
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
    public function getProveedor()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'proveedor_id']);
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
    public function getMunicipio()
    {
        return $this->hasOne(Municipios::className(), ['id' => 'municipio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoVehiculo()
    {
        return $this->hasOne(GruposVehiculos::className(), ['id' => 'grupo_vehiculo_id']);
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
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
    }

    public function almacenarMedicion($q, $idVehiculo){
        $medicion = new Mediciones();
        $medicion->fecha_medicion = $q['fecha'];
        $medicion->hora_medicion = $q['hora'];
        if($q['function']=='horom'){
            $medicion->valor_medicion = round($q['valor']/60);
        
        }else{
            $medicion->valor_medicion = $q['valor'];
        
        }
        $medicion->estado_vehiculo = $q['estado'];
        $medicion->tipo_medicion = $q['tipo'];
        $medicion->vehiculo_id = $idVehiculo;
        $medicion->usuario_id = Yii::$app->user->identity->id;
        $medicion->proviene_de = 'Combustibles';
        if (!$medicion->save()) {
            print_r($medicion->getErrors());
            die();
        }
    }

    /**
     * Realiza la asociación de la imagen con la empresa
     */
    public function almacenarImagenes($idCombustible) {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesCombustibles'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }


        $archivo = UploadedFile::getInstance($this, 'imagenCombustible');
        if (!empty($archivo)) {
            $imagen = new ImagenesCombustibles();
            $imagen->nombre_archivo_original = $archivo->name;
            $imagen->nombre_archivo = uniqid('combustible_' . $idCombustible . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'combustible' . $idCombustible . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagen->ruta_archivo = $rutaCarpetaDocumento . $imagen->nombre_archivo;
            $imagen->combustible_id = $idCombustible;
            if (!$imagen->save()) {
                echo $imagen->getErrors();
                die();    
            }
            $guardoBien = $archivo->saveAs($imagen->ruta_archivo);
            $imagen->nombre_archivo = 'combustible' . $idCombustible . "/" . $imagen->nombre_archivo;
            $imagen->save();
            if (!$guardoBien) {
                $imagen->delete();
            }
        }
    }

    
    public function antesDelete()
    {
        $imagenes = ImagenesCombustibles::find()->where(['combustible_id'=>$this->id])->all();
        foreach ($imagenes as $imagen) {
            if(!empty($imagen)){
                $imagen->delete();
            }
            
        }
    }
    
}
