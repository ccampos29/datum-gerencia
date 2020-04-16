<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cotizaciones */

$this->title = $model->proveedor->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index', 'idSolicitud' => $model->solicitud_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cotizaciones-view">

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
            'fecha_hora_cotizacion',
            [
                'label' => 'Solicitud N°',
                'attribute' => 'solicitud.consecutivo'
            ],
            [
                'label' => 'Proveedor',
                'attribute' => 'proveedor.nombre'
            ],
            'fecha_hora_vigencia',
            'observacion',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',
        ],
    ]) ?>

<?php if (!empty($repuestos)) { ?>
        <h3>Repuestos</h3>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Repuesto</th>
                        <th>Cantidad</th>
                        <th>Observacion Cliente</th>
                        <th>Valor Unitario</th>
                        <th>Descuento</th>
                        <th>Tipo Descuento</th>
                        <th>Impuesto</th>
                        <th>Observacion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repuestos as $repuesto) { ?>
                        <tr>
                            <td>
                                <?= $repuesto->repuesto->nombre ?>
                            </td>
                            <td>
                                <?= $repuesto->cantidad ?>
                            </td>
                            <td>
                                <?= $repuesto->observacion_cliente ?>
                            </td>
                            <td>
                                <?= $repuesto->valor_unitario ?>
                            </td>
                            <td>
                                <?= $repuesto->descuento_unitario ?>
                            </td>
                            <td>
                                <?= $repuesto->tipo_descuento ?>
                            </td>
                            <td>
                                <?= $repuesto->tipoImpuesto->nombre ?>
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
        <h3>Trabajos</h3>
        <div>
            <table class="table table-hover">
            <thead>
                    <tr>
                        <th>Trabajo</th>
                        <th>Cantidad</th>
                        <th>Observacion Cliente</th>
                        <th>Valor Unitario</th>
                        <th>Descuento</th>
                        <th>Tipo Descuento</th>
                        <th>Impuesto</th>
                        <th>Observacion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trabajos as $trabajo) { ?>
                        <tr>
                            <td>
                                <?= $trabajo->trabajo->nombre ?>
                            </td>
                            <td>
                                <?= $trabajo->cantidad ?>
                            </td>
                            <td>
                                <?= $trabajo->observacion_cliente ?>
                            </td>
                            <td>
                                <?= $trabajo->valor_unitario ?>
                            </td>
                            <td>
                                <?= $trabajo->descuento_unitario ?>
                            </td>
                            <td>
                                <?= $trabajo->tipo_descuento ?>
                            </td>
                            <td>
                                <?= $trabajo->tipoImpuesto->nombre ?>
                            </td>
                            <td>
                                <?= $trabajo->observacion ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['cotizaciones/index?idSolicitud=' . $model->solicitud_id]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>