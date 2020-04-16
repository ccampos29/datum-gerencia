<?php

namespace frontend\models;

use Yii;
use common\models\User;
use frontend\models\ImagenesEmpresas;
use yii\web\UploadedFile;
use backend\models\AuthAssignment;

/**
 * This is the model class for table "empresas".
 *
 * @property int $id
 * @property string $nombre Nombre de la empresa
 * @property string $nit_identificacion Nit de la empresa o 
 * @property string $digito_verificacion Digito de verificación
 * @property string $numero_fijo Número fijo de la empresa
 * @property string $numero_celular Número celular de la empresa
 * @property string $correo_contacto Correo del contacto de la empresa
 * @property string $direccion Dirección de la empresa
 * @property string $fecha_inicio_licencia Fecha de inicio de la licencia para utilizar el software
 * @property string $fecha_fin_licencia Fecha de fin de la licencia para utilizar el software
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property string $tipo Tipo de empresa
 * @property int $estado Inidica si una empresa esta activa o no, todos los usuarios que esten ligados a esta empresa dependen de este atributo para poder usar el sistema
 *
 * @property AcuerdoPrecios[] $acuerdoPrecios
 * @property CalificacionesChecklist[] $calificacionesChecklists
 * @property CentrosCostos[] $centrosCostos
 * @property Checklist[] $checklists
 * @property Combustibles[] $combustibles
 * @property Conceptos[] $conceptos
 * @property CriteriosEvaluaciones[] $criteriosEvaluaciones
 * @property DocumentosProveedores[] $documentosProveedores
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property EstadosChecklist[] $estadosChecklists
 * @property EtiquetasMantenimientos[] $etiquetasMantenimientos
 * @property Grupos2Vehiculos[] $grupos2Vehiculos
 * @property GruposInsumos[] $gruposInsumos
 * @property GruposNovedades[] $gruposNovedades
 * @property GruposVehiculos[] $gruposVehiculos
 * @property ImagenesEmpresas[] $imagenesEmpresas
 * @property ImagenesVehiculos[] $imagenesVehiculos
 * @property LineasMarcas[] $lineasMarcas
 * @property LineasMotores[] $lineasMotores
 * @property Mantenimientos[] $mantenimientos
 * @property MarcasMotores[] $marcasMotores
 * @property MarcasVehiculos[] $marcasVehiculos
 * @property Mediciones[] $mediciones
 * @property Motores[] $motores
 * @property Novedades[] $novedades
 * @property NovedadesMantenimientos[] $novedadesMantenimientos
 * @property OrdenesTrabajos[] $ordenesTrabajos
 * @property OrdenesTrabajosRepuestos[] $ordenesTrabajosRepuestos
 * @property OrdenesTrabajosTrabajos[] $ordenesTrabajosTrabajos
 * @property OtrosGastos[] $otrosGastos
 * @property OtrosIngresos[] $otrosIngresos
 * @property PeriodicidadesRutinas[] $periodicidadesRutinas
 * @property PeriodicidadesTrabajos[] $periodicidadesTrabajos
 * @property PrioridadesMantenimientos[] $prioridadesMantenimientos
 * @property PropiedadesTrabajos[] $propiedadesTrabajos
 * @property Proveedores[] $proveedores
 * @property Repuestos[] $repuestos
 * @property RepuestosProveedores[] $repuestosProveedores
 * @property Rutinas[] $rutinas
 * @property RutinasRepuestos[] $rutinasRepuestos
 * @property RutinasTrabajos[] $rutinasTrabajos
 * @property Sistemas[] $sistemas
 * @property Subsistemas[] $subsistemas
 * @property TiemposMuertos[] $tiemposMuertos
 * @property TiposChecklist[] $tiposChecklists
 * @property TiposCombustibles[] $tiposCombustibles
 * @property TiposDescuentos[] $tiposDescuentos
 * @property TiposDocumentos[] $tiposDocumentos
 * @property TiposGastos[] $tiposGastos
 * @property TiposImpuestos[] $tiposImpuestos
 * @property TiposIngresos[] $tiposIngresos
 * @property TiposMantenimientos[] $tiposMantenimientos
 * @property TiposMediciones[] $tiposMediciones
 * @property TiposOrdenes[] $tiposOrdenes
 * @property TiposPeriodicidades[] $tiposPeriodicidades
 * @property TiposProveedores[] $tiposProveedores
 * @property TiposSeguros[] $tiposSeguros
 * @property TiposServicios[] $tiposServicios
 * @property TiposTrabajosVehiculos[] $tiposTrabajosVehiculos
 * @property TiposVehiculos[] $tiposVehiculos
 * @property Trabajos[] $trabajos
 * @property UbicacionesInsumos[] $ubicacionesInsumos
 * @property UnidadesMedidas[] $unidadesMedidas
 * @property User[] $users
 * @property Vehiculos[] $vehiculos
 * @property VehiculosDesvincular[] $vehiculosDesvinculars
 * @property VehiculosGruposVehiculos[] $vehiculosGruposVehiculos
 * @property VehiculosImpuestos[] $vehiculosImpuestos
 * @property VehiculosOtrosDocumentos[] $vehiculosOtrosDocumentos
 * @property VehiculosSeguros[] $vehiculosSeguros
 * @property ZonasCentrosCostos[] $zonasCentrosCostos
 */
