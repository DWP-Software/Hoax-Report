<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;
use common\models\entity\Category;
use common\models\entity\Author;
use common\models\entity\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Berita';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news-index">

    <?php
    $exportColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        'id',
        'title',
        'category.category_name:text:Category',
        'publish_at:datetime',
        'author.name:text:Author',
        'content',
        'photo',
        'views',
        'created_at:datetime',
        'updated_at:datetime',
        'createdBy.username:text:Created By',
        'updatedBy.username:text:Updated By',
    ];

    $exportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $exportColumns,
        'filename' => 'News',
        'fontAwesome' => true,
        'dropdownOptions' => [
            'label' => 'Export',
            'class' => 'btn btn-default'
        ],
        'target' => ExportMenu::TARGET_SELF,
        'exportConfig' => [
            ExportMenu::FORMAT_CSV => false,
            ExportMenu::FORMAT_EXCEL => false,
            ExportMenu::FORMAT_HTML => false,
        ],
        'styleOptions' => [
            ExportMenu::FORMAT_EXCEL_X => [
                'font' => [
                    'color' => ['argb' => '00000000'],
                ],
                'fill' => [
                    // 'type' => PHPExcel_Style_Fill::FILL_NONE,
                    'color' => ['argb' => 'DDDDDDDD'],
                ],
            ],
        ],
        'pjaxContainerId' => 'grid',
    ]);

    $gridColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['class' => 'text-right serial-column'],
            'contentOptions' => ['class' => 'text-right serial-column'],
        ],
        // 'id',
        'title',
        [
            'attribute' => 'category_id',
            'value' => 'category.category_name',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(Category::find()->where(['type'=>1])->orderBy('category_name')->asArray()->all(), 'id', 'category_name'),
            'filterInputOptions' => ['placeholder' => ''],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'publish_at',
            'value' => function ($model) {
                return $model->publish_at ? date('Y-m-d H:i:s', $model->publish_at) : '';
            },
            'format' => 'text'
        ],
        [
            'attribute' => 'author_id',
            'value' => 'author.name',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(User::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            'filterInputOptions' => ['placeholder' => ''],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'photo',
            'value' => function ($model) {
                return Html::a($model->photo, ['report/file-news','id'=>$model->id], ['target'=>'_blank']);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'views',
            'format' => 'integer',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => ['class' => 'text-right'],
        ],
        'statusHtml:raw:Status',

        [
            'contentOptions' => ['class' => 'action-column nowrap text-left'],
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url) {
                    return Html::a('', $url, ['class' => 'glyphicon glyphicon-eye-open btn btn-xs btn-default btn-text-info']);
                },
                'update' => function ($url) {
                    return Html::a('', $url, ['class' => 'glyphicon glyphicon-pencil btn btn-xs btn-default btn-text-warning']);
                },
                'delete' => function ($url) {
                    return Html::a('', $url, [
                        'class' => 'glyphicon glyphicon-trash btn btn-xs btn-default btn-text-danger',
                        'data-method' => 'post',
                        'data-confirm' => 'Are you sure you want to delete this item?'
                    ]);
                },
            ],
        ]
    ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'responsiveWrap' => false,
        'pjax' => false,
        'hover' => true,
        'striped' => false,
        'bordered' => false,
        'toolbar' => [
            Html::a('<i class="fa fa-plus"></i> ' . 'Create', ['create'], ['class' => 'btn btn-success']),
            Html::a('<i class="fa fa-repeat"></i> ' . 'Reload', ['index'], ['data-pjax' => 0, 'class' => 'btn btn-default']),
            '{toggleData}',
            // $exportMenu,
        ],
        'panel' => [
            'type' => 'no-border transparent',
            'heading' => false,
            'before' => '{summary}',
            'after' => false,
        ],
        'panelBeforeTemplate' => '
            <div class="row">
                <div class="col-sm-8">
                    <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
                        {toolbar}
                    </div> 
                </div>
                <div class="col-sm-4">
                    <div class="pull-right">
                        {before}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        ',
        'pjaxSettings' => ['options' => ['id' => 'grid']],
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>

</div>