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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
                </div>

                <div class="card-body">
                    <p>Please fill out the following fields to signup:</p>
                    <?= Html::errorSummary($model) ?>

                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <?= $form->field($model, 'fname')->textInput(['placeholder' => 'Required'])?>
                        </div>
                        <div class="form-group col-md-3">
                            <?= $form->field($model, 'mname')->textInput(['placeholder' => 'Optional'])?>
                        </div>
                        <div class="form-group col-md-3">
                            <?= $form->field($model, 'lname')->textInput(['placeholder' => 'Required'])?>
                        </div>
                        <div class="form-group col-md-2">
                            <?= $form->field($model, 'suffix')->dropDownList(
                                [
                                    'Jr.' => 'Jr.',
                                    'Sr.' => 'Sr.',
                                    'I' => 'I',
                                    'II' => 'II',
                                    'III' => 'III',
                                    'IV' => 'IV',
                                    'V' => 'V'
                                ],
                                ['prompt' => 'Optional']
                            )?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'gender')->dropDownList(
                                [
                                    'Male' => 'Male',
                                    'Female' => 'Female',
                                ],
                                ['prompt' => 'Optional']
                            )?>
                        </div>
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'contact')->textInput(['placeholder' => 'Required'])?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'address')->textarea(['rows' => 2, 'placeholder' => 'Required'])?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Required'])?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

                <div class="card-footer">
                    <p><em>Your default username and password will be automatically generated based on your name.</em></p>
                    <p><em>For example, if your name is <strong>John A. Wick</strong>:</em></p>
                    <ul>
                        <li><em>Your default username will be "jawick" (first letter of your first name, middle initial, and full last name).</em></li>
                        <li><em>Your default password will be "jaw@12345" (first letter of your first name, middle initial, and last name, followed by "@12345").</em></li>
                    </ul>
                </div>
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>