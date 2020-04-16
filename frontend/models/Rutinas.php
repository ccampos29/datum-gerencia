<?php

namespace frontend\models;

use common\models\MyActiveRecord;
use Yii;

use common\models\User;

/**
 * This is the model class for table "rutinas".
 *
 * @property int $id
 * @property string $nombre Es el nombre de una rutina
 * @property string $observacion Es una pequeña descripcion de la rutina
 * @property string $codigo Es el codigo especifico de cada empresa para cada rutina
 * @property int $estado Determina si la rutina esta activa o inactiva
 * @property int $tipo_rutina Es la periodicidad con la que se aplica esta rutina
 * @property int $creado_por
 * @property string $creado_el
 * @property int $actualizado_por
 * @property string $actualizado_el
 *
 * @property User $creadoPor
 * @property User $actualizadoPor
 * @property RutinasRepuestos[] $rutinasRepuestos
 * @property RutinasTrabajos[] $rutinasTrabajos
 */
class Rutinas extends MyActiveRecord
{

    /**
     * Escenario de validación para la asociación de repuestos
     * e insumos
     */
    const ESCENARIOREPUESTOSINSUMOS = 'escenariorepuestosinsumos';

    //public $trabajos,$cantidad,$valor;
    public $proviene;
    /**
     * Repuestos que se visualizan en el formulario
     * @var Array $repuestos
     */
    public $repuestos;


    public $trabajosRutinas = [];

    /**
     * Registra y/o Modifica la empresa en el modelo, según la empresa del usuario logueado
     * @param string $insert Query de inserción
     * @return mixed[]
     */
    public function beforeSave($insert)
    {
        $this->empresa_id = Yii::$app->user->identity->empresa_id;
        return parent::beforeSave($insert);
    }
    /**
     * Sobreescritura del método find para que siempre filtre por la empresa del usuario logueado
     * @return array Arreglo filtrado por empresa
     */
    public static function find()
    {
        return parent::find()->andFilterWhere(['empresa_id' =>@Yii::$app->user->identity->empresa_id]);
    }

