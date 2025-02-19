<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\doctor\models\Appointments */
?>
<div class="history-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'reference_no',
            [
                'attribute' => 'patient_id',
                'label' => 'Patient',
                'value' => function ($model) {
                    return $model->patient
                        ? $model->patient->fname . ' ' . strtoupper(substr($model->patient->mname, 0, 1)) . '. ' . $model->patient->lname
                        : 'No patient assigned';
                },
            ],
            [
                'attribute' => 'specialist_id',
                'label' => 'Specialist',
                'value' => function ($model) {
                    return $model->doctor
                        ? $model->doctor->fname . ' ' . strtoupper(substr($model->doctor->mname, 0, 1)) . '. ' . $model->doctor->lname
                        : 'No specialist assigned';
                },
            ],
            [
                'attribute' => 'visit_date',
                'label' => 'Visit Date',
                'format' => ['date', 'php:D, M j, Y g:i A'], // Example: "January 1, 2024 (Monday)"
            ],
            'diagnosis',
            'remarks',
            // [
            //     'attribute' => 'attachments',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //         if (!empty($model->attachments)) {
            //             return Html::a(
            //                 '<i class="fas fa-download"></i> Download',
            //                 Yii::getAlias('@web/uploads/' . $model->attachments), // Assuming files are in 'uploads/'
            //                 [
            //                     'title' => 'Download Attachment',
            //                     'data-pjax' => '0',
            //                     'download' => basename($model->attachments),
            //                     'class' => 'btn btn-sm btn-outline-primary'
            //                 ]
            //             );
            //         }
            //         return '<span class="text-danger"><i class="fas fa-times"></i> No File</span>';
            //     },
            // ],

            [
                'attribute' => 'attachments',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->attachments)) {
                        $fileUrl = Yii::getAlias('@web/' . $model->attachments);
                        $fileExtension = pathinfo($model->attachments, PATHINFO_EXTENSION);

                        // Allowed image formats
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                        // Allowed PDF format
                        if (strtolower($fileExtension) === 'pdf') {
                            return '<iframe src="' . $fileUrl . '" width="100%" height="500px" style="border: none;"></iframe>';
                        }

                        // If it's an image, display it
                        if (in_array(strtolower($fileExtension), $imageExtensions)) {
                            return Html::img($fileUrl, ['alt' => 'Attachment', 'style' => 'max-width:300px; max-height:300px;']);
                        }

                        // If it's not an image or PDF, provide a download link
                        return Html::a('<i class="fas fa-download"></i> Download', $fileUrl, [
                            'title' => 'Download Attachment',
                            'data-pjax' => '0',
                            'download' => basename($model->attachments),
                            'class' => 'btn btn-sm btn-outline-primary'
                        ]);
                    }

                    return '<span class="text-danger"><i class="fas fa-times"></i> No File</span>';
                },
                'contentOptions' => ['style' => 'vertical-align: middle; text-align: center;']
            ],
        ],
    ]) ?>

</div>