<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'uuid',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'fname',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'lname',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'mname',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'suffix',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'gender',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'dob',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'contact_number',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'email',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'address',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'blood_type',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'existing_conditions',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'allergies',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'emergency_contact',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'emergency_contact_number',
    // ],
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
        'template' => '{view} {update}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        // 'buttons' => [
        // 'view' => function ($url, $model, $key) {
        //     return Html::a('View', $url, [
        //         'role' => 'modal-remote',
        //         'title' => Yii::t('yii2-ajaxcrud', 'More info'),
        //         'data-toggle' => 'tooltip',
        //         'class' => 'btn bg-gradient-info', // Button style
        //     ]);
        // },
        // ]
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => Yii::t('yii2-ajaxcrud', 'View'),
            'data-toggle' => 'tooltip',
            'class' => 'btn bg-gradient-success',
            'label' => 'View'
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => Yii::t('yii2-ajaxcrud', 'Update'),
            'data-toggle' => 'tooltip',
            'class' => 'btn bg-gradient-primary',
            'label' => 'Update'
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
        //     'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Delete Confirm'),
        //     'label' => 'Delete'
        // ],
    ],

];
