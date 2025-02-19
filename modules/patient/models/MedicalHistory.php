<?php

namespace app\modules\patient\models;

use app\modules\admin\models\Doctor;
use app\modules\admin\models\Patient;
use Yii;

/**
 * This is the model class for table "medical_history".
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $specialist_id
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
            [['patient_id', 'specialist_id'], 'integer'],
            [['reference_no', 'remarks', 'created_at', 'updated_at', 'attachments'], 'safe'], 
            [['visit_date', 'diagnosis', 'treatment'], 'required'],
            [['attachments'], 'string', 'max' => 255], 
            [['attachments'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpeg, jpg', 'maxSize' => 2 * 1024 * 1024],
            ['has_consent', 'boolean'],
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
            'specialist_id' => 'Specialist',
            'reference_no' => 'Reference #',
            'visit_date' => 'Visit Date',
            'diagnosis' => 'Diagnosis',
            'treatment' => 'Treatment',
            'remarks' => 'Remarks',
            'attachments' => 'Attachment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['user_id' => 'patient_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['user_id' => 'specialist_id']);
    }
}
