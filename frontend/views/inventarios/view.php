<?php

use frontend\models\RepuestosInventariables;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Inventarios */

$this->title = $model->ubicacionInsumo->nombre . ' - ' . $model->fecha_hora_inventario;
$this->params['breadcrumbs'][] = ['label' => 'Inventarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inventarios-view">

    <p>
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
            'fecha_hora_inventario',
            [
                'label' => 'Ubicacion',
                'attribute' => 'ubicacionInsumo.nombre'
            ],
            'observacion',
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
                        <th>Cantidad Contada</th>
                        <th>Cantidad del Sistema</th>
                        <th>Diferencia</th>
                        <th>Costo Unitario</th>
                        <th>Costo Diferencia</th>
                        <th>Unidad de Medida</th>
                        <th>Observacion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repuestos as $repuesto) {
                        $cantidadSistema = 0;
                        foreach ($repuesto->repuesto->repuestosInventariables as $inventariables) {
                            $cantidadSistema = $cantidadSistema + $inventariables->cantidad;
                        } ?>
                        <tr>
                            <td>
                                <?= $repuesto->repuesto->nombre ?>
                            </td>
                            <td>
                                <?= $repuesto->cantidad_fisica ?>
                            </td>
                            <td>
                                <?= $cantidadSistema ?>
                            </td>
                            <td>
                                <?= ($repuesto->cantidad_fisica - $cantidadSistema) ?>
                            </td>
                            <td>
                                <?= '$ ' . number_format($repuesto->repuesto->precio, 0, '', '.') ?>
                            </td>
                            <td>
                                <?= '$ ' . number_format(($repuesto->repuesto->precio * (($repuesto->cantidad_fisica - $cantidadSistema))), 0, '', '.') ?>
                            </td>
                            <td>
                                <?= $repuesto->repuesto->unidadMedida->nombre ?>
                            </td>
                            <td>
                                <?= $repuesto->observacion ?>
                            </td>
                            <td>
                                <?php $inventariable = RepuestosInventariables::findOne(['repuesto_id' => $repuesto->repuesto_id]);
                                if($inventariable != null){
                                 if (($repuesto->cantidad_fisica - $cantidadSistema) !== 0) {
                                    echo Html::a(
                                        '<i class="fa fa-undo" aria-hidden="true"></i> Generar ajuste',
                                        Yii::$app->urlManager->createUrl(['inventarios/ajustar', 'idRepuesto' => $repuesto->id]),
                                        [
                                            'class' => 'btn btn-primary'
                                        ]
                                    );
                                } 
                            } else {
                                echo Html::a(
                                    '<i class="fa fa-plus" aria-hidden="true"></i> Añadir Repuesto',
                                    Yii::$app->urlManager->createUrl(['inventarios/crear-repuesto', 'idRepuesto' => $repuesto->id]),
                                    [
                                        'class' => 'btn btn-warning'
                                    ]
                                );
                            } ?>
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
        <a class="btn btn-default" href="<?= Url::to(['inventarios/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>

</div>