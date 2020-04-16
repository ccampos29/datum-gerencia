<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Compras */

$this->title = 'Numero Factura: '.$model->numero_factura;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="compras-view">

    <p>
        <?= Html::a('<i class="fa fa-edit aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'label' => 'Proveedor',
                'attribute' => 'proveedor.nombre'
            ],
            [
                'label' => 'Ubicacion',
                'attribute' => 'ubicacion.nombre'
            ],
            'fecha_hora_hoy',
            'fecha_factura',
            'numero_factura',
            'fecha_radicado',
            'fecha_remision',
            'numero_remision',
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repuestos as $repuesto) {
                        if ($repuesto->tipo_descuento == 1) {
                            $tipo = '%';
                        } else {
                            $tipo = '$';
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
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">
            <strong>No hay repuestos asociados</strong>
        </div>
    <?php } ?>

<div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['compras/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>

</div>