<?php
namespace vendor\codefire\cfusermgmt\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\helpers\Url;

/******Models we goona use in this controller*****/
use vendor\codefire\cfusermgmt\models\Setting;
use vendor\codefire\cfusermgmt\models\User;


class SettingController extends Controller{
    
    #################################### CONTROLLER BASE ####################################
    
    var $searchFields = array (
			'index' => array(
				'Setting' => array(
					/*'name'=> array(
						'type' => 'text',
						'label' => 'Name',
                    ),*/
					'name_public' => array(
						'type' => 'text',
						'label' => 'Description'
					),
					'value' => array(
						'type' => 'text',
						'label' => 'Value',
					)
				)
			)
		);
    
    #################################### CONTROLLER BASE ####################################
    
    
    
    
    #################################### ADMIN FUNCTIONS ####################################
    
    /*
     * To show all the records (Users) listing
     * return the view of listing of records (Users)
     */
    public function actionIndex($count = DEFAULT_PAGE_SIZE)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->controller->module->layout = false;
        }
        $where_clause = null;
        if(isset(\Yii::$app->controller->searchFields)) {
            $argument_data = null;
            if(Yii::$app->request->isAjax) {
                $argument_data = $_REQUEST;
            }
            $where_clause = \vendor\codefire\cfusermgmt\models\Behavior\searchBehavior::search_behavior($argument_data);
        }
        $query = Setting::find()->where($where_clause);
        $activeDataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                'pageSize' => $count,
                ],
                'sort' => [
                'defaultOrder' => ['id'=>SORT_DESC],
                'attributes' => ['created', 'id', 'name_public', 'value'],
                ],
                ]);
          //  echo "<pre>";print_r($query);die;

        $models = $activeDataProvider->getModels();
        return $this->render('index', ['activeDataProvider'=>$activeDataProvider, 'models' => $models]);
        
    }
    
    
    
    /**
     * To edit the record information (User Profile)
     * @param long $id : To get the particular user's id
     * @return : the view of edit User form
     */
    public function actionEdit($id = NULL)
    {
        if(!Yii::$app->user->isGuest){
			
            $model = Setting::findOne(['id'=>$_POST['id']]);
            if(isset($model) && !empty($model)){
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				if($_POST['id'] == 10)
				{
					$value_array = explode(",", $_POST['value']);
					$user_data = User::find()->where(["username" => $value_array])->asArray()->all();
					 
					if(!empty($user_data))
					{
						return ['status' => 'banned'];
					}
				}
                $model->value = $_POST['value'];
                return $model->update(false) ? ['status'=>'success'] : ['status'=>'failure'];
            }else{
                Yii::$app->session->setFlash("danger", 'Invalid Setting', true);
                $this->refresh();
            }
        }else{
            Yii::$app->session->setFlash("danger", 'You have to be looged in to perform any private operation', true);
            $this->redirect(Url::to(['/usermgmt/user/index']));
        }
    }
    
    #################################### ADMIN FUNCTIONS ####################################
    
    

    #################################### AJAX FUNCTIONS ####################################
    
    #################################### AJAX FUNCTIONS ####################################
    
    
}
    

