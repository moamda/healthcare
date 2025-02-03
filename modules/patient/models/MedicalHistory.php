<?php

namespace app\modules\patient\models;

use Yii;

/**
 * This is the model class for table "medical_history".
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $doctor_id
 * @property string|null $visit_date
 * @property string|null $diagnosis
 * @property string|null $treatment
 * @property string|null $remarks
 * @property string|null $attachments
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class MedicalHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medical_history';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('healthcare_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patient_id', 'doctor_id'], 'integer'],
            [['visit_date', 'diagnosis', 'treatment', 'remarks', 'attachments', 'created_at', 'updated_at'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patient_id' => 'Patient ID',
            'doctor_id' => 'Doctor ID',
            'visit_date' => 'Visit Date',
            'diagnosis' => 'Diagnosis',
            'treatment' => 'Treatment',
            'remarks' => 'Remarks',
            'attachments' => 'Attachments',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
