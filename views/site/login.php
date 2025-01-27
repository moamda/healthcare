<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="login-logo text-center mb-4">
                <a href="#"><b>Healthcare</b></a>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username', [
                        'template' => '{input}{error}',
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Username'],
                    ])->textInput(['autofocus' => true, 'autocomplete' => 'off']) ?>

                    <?= $form->field($model, 'password', [
                        'template' => '{input}{error}',
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Password'],
                    ])->passwordInput() ?>

                    <!-- <div class="form-group">
                        <= $form->field($model, 'rememberMe')->checkbox(['template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n{error}"]) ?>
                    </div> -->

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                    </div>

                    <!-- <p class="mb-1 text-right">
                        <= Html::a('Forgot Password?', ['site/request-password-reset']) ?>
                    </p> -->

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>