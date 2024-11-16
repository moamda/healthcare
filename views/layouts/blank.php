<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;

use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100" style="background-color: #d6d8db;">
    <?php $this->beginBody() ?>

    <main role="main">
        <div class="container">
            <?= $content ?>
        </div>

        <!-- <div class="container text-center">
            <p class="text-muted">© <?= date('Y') ?> DOST-ITDI. All rights reserved.</p>
        </div> -->
    </main>

    <!-- <footer class="main-footer">
        
    </footer> -->

    <?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage();
