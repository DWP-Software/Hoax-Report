<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\entity\Exam;
use common\models\entity\MediaType;
use common\models\entity\Participant;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */

$institution = Yii::$app->user->identity->examInstitution;
$this->title = $institution->name;
// Yii::$app->params['showTitle'] = false;
?>

<div class="detail-view-container">
    <?= DetailView::widget([
        'options' => ['class' => 'table detail-view'],
        'model' => $institution,
        'attributes' => [
            // 'id',
            'name',
            'code',
            'levelPrefix',
            'director_name',
            'certificate_number',
            'decree_number',
            'decreed_at',
            'phone',
            'address:ntext',
            'email:email',
            'province.name:text:Provinsi',
            'district.name:text:Kota/Kabupaten',
            'isVerifiedHtml:raw',
            [
                'attribute' => 'file_statement',
                'format' => 'raw',
                'value' => $institution->file_statement ? Html::a('Lihat', ['download', 'field' => 'file_statement'], ['class' => 'btn btn-xs btn-info', 'data-pjax' => 0]) : null,
            ],
            [
                'attribute' => 'file_signature',
                'format' => 'raw',
                'value' => $institution->file_signature ? Html::a('Lihat', ['download', 'field' => 'file_signature'], ['class' => 'btn btn-xs btn-info', 'data-pjax' => 0]) : null,
            ],
            [
                'attribute' => 'file_logo',
                'format' => 'raw',
                'value' => $institution->file_logo ? Html::a('Lihat', ['download', 'field' => 'file_logo'], ['class' => 'btn btn-xs btn-info', 'data-pjax' => 0]) : null,
            ],
            // 'created_at:datetime',
            // 'updated_at:datetime',
            // 'createdBy.username:text:Created By',
            // 'updatedBy.username:text:Updated By',
        ],
    ]) ?>
</div>

<div class="row">
    
    <div class="col-md-6">
        <div class="panel panel-primary panel-body">
            <h4 style="margin:0" class="text-primary"><i class="fa fa-check-square-o"></i> UKW yang telah selesai</h4>
            <span class="pull-right" style="font-size:25pt"><?= Exam::find()->where([
                'exam_institution_id' => $institution->id,
                'stage' => Exam::STAGE_DONE,
            ])->count() ?></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary panel-body">
            <h4 style="margin:0" class="text-primary"><i class="fa fa-caret-square-o-right"></i> UKW yang sedang berjalan</h4>
            <span class="pull-right" style="font-size:25pt">
                <?= Exam::find()
                ->where(['exam_institution_id' => $institution->id])
                ->andWhere(['<=', 'stage', Exam::STAGE_APPROVED])
                ->count() ?>
            </span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 style="margin:0">Laporan Hasil Kompetensi UKW</h4>
            </div>
            <div class="panel-body">
                <table class="table" style="margin-bottom:0">
                <?php 
                    $data = [];
                    $results = Participant::results();
                    foreach ($results as $key => $value) {
                        $row = Yii::$app->db->createCommand("
                            select count(participant.id) as count
                            from participant, exam
                            where exam.id = exam_id
                            and participant.result = '".$key."'
                            and exam_institution_id = '".$institution->id."'
                            group by result
                        ")->queryOne();
                        echo '<tr><td>'.$value.'</td><td class="text-right">'.$row['count'].'</td></tr>';
                    }
                ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 style="margin:0">Laporan Berdasarkan Jenjang</h4>
            </div>
            <div class="panel-body">
                <table class="table" style="margin-bottom:0">
                <?php 
                    $levels = Participant::levels();
                    array_shift($levels);
                    foreach ($levels as $key => $value) {
                        $row = Yii::$app->db->createCommand("
                            select count(participant.id) as count
                            from participant, exam
                            where exam.id = exam_id
                            and exam_institution_id = '".$institution->id."'
                            and participant.level_submitted = '".$value."'
                            group by level_submitted
                        ")->queryOne();
                        echo '<tr><td>'.$value.'</td><td class="text-right">'.$row['count'].'</td></tr>';
                    }
                ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 style="margin:0">UKW Berdasarkan Jenis Media</h4>
            </div>
            <div class="panel-body">
                <table class="table" style="margin-bottom:0">
                <?php 
                    $data = [];
                    $mediaTypes = MediaType::find()->all();
                    foreach ($mediaTypes as $mediaType) {
                        $count = Participant::find()->joinWith(['media', 'exam'])->where(['participant.media_type_id' => $mediaType->id, 'exam_institution_id' => $institution->id])->count();
                        echo '<tr><td>'.$mediaType->name.'</td><td class="text-right">'.$count.'</td></tr>';
                    }
                ?>
                </table>
            </div>
        </div>
    </div>

</div>