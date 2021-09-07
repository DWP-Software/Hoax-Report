<?php

namespace api\controllers\v1;

use common\models\entity\Category;
use common\models\entity\Keluhan;
use common\models\entity\News;
use Yii;
use yii\db\Query;
use yii\helpers\Url;

// use yii\httpclient\Client;

class CategoryController extends \yii\rest\Controller
{
    protected function verbs()
    {
        return [
            'index' => ['GET']
        ];
    }

    public function actionIndex()
    {
        $model = Category::find()->where(['type'=>2]);
        $totalItems = $model->count();
        $data = [];
        foreach ($model->all() as $key) {
            $arr = [[
                'id' => $key->id,
                'name' => $key->category_name
            ]];
            $data = array_merge($data, $arr);
        }

        return array('status' => 1, 'data' => $data, 'total_item' => $totalItems);
    }
}

