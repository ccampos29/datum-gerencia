<?php

namespace frontend\models;

use common\models\User;
use DateTime;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "calificaciones_checklist".
 *
 * @property int $id
 * @property string|null $valor_texto_calificacion Dato que indica la calificacion del checklist formato texto
 * @property int $novedad_id Dato intermedio entre calificaciones_checklist y novedades
 * @property int $grupo_novedad_id Dato intermedio entre calificaciones_checklist y grupos_novedades
 * @property int $checklist_id Dato intermedio entre calificaciones_checklist y checklist
 * @property int $tipo_checklist_id Dato intermedio entre calificaciones_checklist y tipos_checklist
 * @property int $vehiculo_id Dato intermedio entre calificaciones_checklist y vehiculos
 * @property int $criterio_calificacion_id Dato intermedio entre calificaciones_checklist y criterios_calificaciones
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 * @property int $empresa_id Relación con empresa
 *
 * @property Novedades $novedad
 * @property Empresas $empresa
 * @property GruposNovedades $grupoNovedad
 * @property Checklist $checklist
 * @property TiposChecklist $tipoChecklist
 * @property Vehiculos $vehiculo
 * @property CriteriosEvaluaciones $criterioCalificacion
 * @property Trabajos $trabajo
 * @property User $creadoPor
 * @property User $actualizadoPor
 */
