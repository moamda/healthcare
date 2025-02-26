<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "tnx_logs".
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string $details
 * @property string $ip_address
 * @property string $user_agent
 * @property string $created_at
 */
class TnxLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tnx_logs';
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
            [['user_id', 'action', 'details', 'ip_address', 'user_agent', 'created_at'], 'safe'],
            [['user_id'], 'integer'],
            [['action', 'details', 'ip_address', 'user_agent', 'created_at'], 'string', 'max' => 255],
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
            'action' => 'Action',
            'details' => 'Details',
            'ip_address' => 'Ip Address',
            'user_agent' => 'User Agent',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function logAction($userId, $action, $details)
    {
        $log = new self();
        $log->user_id = $userId;
        $log->action = $action;
        $log->details = $details;
        $log->ip_address = Yii::$app->request->userIP === '::1' ? '127.0.0.1' : Yii::$app->request->userIP;
        $log->user_agent = Yii::$app->request->userAgent;
        $log->created_at = date('Y-m-d H:i:s');

        return $log->save();
    }
}