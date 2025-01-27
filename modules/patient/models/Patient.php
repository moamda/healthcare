<?php

namespace app\modules\patient\models;

use Yii;

/**
 * This is the model class for table "patient".
 *
 * @property int $id
 * @property string|null $fname
 * @property string|null $lname
 * @property string|null $mname
 * @property string|null $suffix
 * @property string|null $gender
 * @property string|null $dob
 * @property string|null $contact_number
 * @property string|null $email
 * @property string|null $address
 * @property string|null $blood_type
 * @property string|null $existing_conditions
 * @property string|null $allergies
 * @property string|null $emergency_contact
 * @property string|null $emergency_contact_number
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Patient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patient';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('healthcare_db_patient');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'mname', 'suffix', 'gender', 'dob', 'contact_number', 'email', 'address', 'blood_type', 'existing_conditions', 'allergies', 'emergency_contact', 'emergency_contact_number', 'created_at', 'updated_at'], 'string', 'max' => 255],

            [['fname', 'lname', 'mname', 'gender', 'dob', 'contact_number', 'email', 'address', 'emergency_contact', 'emergency_contact_number'], 'required'],

            [['suffix', 'blood_type', 'existing_conditions', 'allergies', 'created_at', 'updated_at'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'Firstname',
            'lname' => 'Lastname',
            'mname' => 'Middle Name',
            'suffix' => 'Suffix',
            'gender' => 'Gender',
            'dob' => 'Date of Birth',
            'contact_number' => 'Contact Number',
            'email' => 'Email',
            'address' => 'Address',
            'blood_type' => 'Blood Type',
            'existing_conditions' => 'Existing Conditions',
            'allergies' => 'Allergies',
            'emergency_contact' => 'Emergency Contact Fullname',
            'emergency_contact_number' => 'Emergency Contact Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
