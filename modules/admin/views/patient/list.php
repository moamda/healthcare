<?php

use yii\helpers\Html;

/** @var $doctors app\models\Doctor[] */
?>

<style>
    .card-title {
        color: #2c3e50;
        font-weight: bold;
    }

    .card-text {
        font-size: 0.9rem;
    }

    .card:hover {
        transform: scale(1.02);
        transition: 0.3s ease-in-out;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4">Select a Doctor</h2>
    <div class="row row-cols-1 row-cols-md-5 g-4">
        <?php foreach ($doctor as $doctors): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-primary">

                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>