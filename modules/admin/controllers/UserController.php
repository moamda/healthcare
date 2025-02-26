<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Doctorx;
use Yii;
use app\modules\admin\models\User;
use app\modules\admin\models\UserSearch;
use app\modules\admin\models\SignupForm;
use app\modules\admin\models\Profile;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

// use mdm\admin\models\form\Signup;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    const FLASH_SUCCESS = 'success';
    const FLASH_ERROR = 'error';
    const INACTIVE = 9;
    const ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
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
                            'roles' => ['admin', 'super-admin'],
                        ],
                        [
                            'allow' => false,
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        // return $this->render('view', [
        //     'user' => $this->findModel($id),
        //     'profile' => Profile::find()->where(['user_id' => $id])->one(),
        // ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'profile' => Profile::find()->where(['user_id' => $id])->one(),
        ]);
    }


    // public function actionCreate()
    // {
    //     $model = new SignupForm();

    //     // original code
    //     // if ($model->load(Yii::$app->request->post()) && $model->signup()) {
    //     //     Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
    //     //     return $this->goHome();
    //     // }

    //     // new optimized code
    //     if (Yii::$app->request->post()) {
    //         $model->load(Yii::$app->request->post());
    //         if ($model->validate()) {
    //             if ($model->signup()) {
    //                 Yii::$app->session->setFlash(self::FLASH_SUCCESS, 'Thank you for registtration. Please check your inbox for verification email.');
    //                 return $this->redirect(['index']);
    //             } else {
    //                 Yii::$app->session->setFlash(self::FLASH_ERROR, 'Failed to save user.');
    //             }
    //         }
    //     }

    //     return $this->render('signup', [
    //         'model' => $model,
    //     ]);
    // }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->new_password = null;

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->new_password)) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->new_password);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'User "' . $model->username . '" has been updated successfully.');
                return $this->redirect(['index']);
                // return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $user = $this->findModel($id);

        if ($user->status == self::ACTIVE) {
            $user->status = self::INACTIVE;
            if ($user->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->redirect(['index']);
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                if ($model->signup()) {
                    Yii::$app->session->setFlash(self::FLASH_SUCCESS, 'Thank you for registration.');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash(self::FLASH_ERROR, 'Failed to save user.');
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionActivate($id)
    {
        $user = $this->findModel($id);

        if ($user->status == self::INACTIVE) {
            $user->status = self::ACTIVE;
            if ($user->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->goHome();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
