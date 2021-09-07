<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\entity\Report */

$this->title = 'Detail Laporan';
$this->params['breadcrumbs'][] = ['label' => 'Report', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-view">

    <div class="detail-view-container">
        <?= DetailView::widget([
            'options' => ['class' => 'table detail-view'],
            'model' => $model,
            'attributes' => [
                // 'id',
                'user.name:text:Nama Pelapor',
                'news_url:url',
                'category.category_name:text:Kategori',
                [
                    'attribute' => 'statusHtml',
                    'label' => 'Status',
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
                'description',
                [
                    'attribute' => 'screenshotImg',
                    'label' => 'Screenshot',
                    'format' => 'raw',
                ],
                // 'created_at:datetime',
                // 'updated_at:datetime',
                // 'createdBy.username:text:Created By',
                // 'updatedBy.username:text:Updated By',
            ],
        ]) ?>
    </div>
    
</div>