class Empresas extends \common\models\MyActiveRecord {

    public $logoEmpresa;
    public $usuario_principal_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'empresas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['nombre', 'nit_identificacion', 'digito_verificacion', 'numero_celular', 'correo_contacto', 'direccion', 'fecha_inicio_licencia', 'fecha_fin_licencia', 'tipo'], 'required'],
            [['creado_por', 'actualizado_por'], 'integer'],
            [['fecha_inicio_licencia', 'fecha_fin_licencia', 'creado_el', 'actualizado_el', 'estado'], 'safe'],
            [['tipo'], 'string'],
            [['logoEmpresa'], 'file'],
            [['nombre', 'correo_contacto', 'direccion'], 'string', 'max' => 355],
            [['nit_identificacion'], 'string', 'max' => 12],
            [['digito_verificacion'], 'string', 'max' => 3],
            [['numero_fijo', 'numero_celular'], 'string', 'max' => 15],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
                //[['usuario_principal_id'], 'eist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_principal_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'nit_identificacion' => 'NIT/Identificación',
            'digito_verificacion' => 'Digito de verificación',
            'numero_fijo' => 'Número fijo',
            'numero_celular' => 'Número celular',
            'correo_contacto' => 'Correo de contacto',
            'direccion' => 'Dirección',
            'fecha_inicio_licencia' => 'Fecha inicio de licencia',
            'fecha_fin_licencia' => 'Fecha fin de licencia',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'tipo' => 'Tipo',
            'estado' => 'Estado',
        ];
    }

    /**
     * Realiza la creación del usuario que administra el perfil de la empresa
     * que se esta creando
     * @param signupform $usuario
     */
    public function asociarUsuarioAdministrador($usuario) {
        /**
         * Primero realizo la creación del usuario
         */
        $user = new User();
        $user->username = $usuario['username'];
        $user->email = $usuario['email'];
        $user->name = $usuario['name'];
        $user->surname = $usuario['surname'];
        $user->id_number = $usuario['id_number'];
        $user->estado = User::ESTADO_INACTIVO;
        $user->empresa_id = $this->id;
        $user->es_administrador_empresa = 1;
        $user->setPassword($usuario['password']);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if (!$user->save()) {
            print_r($user->getErrors());
            die();
        }
        $this->save();
        $model = new AuthAssignment;
        $model->user_id = $user->id;
        $model->item_name = 'r-administrador-empresa';
        $model->save();
        Yii::$app->notificador->enviarCorreoNuevoUsuarioAdministrador($user,$this);
    }

    /**
     * Realiza la asociación de la imagen con la empresa
     */
    public function almacenarImagen() {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesEmpresas'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $archivo = UploadedFile::getInstance($this, 'logoEmpresa');
        if (!empty($archivo)) {
            $imagen = new ImagenesEmpresas();
            $imagen->nombre_archivo_original = $archivo->name;
            $imagen->nombre_archivo = uniqid('empresa_' . $this->id . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'empresa' . $this->id . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagen->ruta_archivo = $rutaCarpetaDocumento . $imagen->nombre_archivo;
            $imagen->empresa_id = $this->id;
            if (!$imagen->save()) {
                print_r($imagen->getErrors());
                die();
            }
            $guardoBien = $archivo->saveAs($imagen->ruta_archivo);
            $imagen->nombre_archivo = 'empresa' . $this->id . "/" . $imagen->nombre_archivo;
            $imagen->save();
            if (!$guardoBien) {
                $imagen->delete();
            }
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user) {
        return Yii::$app
                        ->mailer
                        ->compose(
                                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'], ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => 'Registro en DATUM GERENCIA'])
                        ->setTo($user->email)
                        ->setSubject('Se ha registrado la empresa ' . $this->nombre)
                        ->send();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcuerdoPrecios() {
        return $this->hasMany(AcuerdoPrecios::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionesChecklists() {
        return $this->hasMany(CalificacionesChecklist::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentrosCostos() {
        return $this->hasMany(CentrosCostos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklists() {
        return $this->hasMany(Checklist::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCombustibles() {
        return $this->hasMany(Combustibles::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConceptos() {
        return $this->hasMany(Conceptos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriosEvaluaciones() {
        return $this->hasMany(CriteriosEvaluaciones::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentosProveedores() {
        return $this->hasMany(DocumentosProveedores::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreadoPor() {
        return $this->hasOne(User::className(), ['id' => 'creado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualizadoPor() {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosChecklists() {
        return $this->hasMany(EstadosChecklist::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtiquetasMantenimientos() {
        return $this->hasMany(EtiquetasMantenimientos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getGrupos2Vehiculos() {
    //     return $this->hasMany(Grupos2Vehiculos::className(), ['empresa_id' => 'id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposInsumos() {
        return $this->hasMany(GruposInsumos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposNovedades() {
        return $this->hasMany(GruposNovedades::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposVehiculos() {
        return $this->hasMany(GruposVehiculos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenesEmpresas() {
        return $this->hasMany(ImagenesEmpresas::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagenesVehiculos() {
        return $this->hasMany(ImagenesVehiculos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineasMarcas() {
        return $this->hasMany(LineasMarcas::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineasMotores() {
        return $this->hasMany(LineasMotores::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantenimientos() {
        return $this->hasMany(Mantenimientos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcasMotores() {
        return $this->hasMany(MarcasMotores::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcasVehiculos() {
        return $this->hasMany(MarcasVehiculos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediciones() {
        return $this->hasMany(Mediciones::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotores() {
        return $this->hasMany(Motores::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedades() {
        return $this->hasMany(Novedades::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadesMantenimientos() {
        return $this->hasMany(NovedadesMantenimientos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajos() {
        return $this->hasMany(OrdenesTrabajos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajosRepuestos() {
        return $this->hasMany(OrdenesTrabajosRepuestos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenesTrabajosTrabajos() {
        return $this->hasMany(OrdenesTrabajosTrabajos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOtrosGastos() {
        return $this->hasMany(OtrosGastos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOtrosIngresos() {
        return $this->hasMany(OtrosIngresos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodicidadesRutinas() {
        return $this->hasMany(PeriodicidadesRutinas::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodicidadesTrabajos() {
        return $this->hasMany(PeriodicidadesTrabajos::className(), ['empresa_id' => 'id']);
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getPrioridadesMantenimientos() {
    //     return $this->hasMany(PrioridadesMantenimientos::className(), ['empresa_id' => 'id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropiedadesTrabajos() {
        return $this->hasMany(PropiedadesTrabajos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedores() {
        return $this->hasMany(Proveedores::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuestos() {
        return $this->hasMany(Repuestos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepuestosProveedores() {
        return $this->hasMany(RepuestosProveedores::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinas() {
        return $this->hasMany(Rutinas::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinasRepuestos() {
        return $this->hasMany(RutinasRepuestos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinasTrabajos() {
        return $this->hasMany(RutinasTrabajos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSistemas() {
        return $this->hasMany(Sistemas::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubsistemas() {
        return $this->hasMany(Subsistemas::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiemposMuertos() {
        return $this->hasMany(TiemposMuertos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposChecklists() {
        return $this->hasMany(TiposChecklist::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposCombustibles() {
        return $this->hasMany(TiposCombustibles::className(), ['empresa_id' => 'id']);
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getTiposDescuentos() {
    //     return $this->hasMany(TiposDescuentos::className(), ['empresa_id' => 'id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposDocumentos() {
        return $this->hasMany(TiposDocumentos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposGastos() {
        return $this->hasMany(TiposGastos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposImpuestos() {
        return $this->hasMany(TiposImpuestos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposIngresos() {
        return $this->hasMany(TiposIngresos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposMantenimientos() {
        return $this->hasMany(TiposMantenimientos::className(), ['empresa_id' => 'id']);
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getTiposMediciones() {
    //     return $this->hasMany(TiposMediciones::className(), ['empresa_id' => 'id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposOrdenes() {
        return $this->hasMany(TiposOrdenes::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposPeriodicidades() {
        return $this->hasMany(TiposPeriodicidades::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposProveedores() {
        return $this->hasMany(TiposProveedores::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposSeguros() {
        return $this->hasMany(TiposSeguros::className(), ['empresa_id' => 'id']);
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getTiposServicios() {
    //     return $this->hasMany(TiposServicios::className(), ['empresa_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getTiposTrabajosVehiculos() {
    //     return $this->hasMany(TiposTrabajosVehiculos::className(), ['empresa_id' => 'id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposVehiculos() {
        return $this->hasMany(TiposVehiculos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajos() {
        return $this->hasMany(Trabajos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacionesInsumos() {
        return $this->hasMany(UbicacionesInsumos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadesMedidas() {
        return $this->hasMany(UnidadesMedidas::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(User::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculos() {
        return $this->hasMany(Vehiculos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosDesvinculars() {
        return $this->hasMany(VehiculosDesvincular::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosGruposVehiculos() {
        return $this->hasMany(VehiculosGruposVehiculos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosImpuestos() {
        return $this->hasMany(VehiculosImpuestos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosOtrosDocumentos() {
        return $this->hasMany(VehiculosOtrosDocumentos::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculosSeguros() {
        return $this->hasMany(VehiculosSeguros::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZonasCentrosCostos() {
        return $this->hasMany(ZonasCentrosCostos::className(), ['empresa_id' => 'id']);
    }
    
    public function getUsuarioPrincipal(){
        $usuario = User::find()->where(['empresa_id' => $this->id,'es_administrador_empresa' => 1])->one();
        return $usuario;
    }

}
