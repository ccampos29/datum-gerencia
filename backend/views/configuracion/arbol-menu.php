<?php
use common\models\AuthMenuItem;
use execut\widget\TreeView;
use yii\web\JsExpression;
use common\widgets\Titulo;

$this->title = "Vista árbol: menú ".$tipo;
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Utilidades';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="arbol-menu">

<?php
    echo Titulo::widget([
        'tipo' => Titulo::TIPO_PRINCIPAL,
        'titulo' => $this->title]); 
   
$data = [AuthMenuItem::analisisMenu(1, $tipo)];

$onSelect = new JsExpression(<<<JS
function (undefined, item) {
    console.log(item);
}
JS
);
$groupsContent = TreeView::widget([
    'data' => $data,
    'size' => TreeView::SIZE_SMALL,
    'header' => 'Menú '.$tipo,
    'searchOptions' => [
        'inputOptions' => [
            'placeholder' => "Buscar menú $tipo..."
        ],
    ],
    'clientOptions' => [
        'onNodeSelected' => $onSelect,
        'selectedBackColor' => 'rgb(40, 153, 57)',
        'borderColor' => '#fff',
    ],
]);

echo $groupsContent;

?>
</div>
