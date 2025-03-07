<?php

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
    // 'attribute'=>'specialization',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'license_number',
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
    // 'attribute'=>'years_of_experience',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'availability_schedule',
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
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => false,
            'data-toggle' => 'tooltip',
            'class' => 'btn btn bg-gradient-success',
            'label' => 'View',
            'data-toggle' => false
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => false,
            'data-toggle' => 'tooltip',
            'class' => 'btn bg-gradient-primary',
            'label' => 'Update',
            'data-toggle' => false
        ],
        // 'deleteOptions' => [
        //     'role' => 'modal-remote',
        //     'title' => Yii::t('yii2-ajaxcrud', 'Delete'),
        //     'class' => 'btn btn bg-gradient-danger',
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
