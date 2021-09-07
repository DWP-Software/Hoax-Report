<?php

namespace api\controllers\v1;

use common\models\entity\Keluhan;
use common\models\entity\News;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Url;

// use yii\httpclient\Client;

class NewsController extends \yii\rest\Controller
{
    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'last-news' => ['GET']
        ];
    }

    public function actionIndex()
    {
        $model = News::find()->where(['status' => News::STATUS_PUBLISH]);
        $totalItems = $model->count();
        $data = [];
        foreach ($model->all() as $key) {
            $arr = [[
                'id' => $key->id,
                'title' => $key->title,
                'author' => $key->author->name,
                'content' => $key->content,
                'publish_at' => $key->publish_at,
                'category' => $key->category->category_name,
                'url_photo' => Url::to(['/file/file-news', 'id' => $key->id]),
                'views' => $key->views
            ]];
            $data = array_merge($data, $arr);
        }

        return array('status' => 1, 'data' => $data, 'total_item' => $totalItems);
    }

    public function actionLastNews()
    {
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 5, //set page size here
            ]
        ]);
        $relationShips = $dataProvider->getModels();
        $data = [];
        foreach ($relationShips as $key) {
            $arr = [[
                'id' => $key->id,
                'title' => $key->title,
                'author' => $key->author->name,
                'content' => $key->content,
                'publish_at' => $key->publish_at,
                'category' => $key->category->category_name,
                'url_photo' => Url::to(['/file/file-news', 'id' => $key->id]),
                'views' => $key->views
            ]];
            $data = array_merge($data, $arr);
        }

        return array('status' => 1, 'data' => $data);
    }
}
