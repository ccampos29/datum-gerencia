<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\ImagenesVehiculos;
use frontend\models\VehiculosImpuestos;
use frontend\models\VehiculosOtrosDocumentos;
use frontend\models\VehiculosSeguros;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\Vehiculos */

$imagen = $imagenes->ruta_archivo;
$seguros = VehiculosSeguros::find()->where(['vehiculo_id'=>$model->id])->all();
$documentos = VehiculosOtrosDocumentos::find()->where(['vehiculo_id'=>$model->id])->all();
$impuestos = VehiculosImpuestos::find()->where(['vehiculo_id'=>$model->id])->all();
$this->title = $model->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiculos-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Generar PDF <span class="fa fa-file-pdf-o"></span>', ['pdf', 'id' => $model->id], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>

    </p>
    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [

                        'placa',
                        'modelo',
                        'color',
                        'distancia_maxima',
                        'distancia_promedio',
                        'horas_dia',
                        'observaciones:ntext',
                        'propietario_vehiculo',
                        'numero_chasis',
                        'numero_serie',
                        'tipo_carroceria',
                        'cantidad_sillas',
                        'toneladas_carga',
                        'codigo_fasecolda',
                        'fecha_compra:date',
                        
                        [
                            'attribute' => 'precio_compra',
                            'value' => '$ '.number_format($model->precio_compra, 0, '', '.'), 
                        ],
                        'medicion_compra',
                       
                        [
                            'attribute' => 'precio_accesorios',
                            'value' => '$ '.number_format($model->precio_accesorios, 0, '', '.'), 
                        ],
                        'nombre_vendedor',
                        'numero_importacion',
                        'fecha_importacion:date',
                        'vehiculo_imei_gps',
                        [
                            'label' => 'Marca del vehiculo',
                            'attribute' => 'marcaVehiculo.descripcion'
                        ],
                        [
                            'label' => 'Linea del vehiculo',
                            'attribute' => 'lineaVehiculo.descripcion'
                        ],
                        [
                            'label' => 'Marca del motor',
                            'attribute' => 'motor.nombre'
                        ],
                        [
                            'label' => 'Centro de costos',
                            'attribute' => 'centroCosto.nombre'
                        ],
                        [
                            'label' => 'Municipio',
                            'attribute' => 'municipio.nombre'
                        ],
                        [
                            'label' => 'Tipo del vehiculo',
                            'attribute' => 'tipoVehiculo.descripcion'
                        ],
                        'tipo_medicion',
                        'tipo_servicio',
                        'tipo_trabajo',
                        [
                            'label' => 'Tipo de combustible',
                            'attribute' => 'tipoCombustible.nombre'
                        ],
                        [
                            'label' => 'Centro de costos',
                            'attribute' => 'centroCosto.nombre'
                        ],
                        [
                            'label' => 'Municipio',
                            'attribute' => 'municipio.nombre'
                        ],
                        [
                            'label' => 'Departamento',
                            'attribute' => 'departamento.nombre'
                        ],
                        [
                            'label' => 'Pais',
                            'attribute' => 'pais.nombre'
                        ],
                        'vehiculo_equipo',
                        'vehiculo_equipo_observacion:ntext',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?= DetailView::widget([
                    'model' => $imagenes,
                    'attributes' => [
                        [
                            'attribute' => 'Imagen del vehiculo',
                            'value' => ' <img width="40%" src="' . Yii::$app->urlManager->createUrl('../..' . Yii::$app->params['rutaImagenesVehiculos'].'vehiculo'.$imagenes->vehiculo_id.'/'.$imagenes->nombre_archivo) . '">',
                            'format' => 'raw'
                        ],
                    ],
                ])

                ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <?php foreach ($grupos as $grup) {
                    if(!empty($grup->vehiculo_id)){
                        echo DetailView::widget([
                            'model' => $grup,
                            'attributes' => [
                                [
                                    'label' => 'Grupo del vehiculo',
                                    'attribute' => 'grupoVehiculo.nombre',
                                ],
                            ],
                        ]);
                    }
                } ?>
            </div>
        </div>
        <?php if (!empty($seguros)) { ?>
					<h2><?= Html::encode("Seguros del vehiculo") ?></h2>
					<table class="table table-striped table-condensed" width="100%">
						<thead>
							<tr>
								<th>Nombre del seguro</th>
								<th>Número de póliza</th>
								<th>Valor del seguro</th>
                                <th>Fecha de vigencia</th>
                                <th>Fecha de fin</th>
                                <th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($seguros as $seguro) : ?>
								<tr>
									<td>
										<?= Html::encode($seguro->tipoSeguro->nombre) ?><br>
									</td>
									<td>
										<?= Html::encode($seguro->numero_poliza) ?><br>
									</td>
									<td>
										<?= Html::encode('$ ' . number_format($seguro->valor_seguro, 0, '', '.')) ?><br>
									</td>
									<td>
										<?= Html::encode($seguro->fecha_vigencia) ?><br>
                                    </td>
                                    <td>
										<?= Html::encode($seguro->fecha_expiracion) ?><br>
									</td>
                                    <td>
                                        <?php
                                            if(strtotime($seguro->fecha_expiracion) > strtotime(date('Y-m-d'))){
                                                echo '<label class="label label-success">Vigente</label>';
                                            }else{
                                                echo '<label class="label label-danger">Vencido</label>';
                                            }
                                        ?><br>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<hr>

				<?php } else { ?>
                    <div class="alert alert-warning">
                        <strong>No hay seguros asociados</strong>
                    </div>
                <?php } ?> 
                <?php if (!empty($documentos)) { ?>
					<h2><?= Html::encode("Documentos del vehiculo") ?></h2>
					<table class="table table-striped table-condensed" width="100%">
						<thead>
							<tr>
                                <th>Nombre del documento</th>
								<th>Valor del documento</th>
								<th>Fecha de inicio</th>
								<th>Fecha de fin</th>
                                <th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($documentos as $documento) : ?>
								<tr>
                                    <td>
										<?= Html::encode($documento->tipoDocumento->nombre) ?><br>
									</td>
									
									<td>
										<?= Html::encode('$ ' . number_format($documento->valor_unitario, 0, '', '.')) ?><br>
									</td>
									<td>
										<?= Html::encode($documento->fecha_expedicion) ?><br>
									</td>
                                    <td>
										<?= Html::encode($documento->fecha_expiracion) ?><br>
									</td>
                                    <td>
                                        <?php
                                            if(strtotime($documento->fecha_expiracion) > strtotime(date('Y-m-d'))){
                                                echo '<label class="label label-success">Vigente</label>';
                                            }else{
                                                echo '<label class="label label-danger">Vencido</label>';
                                            }
                                            
                                        ?><br>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<hr>

                    <?php } else { ?>
                    <div class="alert alert-warning">
                        <strong>No hay documentos asociados</strong>
                    </div>
                <?php } ?> 
                <?php if (!empty($impuestos)) { ?>
					<h2><?= Html::encode("Impuestos del vehiculo") ?></h2>
					<table class="table table-striped table-condensed" width="100%">
						<thead>
							<tr>
								<th>Nombre del impuesto</th>
								<th>Valor del impuesto</th>
								<th>Fecha de inicio</th>
								<th>Fecha de fin</th>
                                <th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($impuestos as $impuesto) : ?>
								<tr>
									<td>
										<?= Html::encode($impuesto->tipoImpuesto->nombre) ?><br>
									</td>
									
									<td>
										<?= Html::encode('$ ' . number_format($impuesto->valor_impuesto, 0, '', '.')) ?><br>
									</td>
									<td>
										<?= Html::encode($impuesto->fecha_expedicion) ?><br>
									</td>
                                    <td>
										<?= Html::encode($impuesto->fecha_expiracion) ?><br>
									</td>
                                    <td>
                                        <?php
                                            if(strtotime($impuesto->fecha_expiracion) > strtotime(date('Y-m-d'))){
                                                echo '<label class="label label-success">Vigente</label>';
                                            }else{
                                                echo '<label class="label label-danger">Vencido</label>';
                                            }
                                            
                                        ?><br>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<hr>

                    <?php } else { ?>
                    <div class="alert alert-warning">
                        <strong>No hay impuestos asociados</strong>
                    </div>
                <?php } ?> 
    </div>

    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>