<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="login-logo">
                <a href="#"><b>Basic</b>Template</a>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <?php $form = ActiveForm::begin(['id' => 'login-form',]); ?>
                    <?= $form->field($model, 'username', [
                        'template' => '{input}<div class="input-group-append"></div>{error}',
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Username'],
                    ])->textInput([
                        'autofocus' => true,
                        'autocomplete' => 'off',
                    ]) ?>
                    <?= $form->field($model, 'password', [
                        'template' => '{input}<div class="input-group-append"></div>{error}',
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Password'],
                    ])->passwordInput() ?>


                    <div class="row">
                        <div class="col-7">
                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                            ]) ?>
                        </div>
                        <div class="col-5">
                            <a href="forgot-password.html">Forgot password?</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>