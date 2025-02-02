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

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->generateUsername();
        $user->email = strtolower($this->email);
        $user->setPassword($this->generateDefaultPassword());
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if ($user->save()) {
            $userType = Yii::$app->request->post('user_type'); 

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->first_name = $this->fname;
            $profile->middle_name = $this->mname;
            $profile->last_name = $this->lname;
            $profile->suffix = $this->suffix;
            $profile->gender = $this->gender;
            $profile->address = $this->address;
            $profile->contact = $this->contact;

            if ($profile->save()) {
                date_default_timezone_set('Asia/Manila');

                if ($userType === 'doctor') {
                    $lastDoctor = Doctor::find()->orderBy(['uuid' => SORT_DESC])->one();
                    $lastPatient = Patient::find()->orderBy(['uuid' => SORT_DESC])->one();
                    $lastDoctorId = $lastDoctor ? (int)substr($lastDoctor->uuid, 0, 4) : 0;
                    $lastPatientId = $lastPatient ? (int)substr($lastPatient->uuid, 0, 4) : 0;
                    $nextNumber = max($lastDoctorId, $lastPatientId) + 1;
                    $nextNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT); 
                    $uuid = $nextNumber . date('mdY');


                    $doctor = new Doctor();
                    $doctor->user_id = $user->id;
                    $doctor->uuid = $uuid;
                    $doctor->fname = $profile->first_name;
                    $doctor->lname = $profile->last_name;
                    $doctor->mname = $profile->middle_name;
                    $doctor->suffix = $profile->suffix;
                    $doctor->gender = $profile->gender;
                    $doctor->address = $profile->address;
                    $doctor->contact_number = $profile->contact;
                    $doctor->created_at = date('Y-m-d H:i:s');

                    if (!$doctor->save()) {
                        Yii::$app->session->setFlash('error', 'Failed to save doctor details.');
                        return false;
                    }
                }

                if ($userType === 'patient') {
                    $lastDoctor = Doctor::find()->orderBy(['uuid' => SORT_DESC])->one();
                    $lastPatient = Patient::find()->orderBy(['uuid' => SORT_DESC])->one();
                    $lastDoctorId = $lastDoctor ? (int)substr($lastDoctor->uuid, 0, 4) : 0;
                    $lastPatientId = $lastPatient ? (int)substr($lastPatient->uuid, 0, 4) : 0;
                    $nextNumber = max($lastDoctorId, $lastPatientId) + 1;
                    $nextNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT); 
                    $uuid = $nextNumber . date('mdY');

                    $patient = new Patient();
                    $patient->user_id = $user->id;
                    $patient->uuid = $uuid;
                    $patient->fname = $profile->first_name;
                    $patient->lname = $profile->last_name;
                    $patient->mname = $profile->middle_name;
                    $patient->suffix = $profile->suffix;
                    $patient->gender = $profile->gender;
                    $patient->address = $profile->address;
                    $patient->contact_number = $profile->contact;
                    $patient->created_at = date('Y-m-d H:i:s');

                    if (!$patient->save()) {
                        Yii::$app->session->setFlash('error', 'Failed to save patient details.');
                        return false;
                    }
                }

                Yii::$app->session->setFlash('success', 'User registered successfully!');
                return true;
            }

            Yii::$app->session->setFlash('error', 'Failed to save profile.');
            return false;
        }

        Yii::$app->session->setFlash('error', 'Failed to register user.');
        return false;
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
