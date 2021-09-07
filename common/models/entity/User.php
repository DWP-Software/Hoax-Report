<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property string $verification_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class User extends \common\models\User
{
    public $password;
    public $role;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],

            [['password'], 'safe',],
            [['password'], 'required', 'on' => 'create',],

            [['role'], 'safe',],

            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'name'                 => 'Nama',
            'username'             => 'Username',
            'auth_key'             => 'Auth Key',
            'password_hash'        => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email'                => 'Email',
            'status'               => 'Status',
            'verification_token'   => 'Verification Token',
            'created_at'           => 'Created At',
            'updated_at'           => 'Updated At',
            'created_by'           => 'Created By',
            'updated_by'           => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public static function statuses($index = null) {
        $array = [
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
        if ($index == null) return $array;
        if (isset($array[$index])) return $array[$index];
        return null;
    }

    public function getRoles()
    {
        $array = [];
        $authAssignments = AuthAssignment::findAll(['user_id' => $this->id]);
        foreach ($authAssignments as $authAssignment) {
            $array[] = $authAssignment['item_name'];
        }
        $return = implode(', ', $array);
        return $return;
    }
}
