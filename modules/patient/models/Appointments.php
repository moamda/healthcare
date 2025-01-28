<?php

namespace app\modules\patient\models;

use app\modules\admin\models\Doctor;
use Yii;

/**
 * This is the model class for table "appointments".
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $doctor_id
 * @property string|null $appointment_date
 * @property string|null $status
 * @property string|null $reason
 * @property string|null $notes
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Appointments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointments';
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
            [['appointment_date', 'status', 'reason', 'notes', 'created_at', 'updated_at'], 'string', 'max' => 255],
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
            'appointment_date' => 'Appointment Date',
            'status' => 'Status',
            'reason' => 'Reason',
            'notes' => 'Notes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getDoctor()
{
    return $this->hasOne(Doctor::class, ['id' => 'doctor_id']);
}
}
