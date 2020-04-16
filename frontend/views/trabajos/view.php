<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Trabajos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="trabajos-view">

    <p>
        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nombre',
            'observacion',
            'codigo',
            [
                'label' => 'Estado',
                'attribute' => 'estado',
                'value' => $model->estado ? '<div class="label label-success">Activo</div>' : '<div class="label label-danger">Inactivo</div>',
                'format' => 'raw'
            ],
            [
                'label' => 'Tipo Mantenimiento',
                'attribute' => 'tipoMantenimiento.nombre'
            ],
            [
                'label' => 'Sistema',
                'attribute' => 'sistema.nombre'
            ],
            [
                'label' => 'Subsistema',
                'attribute' => 'subsistema.nombre'
            ],
            [
                'label' => 'Cuenta Contable',
                'attribute' => 'cuentaContable.nombre'
            ],
            [
                'label' => '¿Tiene periodicidad?',
                'attribute' => 'periodico',
                'value' => $model->periodico ? 'Si' : 'No',
                'format' => 'raw'
            ],
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
        ],
    ]) ?>

    <?php if (!empty($propiedades)) {
        $totalTrabajo = 0;
        $totalRepuesto = 0; ?>
        <h3>Propiedades</h3>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tipo de vehiculo</th>
                        <th>Duracion(minutos)</th>
                        <th>Costo Mano de Obra</th>
                        <th>Cantidad Trabajo</th>
                        <th>Repuesto</th>
                        <th>Valor Repuesto</th>
                        <th>Cantidad Repuesto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($propiedades as $propiedad) {
                        $totalTrabajo = $propiedad->costo_mano_obra * $propiedad->cantidad_trabajo;
                        if ($propiedad->repuesto_id != null) {
                            $totalRepuesto = $propiedad->repuesto->precio * $propiedad->cantidad_repuesto;
                        }
                        $total = $totalTrabajo + $totalRepuesto; ?>
                        <tr>
                            <td>
                                <?= $propiedad->tipoVehiculo->descripcion ?>
                            </td>
                            <td>
                                <?= $propiedad->duracion ?>
                            </td>
                            <td>
                                <?= '$ ' . number_format($propiedad->costo_mano_obra, 0, '', '.') ?>
                            </td>
                            <td>
                                <?= $propiedad->cantidad_trabajo ?>
                            </td>
                            <td>
                                <?= $propiedad->repuesto_id ? $propiedad->repuesto->nombre : 'Ninguno' ?>
                            </td>
                            <td>
                                <?= $propiedad->repuesto_id ? '$ ' . number_format($propiedad->repuesto->precio,0,'','.') : 0 ?>
                            </td>
                            <td>
                                <?= $propiedad->cantidad_repuesto ?>
                            </td>
                            <td>
                                <b>
                                    <?= '$ ' . number_format($total, 0, '', '.') ?>
                                </b>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">
            <strong>No hay propiedades asociadas</strong>
        </div>
    <?php } ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>