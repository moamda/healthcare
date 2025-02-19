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
        'attribute' => 'full_name',
        'label' => 'Name',
        'vAlign' => 'middle',
        'value' => function ($model) {
            $mnameInitial = $model->mname ? strtoupper(substr($model->mname, 0, 1)) . '.' : '';
            return trim($model->fname . ' ' . $mnameInitial . ' ' . $model->lname);
        },
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'filter' => Html::textInput('full_name', Yii::$app->request->get('full_name'), ['class' => 'form-control']),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'specialization',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'availability_schedule',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => '{view-midwife} {createmidwife}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },

        'buttons' => [
            'view-midwife' => function ($url, $model, $key) {
                return Html::a('View', $url, [
                    'role' => 'modal-remote',
                    'title' => Yii::t('yii2-ajaxcrud', 'More info'),
                    'data-toggle' => 'tooltip',
                    'class' => 'btn bg-gradient-info', // Button style
                ]);
            },
            'createmidwife' => function ($url, $model, $key) {

                // var_dump($url); die;
                return Html::a('Book', $url, [
                    'role' => 'modal-remote',
                    'title' => Yii::t('yii2-ajaxcrud', 'More info'),
                    'data-toggle' => 'tooltip',
                    'class' => 'btn bg-gradient-success', // Button style
                ]);
            },
        ],
        // 'updateOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'Update'), 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-primary'],
        // 'deleteOptions' => [
        //     'role' => 'modal-remote',
        //     'title' => Yii::t('yii2-ajaxcrud', 'Delete'),
        //     'class' => 'btn btn-sm btn-outline-danger',
        //     'data-confirm' => false,
        //     'data-method' => false, // for overide yii data api
        //     'data-request-method' => 'post',
        //     'data-toggle' => 'tooltip',
        //     'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Delete'),
        //     'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Delete Confirm')
        // ],
    ],



];
