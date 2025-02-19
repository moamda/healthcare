<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Midwife;
use app\modules\admin\models\MidwifeSearch;
use app\modules\patient\models\Appointments;
use app\modules\patient\models\MedicalHistory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * MidwifeController implements the CRUD actions for Midwife model.
 */
class MidwifeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Midwife models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MidwifeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionComplete($id)
    {
        $request = Yii::$app->request;
        $model = new MedicalHistory();
        $modelApt = $this->findModel2($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title' => "Complete Appointment",
                    'content' => $this->renderAjax('complete', ['model' => $model]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }

            if ($model->load($request->post()) && $model->validate()) {
                $file = UploadedFile::getInstance($model, 'attachments');
                if ($file) {
                    $uploadPath = 'uploads/';
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0775, true);
                    }

                    $filePath = $uploadPath . uniqid() . '_' . $file->baseName . '.' . $file->extension;
                    if ($file->saveAs($filePath)) {
                        $model->attachments = $filePath;
                    } else {
                        Yii::$app->session->setFlash('error', 'File upload failed.');
                        return [
                            'title' => "Complete Appointment",
                            'content' => $this->renderAjax('complete', ['model' => $model]),
                            'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                                Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                        ];
                    }
                }

                $model->patient_id = $modelApt->patient_id;
                $model->specialist_id = $modelApt->specialist_id;
                $model->reference_no = $modelApt->reference_no;
                $model->created_at = date('Y-m-d H:i:s');
                $model->has_consent = 1;

                try {
                    $existingRecord = $this->readRecord($model->reference_no);
                    if (empty($existingRecord)) {
                        $this->saveRecord($model);

                        if ($model->save(false)) {
                            $modelApt->status = "Completed";
                            $modelApt->notes = 'completed consultation';
                            $modelApt->save(false);

                            // return [
                            //     'forceClose' => true,
                            //     'forceReload' => '#crud-datatable-pjax'
                            // ];

                            return $this->redirect(['appointments']);
                        }
                    }
                } catch (\Exception $e) {
                    Yii::error("Blockchain save error: " . $e->getMessage());
                }
            }

            return [
                'title' => "Complete Appointment",
                'content' => $this->renderAjax('complete', ['model' => $model]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                    Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), ['class' => 'btn btn-primary', 'type' => 'submit'])
            ];
        }

        if ($model->load($request->post())) {
            $file = UploadedFile::getInstance($model, 'attachments');
            $uploadPath = 'uploads/';
            $filePath = $uploadPath . uniqid() . '_' . $file->baseName . '.' . $file->extension;

            $model->attachments = $file;
            $model->patient_id = $modelApt->patient_id;
            $model->specialist_id = $modelApt->specialist_id;
            $model->reference_no = $modelApt->reference_no;
            $model->created_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                $modelApt->status = "Completed";
                $modelApt->save(false);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }


    /**
     * Displays a single Midwife model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Midwife #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                    Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Midwife();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Midwife",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Create'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Midwife",
                    'content' => '<span class="text-success">' . Yii::t('yii2-ajaxcrud', 'Create') . ' Midwife ' . Yii::t('yii2-ajaxcrud', 'Success') . '</span>',
                    'footer' =>  Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a(Yii::t('yii2-ajaxcrud', 'Create More'), ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Midwife",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Midwife #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Midwife #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Midwife #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Midwife::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel2($id)
    {
        if (($model = Appointments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
