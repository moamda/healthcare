<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\patient\models\Patient */
?>
<div class="patient-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fname',
            'lname',
            'mname',
            'suffix',
            'gender',
            'dob',
            'contact_number',
            'email:email',
            'address',
            'blood_type',
            'existing_conditions',
            'allergies',
            'emergency_contact',
            'emergency_contact_number',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
