<?php

use kartik\helpers\Html;
use yii\helpers\Url;

$this->title = 'Mantenimientos';
                         
?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Vehiculo</th>
                <th>Fecha y hora de ejecucion</th>
                <th>Descripcion</th>
                <th>Medicion</th>
                <th>Trabajo</th>
                <th>Tipo de Mantenimiento</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model as $mantenimiento) { ?>
                <tr>
                    <td>
                        <?= $mantenimiento->vehiculo->placa ?>
                    </td>
                    <td>
                        <?= $mantenimiento->fecha_hora_ejecucion ?>
                    </td>
                    <td>
                        <?= $mantenimiento->descripcion ?>
                    </td>
                    <td>
                        <?= $mantenimiento->medicion ?>
                    </td>
                    <td>
                        <?= $mantenimiento->trabajo->nombre ?>
                    </td>
                    <td>
                        <?= $mantenimiento->tipoMantenimiento->nombre ?>
                    </td>
                    <td>
                        <?= $mantenimiento->estado ?>
                    </td>
                    <td>
                        <?php echo Html::a(
                                    'Solucionar Mantenimiento',
                                    Yii::$app->urlManager->createUrl(['ordenes-trabajos/cambiar-estado-mantenimiento', 'mantenimientoId' => $mantenimiento->id]),
                                    [
                                        'title' => 'Cambiar Estado',
                                        'class' => 'btn btn-primary'
                                    ]
                                ); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>