<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

return [
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
        'attribute' => 'patient_id',
        'value' => function ($model) {
            return $model->patient ? $model->patient->fname . ' ' . strtoupper(substr($model->patient->mname, 0, 1)) . '. ' . $model->patient->lname : 'No patient assigned';
        },
        'label' => 'Patient',
        'contentOptions' => ['style' => 'vertical-align: middle;']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'specialist_id',
        'value' => function ($model) {
            if ($model->doctor) {
                return $model->doctor->fname . ' ' . strtoupper(substr($model->doctor->mname, 0, 1)) . '. ' . $model->doctor->lname . ' (Doctor)';
            } elseif ($model->midwife) {
                return $model->midwife->fname . ' ' . strtoupper(substr($model->midwife->mname, 0, 1)) . '. ' . $model->midwife->lname . ' (Midwife)';
            } else {
                return 'No doctor or midwife assigned';
            }
        },
        'label' => 'Specialist',
        'contentOptions' => ['style' => 'vertical-align: middle;']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'visit_date',
        'contentOptions' => ['style' => 'vertical-align: middle;']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'diagnosis',
        'contentOptions' => ['style' => 'vertical-align: middle;']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'treatment',
        'contentOptions' => ['style' => 'vertical-align: middle;']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'remarks',
        'contentOptions' => ['style' => 'vertical-align: middle;']
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'attachments',
        'format' => 'raw',
        'value' => function ($model) {
            if (!empty($model->attachments)) {
                return Html::a('<i class="fas fa-download"></i> Download', Yii::getAlias('@web/' . $model->attachments), [
                    'title' => 'Download Attachment',
                    'data-pjax' => '0',
                    'download' => basename($model->attachments),
                    'class' => 'btn btn-sm btn-outline-primary'
                ]);
            }
            return '<span class="text-danger"><i class="fas fa-times"></i> No File</span>';
        },
        'contentOptions' => ['style' => 'vertical-align: middle; text-align: center;']
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => '{update-history} {give-consent} {revoke-consent}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'buttons' => [
            // 'update-history' => function ($url, $model, $key) {
            //     if (Yii::$app->user->can('access patient module')) {
            //         return Html::a('Update', $url, [
            //             'role' => 'modal-remote',
            //             'title' => Yii::t('yii2-ajaxcrud', 'More info'),
            //             'data-toggle' => 'tooltip',
            //             'class' => 'btn bg-gradient-warning', // Button style
            //         ]);
            //     }
            // },

            'revoke-consent' => function ($url, $model, $key) {
                if (Yii::$app->user->can('access patient module') && $model->has_consent) {
                    return Html::a('Revoke Consent', $url, [
                        'role' => 'modal-remote',
                        // 'title' => Yii::t('yii2-ajaxcrud', 'Confirm'),
                        'class' => 'btn bg-gradient-danger',
                        'data-method' => false,
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Consent'),
                        'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Revoke consent confirm')
                    ]);
                }
                return ''; // Return empty if condition is not met
            },
            'give-consent' => function ($url, $model, $key) {
                if (Yii::$app->user->can('access patient module') && !$model->has_consent) {
                    return Html::a('Give Consent', $url, [
                        'role' => 'modal-remote',
                        // 'title' => Yii::t('yii2-ajaxcrud', 'Confirm'),
                        'class' => 'btn bg-gradient-success',
                        'data-method' => false,
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Consent'),
                        'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Give consent confirm')
                    ]);
                }
                return ''; // Return empty if condition is not met
            },
        ],
        // 'viewOptions' => [
        //     'role' => 'modal-remote',
        //     'title' => Yii::t('yii2-ajaxcrud', 'View'),
        //     'data-toggle' => 'tooltip',
        //     'class' => 'btn bg-gradient-info',
        //     'label' => 'View'
        // ],
        // 'update-history' => [
        //     'role' => 'modal-remote',
        //     'title' => Yii::t('yii2-ajaxcrud', 'Update'),
        //     'data-toggle' => 'tooltip',
        //     'class' => 'btn bg-gradient-warning',
        //     'label' => 'Update'
        // ],
        // 'deleteOptions' => [
        //     'role' => 'modal-remote',
        //     'title' => Yii::t('yii2-ajaxcrud', 'Delete'),
        //     'class' => 'btn bg-gradient-danger',
        //     'data-confirm' => false,
        //     'data-method' => false, // for overide yii data api
        //     'data-request-method' => 'post',
        //     'data-toggle' => 'tooltip',
        //     'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Delete'),
        //     'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Delete Confirm'),
        //     'label' => 'Delete'
        // ],
    ],

];
