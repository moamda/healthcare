<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\patient\models\Appointments */
?>
<div class="appointments-view">
    <div class="row">
        <!-- Card for Picture -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <img src="<?= Yii::$app->request->baseUrl ?>/uploads/avatar.png" alt="Profile Picture">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'patient_id',
                    'specialist_id',
                ],
            ]) ?>
        </div>
    </div>

</div>
</div>