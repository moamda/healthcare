<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use yii2ajaxcrud\ajaxcrud\CrudAsset;
use yii2ajaxcrud\ajaxcrud\BulkButtonWidget;

$this->title = 'Appointments';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="Appointments-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'width' => '30px',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'doctor_id',
                    'value' => function ($model) {
                        return $model->doctor ? $model->doctor->fname . ' ' . strtoupper(substr($model->doctor->mname, 0, 1)) . '. ' . $model->doctor->lname : 'No doctor assigned';
                    },
                    'label' => 'Doctor',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'appointment_date',
                    'format' => ['date', 'php:F j, Y h:i A'],
                ],

                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'reason',
                    'contentOptions' => [
                        'style' => 'vertical-align: middle;', // Center align text
                    ],
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'status',
                    'format' => 'raw', // Ensures HTML is rendered
                    'value' => function ($model) {
                        $statusClass = match ($model->status) {
                            'Pending' => 'badge bg-danger',
                            'Scheduled' => 'badge bg-warning',
                            'Completed' => 'badge bg-success',
                            default => 'badge bg-secondary',
                        };

                        // Wrap the status with a span and the appropriate class
                        return "<span class='{$statusClass}'>{$model->status}</span>";
                    },
                    'contentOptions' => [
                        'style' => 'text-align: center;', // Center align text
                    ],
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'notes',
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'noWrap' => 'true',
                    'template' => '{update} {cancel}',
                    'vAlign' => 'middle',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return Url::to([$action, 'id' => $key]);
                    },
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('Update', $url, [
                                'role' => 'modal-remote',
                                'title' => Yii::t('yii2-ajaxcrud', 'More info'),
                                'data-toggle' => 'tooltip',
                                'class' => 'btn bg-gradient-warning', // Button style
                            ]);
                        },
                        'cancel' => function ($url, $model, $key) {

                            // var_dump($url); die;
                            return Html::a('Cancel', $url, [
                                'role' => 'modal-remote',
                                'title' => Yii::t('yii2-ajaxcrud', 'Confi'),
                                'class' => 'btn bg-gradient-danger',
                                'data-method' => false,
                                'data-request-method' => 'post',
                                'data-toggle' => 'tooltip',
                                'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Cancel'),
                                'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Cancel Confirm')
                            ]);
                        },
                    ],
                    // 'deleteOptions' => [
                    //     'role' => 'modal-remote',
                    //     'title' => Yii::t('yii2-ajaxcrud', 'Delete'),
                    //     'class' => 'btn bg-gradient-danger',
                    //     'data-confirm' => false,
                    //     'data-method' => false, // for overide yii data api
                    //     'data-request-method' => 'post',
                    //     'data-toggle' => 'tooltip',
                    //     'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Delete'),
                    //     'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Delete Confirm')
                    // ],
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
        ]) ?>
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
]) ?>
<?php Modal::end(); ?>