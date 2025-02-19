<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Midwife */
?>
<div class="midwife-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'uuid',
            'fname',
            'lname',
            'mname',
            'suffix',
            'gender',
            'dob',
            'specialization',
            'license_number',
            'contact_number',
            'email:email',
            'address',
            'years_of_experience',
            'availability_schedule',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
