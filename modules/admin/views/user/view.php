<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <!-- <= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to deactivate this user?',
                                'method' => 'post',
                            ],
                        ]) ?> -->
                    </p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'username',
                            'password_hash',
                            'password_reset_token',
                            'verification_token',
                            'email:email',
                            'auth_key',
                            [
                                'attribute' => 'status',
                                'value' => fn($model) => $model->status === 9 ? 'Inactive' : 'Active',
                                'filter' => [
                                    9 => 'Inactive',
                                    10 => 'Active',
                                ],
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
                            'password',
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>