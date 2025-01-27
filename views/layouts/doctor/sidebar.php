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
                    ['label' => 'Patient', 'url' => ['/admin/patient/index']],
                    ['label' => 'Doctor', 'url' => ['/admin/doctor/index']],
                    // [
                    //     'label' => 'Development',
                    //     'items' => [
                    //         ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    //         ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                    //     ],
                    //     'visible' => Yii::$app->user->can('access admin module')
                    // ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>