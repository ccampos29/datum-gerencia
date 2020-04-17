<?php

namespace frontend\controllers\Api;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'frontend\models\User';

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    public function actionAuthenticate(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $params=json_decode(file_get_contents("php://input"), false);
            @$username=$params->username;
            @$password=$params->password;

            if($u=\common\models\User::findOne(['username'=>$username])){
                if($u->tipo_usuario_id == 6 || $u->tipo_usuario_id == 7){
                    if($u->validatePassword($password)) {
                        return ['token'=>$u->verification_token,'user'=>$u];
                    }
                }
            }

            return ['error'=>'Usuario incorrecto. '.$username];
        }
    }

}