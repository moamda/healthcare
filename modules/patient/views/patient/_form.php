<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\patient\models\Appointments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appointments-form">



	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'appointment_date')->widget(DateTimePicker::class, [
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

	<?= $form->field($model, 'reason')->textarea(['maxlength' => true]) ?>

	<?php if (!Yii::$app->request->isAjax) { ?>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	<?php } ?>

	<?php ActiveForm::end(); ?>

</div>