<?php

use yii\helpers\Html;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= $totalUsers ?></h3>
            <p>Total Users</p>
          </div>
          <div class="icon"><i class="ion ion-bag"></i></div>
        </div>
      </div>
      <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= $activeCount ?></h3>
            <p>Active Users</p>
          </div>
          <div class="icon"><i class="ion ion-stats-bars"></i></div>
        </div>
      </div>
      <div class="col-lg-4 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= $inactiveCount ?></h3>
            <p>Inactive Users</p>
          </div>
          <div class="icon"><i class="ion ion-pie-graph"></i></div>
        </div>
      </div>
    </div>

    <!-- Transaction Logs Section -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-primary">
            <h3 class="card-title">Recent Transaction Logs</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Action</th>
                  <th>Details</th>
                  <th>IP Address</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($logs as $log): ?>
                <tr>
                  <td><?= Html::encode($log->id) ?></td>
                  <td><?= Html::encode($log->user->username ?? 'Unknown') ?></td>
                  <td><?= Html::encode($log->action) ?></td>
                  <td><?= Html::encode($log->details) ?></td>
                  <td><?= Html::encode($log->ip_address) ?></td>
                  <td><?= date('Y-m-d H:i:s', strtotime($log->created_at)) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
