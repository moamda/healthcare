<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\patient\models\Appointments */

?>
<div class="appointments-create">
    <h5 class="text-center">
        <?= Html::encode($doctor->fname . ' ' . ($doctor->mname ? strtoupper(substr($doctor->mname, 0, 1)) . '. ' : '') . $doctor->lname . ($doctor->suffix ? ' ' . $doctor->suffix : '')) ?>
    </h5>
    <h6 class="text-center">
        <?= Html::encode('(' . $doctor->availability_schedule . ')') ?>
    </h6>
    <hr>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>