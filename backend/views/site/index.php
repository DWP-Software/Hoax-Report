<?php

use common\models\entity\Log;
use common\models\entity\User;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
// $this->title = Yii::$app->name;
// Yii::$app->params['showTitle'] = false;
?>

<div class="row">
    
    <div class="col-md-6">
        <div class="panel panel-primary panel-body" style="color:#fff;background:#337ab7">
            <h4 style="margin:0" class="text-white">User</h4>
            <span class="pull-right" style="font-size:25pt"><?= User::find()->count() ?></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary panel-body" style="color:#fff;background:#337ab7">
            <h4 style="margin:0" class="text-white">Log</h4>
            <span class="pull-right" style="font-size:25pt"><?= Log::find()->count() ?></span>
        </div>
    </div>

</div>