<?php

namespace app\modules\scheduling\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class DefaultController extends Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['admin'],
    //                 ],
    //                 [
    //                     'allow' => true,
    //                     'roles' => []
    //                 ]
    //             ],
    //         ],
    //     ];
    // }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
