<?php

namespace api\controllers\v1;

use api\models\SignupForm;
use common\models\entity\User;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;

class AuthController extends \yii\rest\Controller
{
  
  protected function verbs()
  {
    return [
      'login' => ['POST'],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'logout' => ['post'],
        ],
      ],
      'request' => [
        'parsers' => [
            'multipart/form-data' => 'yii\web\MultipartFormDataParser'
        ],
    ],
    ];
  }


  public function actionLogin()
  {
    
    $email = !empty($_POST['email']) ? $_POST['email'] : '';
    $password = !empty($_POST['password']) ? $_POST['password'] : '';
    $response = [];

    if (empty($email) || empty($password)) {
      $response = [
        'status' => 0,
        'message' => 'email & password tidak boleh kosong!',
        'data' => '',
      ];
    } else {
      $user = User::findByemail($email);
      if (!empty($user)) {
        $user->generateAuthKey();
        if ($user->save() && $user->validatePassword($password)) {
          $response = [
            'status' => 1,
            'message' => 'login berhasil!',
            'data' => [
              'id' => $user->id,
              'email' => $user->email,
              'name' => $user->name,
              'no_telp' => $user->phone,
              'token' => $user->auth_key,
            ]
          ];
        } else {
          $response = [
            'status' => 0,
            'message' => 'password tidak valid',
            'data' => '',
          ];
        }
      } else {
        $response = [
          'status' => 1,
          'message' => 'email tidak valid',
          'data' => '',
        ];
      }
    }

    return $response;
  }

  public function actionRegistration()
  {

    $params = $_REQUEST;

    $model = new SignupForm();
    $model->username = $params['username'];
    $model->email = $params['email'];
    $model->name = $params['name'];
    $model->phone = $params['phone'];
    $model->password = $params['password'];
    $model->password_confirmation = $params['password_confirmation'];

    if ($model->password != $model->password_confirmation) {
      Yii::$app->response->statusCode = 403;
      $response = [
        'status' => 0,
        'message' => 'password tidak sama',
        'data' => '',
      ];
    } else {

      if ($model->signup()) {
        $user = User::findByEmail($model->email);
        $response = [
          'status' => 1,
          'message' => 'Berhasil registrasi',
          'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'phone' => $user->phone,
            'email' => $user->email,
            'status' => $user->status,
            'access_token' => $user->auth_key,
          ]
        ];
      } else {
        Yii::$app->response->statusCode = 403;
        $response = [
          'status' => 0,
          'message' => $model->errors,
          'data' => '',
        ];
      }
    }

    return $response;
  }
}
