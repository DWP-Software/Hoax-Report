<?php

namespace common\models\entity;

use Yii;
use yii\bootstrap\Html;

/**
 * This is the model class for table "report".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $news_url
 * @property integer $category_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Photo[] $photos
 * @property Category $category
 * @property User $user
 * @property User $createdBy
 * @property User $updatedBy
 */
class Report extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_READ = 1;
    const STATUS_PROCESS = 2;
    const STATUS_FINISH = 3;


    public static function statuses($index = 'all', $html = false, $cssClass = '')
    {
        $array = [
            self::STATUS_NEW => 'Baru',
            self::STATUS_READ => 'Dibaca',
            self::STATUS_PROCESS => 'Prosess',
            self::STATUS_FINISH => 'Selesai',
        ];
        if ($html) $array = [
            self::STATUS_NEW => '<span class="label label-default label-inline nowrap">baru</span>',
            self::STATUS_READ => '<span class="label label-primary label-inline nowrap">Dibaca</span>',
            self::STATUS_PROCESS => '<span class="label label-warning label-inline nowrap">Prosess</span>',
            self::STATUS_FINISH => '<span class="label label-success label-inline nowrap">Selesai</span>',
        ];
        if (isset($array[$index])) return $array[$index];
        if ($index === 'all') return $array;
        return null;
    }
    public function getStatusHtml()
    {
        return self::statuses($this->status, true);
    }

    public function getScreenshot()
    {
        $model = Photo::find()->where(['report_id' => $this->id]);
        $array = [];
        foreach ($model->all() as $model) {
            $array[] = Html::a($model->photo, ['report/file-report', 'id' => $model->id], ['class' => 'btn btn-xs', 'target'=>'_blank']);
        }
        return implode('', $array);
    }

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
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'news_url', 'category_id','description'], 'required'],
            [['user_id', 'category_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['news_url'], 'string', 'max' => 225],
            [['description'],'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Nama Pelapor',
            'news_url' => 'Url',
            'category_id' => 'Kategori',
            'status' => 'Status',
            'description' => 'Keterangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['report_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
