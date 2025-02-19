<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="history-form">



	<?php $form = ActiveForm::begin(); ?>

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