<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "doctor".
 *
 * @property int $id
 * @property string|null $fname
 * @property string|null $lname
 * @property string|null $mname
 * @property string|null $suffix
 * @property string|null $gender
 * @property string|null $dob
 * @property string|null $specialization
 * @property string|null $license_number
 * @property string|null $contact_number
 * @property string|null $email
 * @property string|null $address
 * @property string|null $years_of_experience
 * @property string|null $availability_schedule
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Doctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor';
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
            [['fname', 'lname', 'mname', 'suffix', 'gender', 'dob', 'specialization', 'license_number', 'contact_number', 'email', 'address', 'years_of_experience', 'availability_schedule', 'created_at', 'updated_at'], 'string', 'max' => 255],

            [['fname', 'lname', 'mname', 'gender', 'dob', 'specialization', 'license_number', 'contact_number', 'email', 'address', 'years_of_experience', 'availability_schedule'], 'required'],

            [['suffix', 'created_at', 'updated_at'], 'safe'],

            [['email'], 'email'],
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
            'specialization' => 'Specialization',
            'license_number' => 'License Number',
            'contact_number' => 'Contact Number',
            'email' => 'Email',
            'address' => 'Address',
            'years_of_experience' => 'Years Of Experience',
            'availability_schedule' => 'Availability Schedule',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
