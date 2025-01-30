<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\doctor\models\Appointments */
?>
<div class="appointments-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'patient_id',
            'doctor_id',
            'appointment_date',
            'status',
            'reason',
            'notes',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
