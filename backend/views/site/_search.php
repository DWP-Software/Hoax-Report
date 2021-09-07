<?php

use common\models\entity\Category;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\search\ReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Category::find()->where(['type'=>2])->all(), 'id', 'category_name'),
                'options' => ['placeholder' => 'Kategori'],
                'pluginOptions' => ['allowClear' => true],
            ])->label(false); ?>
        </div>
        <div class="col-md-4">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>