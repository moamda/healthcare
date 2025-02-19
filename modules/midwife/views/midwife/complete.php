<?php

use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Appointment */

$this->title = 'Complete Appointment';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="appointment-complete">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'visit_date')->widget(DateTimePicker::class, [
        'options' => ['placeholder' => 'Select time...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss P',
            'showMeridian' => true,
            'startView' => 1,
            'minView' => 0,
            'maxView' => 1,
            'todayBtn' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'diagnosis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'treatment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attachments')->widget(FileInput::class, [
        'options' => ['accept' => 'application/pdf, image/png, image/jpeg'],
        'pluginOptions' => [
            'showPreview' => true,
            'showUpload' => false,
            'allowedFileExtensions' => ['pdf', 'png', 'jpeg', 'jpg'],
            'maxFileSize' => 2048,
        ]
    ]) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>