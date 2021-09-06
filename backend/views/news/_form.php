<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use common\models\entity\Category;
use common\models\entity\User;
use dosamigos\tinymce\TinyMce;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\entity\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form panel">
    <div class="panel-body">

        <div class="row">
            <div class="col-md-12 col-sm-12">

                <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-2 text-left',
                        'offset' => 'col-sm-offset-4',
                        'wrapper' => 'col-sm-8',
                        'error' => '',
                        'hint' => '',
                    ],
                ],]); ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Category::find()->all(), 'id', 'category_name'),
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>

                <?= $form->field($model, 'photo')->fileInput() ?>


                <?= $form->field($model, 'content')->widget(TinyMce::className(), [
                    'options' => ['rows' => 15],
                    'language' => 'id',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]); ?>

                <?= $form->field($model, 'author_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(User::find()->where(['id' => Yii::$app->user->identity->id])->all(), 'id', 'name'),
                    'options' => ['placeholder' => '', 'value' => Yii::$app->user->identity->id],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>

                <?= $form->field($model, 'status')->widget(Select2::classname(), [
                    'data' => [0 => 'Draf', 1 => 'Publish'],
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>


                <div class="form-panel">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <?= Html::a('<i class="fa fa-arrow-left"></i> Kembali', 'index', ['class' => 'btn btn-default']) ?>
                            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Simpan', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>