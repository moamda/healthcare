<?php

use yii\helpers\Html;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" id="notifDropdown" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span id="notif-count" class="badge badge-warning navbar-badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header"><span id="notif-total">0</span> Notifications</span>
                <div class="dropdown-divider"></div>
                <div id="notif-list">
                    <a href="#" class="dropdown-item text-center">No new notifications</a>
                </div>
                <div class="dropdown-divider"></div>
                <a href="<?= \yii\helpers\Url::to(['appointments']) ?>" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<?php
$fetchUrl = Yii::$app->user->can('access patient module') ||
    Yii::$app->user->can('access doctor module') ||
    Yii::$app->user->can('access midwife module')
    ? \yii\helpers\Url::to(['get-notifications'])
    : '#';

$script = <<<JS
function fetchNotificationCount() {
    $.ajax({
        url: '$fetchUrl',
        type: 'GET',
        success: function(response) {
            $('#notif-count').text(response.count);
            $('#notif-total').text(response.count);

            let notifList = '';

            if (response.count > 0) {
                response.notifications.forEach(function (notif) {
                    notifList += '<a href="' + notif.url + '" class="dropdown-item">' +
                                    '<div class="d-flex flex-column">' +
                                    '<span class="text-wrap">' + notif.message + '</span>' +
                                    '<small class="text-muted text-sm">' + notif.time + '</small>' +
                                    '</div>' +
                                    '</a>' +
                                    '<div class="dropdown-divider"></div>';
                });
            } else {
                notifList = '<a href="#" class="dropdown-item text-center">No new notifications</a>';
            }

            $('#notif-list').html(notifList);
        },
        error: function() {
            $('#notif-count').text('0');
            $('#notif-total').text('0');
            $('#notif-list').html('<a href="#" class="dropdown-item text-center">Failed to load notifications</a>');
        }
    });
}

// Fetch notifications every 5 seconds
setInterval(fetchNotificationCount, 5000);
fetchNotificationCount();
JS;
$this->registerJs($script);
?>