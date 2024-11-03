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
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="card-body">

                    <p>Please fill out the following fields to signup:</p>
                    <?= Html::errorSummary($model) ?>

                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <?= $form->field($model, 'fname')->textInput(['placeholder' => 'First Name'])->label(false) ?>
                        </div>
                        <div class="form-group col-md-3">
                            <?= $form->field($model, 'mname')->textInput(['placeholder' => 'Middle Name'])->label(false) ?>
                        </div>
                        <div class="form-group col-md-3">
                            <?= $form->field($model, 'lname')->textInput(['placeholder' => 'Last Name'])->label(false) ?>
                        </div>
                        <div class="form-group col-md-3">
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
                                ['prompt' => 'Select Suffix']
                            )->label(false) ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'gender')->dropDownList(
                                [
                                    'Male' => 'Male',
                                    'Female' => 'Female',
                                ],
                                ['prompt' => 'Select Gender']
                            )->label(false) ?>
                        </div>
                        <div class="form-group col-md-6">
                            <?= $form->field($model, 'contact')->textInput(['placeholder' => 'Contact Number'])->label(false) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'address')->textarea(['rows' => 2, 'placeholder' => 'Address'])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Email'])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

                <div class="card-footer">
                    <p><em>Your default password will be generated based on your name (first letter of first name, middle initial, and last name, followed by "@12345"). For example, if your name is John A. Doe, your default password will be "jad@12345".</em></p>
                </div>
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>