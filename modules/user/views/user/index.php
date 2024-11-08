<?php

use yii\helpers\Html;
use yii\grid\GridView;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);

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


                    <?php // echo $this->render('_search', ['model' => $searchModel]); 
                    ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'id',
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
                            //'password_hash',
                            //'password_reset_token',
                            //'verification_token',
                            //'auth_key',
                            //'status',
                            //'created_at',
                            //'updated_at',
                            //'password',

                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'template' => '{view} {update} {delete} {profile}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                                            'class' => 'btn bg-gradient-info',
                                            'title' => Yii::t('app', 'View'),
                                        ]);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                                            'class' => 'btn bg-gradient-warning',
                                            'title' => Yii::t('app', 'Update'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                                            'class' => 'btn bg-gradient-danger',
                                            'title' => Yii::t('app', 'Delete'),
                                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
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


                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>