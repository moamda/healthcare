<?php

namespace app\modules\midwife\controllers;

use Yii;
use app\modules\admin\models\Doctor;
use app\modules\patient\models\Appointments;
use app\modules\patient\models\AppointmentsSearch;
use app\modules\admin\models\DoctorSearch;
use app\modules\admin\models\Midwife;
use app\modules\admin\models\SignupForm;
use app\modules\admin\models\TnxLogs;
use app\modules\patient\models\MedicalHistory;
use app\modules\patient\models\MedicalHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\httpclient\Client;
use yii\web\UploadedFile;

class MidwifeController extends Controller
{

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

    public function actionBook()
    {
        $searchModel = new DoctorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('book', [
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
        $model->notes = 'Cancelled by midwife.';

        if ($model->save(false)) {
            $this->logUserAction(Yii::$app->user->id, 'Cancel', 'Appointment Cancelled with ref# ' . $model->reference_no);
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
                            $this->logUserAction(Yii::$app->user->id, 'Complete', 'Appointment Completed with ref# ' . $model->reference_no);


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

    public function actionApprove($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel2($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested record does not exist.');
        }

        $model->status = 'Approved';
        $model->notes = 'Approved by midwife.';

        if ($model->save(false)) {
            $this->logUserAction(Yii::$app->user->id, 'Approve', 'Appointment Approved with ref# ' . $model->reference_no);
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


    public function actionHistory()
    {
        $searchModel = new MedicalHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

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
                date_default_timezone_set('Asia/Manila');

                $model->patient_id = Yii::$app->user->id;
                $model->doctor_id = $id;
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
                date_default_timezone_set('Asia/Manila');

                $model->patient_id = Yii::$app->user->id;
                $model->doctor_id = $id;
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
                $model->save();
                $this->logUserAction(Yii::$app->user->id, 'Update', 'Appointment Updated with ref# ' . $model->reference_no);

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



    public function actionGetNotifications()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;
        $appointments = Appointments::find()
            ->where(['specialist_id' => $userId, 'status' => 'Pending'])
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

    private function readRecord($id)
    {
        $client = new Client();

        $method = 'GET';
        $url = 'http://localhost:3000/query';
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImV4YW1wbGVVc2VyIiwiZXhwIjoxNzQzNDM2Nzk5fQ.amElU6uvChHujlfY4vrHPDWCaw_QbmCV8KyIwuzi0MA';
        $queryParams = Yii::$app->params['fabric']['queryParams1'];
        $queryParams['args'] = $id;

        try {
            $response = $client->createRequest()
                ->setMethod($method)
                ->setUrl($url)
                ->setData($queryParams)
                ->setHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])
                ->send();

            if ($response->isOk) {
                $responseContent = $response->getContent();
                $jsonContent = preg_replace('/^Response: /', '', $responseContent);
                $data = json_decode($jsonContent, true);

                if (empty($data)) {
                    return null;
                }

                return $data;
            } else {
                // Yii::error('Unauthorized or Invalid Token. Status: ' . $response->statusCode, __METHOD__);
                return null;
            }
        } catch (\Exception $e) {
            // echo 'HTTP Client Exception while communicating with BCP1 API';
            throw $e;
        }
    }

    private function saveRecord($model)
    {
        $client = new Client();
        $method = 'POST';
        $baseUrl = 'http://localhost:3000/invoke';
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImV4YW1wbGVVc2VyIiwiZXhwIjoxNzQzNDM2Nzk5fQ.amElU6uvChHujlfY4vrHPDWCaw_QbmCV8KyIwuzi0MA';

        $params = [
            strval($model->reference_no),
            intval($model->patient_id),
            intval($model->specialist_id),
            strval($model->visit_date),
            strval($model->diagnosis),
            strval($model->treatment),
            strval($model->remarks),
            strval($model->attachments)
        ];

        $argsQueryString = '&args=' . implode('&args=', array_map('urlencode', $params));

        $url = $baseUrl . '?' . http_build_query([
            'channelid' => 'mychannel',
            'chaincodeid' => 'basic',
            'function' => 'CreateAsset',
        ]) . $argsQueryString;

        $response = $client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setHeaders([
                'content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])
            ->send();

        if ($response->isOk) {
            echo $response->getContent();
        } else {
            echo 'HTTP Client Exception while communicating with FABRIC API';
        }
    }

    private function logUserAction($userId, $action, $details)
    {
        $log = new TnxLogs();
        $log->user_id = $userId;
        $log->action = $action;
        $log->details = $details;
        $log->ip_address = Yii::$app->request->userIP;
        $log->user_agent = Yii::$app->request->userAgent;
        $log->created_at = date('Y-m-d H:i:s');
        $log->save(false);
    }
}
