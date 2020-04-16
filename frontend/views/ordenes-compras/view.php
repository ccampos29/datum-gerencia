<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesCompras */

$this->title = 'Orden N°: '. $model->consecutivo;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ordenes-compras-view">

    <p>
        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Generar PDF <span class="fa fa-file-pdf-o"></span>', ['pdf', 'id' => $model->id], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'consecutivo',
            'fecha_hora_orden',
            [
                'label' => 'Proveedor',
                'attribute' => 'proveedor.nombre'
            ],
            'forma_pago',
            'direccion',
            [
                'label' => 'Estado',
                'attribute' => 'estado',
                'value' => $model->estado ? '<div class="label label-success">Abierta</div>' : '<div class="label label-primary">Cerrada</div>',
                'format' => 'raw'
            ],
            'observacion',
            'proviene_de',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',
        ],
    ]) ?>

<?php if (!empty($repuestos)) {
        $total = 0; ?>
        <h3>Repuestos</h3>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Repuesto</th>
                        <th>Cantidad</th>
                        <th>Valor Unitario</th>
                        <th>Impuesto</th>
                        <th>Descuento</th>
                        <th>Tipo de decuento</th>
                        <th>Observacion</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repuestos as $repuesto) {
                        $totalRepuestos = 0;
                        if ($repuesto->tipo_descuento == 1) {
                            $tipo = '%';
                            $total = $total + ($repuesto->valor_unitario - $repuesto->descuento_unitario)*$repuesto->cantidad;
                            $totalRepuestos = $totalRepuestos + $total;
                        } else {
                            $tipo = '$';
                            $total = ($repuesto->valor_unitario * (1-($repuesto->descuento_unitario/100)))*$repuesto->cantidad;
                            $totalRepuestos = $totalRepuestos + $total;
                        }
                    ?>
                        <tr>
                            <td>
                                <?= $repuesto->repuesto->nombre ?>
                            </td>
                            <td>
                                <?= $repuesto->cantidad ?>
                            </td>
                            <td>
                                <?= '$ ' . number_format($repuesto->valor_unitario, 0, '', '.') ?>
                            </td>
                            <td>
                                <?= $repuesto->tipoImpuesto->nombre ?>
                            </td>
                            <td>
                                <?= $repuesto->descuento_unitario ?>
                            </td>
                            <td>
                                <?= $tipo ?>
                            </td>
                            <td>
                                <?= $repuesto->observacion ?>
                            </td>
                            <td>
                            <b>
                                <?= '$ ' . number_format($total, 0, '', '.') ?>
                            </b>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="7"><b>Total</b></td>
                        <td>
                            <b>
                                <?= '$ ' . number_format($totalRepuestos, 0, '', '.') ?>
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">
            <strong>No hay repuestos asociados</strong>
        </div>
    <?php } ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['ordenes-compras/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>