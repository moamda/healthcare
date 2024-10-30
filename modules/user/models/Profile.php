<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_initial
 * @property string|null $extname
 * @property string|null $gender
 * @property string $address
 * @property string $contact
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'last_name', 'first_name', 'middle_initial', 'address', 'contact'], 'required'],
            [['user_id'], 'integer'],
            [['last_name', 'first_name', 'middle_initial', 'extname', 'gender', 'address', 'contact'], 'string', 'max' => 255],
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
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'middle_initial' => 'Middle Initial',
            'extname' => 'Extname',
            'gender' => 'Gender',
            'address' => 'Address',
            'contact' => 'Contact',
        ];
    }
}
