<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-profile">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['readonly' => true]) ?>
    <div class="form-row">
        <div class="form-group col-md-4">
            <?= $form->field($profile, 'first_name')->textInput(['placeholder' => 'First Name'])->label(false) ?>
        </div>
        <div class="form-group col-md-3">
            <?= $form->field($profile, 'middle_name')->textInput(['placeholder' => 'Middle Name'])->label(false) ?>
        </div>
        <div class="form-group col-md-3">
            <?= $form->field($profile, 'last_name')->textInput(['placeholder' => 'Last Name'])->label(false) ?>
        </div>
        <div class="form-group col-md-2">
            <?= $form->field($profile, 'suffix')->dropDownList(
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
            <?= $form->field($profile, 'gender')->dropDownList(
                [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
                ['prompt' => 'Select Sex']
            )->label(false) ?>
        </div>
        <div class="form-group col-md-6">
            <?= $form->field($profile, 'contact')->textInput(['placeholder' => 'Contact Number'])->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <?= $form->field($profile, 'address')->textarea(['rows' => 2, 'placeholder' => 'Address'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Email'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>