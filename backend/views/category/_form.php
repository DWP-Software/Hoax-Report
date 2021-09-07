<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form panel">
    <div class="panel-body">

        <div class="row">
            <div class="col-md-12 col-sm-12">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>


                <div class="form-panel">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                        <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Simpan', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>