<?php

namespace api\controllers\v1;

use common\models\entity\News;
use common\models\entity\Photo;
use common\models\entity\Report;
use Symfony\Component\Finder\Finder;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\UploadedFile;

// use yii\httpclient\Client;

class ReportController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['bearerAuth'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
        ];
        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'index' => ['POST']
        ];
    }

    public function actionIndex()
    {
        $params = $_REQUEST;

        $model = new Report();
        $model->user_id = Yii::$app->user->identity->id;
        $model->news_url = $params['news_url'];
        $model->category_id = $params['category_id'];
        $model->description = $params['description'];


        $uploadedFile = UploadedFile::getInstancesByName("photo");

        if (empty($uploadedFile)) {
            Yii::$app->response->statusCode = 403;
            return array(
                'status' => 0,
                'message' => '"Must upload at least 1 file in photo form-data POST"',
                'data' => []
            );
        }


        if ($model->save()) {
            // $uploads now contains 1 or more UploadedFile instances
            foreach ($uploadedFile as $file) {
                $photo = new Photo();
                $photo->photo = $file->name;
                $photo->report_id = $model->id;
                if ($photo->save()) {
                    foreach ($photo->uploadableFields() as $field) {
                        if ($file) {
                            uploadFile($photo, $field, $file);
                        }
                    }
                } else {
                    Yii::$app->response->statusCode = 403;
                    Report::findOne($model->id)->delete();
                }
            }
        } else {
            Yii::$app->response->statusCode = 403;
        }

        if (Yii::$app->response->statusCode == 200) {
            return array('status' => 1, 'message' => 'Berhasil disimpan', 'data' => $model->attributes);
        } else {
            Yii::$app->response->statusCode = 403;
            return array('status' => 0, 'message' => 'Gagal menyimpan data', 'errors' => $model->errors);
        }
    }

    public function actionHistory()
    {
        $model = Report::find()->where(['user_id' => Yii::$app->user->identity->id]);
        $totalItems = $model->count();
        $data = [];
        foreach ($model->all() as $key) {
            $photos = Photo::find()->where(['report_id' => $key->id])->all();
            $arr_photo = [];
            foreach ($photos as $photo) {
                $arr = [[
                    'photo' => Url::to(['file/file-report','id'=>$photo->id]),
                ]];
                $arr_photo = array_merge($arr_photo, $arr);
            }
            $arr = [[
                'id' => $key->id,
                'url' => $key->news_url,
                'category' => $key->category->category_name,
                'photo' => $arr_photo,
            ]];
            $data = array_merge($data, $arr);
        }

        return array('status' => 1, 'data' => $data, 'total_item' => $totalItems);
    }


}
