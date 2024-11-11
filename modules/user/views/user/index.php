<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?= Html::a('Create User', ['signup'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>


                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); 
                    ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'username',
                            'email:email',
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return $model->status == 9 ? 'Inactive' : 'Active';
                                },
                                'filter' => [
                                    9 => 'Inactive',
                                    10 => 'Active'
                                ]
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'template' => '{view} {update} {activate} {delete} {profile}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                                            'class' => 'btn bg-gradient-info',
                                            'title' => Yii::t('app', 'View'),
                                        ]);
                                    },
                                    'activate' => function ($url, $model, $key) {
                                        if ($model->status == 10) {
                                            return '';
                                        }
                                        $options = [
                                            'class' => 'btn bg-gradient-warning',
                                            'title' => Yii::t('app', 'Activate'),
                                            'aria-label' => Yii::t('app', 'Activate'),
                                            'data-confirm' => Yii::t('app', 'Are you sure you want to activate this user?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                        ];
                                        return Html::a('<i class="fas fa-check"></i>', $url, $options);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                                            'class' => 'btn bg-gradient-warning',
                                            'title' => Yii::t('app', 'Update'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        if ($model->status == 9) {
                                            return '';
                                        }
                                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                                            'class' => 'btn bg-gradient-danger',
                                            'title' => Yii::t('app', 'Delete'),
                                            'data-confirm' => Yii::t('app', 'Are you sure you want to deactivate this user?'),
                                            'data-method' => 'post',
                                        ]);
                                    },
                                    'profile' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-user"></i>', ['profile/view', 'id' => $model->id], [
                                            'class' => 'btn bg-gradient-success',
                                            'title' => Yii::t('app', 'Profile'),
                                        ]);
                                    },
                                ],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>