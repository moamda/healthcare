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
                    'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'reference_no',
                    'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'appointment_date',
                    'format' => ['date', 'php:F j, Y h:i A'],
                    'contentOptions' => ['style' => 'vertical-align: middle;']

                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'patient_id',
                    'value' => function ($model) {
                        return $model->patient ? $model->patient->fname . ' ' . strtoupper(substr($model->patient->mname, 0, 1)) . '. ' . $model->patient->lname : 'No patient assigned';
                    },
                    'label' => 'Patient',
                    'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'doctor_id',
                    'value' => function ($model) {
                        return $model->doctor ? $model->doctor->fname . ' ' . strtoupper(substr($model->doctor->mname, 0, 1)) . '. ' . $model->doctor->lname : 'No doctor assigned';
                    },
                    'label' => 'Doctor',
                    'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'reason',
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'status',
                    'width' => '100px',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $statusClass = match ($model->status) {
                            'Pending' => 'badge bg-warning',
                            'Approved' => 'badge bg-primary',
                            'Cancelled' => 'badge bg-danger',
                            'Completed' => 'badge bg-success',
                            default => 'badge bg-secondary',
                        };

                        return "<span class='{$statusClass}'>{$model->status}</span>";
                    },
                    'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'notes',
                    'contentOptions' => ['style' => 'vertical-align: middle;']
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'noWrap' => 'true',
                    'template' => '{update} {cancel} {approve} {complete}',
                    'vAlign' => 'middle',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return Url::to([$action, 'id' => $key]);
                    },
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            if ($model->status !== 'Cancelled') { // Hide if Cancelled
                                return Html::a('Update', $url, [
                                    'role' => 'modal-remote',
                                    'title' => Yii::t('yii2-ajaxcrud', 'More info'),
                                    'data-toggle' => 'tooltip',
                                    'class' => 'btn bg-gradient-warning', // Button style
                                ]);
                            }
                        },
                        'cancel' => function ($url, $model, $key) {
                            if ($model->status !== 'Cancelled') { // Hide if Cancelled
                                return Html::a('Cancel', $url, [
                                    'role' => 'modal-remote',
                                    'title' => Yii::t('yii2-ajaxcrud', 'Confirm'),
                                    'class' => 'btn bg-gradient-danger',
                                    'data-method' => false,
                                    'data-request-method' => 'post',
                                    'data-toggle' => 'tooltip',
                                    'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Cancel'),
                                    'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Cancel Confirm')
                                ]);
                            }
                        },
                        'approve' => function ($url, $model, $key) {
                            if ($model->status === 'Pending') { // Hide if Cancelled
                                return Html::a('Approve', $url, [
                                    'role' => 'modal-remote',
                                    'title' => Yii::t('yii2-ajaxcrud', 'Confirm'),
                                    'class' => 'btn bg-gradient-primary',
                                    'data-method' => false,
                                    'data-request-method' => 'post',
                                    'data-toggle' => 'tooltip',
                                    'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Approve'),
                                    'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Approve Confirm')
                                ]);
                            }
                        },
                        'complete' => function ($url, $model, $key) {
                            if ($model->status !== 'Cancelled') { 
                                return Html::a('Complete', $url, [
                                    'role' => 'modal-remote',
                                    'title' => Yii::t('yii2-ajaxcrud', 'submit to complete'),
                                    'data-toggle' => 'tooltip',
                                    'class' => 'btn bg-gradient-success', 
                                ]);
                            }
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