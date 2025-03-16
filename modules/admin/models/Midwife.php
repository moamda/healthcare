<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "midwife".
 *
 * @property int $id
 * @property int $user_id
 * @property string $uuid
 * @property string $fname
 * @property string $lname
 * @property string $mname
 * @property string $suffix
 * @property string $gender
 * @property string $dob
 * @property string $specialization
 * @property string $license_number
 * @property string $contact_number
 * @property string $email
 * @property string $address
 * @property string $years_of_experience
 * @property string $availability_schedule
 * @property string $created_at
 * @property string $updated_at
 */
class Midwife extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'midwife';
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
            [['id', 'user_id', 'uuid', 'fname', 'lname', 'mname', 'suffix', 'gender', 'dob', 'specialization', 'license_number', 'contact_number', 'email', 'address', 'years_of_experience', 'availability_schedule', 'created_at', 'updated_at'], 'safe'],
            [['id', 'user_id'], 'integer'],
            [['uuid', 'fname', 'lname', 'mname', 'suffix', 'gender', 'dob', 'specialization', 'license_number', 'contact_number', 'email', 'address', 'years_of_experience', 'availability_schedule', 'created_at', 'updated_at'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'uuid' => 'Midwife ID',
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
