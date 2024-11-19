<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Forgot Password';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="login-logo text-center mb-4">
                <a href="#"><b>Basic</b>Template</a>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <p class="login-box-msg">You forgot your password? Here you can easily reset password.</p>

                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                    <?= $form->field($model, 'email', [
                        'template' => '{input}{error}',
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Email'],
                    ])->textInput(['autocomplete' => 'off']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Request reset password', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>

                    <p class="mb-1 text-left">
                        <?= Html::a('Login', ['site/login']) ?>
                    </p>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>