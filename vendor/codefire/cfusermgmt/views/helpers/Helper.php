<?php
namespace vendor\codefire\cfusermgmt\views\helpers;
//
use vendor\codefire\cfusermgmt\models\User;
use Yii;
use yii\helpers\Html;


class Helper extends \yii\base\Component{

    static function findStateById($id){
        $model = new State;
        $record = $model->findOne($id);
        if(!empty($record)){
            return $record->s_name;
        }
        return NULL;
    }
    
    static function findAllRoles(){
        $model = new \vendor\codefire\cfusermgmt\models\AuthItem();
        $results = $model->find()->select(['name', 'role_alias'])->where(['auth_item.type' => TYPE_ROLE])->orderBy('created_at DESC')->asArray()->all();
        if(empty($results)){
            return null;
        }
        $resultsArr = [];
        foreach($results as $result){
            $resultsArr[$result['name']] = $result['role_alias'];
        }
        return $resultsArr;
    }
    
    /*static function searchByWholeName(){
		$model = new \vendor\codefire\cfusermgmt\models\User();
		$results = $model->find()->select(['name', 'role_alias'])->where(['auth_item.type' => TYPE_ROLE])->orderBy('created_at DESC')->asArray()->all();
	}*/
    
    static function findCityById($id){
    $model = new City;
        $record = $model->findOne($id);
        if (!empty($record)) {
            return $record->s_name;
        }
        return NULL;
    }

    
    
    static function findGenderOptions(){
		$model = new User();
		return $model->findGenderOptions();
	}

	static function findMaritalStatusOptions(){
		$model = new User();
		return $model->findMaritalStatusOptions();
	}

	static function findCities(){
		$model = new City();
		return $model->findCities();
	}
    static function findStates(){
		$model = new State();
		return $model->findStates();
	}
   
    static function findUserRole($userId = NULL){
        if(empty($userId)){
            $userId = \Yii::$app->user->getId();
        }
        $userRoleData = \vendor\codefire\cfusermgmt\models\AuthAssignment::find()->where(["user_id"=>$userId])->one();
        return (!empty($userRoleData) ? $userRoleData->item_name : NULL);
    }

	
    
    static function findProofCategory($opted = NULL){
		$options = ["1" => "Aadhar Card", "2" => "Passport", "3" => "Voter Id"];
		if(!empty($opted)){
			return isset($options[$opted]) ? $options[$opted] : "";
		}
		return $options;
	}
    
    
   
	public static function addOrdinalNumberSuffix($num) {
		if (!in_array(($num % 100),array(11,12,13))){
			switch ($num % 10) {
				// Handle 1st, 2nd, 3rd
				case 1:  return $num.'st';
				case 2:  return $num.'nd';
				case 3:  return $num.'rd';
			}
		}
		return $num.'th';
	}
	
	public static function isHome(){
    	$controller = Yii::$app->controller;
		$default_controller = Yii::$app->defaultRoute;
		$isHome = (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;
		return $isHome;
    }
    static function findRequestStatus($opted = NULL){
    $options = [REQUEST_PENDING => "Pending", REQUEST_APPROVED => "Approved", REQUEST_REJECTED => "Rejected"];
        if (!empty($opted)) {
            return isset($options[$opted]) ? $options[$opted] : "";
        }
        return $options;
    }

    public static function canAskForUpdateDetails($userId = NULL) {
        return ((!\common\models\Request::find()->where('user_id = :user_id and approved = :pending', [":user_id" => \Yii::$app->user->getId(), ':pending' => REQUEST_PENDING])->count()) 
        && ($userId == Yii::$app->user->getId()));
    }

    static function findRoles($id){
        $model = new \vendor\codefire\cfusermgmt\models\AuthAssignment();
        return $model->findRecords();
    }  
    
    public static function findCompanyYearRange(){
        $years = []; 
        for($i = date('Y'); $i >= (date('Y') - 100) ; $i--)
            $years[$i] = $i;
        return $years;
    }

    public static function formatAmount($amount=0){
		return number_format($amount, 2, '.', ',');
	}
    
    public static function getAge($date){
        $date = new \DateTime($date);
        $now = new \DateTime();
        $interval = $now->diff($date);
        return $interval->y . " Years"; 
    }
    
    static function findRoleAlias($roleName = NULL){
        if(empty($roleName)){
            return null;
        }
        $roleAlias = \vendor\codefire\cfusermgmt\models\AuthItem::find()->where(["name"=>$roleName, 'type' => TYPE_ROLE])->one();
        return (!empty($roleAlias) ? $roleAlias->role_alias : NULL);
    }
    
}

