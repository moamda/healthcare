<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Doctorx */
?>
<div class="doctorx-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'profile_id',
            'specialization',
            'license_number',
            'years_of_experience',
            'availability_schedule',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
