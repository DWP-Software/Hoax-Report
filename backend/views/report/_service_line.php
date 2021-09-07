<?php

use common\models\entity\Expense;
use common\models\entity\Payment;
use common\models\entity\Report;
use common\models\entity\Service;
use common\models\entity\Work;
use miloschuman\highcharts\Highcharts;

$report = [];
$year = date('Y');
for ($i = 1; $i <= 12; $i++) {
    if($i < 10){
        $month = '0'.$i;
    }else{
        $month = $i;
    }
    $count = [(int)Report::find()
        ->where(["date_format(FROM_UNIXTIME(created_at), '%Y-%m')" => $year.'-'.$month])
        ->count()];
    $report = array_merge($report, $count);
}

?>
<?= Highcharts::widget([
    'options' => [
        'credits' => ['enabled' => false],
        'chart'   => [
            'type'  => 'column',
            'style' => [
                'fontFamily' => 'Poppins, Arial, sans-serif',
                'width'      => '100%'
            ],
        ],
        'title'  => ['text' => ''],
        'xAxis' => [
            'categories' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            'crosshair' => true
        ],
        'yAxis' => [
            'min' => 0,
            'title' => [
                'text' => 'Jumlah'
            ]
        ],
        'tooltip' => [
            'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
            'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' .
                '<td style="padding:0"><b>Rp{point.y:.1f}</b></td></tr>',
            'footerFormat' => '</table>',
            'shared' =>  true,
            'useHTML' => true
        ],
        'plotOptions' => [
            'column' => [
                'pointPadding' => 0,
                'borderWidth' => 0
            ]
        ],
        'series' => [[
            'name' => 'Laporan',
            'data' => $report
        ]]
    ]
]);
