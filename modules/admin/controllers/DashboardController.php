<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\User;
use app\modules\admin\models\UserSearch;
use app\modules\admin\models\SignupForm;
use app\modules\admin\models\Profile;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                            'roles' => ['super-admin', 'admin'],
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
