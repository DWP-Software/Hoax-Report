<?php

use common\models\entity\Report;
use common\models\entity\Service;
use common\models\entity\Work;
use miloschuman\highcharts\Highcharts;

$data = [];
foreach ($categories as $key) {
    $count = Report::find()->where(['category_id' => $key->category_id])->count();
    if ($count) {
        $data[] = [
            'name' => $key->category->category_name,
            'y' => intval($count),
        ];
    }
}
?>

<?= Highcharts::widget([
    'options' => [
        'credits' => ['enabled' => false],
        'chart'   => [
            'type'  => 'pie',
            'style' => [
                'fontFamily' => 'Poppins, Arial, sans-serif',
                'width'      => '100%',
            ],
        ],
        'title'  => false,
        'series' => [
            [
                'name'      => 'Jumlah',
                'colorByPoint' => true,
                // 'size'      => '50%',
                'innerSize' => '30%',
                'data'      => $data,
                'showInLegend' => false,
            ]
        ],
        'plotOptions' => [
            'pie' => [
                'allowPointSelect' => true,
                'cursor'           => 'pointer',
                'dataLabels'       => [
                    'enabled'  => true,
                    'format'   => '<b>{point.name}</b>: {point.y:.0f}',
                    'distance' => -50,
                ],
                'events' => [
                    'click' => function () {
                        return false; // <== returning false will cancel the default action
                    }
                ],
            ],
        ],
        'legend' => [
            'enabled' => false,
            'labelFormat' => '<b>{name}</b>: {y:.0f}',
            'events'      => [
                'click' => function () {
                    return false; // <== returning false will cancel the default action
                }
            ],
            'align'         => 'top',
            'layout'        => 'horizontal',
            'verticalAlign' => 'top',
        ]
    ]
]);
