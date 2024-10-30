<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title = Yii::t('rbac-admin', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="user-signup">
                                <h1><?= Html::encode($this->title) ?></h1>

                                <p>Please fill out the following fields to signup:</p>
                                <?= Html::errorSummary($model) ?>
                                
                                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                                <?= $form->field($model, 'username') ?>
                                <?= $form->field($model, 'email') ?>
                                <?= $form->field($model, 'password')->passwordInput() ?>
                                <?= $form->field($model, 'retypePassword')->passwordInput() ?>
                                <div class="form-group">
                                    <?= Html::submitButton(Yii::t('rbac-admin', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>