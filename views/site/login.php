<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'login-form',]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>LTE</a>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <div class="input-group mb-3">
                    <?= $form->field($model, 'username', [
                        'template' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>{error}',
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Username'],
                    ])->textInput(['autofocus' => true]) ?>
                </div>

                <div class="input-group mb-3">
                    <?= $form->field($model, 'password', [
                        'template' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>{error}',
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Password'],
                    ])->passwordInput() ?>
                </div>

                <div class="row">
                    <div class="col-7">
                        <div class="icheck-primary">
                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => '{input} {label}',
                                'labelOptions' => ['class' => 'form-check-label']
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-5">
                        <a href="forgot-password.html">Forgot password?</a>
                    </div>
                </div>

                <div class="social-auth-links text-center mt-3">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>