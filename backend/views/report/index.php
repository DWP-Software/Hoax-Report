<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;
use common\models\entity\User;
use common\models\entity\Category;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-index">

    <?php
    $exportColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        'id',
        'user.name:text:User',
        'news_url:url',
        'category.category_name:text:Category',
        'status',
        'created_at:datetime',
        'updated_at:datetime',
        'createdBy.username:text:Created By',
        'updatedBy.username:text:Updated By',
    ];

    $exportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $exportColumns,
        'filename' => 'Report',
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
        [
            'attribute' => 'user_id',
            'value' => 'user.name',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(User::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            'filterInputOptions' => ['placeholder' => ''],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'label' => 'Email Pelapor',
            'value' => 'user.email',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(User::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            'filterInputOptions' => ['placeholder' => ''],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        'news_url:url',
        [
            'attribute' => 'category_id',
            'value' => 'category.category_name',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(Category::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'),
            'filterInputOptions' => ['placeholder' => ''],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'statusHtml',
            'label' => 'Status',
            'format' => 'raw',
        ],
        [
            'attribute' => 'screenshot',
            'label' => 'Screenshot',
            'format' => 'raw',
        ],
        [
            'attribute' => 'created_at',
            'label' => 'Tanggal',
            'value' => function ($model) {
                return date('Y-m-d', $model->created_at);
            },
            'format' => 'text',
        ],
        [
            'contentOptions' => ['class' => 'action-column nowrap text-left'],
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttons' => [
                'view' => function ($url) {
                    return Html::a('', $url, ['class' => 'glyphicon glyphicon-eye-open btn btn-xs btn-default btn-text-info']);
                },
                'update' => function ($url) {
                    return Html::button('', [
                        'class' => 'glyphicon glyphicon-pencil btn btn-xs btn-default btn-text-warning showModalButton',
                        'value' => $url,
                        'title' => 'Ubah Status'
                    ]);
                }
            ],
        ],
        // 'updated_at:integer',
        // 'created_by:integer',
        // 'updated_by:integer',
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
            // Html::a('<i class="fa fa-plus"></i> ' . 'Create', ['create'], ['class' => 'btn btn-success']),
            // Html::a('<i class="fa fa-repeat"></i> ' . 'Reload', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default']),
            // '{toggleData}',
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
        // 'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-header">
                    <h5 class="text-bold text-center">Jumlah Berita yang Dilaporkan berdasarkan Kategori</h5>
                </div>
                <div class="panel panel-body">
                    <?= $this->render(
                        '_service_chart',
                        [
                            'categories' => $categories
                        ]
                    )
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel">
                <div class="panel-header">
                    <h5 class="text-bold text-center">Jumlah Berita yang Dilaporkan berdasarkan perbulan</h5>
                </div>
                <div class="panel panel-body">
                    <?= $this->render(
                        '_service_line',
                        [
                            'categories' => $categories
                        ]
                    )
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>