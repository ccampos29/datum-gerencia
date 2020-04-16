<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\db\Expression;
use yii\helpers\Html;
use aplicacion\models\FlujoAprobacion;
use aplicacion\models\Aprobador;
use backend\models\AuthAssignment;
use common\models\User;
use aplicacion\models\FlujoAprobacionRolUser;
use DateTime;
use Exception;
use frontend\models\AlertasTipos;
use frontend\models\AlertasUsuarios;
use frontend\models\Checklist;
use frontend\models\CotizacionesRepuestos;
use frontend\models\CotizacionesTrabajos;
use frontend\models\InventariosRepuestos;
use frontend\models\Mantenimientos;
use frontend\models\NovedadesMantenimientos;
use frontend\models\OrdenesTrabajos;
use frontend\models\RepuestosInventariables;
use frontend\models\TiposImpuestos;
use frontend\models\TiposOtrosDocumentos;
use frontend\models\TiposSeguros;
use frontend\models\UsuariosDocumentosUsuarios;
use frontend\models\VehiculosConductores;
use frontend\models\VehiculosImpuestos;
use frontend\models\VehiculosOtrosDocumentos;
use frontend\models\VehiculosSeguros;

/**
 * La clase Notificador agrupa varias funciones para la generacion de
 * notificaciones
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 */
class Notificador extends Component
{
    /**
     * Correo de que se subio un entregable
     */
    public static function enviarCorreoNuevaOrdenTrabajo($param)
    {
        $correosANotificar = [];
        $correosANotificar[] = Yii::$app->user->identity->email;
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 5, 'empresa_id' => Yii::$app->user->identity->empresa_id])->one();
        if (!empty($admin)){
            $correosANotificar[] = $admin->user->email;
        }
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Se ha creado una Orden de Trabajo.';
            Yii::$app->mailer->compose('nueva-orden-trabajo', [
                'model' => $param,
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Se ha creado una orden de trabajo.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }


    public static function enviarCorreoVencimientoOrdenTrabajo()
    {
        $param = OrdenesTrabajos::find()->all();
        $tipo = AlertasTipos::findOne(8);
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 5])->one();

        foreach ($param as $rows) {

            $vencimiento = new DateTime();
            $venc        = new DateTime($rows->fecha_hora_cierre);
            $interval    = $vencimiento->diff($venc);
            $days_neg    = $interval->invert;

            if ($interval->d <= $tipo->medicion and !$days_neg) {

                $correosANotificar = [];
                $correosANotificar[] = $rows->creadoPor->email;
                if (!empty($admin))
                    $correosANotificar[] = $admin->user->email;

                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'La orden de trabajo ' . $rows->id . ' se aproxima a vencerse';
                    Yii::$app->mailer->compose('vencimiento-ordenes-trabajos', [
                        'model' => $rows,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('Datum Gerencia - Se aproxima la fecha de cierre de una orden de trabajo.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }

    /**
     * Correo de que se subio un entregable
     */
    public static function enviarCorreoNuevaNovedadMantenimiento($param)
    {
        $correosANotificar = [];
        $correosANotificar[] = $param->usuarioReporte->email;
        if ($param->usuarioResponsable != null) {
            $correosANotificar[] = $param->usuarioResponsable->email;
        }
        $correosANotificar[] = Yii::$app->user->identity->email;
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 5])->one();
        if (!empty($admin))
            $correosANotificar[] = $admin->user->email;

        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Se ha creado una novedad de mantenimiento.';
            Yii::$app->mailer->compose('nueva-novedad-mantenimiento', [
                'model' => $param,
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Se ha creado una novedad de mantenimiento.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }

    public static function enviarCorreoVencimientoNovedadMantenimiento()
    {
        $param = NovedadesMantenimientos::find()->all();
        $tipo  = AlertasTipos::findOne(8);
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 5])->one();

        foreach ($param as $rows) {

            $vencimiento = new DateTime();
            $venc        = new DateTime($rows->fecha_solucion);
            $interval    = $vencimiento->diff($venc);
            $days_neg    = $interval->invert;

            if ($interval->d <= $tipo->medicion and !$days_neg) {

                $correosANotificar = [];
                $correosANotificar[] = $rows->creadoPor->email;
                if (!empty($admin))
                    $correosANotificar[] = $admin->user->email;

                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'La novedadad de mantenimiento ' . $rows->id . ' se aproxima a su fecha de solución.';
                    Yii::$app->mailer->compose('vencimiento-novedad-mantenimiento', [
                        'model' => $rows,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('Datum Gerencia - Se aproxima la fecha de solución de una novedad de mantenimiento.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }

    public static function enviarCorreoenviarCorreoNuevoChecklist($para)
    {
        $param = Checklist::findOne($para);
        $correosANotificar = [];
        $correosANotificar[] = $param->usuario->email;
        $correosANotificar[] = $param->creadoPor->email;
        $correosANotificar[] = Yii::$app->user->identity->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Se ha creado un nuevo checklist con su respectiva calificacion.';
            Yii::$app->mailer->compose('nuevo-checklist', [
                'model' => $param,
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Se ha creado un nuevo checklist.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }

    public static function enviarCorreoVencimientoDocumentoUsuario()
    {
        $tipo  = AlertasTipos::findOne(7);
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 7])->one();
        $param = UsuariosDocumentosUsuarios::find()->all();

        foreach ($param as $rows) {

            $vencimiento = new DateTime();
            $venc        = new DateTime($rows->fecha_expiracion);
            $interval    = $vencimiento->diff($venc);
            $days_neg    = $interval->invert;

            if ($interval->d <= $tipo->medicion and !$days_neg) {

                $correosANotificar = [];
                $correosANotificar[] = $rows->creadoPor->email;
                $correosANotificar[] = Yii::$app->user->identity->email;
                if (!empty($admin))
                    $correosANotificar[] = $admin->user->email;
                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'El documento ' . $rows->usuarioDocumento->nombre . ' para el usuario ' . $rows->usuario->name . ' ' . $rows->usuario->surname . ' esta apunto de expirar, por favor acceder a datum gerencia para tomar acciones frente a esto.';
                    Yii::$app->mailer->compose('vencimiento-documento-usuario', [
                        'model' => $rows,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Un documento de usuario esta por expirar.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }

    public static function enviarCorreoVencimientoVehiculoSeguro()
    {
        $param = VehiculosSeguros::find()->all();
        $tipo  = AlertasTipos::findOne(7);
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 7])->all();
        
        foreach ($param as $rows) {

            $vencimiento = new DateTime();
            $venc        = new DateTime($rows->fecha_expiracion);
            $interval    = $vencimiento->diff($venc);
            $days_neg    = $interval->invert;
            if ($interval->d >= $tipo->medicion and $days_neg) {
                $correosANotificar = [];
                $correosANotificar[] = $rows->creadoPor->email;
                $correosANotificar[] = Yii::$app->user->identity->email;
                foreach ($admin as $adm) {
                    if (!empty($adm))
                        $correosANotificar[] = $adm->user->email;
                }
                    
                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'El seguro ' . $rows->tipoSeguro->nombre
                        . ' para el vehiculo ' . $rows->vehiculo->placa . ' esta apunto de expirar.';

                    Yii::$app->mailer->compose('vencimiento-vehiculos-seguros', [
                        'model' => $rows,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Un seguro esta por expirar.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }

    public static function enviarCorreoVencimientoVehiculoImpuesto()
    {
        $param = VehiculosImpuestos::find()->all();
        $tipo  = AlertasTipos::findOne(7);
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 7])->all();

        foreach ($param as $rows) {

            $vencimiento = new DateTime();
            $venc        = new DateTime($rows->fecha_expiracion);
            $interval    = $vencimiento->diff($venc);
            $days_neg    = $interval->invert;

            if ($interval->d >= $tipo->medicion and $days_neg) {
            
                $correosANotificar = [];
                $correosANotificar[] = $rows->creadoPor->email;
                $correosANotificar[] = Yii::$app->user->identity->email;
                foreach ($admin as $adm) {
                    if (!empty($adm))
                        $correosANotificar[] = $adm->user->email;
                }
                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'El impuesto ' . $rows->tipoImpuesto->nombre
                        . ' para el vehiculo ' . $rows->vehiculo->placa . ' esta apunto de expirar.';
                    Yii::$app->mailer->compose('vencimiento-vehiculos-impuestos', [
                        'model' => $rows,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Un impuesto esta por expirar.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }

    public static function enviarCorreoFinalizacionConductor()
    {
        $param = VehiculosConductores::find()->all();
        $tipo  = AlertasTipos::findOne(7);
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 7])->all();

        foreach ($param as $rows) {

            $vencimiento = new DateTime();
            $venc        = new DateTime($rows->fecha_hasta);
            $interval    = $vencimiento->diff($venc);
            $days_neg    = $interval->invert;

            if ($interval->d <= $tipo->medicion and !$days_neg) {

                $correosANotificar = [];
                $correosANotificar[] = $rows->creadoPor->email;
                $correosANotificar[] = Yii::$app->user->identity->email;
                foreach ($admin as $adm) {
                    if (!empty($adm))
                        $correosANotificar[] = $adm->user->email;
                }
                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'El conductor ' . $rows->conductor->name . ' ' . $rows->conductor->surname
                        . ' asociado al vehiculo ' . $rows->vehiculo->placa . ' esta apunto de finalizar su proceso.';
                    Yii::$app->mailer->compose('vencimiento-vehiculos-conductores', [
                        'model' => $rows,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: El proceso de un conductor esta por culminar.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }

    public static function enviarCorreoVencimientoVehiculoDocumento()
    {
        $param = VehiculosOtrosDocumentos::find()->all();
        $tipo  = AlertasTipos::findOne(7);
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 7])->all();

        foreach ($param as $rows) {

            $vencimiento = new DateTime();
            $venc        = new DateTime($rows->fecha_expiracion);
            $interval    = $vencimiento->diff($venc);
            $days_neg    = $interval->invert;

            if ($interval->d >= $tipo->medicion and $days_neg) {
            
                $correosANotificar = [];
                $correosANotificar[] = $rows->creadoPor->email;
                $correosANotificar[] = Yii::$app->user->identity->email;
                foreach ($admin as $adm) {
                    if (!empty($adm))
                        $correosANotificar[] = $adm->user->email;
                }
                
                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'El documento ' . $rows->tipoDocumento->nombre
                        . ' para el vehiculo ' . $rows->vehiculo->placa . ' esta apunto de expirar.';
                    Yii::$app->mailer->compose('vencimiento-vehiculos-documentos', [
                        'model' => $rows,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Un documento esta por expirar.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }


    public static function enviarCorreoSiguienteChecklist($rows, $odometro_actual)
    {
        $tipo  = AlertasTipos::findOne(6);
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => 6])->all();


        $vencimiento = new DateTime();
        $venc        = new DateTime($rows->fecha_siguente);
        $interval    = $vencimiento->diff($venc);
        $days_neg    = $interval->invert;
        $correosANotificar = [];
        $correosANotificar[] = $rows->creadoPor->email;
        foreach ($admin as $adm) {
            if (!empty($adm))
                $correosANotificar[] = $adm->user->email;
        }
        if ($interval->d <= $tipo->medicion and !$days_neg) {
            try {
                Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                Yii::$app->params['textoTitulo'] = 'El checklist para el vehiculo ' . $rows->vehiculo->placa . ' esta proximo a realizarse.';
                Yii::$app->mailer->compose('siguente-checklist', [
                    'model' => $rows,
                ])
                    ->setFrom('soporte@datum.com')
                    ->setTo($correosANotificar)
                    ->setSubject('AVISO: Un checklist esta proximo a realizarse.')
                    ->send();
            } catch (Exception $ex) {
                print_r($ex);
                echo '<br/>';
            }
        } elseif ($rows->medicion_siguente) {
            $venc = ($rows->medicion_siguente) - ($odometro_actual['valor']);
            if ($venc <= $tipo->medicion) {
                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'El checklist para el vehiculo' . $rows->vehiculo->placa . ' esta proximo a realizarse.';
                    Yii::$app->mailer->compose('siguente-checklist', [
                        'model' => $rows,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Un checklist esta proximo a realizarse.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                }
            }
        }
    }

    public static function enviarCorreoNuevoChecklist($param)
    {
        $tipo = AlertasUsuarios::find()->where(['tipo_alerta_id' => 6])->all();
        foreach ($tipo as $key) {
            $correosANotificar = [];
            $correosANotificar[] = $key->user->email;
        }
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Se ha creado un nuevo checklist con su respectiva calificacion.';
            Yii::$app->mailer->compose('nuevo-checklist', [
                'model' => $param,
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Se ha creado un nuevo checklist.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }

    public static function enviarCorreoRepuestoInferiorInventario()
    {
        $inventarios = InventariosRepuestos::find()->all();
        $alerta = AlertasTipos::find()->where(['nombre' => 'Inventario'])->orderBy(['id' => SORT_DESC])->one();
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => $alerta->id])->one();
        foreach ($inventarios as $inventario) {
            $repuesto = RepuestosInventariables::findOne($inventario->repuesto_id);
            if ($inventario->cantidad_fisica <= $repuesto->cantidad_minima) {
                $correosANotificar = [];
                $correosANotificar[] = $inventario->creadoPor->email;
                $correosANotificar[] = $admin->user->email;
                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'Del siguiente repuesto de inventario: ' . $inventario->repuesto->nombre . ', se tiene tan sólo ' . $inventario->cantidad_fisica . ' en la ubicacion ' . $inventario->inventario->ubicacion->nombre . '. Teniendo en cuenta que el stock minimo es de ' . $repuesto->cantidad_minima . ' unidades, existe actualmente escasez del mismo.';
                    Yii::$app->mailer->compose('repuesto-inferior-inventario', [
                        'model' => $inventario,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Hay escasez de repuestos disponibles en el inventario.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }

    public static function enviarCorreoNuevaProgramacionMantenimiento($param)
    {
        $alerta = AlertasTipos::find()->where(['nombre' => 'Mantenimiento'])->orderBy(['id' => SORT_DESC])->one();
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => $alerta->id])->one();
        $correosANotificar = [];
        $correosANotificar[] = $param->creadoPor->email;
        $correosANotificar[] = $admin->user->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Se ha programado un mantenimiento.';
            Yii::$app->mailer->compose('nueva-programacion-mantenimiento', [
                'model' => $param,
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Se ha programado un mantenimiento.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }

    public static function enviarCorreoVencimientoMantenimiento()
    {
        $mantenimientos = Mantenimientos::find()->all();
        $alerta = AlertasTipos::find()->where(['nombre' => 'Mantenimiento'])->orderBy(['id' => SORT_DESC])->one();
        $admin = AlertasUsuarios::find()->where(['tipo_alerta_id' => $alerta->id])->one();
        $dias = $alerta->medicion;

        foreach ($mantenimientos as $mantenimiento) {
            $vencimiento = new DateTime;
            $venc = new DateTime($mantenimiento->fecha_hora_ejecucion);
            $interval = $vencimiento->diff($venc);
            $days_neg = $interval->invert;
            if ($interval->d <= $dias and !$days_neg) {
                $correosANotificar = [];
                $correosANotificar[] = $mantenimiento->creadoPor->email;
                $correosANotificar[] = $admin->user->email;
                try {
                    Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                    Yii::$app->params['textoTitulo'] = 'Recuerde que el dia ' . $mantenimiento->fecha_hora_ejecucion . ' se tiene programada la ejecucion del siguiente mantenimiento de tipo ' . $mantenimiento->tipoMantenimiento->nombre . '. Se debe ejecutar sobre el vehiculo ' . $mantenimiento->vehiculo->placa . ' el trabajo ' . $mantenimiento->trabajo->nombre;
                    Yii::$app->mailer->compose('vencimiento-vehiculos-impuestos', [
                        'model' => $mantenimiento,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Se aproxima la ejecución de un mantenimiento programado.')
                        ->send();
                } catch (Exception $ex) {
                    print_r($ex);
                    echo '<br/>';
                    die();
                }
            }
        }
    }

    /**
     * Correo para envío de notificación de creación de empresa
     */
    public static function enviarCorreoNuevaEmpresa($param)
    {
        $correosANotificar = [];
        $correosANotificar[] = $param->correo_contacto;
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Se ha creado una empresa.';
            Yii::$app->mailer->compose('nueva-empresa', [
                'model' => $param,
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Se ha creado una empresa.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }


    /**
     * Correo para envío de notificación de creación de empresa
     */
    public static function enviarCorreoNuevoUsuarioAdministrador($param, $empresa)
    {
        $correosANotificar = [];
        $correosANotificar[] = $param->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Activación de cuenta.';
            Yii::$app->mailer->compose('nuevo-usuario-administrador', [
                'user' => $param,
                'empresa' => $empresa
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Activación de cuenta.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }

    /**
     * Correo para envío de notificación de creación de empresa
     */
    public static function enviarCorreoNuevoUsuario($param, $empresa)
    {
        $correosANotificar = [];
        $correosANotificar[] = $param->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Activación de cuenta.';
            Yii::$app->mailer->compose('nuevo-usuario', [
                'user' => $param,
                'empresa' => $empresa
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Activación de cuenta.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }



    /**
     * Correo para envío de notificación de creación de empresa
     */
    public static function enviarCorreoCambioContrasena($param)
    {
        $correosANotificar = [];
        $correosANotificar[] = $param->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Cambio de contraseña.';
            Yii::$app->mailer->compose('cambio-contrasena', [
                'user' => $param
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Cambio de contraseña.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }

    /**
     * Correo de que se subio un entregable
     */
    public static function emailOtrosGastos($param)
    {
        $correosANotificar = [];
        $correosANotificar[] = $param->creadoPor->email;
        $correosANotificar[] = Yii::$app->user->identity->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
            Yii::$app->params['textoTitulo'] = 'Se ha registrado un gasto para el vehiculo ' . $param->vehiculo->placa . ' .';
            Yii::$app->mailer->compose('otros-gastos', [
                'model' => $param,
            ])
                ->setFrom('soporte@datum.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Se ha registrado un gasto.')
                ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }

    /**
     * Correo para notificar al proveedor
     */
    public static function enviarCorreoProveedor($param)
    {
        $repuestos = CotizacionesRepuestos::find()->where(['cotizacion_id' => $param->id])->all();
        $trabajos = CotizacionesTrabajos::find()->where(['cotizacion_id' => $param->id])->all();
        $correosANotificar = [];
        $correosANotificar[] = $param->proveedor->email;
        if (!empty($repuestos)) {
            try {
                Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                foreach ($repuestos as $repuesto) {
                    Yii::$app->params['textoTitulo'] = 'Del siguiente repuesto: ' . $repuesto->repuesto->nombre . ', se necesita cotizacion para una cantidad de  ' . $repuesto->cantidad . ' unidades, ya que, no tenemos disponible en nuestra empresa. Por favor adjuntar metodo de pago';
                    Yii::$app->mailer->compose('correo-proveedor', [
                        'model' => $repuesto,
                        'fecha' => $param->fecha_hora_vigencia,
                        'correo' => $param->creadoPor->email,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Se necesita cotización para algunos insumos')
                        ->send();
                }
            } catch (Exception $ex) {
                print_r($ex);
                echo '<br/>';
                die();
            }
        } else {
            try {
                Yii::$app->params['textoEncabezado'] = 'Datum Gerencia';
                foreach ($trabajos as $trabajo) {
                    Yii::$app->params['textoTitulo'] = 'Del siguiente trabajo: ' . $trabajo->trabajo->nombre . ', se necesita cotizacion para una cantidad de  ' . $trabajo->cantidad . ' unidades, ya que, no se cuenta con el mismo';
                    Yii::$app->mailer->compose('correo-proveedor', [
                        'model' => $trabajo,
                        'fecha' => $param->fecha_hora_vigencia,
                        'correo' => $param->creadoPor->email,
                    ])
                        ->setFrom('soporte@datum.com')
                        ->setTo($correosANotificar)
                        ->setSubject('AVISO: Se necesita cotización para la realización de algunos trabajos')
                        ->send();
                }
            } catch (Exception $ex) {
                print_r($ex);
                echo '<br/>';
                die();
            }
        }
    }
}
