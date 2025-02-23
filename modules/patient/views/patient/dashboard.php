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
                        <ul class="list-group">
                            <?php foreach ($appointment as $item) : ?>
                                <li class="list-group-item">
                                    <strong>🗓 Date:</strong> <?= Yii::$app->formatter->asDatetime($item->appointment_date, 'long'); ?><br>
                                    <?php if ($item->doctor): ?>
                                        <strong>👨‍⚕️ Doctor:</strong> <?= $item->doctor ? Html::encode($item->doctor->fname . ' ' . strtoupper(substr($item->doctor->mname, 0, 1)) . '. ' . $item->doctor->lname) : 'N/A'; ?><br>
                                    <?php endif; ?>
                                    <?php if ($item->midwife): ?>
                                        <strong>👩🏻‍⚕️ Midwife:</strong> <?= Html::encode($item->midwife->fname . ' ' . strtoupper(substr($item->midwife->mname, 0, 1)) . '. ' . $item->midwife->lname); ?><br>
                                    <?php endif; ?>
                                    <strong>🏥 Location:</strong> <?= Html::encode('Barangay Ibaba Health Center'); ?><br>
                                    <strong>❓ Status:</strong> <?= Html::encode($item->status); ?><br>

                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class="text-muted">No upcoming appointments.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Latest Lab Results -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">🧪 Latest Lab Results</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">🩸 Blood Test (Normal) 📄 <a href="#" class="text-primary">[View Report]</a></li>
                        <li class="list-group-item">🩺 X-Ray (Pending) 📄 <a href="#" class="text-primary">[Check Status]</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Prescriptions -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">💊 Prescriptions</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">💊 Paracetamol 500mg (Take 1 tablet every 6 hours)</li>
                        <li class="list-group-item">💊 Atorvastatin 10mg (1x daily, for cholesterol)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>