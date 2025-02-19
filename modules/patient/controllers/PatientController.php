<?php

namespace app\modules\patient\controllers;

use Yii;
use app\modules\admin\models\Doctor;
use app\modules\admin\models\DoctorSearch;
use app\modules\admin\models\Midwife;
use app\modules\admin\models\MidwifeSearch;
use app\modules\patient\models\Appointments;
use app\modules\patient\models\AppointmentsSearch;
use app\modules\patient\models\MedicalHistory;
use app\modules\patient\models\MedicalHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * PatientController implements the CRUD actions for Doctors model.
 */
class PatientController extends Controller
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
     * Lists all Doctors models.
     * @return mixed
     */
    public function actionBookDoctor()
    {
        $searchModel = new DoctorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('book-doctor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionBookMidwife()
    {
        $searchModel = new MidwifeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('book-midwife', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAppointments()
    {
        $searchModel = new AppointmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('appointments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCancel($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel2($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested record does not exist.');
        }

        $model->status = 'Cancelled';
        $model->notes = 'Cancelled by patient.';

        if ($model->save(false)) {
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Unable to cancel the appointment.');
            return $this->redirect(['index']);
        }
    }


    /**
     * Displays a single Appointments model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' =>  "Details",
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionViewAppointments($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' =>  "Details",
                'content' => $this->renderAjax('view-appointments', [
                    'model' => $this->findModel2($id),
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
            ];
        } else {
            return $this->render('view-appointments', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    public function actionViewMidwife($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' =>  "Details",
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModelMidwife($id),
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionGetNotifications()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;
        $appointments = Appointments::find()
            ->where(['patient_id' => $userId, 'status' => 'Pending'])
            ->orderBy(['appointment_date' => SORT_ASC])
            ->limit(10)
            ->all();

        $notifications = [];
        foreach ($appointments as $appointment) {
            $notifications[] = [
                'message' => "You have an appointment on " . Yii::$app->formatter->asDatetime($appointment->appointment_date, 'php:M d, Y h:i A'),
                'url' => \yii\helpers\Url::to(['appointments']),
                'time' => Yii::$app->formatter->asRelativeTime($appointment->appointment_date),
                'type' => 'appointment', // Add notification type for styling later
            ];
        }

        return [
            'count' => count($appointments),
            'notifications' => $notifications,
        ];
    }

    public function actionCreate($id)
    {
        $request = Yii::$app->request;
        $model = new Appointments();

        if ($request->isAjax) {

            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Book Appointment",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'doctor' => $this->findModel($id),
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post())) {
                $doctor = Doctor::findOne($id);
                date_default_timezone_set('Asia/Manila');

                do {
                    $refNo = sprintf('%06d', mt_rand(0, 999999));
                } while (Appointments::find()->where(['reference_no' => $refNo])->exists());



                $model->reference_no = Yii::$app->user->id . $refNo . $doctor->user_id;
                $model->patient_id = Yii::$app->user->id;
                $model->specialist_id = $doctor->user_id;
                $model->created_at = date('Y-m-d H:i:s');
                $model->status = 'Pending';
                $model->save();
                // return $this->redirect(['appointments']);
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Appointment",
                    'content' => '<span class="text-success">' . Yii::t('yii2-ajaxcrud', 'Create') . ' Appointments ' . Yii::t('yii2-ajaxcrud', 'Success') . '</span>',
                    'footer' =>  Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Appointment",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,

                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            if ($model->load($request->post())) {
                $doctor = Doctor::findOne($id);
                date_default_timezone_set('Asia/Manila');

                $model->patient_id = Yii::$app->user->id;
                $model->specialist_id = $doctor->user_id;
                $model->created_at = date('Y-m-d H:i:s');
                $model->status = 'Pending';
                $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,

                ]);
            }
        }
    }

    public function actionCreatemidwife($id)
    {
        $request = Yii::$app->request;
        $model = new Appointments();

        if ($request->isAjax) {

            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Book Appointment",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'doctor' => $this->findModelMidwife($id),
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post())) {
                $doctor = Midwife::findOne($id);
                date_default_timezone_set('Asia/Manila');

                do {
                    // Generate a random 6-digit number as reference number
                    $refNo = sprintf('%06d', mt_rand(0, 999999));
                } while (Appointments::find()->where(['reference_no' => $refNo])->exists());



                $model->reference_no = Yii::$app->user->id . $refNo . $doctor->user_id;
                $model->patient_id = Yii::$app->user->id;
                $model->specialist_id = $doctor->user_id;
                $model->created_at = date('Y-m-d H:i:s');
                $model->status = 'Pending';
                $model->save();

                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Appointment",
                    'content' => '<span class="text-success">' . Yii::t('yii2-ajaxcrud', 'Create') . ' Appointments ' . Yii::t('yii2-ajaxcrud', 'Success') . '</span>',
                    'footer' =>  Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " Appointment",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,

                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            if ($model->load($request->post())) {
                $doctor = Doctor::findOne($id);
                date_default_timezone_set('Asia/Manila');

                $model->patient_id = Yii::$app->user->id;
                $model->specialist_id = $doctor->user_id;
                $model->created_at = date('Y-m-d H:i:s');
                $model->status = 'Pending';
                $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,

                ]);
            }
        }
    }


    public function actionUpdateHistory($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelHistory($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title' => "Update Medical Record",
                    'content' => $this->renderAjax('update-history', ['model' => $model]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }

            if ($model->load($request->post()) && $model->validate()) {
                $file = UploadedFile::getInstance($model, 'attachments');

                if ($file) {
                    $uploadPath = Yii::getAlias('@webroot/uploads/'); // Use absolute path
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0775, true);
                    }

                    $fileName = uniqid() . '_' . $file->baseName . '.' . $file->extension;
                    $filePath = $uploadPath . $fileName;

                    if ($file->saveAs($filePath)) {
                        $model->attachments = 'uploads/' . $fileName; // Store relative path
                    } else {
                        Yii::$app->session->setFlash('error', 'File upload failed.');
                        return $this->generateModalResponse("Complete Appointment", 'complete', $model);
                    }
                }

                if ($model->save(false)) {
                    return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
                }
            }

            return $this->generateModalResponse(Yii::t('yii2-ajaxcrud', 'Update') . " MedicalHistory #$id", 'update', $model);
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * Generates modal response for AJAX requests
     */
    private function generateModalResponse($title, $view, $model)
    {
        return [
            'title' => $title,
            'content' => $this->renderAjax($view, ['model' => $model]),
            'footer' =>
            Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                'class' => 'btn btn-default pull-left',
                'data-dismiss' => 'modal'
            ]) .
                Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), [
                    'class' => 'btn btn-primary',
                    'type' => 'submit'
                ])
        ];
    }


    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel2($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Appointment",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post())) {

                date_default_timezone_set('Asia/Manila');
                $model->updated_at = date('Y-m-d H:i:s');
                $model->save();

                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Appointment",
                    'content' => '<span class="text-success">Successfully updated!</span>',
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " Appointment",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Submit'), ['class' => 'btn btn-primary', 'type' => 'submit'])
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

    public function actionHistory()
    {
        $searchModel = new MedicalHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRevokeConsent($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelHistory($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested record does not exist.');
        }

        $model->has_consent = 0;
        $model->updated_at = date('Y-m-d H:i:s');

        if ($model->save(false)) {
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Unable to revoke consent');
            return $this->redirect(['index']);
        }
    }

    public function actionGiveConsent($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelHistory($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested record does not exist.');
        }

        $model->has_consent = 1;
        $model->updated_at = date('Y-m-d H:i:s');

        if ($model->save(false)) {
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            return $this->redirect(['patient/history']);
        } else {
            Yii::$app->session->setFlash('error', 'Unable to revoke consent');
            return $this->redirect(['patient/history']);
        }
    }




    /**
     * Finds the Appointments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appointments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Doctor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelMidwife($id)
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

    protected function findModelHistory($id)
    {
        if (($model = MedicalHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
