<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use backend\models\AuthAssignment;
use frontend\models\Empresas;
use frontend\models\InformacionAdicionalUsuarios;
use frontend\models\SignupForm;
use frontend\models\TiposUsuarios;
use yii\db\Query;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\UsuariosDocumentosSearch;
use frontend\models\UsuariosDocumentosUsuariosSearch;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;

/**
 * Controlador que permite administrar el modelo User
 * 
 * El controlador permite realizar las siguientes acciones sobre el modelo User:
 * listar, crear, ver y asignar rol
 * 
 * @author Fabian Augusto Aguilar Sarmiento <faaguilars@gmail.com>
 * @see common\models\User
 * @since 1.0
 */
class UserController extends Controller
{

    /**
     * Leer documentación de Yii2
     * 
     * @link http://www.yiiframework.com/doc-2.0/guide-concept-behaviors.html
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'view', 'asignarRol'],
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['index', 'create', 'view', 'asignarRol'],
                        'roles' => ['p-user-all', 'r-administrador-empresa'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lista todos los modelos User
     * 
     * @return view la vista 'index'
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Permite ver el detalle y actualizar el modelo User
     * 
     * Redirecciona siempre a la vista 'view'
     * 
     * @param int $id identificador único
     * @return mixed muestra la vista 'view' con los detalles
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $informacionAdicional = InformacionAdicionalUsuarios::find()->where(['usuario_id' => $model->id])->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Usuario actualizado correctamente');
            return $this->redirect(['view', 'id' => $model->id, 'informacionAdicional' => $informacionAdicional]);
        } else {

            return $this->render('view', ['model' => $model, 'informacionAdicional' => $informacionAdicional]);
        }
    }

    /**
     * Crea un nuevo modelo User
     * 
     * Redirecciona a la vista 'view' si se creó correctamente
     * 
     * @return mixed retorna la vista 'view' si se creó; de lo contrario retorna
     * la vista 'create'
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $model->scenario = SignupForm::ESCENARIO_NUEVOUSUARIO;
        if ($model->load(Yii::$app->request->post())) {
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->name = $model->name;
            $user->surname = $model->surname;
            $user->id_number = $model->id_number;
            $user->tipo_usuario_id = $model->tipo_usuario_id;
            $user->estado = User::ESTADO_INACTIVO;
            $user->empresa_id = Yii::$app->user->identity->empresa_id;
            $user->setPassword($model->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            if (!$user->save()) {
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user
                ]);
            }
            $tipoUsuarioRol = TiposUsuarios::findOne($user->tipo_usuario_id);
            $model = new AuthAssignment;
            $model->user_id = $user->id;
            $model->item_name = $tipoUsuarioRol->permiso_rol;
            $model->save();
            $empresa = Empresas::findOne(Yii::$app->user->identity->empresa_id);
            Yii::$app->notificador->enviarCorreoNuevoUsuario($user, $empresa);
            Yii::$app->session->setFlash('success', 'Usuario creado correctamente, se ha enviado un correo las instrucciones para activar la cuenta.');
            return $this->redirect(['view', 'id' => $user->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Función para leer el excel con los usuarios 
     */
    public function actionRecibirExcel()
    {
        //        echo '<pre>';
        //        print_r($_FILES);
        //        echo '</pre><br><br><br><br><br>';
        ////        print_r(Yii::$app->urlManager->createUrl(['']));
        //        $file = fopen('prueba_excel.csv', "r");
        ////        while (!feof($file)) {
        //            print_r(fgetcsv($file));
        ////        }
        //
        //        fclose($file);
        //        die();
        //Open the file.
        $fileHandle = fopen("/var/www/html/proyectos-y-contratos/administracion/controllers/prueba.csv", "r");

        //Loop through the CSV rows.
        while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {
            //Print out my column data.
            print_r($row);
            //            echo 'Name: ' . $row[0] . '<br>';
            //            echo 'Country: ' . $row[1] . '<br>';
            //            echo 'Age: ' . $row[2] . '<br>';
            //            echo '<br>';
        }
    }

