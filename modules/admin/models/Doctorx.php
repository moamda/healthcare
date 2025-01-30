<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "doctorx".
 *
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property string $specialization
 * @property string $license_number
 * @property string $years_of_experience
 * @property string $availability_schedule
 * @property string $created_at
 * @property string $updated_at
 */
class Doctorx extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctorx';
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
            [['user_id', 'profile_id', 'specialization', 'license_number', 'years_of_experience', 'availability_schedule', 'created_at', 'updated_at'], 'safe'],
            [['user_id', 'profile_id'], 'integer'],
            [['specialization', 'license_number', 'years_of_experience', 'availability_schedule', 'created_at', 'updated_at'], 'string', 'max' => 255],
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
            'profile_id' => 'Profile ID',
            'specialization' => 'Specialization',
            'license_number' => 'License Number',
            'years_of_experience' => 'Years Of Experience',
            'availability_schedule' => 'Availability Schedule',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
