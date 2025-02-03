<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="doctor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>

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
    ) ?>

    <?= $form->field($model, 'gender')->dropDownList(
        [
            'Male' => 'Male',
            'Female' => 'Female',
        ],
        ['prompt' => 'Select Gender']
    ) ?>

    <?= $form->field($model, 'dob')->widget(DatePicker::class, [
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'options' => ['placeholder' => 'Select date'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'specialization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'license_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'years_of_experience')->dropDownList(
        [
            '0' => 'Less than a year',
            '1' => '1 Year',
            '2' => '2 Years',
            '3' => '3 Years',
            '4' => '4 Years',
            '5' => '5+ Years'
        ],
        ['prompt' => 'Select Years of Experience']
    ) ?>

    <?= $form->field($model, 'availability_schedule')->textInput(['maxlength' => true]) ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>