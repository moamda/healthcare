<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use yii2ajaxcrud\ajaxcrud\CrudAsset;
use yii2ajaxcrud\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\patient\models\MedicalHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medical Histories';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="medical-history-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__.'/_history.php'),
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
    "clientOptions" => [
        "tabindex" => false,
        "backdrop" => "static",
        "keyboard" => false,
    ],
    "options" => [
        "tabindex" => false
    ]
])?>
<?php Modal::end(); ?>
