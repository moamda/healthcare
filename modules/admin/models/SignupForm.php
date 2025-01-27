<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

use app\models\User;
use app\modules\admin\models\Profile;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $fname;
    public $mname;
    public $lname;
    public $suffix;
    public $gender;
    public $address;
    public $contact;
    public $email;
    public $password;
    public $retypePassword;


    public function rules()
    {
        return [
            // ['username', 'trim'],
            // ['username', 'required'],
            // ['username', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'This username has already been taken.'],
            // ['username', 'string', 'min' => 5, 'max' => 255],

            [['fname', 'lname', 'gender', 'address', 'contact', 'email'], 'required'],
            [['mname', 'suffix'], 'safe'],
            ['suffix', 'string', 'max' => 10],
            [['fname', 'lname', 'mname', 'address'], 'string', 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'This email address has already been taken.'],

            // ['password', 'required'],
            // ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            // ['retypePassword', 'required'],
            // ['retypePassword', 'compare', 'compareAttribute' => 'password'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'fname' => 'First Name',
            'mname' => 'Middle Name',
            'lname' => 'Last Name',
            'suffix' => 'Suffix',
            'gender' => 'Gender',
            'address' => 'Address',
            'contact' => 'Contact Number',
            'email' => 'Email Address',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->generateUsername();
        // $user->username = $this->username;
        $user->email = strtolower($this->email);
        $user->setPassword($this->generateDefaultPassword());
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();


        if ($user->save()) {
            // return $this->sendEmail($user);

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->first_name = $this->fname;
            $profile->middle_name = $this->mname;
            $profile->last_name = $this->lname;
            $profile->suffix = $this->suffix;
            $profile->gender = $this->gender;
            $profile->address = $this->address;
            $profile->contact = $this->contact;

            return $profile->save();
        }

        return false;

        //return $user->save() && $this->sendEmail($user);

    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    protected function generateUsername()
    {
        $username = strtolower(substr($this->fname, 0, 1) . substr($this->mname, 0, 1) . $this->lname);
        $baseUsername = $username;
        $counter = 1;

        while (User::find()->where(['username' => $username])->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    protected function generateDefaultPassword()
    {
        return strtolower(substr($this->fname, 0, 1) . substr($this->mname, 0, 1) . substr($this->lname, 0, 1)) . '@12345';
    }
}
