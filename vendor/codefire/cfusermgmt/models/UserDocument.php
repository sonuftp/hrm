<?php
namespace vendor\codefire\cfusermgmt\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

class UserDocument extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            
             [
             'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modified_by'],
              ],
                 'value' => new Expression('NOW()'),
            ],

        ];
    }

    public static function tableName()
    {
        return 'user_document';
    }

    public function rules()
    {
        return [
            //[['user_id','file_name'], 'required'],
            [['user_id'], 'integer'],
            [['file_name','created_by','modified_by'], 'string', 'max' => 200],
            [['created_by','modified_by'],'safe'],
        ];
    }

    public static function getUserDocument($id)
    { 

      $Document = UserDocument::find()->where(['user_id' => $id])->asArray()->all();
      return $Document;
    }
     
}