<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="index3.html" class="brand-link">
        <img src="<= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">HEALTHCARE</span>
    </a> -->
    <a class="brand-link d-flex align-items-center">
        <span class="brand-logo position-relative d-inline-block" style="width: 42px; height: 42px;">
            <!-- Sky Blue Glowing Heart -->
            <i class="fas fa-heart heartbeat-icon"></i>

            <!-- Animated Medical Cross -->
            <i class="fas fa-plus medical-cross"></i>
        </span>

        <span class="brand-text font-weight-bold text-uppercase ml-2"
            style="letter-spacing: 0.5px;">
            BARANGAY IBABA
        </span>
    </a>

    <style>
        /* Sky Blue Heart with Glow & Pulse */
        .heartbeat-icon {
            font-size: 42px;
            color: #007bff;
            /* Solid blue color */
            filter: drop-shadow(0 0 8px rgba(0, 123, 255, 0.8));
            /* Strong blue glow */
            animation: heartbeat 1.5s infinite ease-in-out;
            will-change: transform;
        }



        /* Medical Cross: Glowing + Soft Rotation */
        .medical-cross {
            font-size: 16px;
            color: hsl(211, 100.00%, 50.00%);
            background: white;
            border-radius: 50%;
            padding: 2px;
            position: absolute;
            bottom: 2px;
            right: 2px;
            filter: drop-shadow(0 0 4px rgba(0, 123, 255, 0.8));
            animation: cross-glow 1.5s infinite, rotate-cross 3s infinite ease-in-out;
            will-change: filter, transform;
        }

        /* Heartbeat Animation */
        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.1);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: scale(1.05);
            }
        }

        /* Cross Glow Animation */
        @keyframes cross-glow {

            0%,
            100% {
                filter: drop-shadow(0 0 4px rgba(0, 123, 255, 0.8));
            }

            50% {
                filter: drop-shadow(0 0 8px rgba(0, 123, 255, 1));
            }
        }

        /* Cross Soft Rotation */
        @keyframes rotate-cross {

            0%,
            100% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(10deg);
            }
        }

        .step {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .step:hover {
            transform: scale(1.05);
        }

        .step-icon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .step h5 {
            font-weight: bold;
            color: #333;
        }

        .step img {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>




    <!-- Sidebar -->
    <div class="sidebar" style="display: flex; flex-direction: column; height: 92vh;">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-circle fa-2x text-white"></i>
            </div>

            <div class="info">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <a href="#" class="d-block">
                        <?= Yii::$app->user->identity->username ?>
                        (<?php
                            if (Yii::$app->user->can('access admin module')) {
                                echo 'Admin';
                            } elseif (Yii::$app->user->can('access midwife module')) {
                                echo 'Midwife';
                            } elseif (Yii::$app->user->can('access doctor module')) {
                                echo 'Doctor';
                            } elseif (Yii::$app->user->can('access patient module')) {
                                echo 'Patient';
                            } else {
                                echo 'User';
                            }
                            ?>)
                    </a>
                <?php else: ?>
                    <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>" class="d-block"> <i class="fas fa-sign-in-alt"></i> Login</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'options' => [
                    'class' => 'nav nav-pills nav-sidebar flex-column nav-child-indent',
                    'data-widget' => 'treeview',
                    'role' => 'menu',
                    'data-accordion' => 'false'
                ],


                'items' => [
                    ['label' => 'DASHBOARD', 'url' => ['/patient/patient/dashboard'], 'icon' => 'tachometer-alt', 'visible' => Yii::$app->user->can('access patient module')],
                    ['label' => 'DASHBOARD', 'url' => ['/admin/dashboard/v1'], 'icon' => 'tachometer-alt', 'visible' => Yii::$app->user->can('access admin module')],


                    ['label' => '', 'header' => true],
                    ['label' => 'MODULES', 'header' => true, 'visible' => !Yii::$app->user->isGuest],
                    [
                        'label' => 'Admin',
                        'items' => [
                            ['label' => 'User Management', 'url' => ['/admin/user/index'], 'iconStyle' => 'far'],
                            [
                                'label' => 'RBAC',
                                'iconStyle' => 'far',
                                'items' => [
                                    // ['label' => 'Users', 'url' => ['/rbac/user/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Assignments', 'url' => ['/rbac/assignment/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Roles', 'url' => ['/rbac/role/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Permissions', 'url' => ['/rbac/permission/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    // ['label' => 'Routes', 'url' => ['/rbac/route/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    // ['label' => 'Rules', 'url' => ['/rbac/rule/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    // ['label' => 'Menus', 'url' => ['/rbac/menu/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                ],
                            ],
                        ],
                        'visible' => Yii::$app->user->can('access admin module')
                    ],
                    ['label' => 'Patient', 'url' => ['/admin/patient/index'], 'visible' => Yii::$app->user->can('access admin module')],
                    ['label' => 'Doctor', 'url' => ['/admin/doctor/index'], 'visible' => Yii::$app->user->can('access admin module')],
                    ['label' => 'Midwife', 'url' => ['/admin/midwife/index'], 'visible' => Yii::$app->user->can('access admin module')],
                    ['label' => 'Appointments', 'url' => ['/doctor/doctor/appointments'], 'visible' => Yii::$app->user->can('access doctor module')],
                    ['label' => 'Appointments', 'url' => ['/midwife/midwife/appointments'], 'visible' => Yii::$app->user->can('access midwife module')],
                    ['label' => 'Find Doctor', 'url' => ['/patient/patient/book-doctor'], 'visible' => Yii::$app->user->can('access patient module')],
                    ['label' => 'Find Midwife', 'url' => ['/patient/patient/book-midwife'], 'visible' => Yii::$app->user->can('access patient module')],
                    ['label' => 'Appointments', 'url' => ['/patient/patient/appointments'], 'visible' => Yii::$app->user->can('access patient module')],
                    ['label' => 'Medical History', 'url' => ['/patient/patient/history'], 'visible' => Yii::$app->user->can('access patient module')],
                    ['label' => 'Medical History', 'url' => ['/doctor/doctor/history'], 'visible' => Yii::$app->user->can('access doctor module')],
                    ['label' => 'Medical History', 'url' => ['/midwife/midwife/history'], 'visible' => Yii::$app->user->can('access midwife module')],
                ],
            ]);
            ?>
        </nav>

        <div style="flex-grow: 1;"></div>

        <!-- Guide at the bottom -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'options' => [
                    'class' => 'nav nav-pills nav-sidebar flex-column nav-child-indent',
                    'data-widget' => 'treeview',
                    'role' => 'menu',
                    'data-accordion' => 'false'
                ],
                'items' => [
                    [
                        'label' => 'Guide',
                        'url' => '#',
                        'icon' => 'fa fa-question-circle',
                        'visible' => Yii::$app->user->can('access patient module'),
                        'options' => [
                            'data-toggle' => 'modal',
                            'data-target' => '#guideModal',
                        ],
                    ],
                ],
            ]);
            ?>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>

<div class="modal fade" id="guideModal" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guideModalLabel">Guide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="guideModalContent">
                    <div class="step">
                        <div class="step-icon">🔍</div>
                        <h5>Hakbang 1</h5>
                        <p>Pumunta sa "Find Doctor" o "Find Midwife" upang maghanap ng available na tagapagbigay ng serbisyo.</p>
                        <img src="<?= Yii::$app->request->baseUrl ?>/uploads/step1.jpg" alt="Step 1 Image">
                    </div>

                    <div class="step">
                        <div class="step-icon">📅</div>
                        <h5>Hakbang 2</h5>
                        <p>Piliin ang iyong nais na doktor o midwife at pumili ng available na petsa at oras at ilagay ang dahilan.</p>
                        <img src="<?= Yii::$app->request->baseUrl ?>/uploads/step2.jpg" alt="Step 2 Image">
                    </div>

                    <div class="step">
                        <div class="step-icon">✅</div>
                        <h5>Hakbang 3</h5>
                        <p>Kumpirmahin ang detalye ng iyong appointment at isumite.</p>
                        <img src="<?= Yii::$app->request->baseUrl ?>/uploads/step3.jpg" alt="Step 3 Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>