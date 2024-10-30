<?php

use yii\helpers\Html;
use yii\grid\GridView;

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


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'id',
                            'username',
                            [
                                'attribute' => 'status',
                                'value' => function($model) {
                                    return $model->status == 0 ? 'Inactive' : 'Active';
                                },
                                'filter' => [
                                    0 => 'Inactive',
                                    10 => 'Active'
                                ]
                            ],
                            // 'password_hash',
                            // 'password_reset_token',
                            // 'verification_token',
                            //'email:email',
                            //'auth_key',
                            //'status',
                            //'created_at',
                            //'updated_at',
                            //'password',

                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
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
