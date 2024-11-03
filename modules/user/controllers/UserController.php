<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\user\models\SignupForm;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
// use mdm\admin\models\form\Signup;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    const FLASH_SUCCESS = 'success';
    const FLASH_ERROR = 'error';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
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

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        
        // original code
        // if ($model->load(Yii::$app->request->post()) && $model->signup()) {
        //     Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
        //     return $this->goHome();
        // }

        // new optimized code
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                if ($model->signup()){
                    Yii::$app->session->setFlash(self::FLASH_SUCCESS, 'Thank you for registtration. Please check your inbox for verification email.');
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

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSignup()
    {

        $model = new SignupForm();
        
        // original code
        // if ($model->load(Yii::$app->request->post()) && $model->signup()) {
        //     Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
        //     return $this->goHome();
        // }

        // new optimized code
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                if ($model->signup()){
                    Yii::$app->session->setFlash(self::FLASH_SUCCESS, 'Thank you for registtration. Please check your inbox for verification email.');
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
