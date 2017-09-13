<?php

namespace frontend\models;
use yii\behaviors\SluggableBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "holiday".
 *
 * @property integer $id
 * @property string $date
 * @property string $description
 * @property string $createdby
 * @property string $createddate
 * @property string $modifiedby
 * @property string $modifieddate
 */
class Holiday extends \yii\db\ActiveRecord
{
	
    /**
     * @inheritdoc
     */
         
    public static function tableName()
    {
        return 'holiday';
    }
    
    public function behaviors() {
        return [
            'timestamp'=>[
                'class' =>'yii\behaviors\TimestampBehavior',
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['createddate'],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['modifieddate']
                ],
                'value'=> function (){
                        return date('Y-m-d H:i:s');
                }
            ],
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['createdby'],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['modifiedby']
                ]
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
		
        return [
             
            [['date', 'description'], 'required'],
            [['date'],'verify_date', 'on' => 'create'],
            [['date', 'createddate', 'modifieddate'], 'safe'],
            [['description'], 'string', 'max' => 100],
            [['createdby', 'modifiedby'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'description' => 'Description',
            'createdby' => 'Createdby',
            'createddate' => 'Createddate',
            'modifiedby' => 'Modifiedby',
            'modifieddate' => 'Modifieddate',
        ];
    } 
    public function verify_date($attribute, $params)
    {
		
		$validate = Yii::$app->db->createCommand('SELECT * FROM holiday  WHERE date = :date AND deleted=0')
                ->bindValue(':date', $this->date)
                ->queryOne();
               
                 if($validate)
                  $this->addError($attribute, 'This holiday allready declaired. Please try another.');	
	}
	public static function getHolidays($from_date,$to_date)
	{
		$holiday = Holiday::find()->andWhere(['between','date',$from_date,$to_date])->andWhere(['deleted' => '0'])->asArray()->all();
		$arr = [];
		for($i=0;$i<sizeof($holiday);$i++)
		{
			$arr[$holiday[$i]['date']]['id']=$holiday[$i]['id'];
			$arr[$holiday[$i]['date']]['description']=$holiday[$i]['description'];
		}
		 
        return $arr;
	}
}
