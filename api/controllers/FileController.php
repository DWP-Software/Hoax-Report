<?php

namespace api\controllers;

use common\models\entity\ExamInstitution;
use common\models\entity\Participant;
use common\models\entity\User;
use api\models\ResendVerificationEmailForm;
use api\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\PasswordForm;
use api\models\PasswordResetRequestForm;
use api\models\ResetPasswordForm;
use api\models\SignupForm;
use api\models\ContactForm;
use common\models\entity\News;
use common\models\entity\Photo;
use common\models\entity\Report;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class FileController extends Controller
{
    public function actionFileReport($id, $field = 'photo')
    {
        $model = Photo::findOne($id);
        downloadFile($model, $field, $model->photo);
    }
    public function actionFileNews($id, $field = 'photo')
    {
        $model = News::findOne($id);
        downloadFile($model, $field, $model->photo);
    }
}
