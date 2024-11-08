<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar ">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> <?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'options' => [
                    'class' => 'nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact',
                    'data-widget' => 'treeview',
                    'role' => 'menu',
                    'data-accordion' => 'false'
                ],
                'items' => [
                    ['label' => 'DASHBOARD', 'url' => ['/scheduling/profile'], 'icon' => 'tachometer-alt'],

                    ['label' => '', 'header' => true],
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],

                    ['label' => '', 'header' => true],
                    ['label' => 'MODULES', 'header' => true],
                    [
                        'label' => 'User Management',
                        'items' => [
                            ['label' => 'Users', 'url' => ['/user/user/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    ['label' => '', 'header' => true],
                    ['label' => 'SECURITY', 'header' => true],
                    [
                        'label' => 'RBAC',
                        'items' => [
                            ['label' => 'Users', 'url' => ['/admin/user/index'], 'iconStyle' => 'far'],
                            ['label' => 'Assignments', 'url' => ['/admin/assignment/index'], 'iconStyle' => 'far'],
                            ['label' => 'Roles', 'url' => ['/admin/role/index'], 'iconStyle' => 'far'],
                            ['label' => 'Permissions', 'url' => ['/admin/permission/index'], 'iconStyle' => 'far'],
                            ['label' => 'Routes', 'url' => ['/admin/route/index'], 'iconStyle' => 'far'],
                            ['label' => 'Rules', 'url' => ['/admin/rule/index'], 'iconStyle' => 'far'],
                            ['label' => 'Menus', 'url' => ['/admin/menu/index'], 'iconStyle' => 'far'],
                        ]
                    ],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>