<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\user\models\SignupForm;
use app\modules\user\models\Profile;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
// use mdm\admin\models\form\Signup;

/**
 * UserController implements the CRUD actions for User model.
 */
class DashboardController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['super-admin'], 
                        ],
                        [
                            'allow' => false, 
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionV1()
    {
        $totalUsers = User::find()->count();
        $activeCount = User::find()->where(['status' => 10])->count();
        $inactiveCount = User::find()->where(['status' => 9])->count();

        return $this->render('v1', [
            'totalUsers' => $totalUsers,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount
        ]);
    }
}