    /**
     * Busca un modelo User
     * 
     * La busqueda la hace basado en el valor de su llave primaria. Si el modelo 
     * no existe, se lanza una excepción HTTP 404.
     * 
     * @param int $id identificador único
     * @return User el modelo User
     * @throws NotFoundHttpException si el modelo no existe
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== NULL) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    /**
     * Asignar rol
     * 
     * Permite asignar o quitar un rol al usuario
     * 
     * @return mixed retorna a la vista 'view'
     */
    public function actionAsignarRol()
    {
        $userId = Yii::$app->request->post('userId');
        $rolNombre = Yii::$app->request->post('rolNombre');
        $user = User::findOne($userId);

        if ($userId && $rolNombre) {
            $rol = Yii::$app->authManager->getRole($rolNombre);

            if (User::tieneAsignado($rolNombre, $userId)) {
                Yii::$app->session->setFlash('success', 'Se eliminó el rol: '
                    . $rolNombre . ' correctamente');
                Yii::$app->authManager->revoke($rol, $userId);
            } else {
                $model = new AuthAssignment;
                $model->user_id = $userId;
                $model->item_name = $rolNombre;
                $model->save();
                Yii::$app->session->setFlash('success', 'Se adicionó el rol: '
                    . $rolNombre . ' correctamente');

                //Yii::$app->authManager->assign($rol, $userId);
            }
            $user->actualizado_por = Yii::$app->user->id;
            $user->save();
        }

        return $this->redirect(Url::to(['/user/view', 'id' => $userId]));
    }


    /**
     * Ajax para la carga de los usuarios en el select2 que esta 
     * en el formulario de Ordenes Trabajos
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionUsuariosList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select(['id', "concat(id_number,' - ',name,' ',surname) AS text"])
            ->from('user')
            ->andFilterWhere(['like', 'name', $q])
            ->orFilterWhere(['like', 'surname', $q])
            ->orFilterWhere(['like', 'id_number', $q])
            ->andFilterWhere(['empresa_id' => @Yii::$app->user->identity->empresa_id])
            ->andWhere(['=', 'estado', 1]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);

        return $out;
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
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }


    public function actionConductoresList($q = null, $id = null, $tipo_user= 6)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select(['id', "concat(id_number,' - ',name,' ',surname) AS text"])
            ->from('user')
            ->andFilterWhere(['like', 'name', $q])
            ->orFilterWhere(['like', 'surname', $q])
            ->orFilterWhere(['like', 'id_number', $q])
            ->andWhere(['=', 'estado', 1])
            ->andFilterWhere(['empresa_id' => @Yii::$app->user->identity->empresa_id])
            ->andWhere(['=', 'tipo_usuario_id', $tipo_user]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
        return $out;
    }

    public function actionConductoresAsignadosList($q = null, $id = null, $tipo_user= 6,$vehiculo_id=NULL)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select(['a.id', "concat(a.id_number,' - ',a.name,' ',surname) AS text"])
            ->from(['user a', 'vehiculos_conductores b'])
            ->andWhere('b.conductor_id = a.id')
            ->andFilterWhere(['like', 'a.name', $q])
            ->andWhere(['=', 'b.vehiculo_id', $vehiculo_id])
            ->orFilterWhere(['like', 'a.surname', $q])
            ->orFilterWhere(['like', 'a.id_number', $q])
            ->andWhere(['=', 'b.estado', 1])
            ->andFilterWhere(['b.empresa_id' => @Yii::$app->user->identity->empresa_id]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
        return $out;
    }

    /**
     * Ajax para la carga de los usuarios en el select2 que esta 
     * en el formulario de Ordenes Trabajos
     */
    /*     * ***********
     * Controller
     * ********** */
    public function actionTiposUsuariosList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select(['id', "concat(id_number,' - ',name,' ',surname) AS text"])
            ->from('user')
            ->andFilterWhere(['like', 'name', $q])
            ->orFilterWhere(['like', 'surname', $q])
            ->orFilterWhere(['like', 'id_number', $q])
            ->andFilterWhere(['empresa_id' => @Yii::$app->user->identity->empresa_id])
            ->andWhere(['=', 'estado', 1])
            ->andWhere(['=', 'tipo_usuario_id', 3]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);


