<?php

/* @var $this yii\web\View */

use common\models\User;
use frontend\models\OrdenesTrabajos;
use frontend\models\Solicitudes;
use frontend\models\Vehiculos;
use yii\helpers\Url;

$this->title = 'Inicio';
?>

<div >
  <div>
    
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= Vehiculos::find()->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id])->count() ?></h3>

              <p>Vehículos</p>
            </div>
            <div class="icon">
              <i class="fa fa-car"></i>
            </div>
            <a href="<?= Url::to(['/vehiculos']) ?>" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
            <h3><?= OrdenesTrabajos::find()->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id])->count() ?></h3>
              <p>Ordenes de Trabajo</p>
            </div>
            <div class="icon">
              <i class="fa fa-industry"></i>
            </div>
            <a href="<?= Url::to(['/ordenes_trabajos']) ?>" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
            <h3><?= Solicitudes::find()->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id])->count() ?></h3>

              <p>Solicitudes y Cotizaciones</p>
            </div>
            <div class="icon">
              <i class="fa fa-list-ul"></i>
            </div>
            <a href="<?= Url::to(['/solicitudes']) ?>" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
            <h3><?= User::find()->andFilterWhere(['empresa_id'=>@Yii::$app->user->identity->empresa_id])->count() ?></h3>

              <p>Usuarios</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="<?= Url::to(['/user']) ?>" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
  

    </section>
  </div>
  


  <div class="control-sidebar-bg"></div>
</div>
