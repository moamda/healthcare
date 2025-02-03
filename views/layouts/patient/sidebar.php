<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">HEALTHCARE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar ">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?></a>
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
                    ['label' => 'DASHBOARD', 'url' => ['/dashboard'], 'icon' => 'tachometer-alt'],
                    ['label' => '', 'header' => true],
                    ['label' => 'PATIENT', 'header' => true, 'visible' => !Yii::$app->user->isGuest],
                    ['label' => 'Find Doctor', 'url' => ['/patient/patient/book'], 'visible' => Yii::$app->user->can('access patient module')],
                    ['label' => 'Appointments', 'url' => ['/patient/patient/appointments'], 'visible' => Yii::$app->user->can('access patient module')],
                    ['label' => 'Medical History', 'url' => ['/patient/patient/history'], 'visible' => Yii::$app->user->can('access patient module')],

                ],
            ]);
            ?>
        </nav>
    </div>
</aside>