<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use common\models\entity\User;
use common\models\entity\Category;
use common\models\entity\Report;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <div class="row">
        <div class="col-md-12 col-sm-12">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => Report::statuses(),
                'options' => ['placeholder' => ''],
                'pluginOptions' => ['allowClear' => true],
            ]); ?>


            <div class="form-panel">
                <div class="row">
                    <div class="col-sm-12">
                        <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> ' . ($model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>