        return $out;
    }
    /**
     * Método para llenar un select-ajax
     * @param string $q Valor a buscar
     * @param array query resultado 
     * @return array Resultados encontrados según la búsqueda 
     */
    public function actionNombresUsuariosList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select(['id', "concat(id_number,' - ',name,' ',surname) AS text"])
            ->from('user')
            ->andFilterWhere(['like', 'name', $q])
            ->orFilterWhere(['like', 'surname', $q])
            ->orFilterWhere(['like', 'id_number', $q])
            ->andWhere(['empresa_id' => Yii::$app->user->identity->empresa_id])
            ->andWhere(['=', 'estado', 1]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);


        return $out;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionCambiarContrasena($email, $id)
    {
        /* @var $user User */
        $user = User::findOne([
            'estado' => User::ESTADO_ACTIVO,
            'email' => $email,
        ]);

        if (!$user) {
            Yii::$app->session->setFlash('error', 'El usuario no está activo, por ende no se puede cambiar la contraseña.');
            return $this->redirect(['view', 'id' => $id]);
        } else if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                Yii::$app->session->setFlash('error', 'El usuario no está activo o ya tiene otro proceso de cambio de contraseña en curso, por ende no se puede realizar esta operación.');
                return $this->redirect(['view', 'id' => $id]);
            } else {

                Yii::$app->notificador->enviarCorreoCambioContrasena($user);
                Yii::$app->session->setFlash('success', 'Se envió un correo al usuario indicandole las instrucciones para realizar el cambio.');
                return $this->redirect(['view', 'id' => $id]);
            }
        }
    }


    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionReenviarCorreoActivacion($id)
    {
        $user = User::findOne([
            'id' => $id,
            'estado' => User::ESTADO_INACTIVO
        ]);

        if ($user === null) {
            Yii::$app->session->setFlash('error', 'El usuario ya está activo.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            $empresa = Empresas::findOne(Yii::$app->user->identity->empresa_id);
            Yii::$app->notificador->enviarCorreoNuevoUsuario($user, $empresa);
            Yii::$app->session->setFlash('success', 'Correo enviado.');
            return $this->redirect(['view', 'id' => $id]);
        }
    }


    public function actionInformacionAdicional($id)
    {
        $informacionExistente = InformacionAdicionalUsuarios::find()->where(['usuario_id' => $id])->one();
        if (!empty($informacionExistente)) {
            $model = $informacionExistente;
        } else {
            $model = new InformacionAdicionalUsuarios();
            $model->usuario_id = $id;
        }
        $usuario = User::findOne($id);
        return $this->render('../informacion-adicional-usuarios/create', [
            'model' => $model,
            'usuario' => $usuario
        ]);
    }


    public function actionAsociarInformacionAdicional($id)
    {
        $informacionExistente = InformacionAdicionalUsuarios::find()->where(['usuario_id' => $id])->one();
        if (!empty($informacionExistente)) {
            $informacionExistente->load(Yii::$app->request->post());
            $informacionExistente->save();
        } else {
            $model = new InformacionAdicionalUsuarios();
            $model->load(Yii::$app->request->post());
            $model->save();
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Yii::$app->session->setFlash('success', 'Información asociada con éxito.');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Personal
     */
    public function actionConsultaPersonal()
    {

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/consulta_personal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }

    /**
     * Ver Documentacion
     */
    public function actionVerDocumentos($iUs)
    {
        $searchModel = new UsuariosDocumentosUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultas/ver_documentos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
        ]);
    }
}
