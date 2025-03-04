<?php

use yii\helpers\Html;
use yii\grid\GridView;
?>

<div class="container mt-4">
    <div class="row">
        <!-- Welcome Message -->
        <div class="col-12 mb-4">
            <div class="alert alert-primary text-center">
                <h4>Welcome, <?= Yii::$app->user->identity->username; ?>!</h4>
                <p>Your health information at a glance.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Upcoming Appointments -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📅 Upcoming Appointments</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($appointment)) : ?>
                        <div style="max-height: 350px; overflow-y: auto;">
                            <ul class="list-group">
                                <?php foreach ($appointment as $item) : ?>
                                    <li class="list-group-item">
                                        <strong>🗓 Date:</strong> <?= Yii::$app->formatter->asDatetime($item->appointment_date, 'long'); ?><br>
                                        <?php if ($item->doctor): ?>
                                            <strong>👨‍⚕️ Doctor:</strong> <?= Html::encode($item->doctor->fname . ' ' . strtoupper(substr($item->doctor->mname, 0, 1)) . '. ' . $item->doctor->lname) ?: 'N/A'; ?><br>
                                        <?php endif; ?>
                                        <?php if ($item->midwife): ?>
                                            <strong>👩🏻‍⚕️ Midwife:</strong> <?= Html::encode($item->midwife->fname . ' ' . strtoupper(substr($item->midwife->mname, 0, 1)) . '. ' . $item->midwife->lname); ?><br>
                                        <?php endif; ?>
                                        <strong>🏥 Location:</strong> <?= Html::encode('Barangay Ibaba Health Center'); ?><br>
                                        <strong>❓ Status:</strong> <?= Html::encode($item->status); ?><br>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else : ?>
                        <p class="text-muted">No upcoming appointments.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>



        <!-- Latest Lab Results -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">🧪 Latest Visit</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($history)) : ?>
                        <!-- Scrollable Container (Shows at least 3 items before scrolling) -->
                        <div style="max-height: 350px; overflow-y: auto;">
                            <ul class="list-group">
                                <?php foreach ($history as $item) : ?>
                                    <li class="list-group-item">
                                        <strong>🆔 Reference No:</strong> <?= Html::encode($item->reference_no); ?><br>
                                        <strong>📅 Date of Visit:</strong> <?= Yii::$app->formatter->asDatetime($item->visit_date, 'long'); ?><br>
                                        <?php if ($item->doctor): ?>
                                            <strong>👨‍⚕️ Doctor:</strong> <?= $item->doctor ? Html::encode($item->doctor->fname . ' ' . strtoupper(substr($item->doctor->mname, 0, 1)) . '. ' . $item->doctor->lname) : 'N/A'; ?><br>
                                        <?php endif; ?>
                                        <?php if ($item->midwife): ?>
                                            <strong>👩🏻‍⚕️ Midwife:</strong> <?= Html::encode($item->midwife->fname . ' ' . strtoupper(substr($item->midwife->mname, 0, 1)) . '. ' . $item->midwife->lname); ?><br>
                                        <?php endif; ?>
                                        <strong>🏥 Diagnosis:</strong> <?= Html::encode($item->diagnosis); ?><br>
                                        <strong>💊 Treatment:</strong> <?= Html::encode($item->treatment); ?><br>
                                        <strong>📝 Remarks:</strong> <?= Html::encode($item->remarks); ?><br>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else : ?>
                        <p class="text-muted">No latest visit available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>