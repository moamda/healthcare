<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'reference_no',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'attachments',
        'format' => 'raw',
        'value' => function ($model) {
            if (!$model->has_consent) {
                return Html::button('<i class="fas fa-lock"></i> Consent Required', [
                    'class' => 'btn btn-sm btn-outline-danger',
                    'onclick' => 'alert("Patient consent needed to download attachments.");',
                    'title' => 'Consent Required',
                ]);
            }

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
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => '{view-history}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'buttons' => [
            'view-history' => function ($url, $model, $key) {
                if ($model->has_consent) { // If consent is given
                    return Html::a('View', $url, [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii2-ajaxcrud', 'More info'),
                        'data-toggle' => 'tooltip',
                        'class' => 'btn bg-gradient-info',
                    ]);
                } else {
                    return Html::button('View', [
                        'class' => 'btn bg-gradient-danger',
                        'onclick' => 'alert("Patient consent needed to view this history.");',
                        'title' => 'Consent Required',
                    ]);
                }
            },
        ],
    ],

];
