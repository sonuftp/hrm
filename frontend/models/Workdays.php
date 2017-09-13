<?php

namespace frontend\models;
use yii\behaviors\SluggableBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;


use Yii;

/**
 * This is the model class for table "workdays".
 *
 * @property integer $id
 * @property integer $month
 * @property integer $year
 * @property string $sun
 * @property string $mon
 * @property string $tue
 * @property string $wed
 * @property string $thu
 * @property string $fri
 * @property string $sat
 * @property string $createdby
 * @property string $createddate
 * @property string $modifiedby
 * @property string $modifiedate
 */
class Workdays extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workdays';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
            [['createdby', 'createddate', 'modifiedby', 'modifieddate','month','year'],'safe'],
            [['sun', 'mon', 'tue', 'wed', 'thu', 'createdby', 'modifiedby','fri', 'sat'], 'safe' ],
            [['fri', 'sat'], 'safe',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
            'year' => 'Year',
            'sun' => 'Sun',
            'mon' => 'Mon',
            'tue' => 'Tue',
            'wed' => 'Wed',
            'thu' => 'Thu',
            'fri' => 'Fri',
            'sat' => 'Sat',
            'createdby' => 'Createdby',
            'createddate' => 'Createddate',
            'modifiedby' => 'Modifiedby',
            'modifiedate' => 'Modifiedate',
        ];
    }
     public static function findMonthsOptions()
    {
        return [
            'Jan'=>'January',
			'Feb'=>'February',
			'Mar'=>'March',
			'Apr'=>'April',
			'May'=>'May',
			'June'=>'June',
			'July'=>'July',
			'Aug'=>'August',
			'Sep'=>'September',
			'Oct'=>'October',
			'Nov'=>'November',
			'Dec'=>'December'        
   ];
    }
 
 public static function findYearsOptions()
    {
        $arr =[];
  for($i=date("Y");$i<=2020;$i++)
   $arr[$i]=$i;
  return $arr;
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
  
             public static function conversion($data) {  
				  $cmp=strcmp($data,"1,2,3,4,5");
					if($cmp==0)
					return 'All';
					else if($data=='')
					return 'None';
					else
					 return $data;
				
				}
	public static function getWorkdays($from_date,$to_date)
	{
		$date = new \DateTime($from_date);
		$from_mon = $date->format('M');
		$from_year = $date->format('Y');
		$date = new \DateTime($to_date);
		$to_mon = $date->format('M');
		$to_year = $date->format('Y');
		
		if($from_mon == $to_mon && $from_year == $to_year)
			$workday = self::getWork($from_mon,$from_year);
		else
		{
			$workday[0] = self::getWork($from_mon,$from_year);
			$workday[1] = self::getWork($to_mon,$to_year);
		}
		
		return $workday;
	}
	public static function getWork($mon,$year)
	{
		$q1 = Workdays::find()->andwhere(['month' => $mon])->andwhere(['year' => $year])->orderBy(['createddate' => SORT_DESC])->asArray()->one();
		$q2 = Workdays::find()->andwhere(['month' => null])->andwhere(['year' => $year])->orderBy(['createddate' => SORT_DESC])->asArray()->one();
		$q3 = Workdays::find()->andwhere(['month' => null])->andwhere(['year' => null])->orderBy(['createddate' => SORT_DESC])->asArray()->one();
		
		if(!empty($q1))
			
			$work =$q1;
			
		elseif(!empty($q2))
		
			$work = $q2;
		else
			$work = $q3;
		
		return $work;
	
	}
   
}