    /**
     * Trabajos que se visualizan en el formulario
     * @var Array
     */
    public $trabajosFormulario;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rutinas';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['estado', 'periodico', 'creado_por', 'actualizado_por', 'empresa_id'], 'integer'],
            [['creado_el', 'actualizado_el', 'repuestos'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['observacion'], 'string', 'max' => 355],
            [['codigo', 'tipo_rutina'], 'string', 'max' => 20],
            [['creado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creado_por' => 'id']],
            [['actualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['actualizado_por' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [
                'repuestos',
                'validarRepuestos',
                'on' => self::ESCENARIOREPUESTOSINSUMOS
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'observacion' => 'Observacion',
            'codigo' => 'Codigo',
            'estado' => 'Estado',
            'tipo_rutina' => 'Tipo Rutina',
            'periodico' => 'Periodico',
            'creado_por' => 'Creado Por',
            'creado_el' => 'Creado El',
            'actualizado_por' => 'Actualizado Por',
            'actualizado_el' => 'Actualizado El',
            'empresa_id' => 'Empresa ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodicidadesRutinas()
    {
        return $this->hasMany(PeriodicidadesRutinas::className(), ['rutina_id' => 'id']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'empresa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinasRepuestos()
    {
        return $this->hasMany(RutinasRepuestos::className(), ['rutina_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutinasTrabajos()
    {
        return $this->hasMany(RutinasTrabajos::className(), ['rutina_id' => 'id']);
    }

    /**
     * Asocia los trabajos a las rutinas
     * @param array $trabajos
     */
    public function asociarTrabajos($trabajos)
    {
        //$this->eliminarTrabajos();
        foreach ($trabajos as $trabajo) {
            $rutinaTrabajo = new RutinasTrabajos();
            $rutinaTrabajo->rutina_id = $this->id;
            $rutinaTrabajo->trabajo_id  = $trabajo['trabajo_id'];
            $rutinaTrabajo->cantidad    = $trabajo['cantidad'];
            $rutinaTrabajo->observacion = $trabajo['observacion'];
            if (!$rutinaTrabajo->save()) {
                print_r($rutinaTrabajo->getErrors());
                die();
            }
        }
    }

    public function actualizarTrabajos($trabajos)
    {
        $trabajosExistentes = [];
        foreach ($this->rutinasTrabajos as $trabajo) {
            $trabajosExistentes[] = $trabajo->id;
        }
        $vecesentro = 0;
        foreach ($trabajos as $trabajito) {
            if (!empty($trabajito['id'])) {
                if (!in_array($trabajito['id'], $trabajosExistentes)) {
                    $vecesentro++;
                    $trabajoRutina = RutinasTrabajos::findOne($trabajito['id']);
                    $trabajoRutina->eliminarInsumosRepuestos();
                    
                    if(!$trabajoRutina->delete()){
                        print_r('no');
                        die();
                    }
                } else {
                    $posicionExistente = array_search($trabajito['id'], $trabajosExistentes);
                    $trabajoExistente = RutinasTrabajos::findOne($trabajosExistentes[$posicionExistente]);
                    $trabajoExistente->rutina_id = $trabajito['rutina_id'];
                    $trabajoExistente->cantidad = $trabajito['cantidad'];
                    $trabajoExistente->observacion = $trabajito['observacion'];
                    $trabajoExistente->save();
                    if(!$trabajoExistente->save()){
                        print_r($trabajoExistente->getErrors());
                        die();
                    }
                }
            } else {
                $nuevoTrabajo = new RutinasTrabajos();
                $nuevoTrabajo->rutina_id = $this->id;
                $nuevoTrabajo->trabajo_id = $trabajito['trabajo_id'];
                $nuevoTrabajo->cantidad = $trabajito['cantidad'];
                $nuevoTrabajo->observacion = $trabajito['observacion'];
                if(!$nuevoTrabajo->save()){
                    print_r($nuevoTrabajo->getErrors());
                    die();
                }
            }
        }

        // $trabajosExistentes2 = [];
        // echo '<pre>';
        // foreach ($this->rutinasTrabajos as $trabajo) {
        //     //$trabajosExistentes2 = [$trabajo->id];
        //     print_r($trabajo->getAttributes());
        // }

        // print_r($vecesentro);
        // die();
    }

    /**
     * Asocia los repuestos a las rutinas
     * @param array $repuestos
     */
    public function asociarRepuestos($repuestos)
    {
        //$this->eliminarTrabajos();
        foreach ($repuestos as $repuesto) {
            $rutinaTrabajo = new RutinasRepuestos();
            $rutinaTrabajo->rutina_id = $this->id;
            $rutinaTrabajo->repuesto_id = $repuesto['repuesto'];
            $rutinaTrabajo->rutina_trabajo_id = $repuesto['rutina_trabajo_id'];
            $rutinaTrabajo->cantidad = $repuesto['cantidad'];
            if (!$rutinaTrabajo->save()) {
                print_r($rutinaTrabajo->getErrors());
                die();
            }
        }
    }

    public function actualizarRepuestos($repuestos)
    {

        $repuestosExistentes = [];
        foreach ($this->rutinasRepuestos as $repuesto) {
            $repuestosExistentes[] = $repuesto->id;
        }
        foreach ($repuestos as $repuestico) {
            if (!empty($repuestico['id'])) {
                if (!in_array($repuestico['id'], $repuestosExistentes)) {
                    $repuestoRutina = RutinasRepuestos::findOne($repuestico['id']);
                    $repuestoRutina->delete();
                } else {
                    $posicionExistente = array_search($repuestico['id'], $repuestosExistentes);
                    $repuestoExistente = RutinasRepuestos::findOne($repuestosExistentes[$posicionExistente]);
                    $repuestoExistente->repuesto_id = $repuestico['repuesto'];
                    $repuestoExistente->rutina_trabajo_id = $repuestico['rutina_trabajo_id'];
                    $repuestoExistente->cantidad = $repuestico['cantidad'];
                    $repuestoExistente->save();
                }
            } else {
                $nuevoRepuesto = new RutinasRepuestos();
                $nuevoRepuesto->rutina_id = $this->id;
                $nuevoRepuesto->repuesto_id = $repuestico['repuesto'];
                $nuevoRepuesto->rutina_trabajo_id = $repuestico['rutina_trabajo_id'];
                $nuevoRepuesto->cantidad = $repuestico['cantidad'];
                $nuevoRepuesto->save();
            }
        }
    }

    public function antesDelete() {
        $model = Rutinas::findOne($this->id);
        $repuestos = $model->rutinasRepuestos;

        foreach ($repuestos as $repuesto) {
            $repuesto->delete();
        }

        $trabajos = $model->rutinasTrabajos;

        foreach ($trabajos as $trabajo) {
            $trabajo->delete();
        }

        $periodicidades = $model->periodicidadesRutinas;

        foreach ($periodicidades as $periodicidad) {
            $periodicidad->delete();
        }
    }

    public function afterFind()
    {
        parent::afterFind();

        // print_r(gettype($this->repuestos));
        // die();
        $this->trabajosFormulario = $this->rutinasTrabajos;

        $this->repuestos = [];
        // $this->repuestos = $this->rutinasRepuestos;

        //$this->repuestos[] = $this->rutinasRepuestos;
        foreach ($this->rutinasRepuestos as $index => $insumos) {
            $this->repuestos[$index]['rutina_trabajo_id'] = $insumos->rutina_trabajo_id;
            $this->repuestos[$index]['cantidad'] = $insumos->cantidad;
            $this->repuestos[$index]['inventariable'] = $insumos->repuesto->inventariable;
            $this->repuestos[$index]['repuesto_id'] = $insumos->repuesto_id;
            $repuesto = Repuestos::findOne($insumos->repuesto_id);
            $this->repuestos[$index]['valor'] = $repuesto->precio * $insumos->cantidad;
        }
    }

    public function validarRepuestos()
    {
        // print_r($this->repuestos);
        // die();
        foreach ($this->repuestos as $indexRepuesto => $repuesto) {
            if (empty($repuesto['rutina_trabajo_id'])) {
                $error = 'Debe seleccionar un trabajo.';
                $this->addError('repuestos[' . $indexRepuesto . '][rutina_trabajo_id]', $error);
            }
            if (empty($repuesto['inventariable'])) {
                $error = '"Proviene de" no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][inventariable]', $error);
            }
            if (empty($repuesto['repuesto'])) {
                $error = '"Repuesto" no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][repuesto]', $error);
            }
            if (empty($repuesto['cantidad'])) {
                $error = '"Cantidad" no puede estar vacio.';
                $this->addError('repuestos[' . $indexRepuesto . '][cantidad]', $error);
            }
        }
    }
}
