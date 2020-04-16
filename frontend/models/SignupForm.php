<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $surname;
    public $id_number;
    public $username;
    public $email;
    public $password;
    public $tipo_usuario_id;


    /**
     * Escenarios
     */
    const ESCENARIO_NUEVAEMPRESA = 'escenario_nueva_empresa';
    const ESCENARIO_NUEVOUSUARIO = 'escenario_nuevo_usuario';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['surname', 'required'],
            ['surname', 'string', 'min' => 2, 'max' => 255],
            ['id_number', 'required'],
            ['id_number', 'string', 'min' => 2, 'max' => 255],
            ['id_number', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El número de identificación indicado ya esta siendo usado por otro usuario.'],
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El nombre de usuario indicado ya esta siendo usado.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El correo electronico ya esta siendo usado.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['tipo_usuario_id', 'required', 'on' => self::ESCENARIO_NUEVOUSUARIO],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Nombres',
            'surname' => 'Apellidos',
            'id_number' => 'Número de identificación',
            'username' => 'Usuario',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'rememberMe' => 'Recordarme',
            'tipo_usuario_id' => 'Tipo usuario'
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->id_number = $this->id_number;
        $user->estado = User::ESTADO_INACTIVO;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if(!$user->save()){
            print_r($user->getErrors());
            die();
        }
        return $user->save() && $this->sendEmail($user);

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }


}