class CalificacionesChecklist extends \common\models\MyActiveRecord
{
    public $novedadesCalificadas;
    public $imagenChecklist;
    public $test;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calificaciones_checklist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['novedadesCalificadas'], 'required'],

            [['valor_texto_editable', 'valor_texto_calificacion', 'novedad_id', 'grupo_novedad_id', 'checklist_id', 'tipo_checklist_id', 'vehiculo_id', 'criterio_calificacion_id', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el'], 'safe'],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedades::className(), 'targetAttribute' => ['novedad_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['grupo_novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => GruposNovedades::className(), 'targetAttribute' => ['grupo_novedad_id' => 'id']],
            [['checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Checklist::className(), 'targetAttribute' => ['checklist_id' => 'id']],
            [['tipo_checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposChecklist::className(), 'targetAttribute' => ['tipo_checklist_id' => 'id']],
            [['vehiculo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::className(), 'targetAttribute' => ['vehiculo_id' => 'id']],
            [['criterio_calificacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => CriteriosEvaluaciones::className(), 'targetAttribute' => ['criterio_calificacion_id' => 'id']],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_texto_calificacion' => 'Calificacion',
            'valor_texto_editable' => 'Calificacion Editable',
            'novedad_id' => 'Novedad',
            'grupo_novedad_id' => 'Grupo de la novedad',
            'checklist_id' => 'Checklist ID',
            'tipo_checklist_id' => 'Tipo Checklist ID',
            'vehiculo_id' => 'Vehiculo ID',
            'criterio_calificacion_id' => 'Criterio Calificacion ID',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
            'novedadesCalificadas' => 'La calificacion'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedades::className(), ['id' => 'novedad_id']);
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
    public function getGrupoNovedad()
    {
        return $this->hasOne(GruposNovedades::className(), ['id' => 'grupo_novedad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChecklist()
    {
        return $this->hasOne(Checklist::className(), ['id' => 'checklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoChecklist()
    {
        return $this->hasOne(TiposChecklist::className(), ['id' => 'tipo_checklist_id']);
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
    public function getCriterioCalificacion()
    {
        return $this->hasOne(CriteriosEvaluaciones::className(), ['id' => 'criterio_calificacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalle()
    {
        return $this->hasOne(CriteriosEvaluacionesDetalle::className(), ['id' => 'valor_texto_calificacion']);
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
    public function getActualizadoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'actualizado_por']);
    }

    /**
     * Asocia las calificaciones de los checklist
     * @param array $repuestos
     */
    public function asociarCalificacion($keys)
    {
        foreach ($keys as $k) {
            $key[] = [intval($k)];
        }
        $calif = new CalificacionesChecklist();
        if ($key[2][0] == 3) {
            foreach (CriteriosEvaluacionesDetalle::find()->where(['tipo_criterio_id' => $key[2][0]])->all() as $test) {
                if ($key[3][0] >= $test->minimo && $key[3][0] <= $test->maximo) {
                    $temporal = $test->id;
                }
            }
            $calif->grupo_novedad_id = $key[0][0];
            $calif->novedad_id = $key[1][0];
            $calif->criterio_calificacion_id = $key[2][0];
            $calif->valor_texto_calificacion = $temporal;

            $calif->vehiculo_id = $key[4][0];
            $calif->tipo_checklist_id = $key[5][0];
            $calif->checklist_id = $key[6][0];
            $calif->empresa_id = Yii::$app->user->identity->empresa_id;
            $calif->valor_texto_editable = $key[3][0];

            if (!$calif->save()) {
                print_r($calif->getErrors());
                die();
            }
        } else {
            $calif->grupo_novedad_id = $key[0][0];
            $calif->novedad_id = $key[1][0];
            $calif->criterio_calificacion_id = $key[2][0];
            $calif->valor_texto_calificacion = $key[3][0];
            $calif->vehiculo_id = $key[4][0];
            $calif->tipo_checklist_id = $key[5][0];
            $calif->checklist_id = $key[6][0];
            $calif->empresa_id = Yii::$app->user->identity->empresa_id;

            if (!$calif->save()) {
                print_r($calif->getErrors());
                die();
            }
        }
    }

    public function asociarNovedadesMantenimientos($keys)
    {
        foreach ($keys as $k) {
            $key[] = [intval($k)];
        }
        if ($key[2][0] == 3) {
            foreach (CriteriosEvaluacionesDetalle::find()->where(['tipo_criterio_id' => $key[2][0]])->all() as $test) {
                if ($key[3][0] >= $test->minimo && $key[3][0] <= $test->maximo) {
                    $temporal = $test->id;
                }
            }
        } else {
            $temporal = $key[3][0];
        }


        $novedadChecklist = NovedadesChecklist::find()->where(['novedad_id' => $key[1][0], 'id_criterio_evaluacion_det' => $temporal])->all();
        foreach ($novedadChecklist as $noveCheck) {
            if ($noveCheck->novedad->genera_novedades== 1 &&  (strtolower($noveCheck->calificacion0->estado) == 'rechazado' || strtolower($noveCheck->calificacion0->estado) == 'rechazado critico') ) {
                $novedades = new NovedadesMantenimientos();
                $novedades->vehiculo_id = $key[4][0];
                $novedades->fecha_hora_reporte = date('Y-m-d H:i');
                $novedades->usuario_reporte_id = Yii::$app->user->identity->id;
                if ($noveCheck->prioridad == 'Bajo') {
                    $novedades->prioridad_id = 1;
                } elseif ($noveCheck->prioridad == 'Medio') {
                    $novedades->prioridad_id = 2;
                } else {
                    $novedades->prioridad_id = 3;
                }
                $checklist = Checklist::find()->where(['id' => $key[6][0]])->one();
                $novedades->medicion = $checklist->medicion_actual;
                $novedades->trabajo_id = $noveCheck->trabajo_id;
                $novedades->empresa_id = Yii::$app->user->identity->empresa_id;
                $novedades->estado = 'Pendiente';
                $novedades->proviene_de = 'Checklist';
                $novedades->checklist_id = $checklist->id;
                if (!$novedades->save()) {
                    print_r($novedades->getErrors());
                    die();
                }
                Yii::$app->notificador->enviarCorreoNuevaNovedadMantenimiento($novedades);
            }
        }
    }
    /**
     * Realiza la asociación de la imagen con la empresa
     */
    public function almacenarImagenes($idChecklist)
    {
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaBaseImagenes'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }
        $rutaCarpeta = Yii::$app->basePath . Yii::$app->params['rutaImagenesChecklist'];
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta);
        }


        $archivo = UploadedFile::getInstance($this, 'imagenChecklist');
        if (!empty($archivo)) {
            $imagen = new ImagenesChecklist();
            $imagen->nombre_archivo_original = $archivo->name;
            $imagen->nombre_archivo = uniqid('checklist_' . $idChecklist . '_') . "." . $archivo->getExtension();
            $rutaCarpetaDocumento = $rutaCarpeta . 'checklist' . $idChecklist . '/';
            if (!file_exists($rutaCarpetaDocumento)) {
                mkdir($rutaCarpetaDocumento);
            }
            $imagen->ruta_archivo = $rutaCarpetaDocumento . $imagen->nombre_archivo;
            $imagen->checklist_id = $idChecklist;
            if (!$imagen->save()) {
                Yii::$app->session->setFlash('warning', 'La imagen del checklist no fue almacenada correctamente');
            }
            $guardoBien = $archivo->saveAs($imagen->ruta_archivo);
            $imagen->nombre_archivo = 'checklist' . $idChecklist . "/" . $imagen->nombre_archivo;
            $imagen->save();
            if (!$guardoBien) {
                $imagen->delete();
            }
        }
    }
}
