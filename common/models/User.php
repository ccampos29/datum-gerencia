<?php

namespace common\models;

use frontend\models\InformacionAdicionalUsuarios;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

/**
 * El modelo User representa un usuario en el sistema
 *
 * @property int $id identificador único
 * @property string $id_number número de identificación
 * @property string $name nombres
 * @property string $surname apellidos
 * @property string $username nombre de usuario
 * @property string $email correo personal
 * @property int $estado ¿está activo?
 * @property int $tipo_usuario_id
 * @property int $empresa_id Empresa con la que esta ligado este usuario
 * @property int $es_administrador_empresa Iindica si este usuario es el administrador de la empresa con la que esta ligado
 * @property string $auth_key cadena/llave de autenticación
 * @property string $password_hash valor de hash de la contraseña
 * @property string $verification_token valor token de verificación
 * @property string $password_reset_token token para restablecimiento de contraseña
 * @property int $creado_por identificador único del usuario creador
 * @property datetime $created_at fecha de creación
 * @property int $actualizado_por identificador único del usuario que actualiza
 * @property datetime $updated_at fecha de actualización
 * @property AuthAssignment[] $authAssignments registros asignados al usuario
 * de tipo AuthAssignment
 * @property AuthItem[] $itemNames roles/permisos asignados al usuario
 * @property boolean esNotificado si le llegan notificaciones
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 */
class User extends ActiveRecord implements IdentityInterface {

    const ESTADO_ACTIVO = 1;
    const ESTADO_ACTIVO_TXT = 'Activo';
    const ESTADO_INACTIVO = 0;
    const ESTADO_INACTIVO_TXT = 'Inactivo';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * Leer documentación de Yii2
     * 
     * @link http://www.yiiframework.com/doc-2.0/guide-concept-behaviors.html
     * @return array
     */
    public function behaviors() {
        $arrayBehaviors = [];

        $arrayBehaviors['blameable'] = [
            'class' => BlameableBehavior::className(),
            'createdByAttribute' => 'creado_por',
            'updatedByAttribute' => 'actualizado_por',
        ];

        $arrayBehaviors['timestamp'] = [
            'class' => TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
            ],
            'value' => new Expression('NOW()'),
        ];

        return $arrayBehaviors;
    }

    /**
     * @inheritdoc 
     */
    public function rules() {
        return [
            [['id_number', 'name', 'surname', 'username', 'email', 'estado'], 'required'],
            [['id_number', 'username', 'email'], 'unique'],
            [['creado_por', 'actualizado_por','empresa_id'], 'integer'],
            [['name', 'surname', 'email'], 'string', 'max' => 100],
            ['username', 'string', 'max' => 20],
            ['id_number', 'string', 'max' => 30],
            [['id_number', 'name', 'surname', 'username', 'email'], 'filter', 'filter' => 'trim'],
            ['username', 'match', 'pattern' => '/^[A-Za-z]\w.*$/'],
            [['name', 'surname'], 'match', 'pattern' => '/^[a-zA-ZáéíóúñÑÁÉÍÓÚ" "-_]*$/'],
            ['id_number', 'filter', 'filter' => 'strtoupper'],
            ['email', 'email'],
            ['estado', 'in', 'range' => [self::ESTADO_ACTIVO, self::ESTADO_INACTIVO]],
            ['estado', 'integer'],
            [['email', 'username'],
                'filter', 'filter' => function ($value) {
                    return mb_strtolower($value, 'UTF-8');
                }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Nombres',
            'surname' => 'Apellidos',
            'username' => 'Usuario',
            'id_number' => 'Identificación',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'verification_token' => 'Token de verificación',
            'email' => 'Correo electrónico',
            'tipo_usuario_id' => 'Tipo de usuario',
            'estado' => 'Estado',
            'estadoLabel' => 'Estado',
            'rolesNombresHtml' => 'Roles',
            'created_at' => 'Creado el',
            'updated_at' => 'Modificado el',
            'empresa_id'=>'Empresa'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'estado' => self::ESTADO_ACTIVO]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return self::findOne(['verification_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'estado' => self::ESTADO_ACTIVO]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'estado' => self::ESTADO_ACTIVO
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token,
                    'estado' => self::ESTADO_INACTIVO
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }
    /**
     * Obtiene empresa
     */
    public function getEmpresa(){
        return Yii::$app->user->identity->empresa_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformacionAdicionalUsuarios()
    {
        return $this->hasOne(InformacionAdicionalUsuarios::className(), ['usuario_id' => 'id']);
    }

}
