<?php
use backend\models\AuthItem;
use execut\widget\TreeView;
use yii\web\JsExpression;
use common\widgets\Titulo;

$this->title = "Vista árbol de los permisos";
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Utilidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arbol-permisos">

<?php
    echo Titulo::widget([
        'tipo' => Titulo::TIPO_PRINCIPAL,
        'titulo' => $this->title]); 

$data = AuthItem::arbolPermisos();

$onSelect = new JsExpression(<<<JS
function (undefined, item) {
    console.log(item);
}
JS
);

$groupsContent = TreeView::widget([
    'data' => $data,
    'size' => TreeView::SIZE_SMALL,
    'header' => 'Permisos',
    'searchOptions' => [
        'inputOptions' => [
            'placeholder' => 'Buscar permiso...'
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
