<?php

namespace backend\controllers;

/**
 * Controlador que tiene utilidades para visualizar los arboles 
 * de roles, permisos y menús
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 * @see backend\models\AuthAssignment
 * @since 2.0
 */
class ConfiguracionController extends \yii\web\Controller {
    /**
     * Leer documentación de Yii2
     * 
     * @link http://www.yiiframework.com/doc-2.0/guide-concept-behaviors.html
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['arbol-permisos', 'arbol-menu-administracion', 'arbol-menu-aplicacion'],
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['arbol-permisos', 'arbol-menu-administracion', 'arbol-menu-aplicacion'],
                        'roles' => ['p-configuracion-all'],
                    ],
                ],
            ],            
        ];
    }
    
    /**
     * Muestra el árbol con la distribución del menú de administracion
     * 
     * @return view la vista 'arbol-menu'
     */
    public function actionArbolMenuAdministracion() {
        return $this->render('arbol-menu', [
                'tipo' => 'administracion',
        ]);        
    }

    /**
     * Muestra el árbol con la distribución del menú de aplicacion
     * 
     * @return view la vista 'arbol-menu'
     */
    public function actionArbolMenuAplicacion() {
        return $this->render('arbol-menu', [
                'tipo' => 'aplicacion',
        ]);        
    }

    /**
     * Muestra el árbol con la distribución de los roles y permisos
     * 
     * @return view la vista 'arbol-permisos'
     */
    public function actionArbolPermisos() {
        return $this->render('arbol-permisos');        
    }
}
