<?php

namespace vendor\codefire\cfusermgmt\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\helpers\Url;

/* * ****Models we goona use in this controller**** */
use vendor\codefire\cfusermgmt\models\UserDocument;
use vendor\codefire\cfusermgmt\models\User;
use vendor\codefire\cfusermgmt\models\UserDetail;
use vendor\codefire\cfusermgmt\models\EmpTiming;
use vendor\codefire\cfusermgmt\models\UserActivity;
use vendor\codefire\cfusermgmt\models\UserRole;
use vendor\codefire\cfusermgmt\models\LoginForm;
use vendor\codefire\cfusermgmt\models\AuthAssignment;
use vendor\codefire\cfusermgmt\models\PasswordResetRequestForm;
use vendor\codefire\cfusermgmt\models\ResetPasswordForm;
use vendor\codefire\cfusermgmt\views\helpers\Helper;
use vendor\codefire\cfusermgmt\models\Behavior\searchBehavior;
use richweber\twitter\Twitter;

class UserController extends Controller {
    #################################### CONTROLLER BASE ####################################

    var $searchFields = array(
        'index' => array(
            'User' => array(
                'first_name' => array(
                    'type' => 'text',
                    'label' => 'Name'
                ),
                'email' => array(
                    'type' => 'text',
                    'label' => 'Email'
                ),
                'email_verified' => array(
                    'type' => 'select',
                    'label' => 'Email Verified',
                    'options' => array('' => 'Select', '0' => 'No', '1' => 'Yes')
                ),
                'item_name' => array(
                    'type' => 'select',
                    'label' => 'Group',
                    'model' => '\vendor\codefire\cfusermgmt\views\helpers\Helper',
                    'selector' => 'findAllRoles'
                ),
            )
        ),
        'online' => array(
            'UserActivity' => array(
                'status' => array(
                    'type' => 'select',
                    'label' => 'Status',
                    'options' => array('' => 'Select', '0' => 'Guest', '1' => 'Online')
                ),
                'name' => array(
                    'type' => 'text',
                    'label' => 'Name'
                ),
                'email' => array(
                    'type' => 'text',
                    'label' => 'Email'
                ),
                'ip_address' => array(
                    'type' => 'text',
                    'label' => 'Ip Address',
                    'condition' => '=',
                )
            )
        )
    );

    #################################### CONTROLLER BASE ####################################

    public function actionPermissionDenied() {
		return $this->render('permission-denied');
    }
    
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * To get log in the user
     * @return : to home url (the logged in user)
     */
    public function actionLogin($apiLogin = NULL) {
        if (!empty($apiLogin)) {
            $userApi = new User();
            $response = $userApi->registerUsingApis($apiLogin, 'login');
            if (!empty($response['redirect'])) {
                return $this->redirect($response['url']);
            }
        }
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        $model->scenario = "login";
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $userDetail = Yii::$app->user->getIdentity();
            $loginRole = Helper::findUserRole($userDetail->id);
            $redirect = LOGIN_REDIRECT_URL_FOR_ADMIN;
            if (!in_array($loginRole, array(ADMIN_ROLE_ALIAS, SUPERADMIN_ROLE_ALIAS))) {
                $redirect = LOGIN_REDIRECT_URL_FOR_USER;
                //commented by gajendra
                /*if (!$userDetail->profile_updated) {
                    return $this->redirect(['user/edit-profile']);
                }*/
            }
            return (!empty($redirect)) ? $this->redirect([$redirect]) : $this->goBack();
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * To get log out the user
     * return : to the home page
     */
    public function actionLogout() {
		//added by gajendra
		$userDetail = Yii::$app->user->getIdentity();
		if(!empty($userDetail))
		{
			$loginRole = Helper::findUserRole($userDetail->id);
			$redirect = LOGOUT_REDIRECT_URL_FOR_ADMIN;
			if (!in_array($loginRole, array(ADMIN_ROLE_ALIAS, SUPERADMIN_ROLE_ALIAS))) {
				$redirect = LOGOUT_REDIRECT_URL_FOR_USER;
			}
		}
		else
		{
			$redirect = "/";
		}
		//
		Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', FLASH_1001);
        return ($redirect != '') ? $this->redirect([$redirect]) : $this->goBack();
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        $model->scenario = 'requestPasswordReset';
        if ($model->load(Yii::$app->request->post()) && $model->validate(true)) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', FLASH_1002);
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', FLASH_1003);
            }
        }

        return $this->render('requestPasswordResetToken', [
                'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', FLASH_1004);
            return $this->goHome();
        }
        return $this->render('resetPassword', ['model' => $model]);
    }

    /*
     * To show all the records (Users) listing
     * return the view of listing of records (Users)
     */

    public function actionIndex($count = DEFAULT_PAGE_SIZE) {
		
		if (Yii::$app->request->isAjax) {
            Yii::$app->controller->module->layout = false;
        }
        $where_clause = null;
        if (isset(\Yii::$app->controller->searchFields)) {
            $argument_data = null;
            if (Yii::$app->request->isAjax) {
                $argument_data = $_REQUEST;
            }
            $where_clause = searchBehavior::search_behavior($argument_data);
        }
        $query = User::find()->innerJoinWith("userRole")->where($where_clause);
        $activeDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $count,
            ],
            'sort' => [
                'defaultOrder' => ['created' => SORT_DESC],
                'attributes' => ['created', 'id', 'first_name', 'email', 'username', 'email_verified', 'approved', 'status'],
            ],
        ]);
        $models = $activeDataProvider->getModels();
        return $this->render('index', ['activeDataProvider' => $activeDataProvider, 'models' => $models]);
    }
	
	public function actionBirth($count = DEFAULT_PAGE_SIZE) {
	
	//$query = User::find()->where(['MONTH(birth)' => date('m')])->orderBy(['(DAY(birth))' => SORT_ASC]);
	$query = User::find()->where(['between','MONTH(birth)', date('m')-1 , (date('m')+1)])->orderBy(['(MONTH(birth))' =>SORT_ASC,'(DAY(birth))' => SORT_ASC]);
		
		//print_r($query->createCommand()->getRawSql());exit;
       
	   $activeDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $count,
            ],
            'sort' => [
                'attributes' => ['birth', 'id', 'first_name', 'email', 'username'],
            ],
        ]);
        $models = $activeDataProvider->getModels();
        return $this->render('birth', ['activeDataProvider' => $activeDataProvider, 'models' => $models]);
    }
	
	public function actionReview($count = DEFAULT_PAGE_SIZE) {
		
    $query = User::find()->innerJoinWith("userDetail")->where(['MONTH(joining_date)' => date('m')])->orderBy(['DAY(joining_date)' => SORT_ASC]);
		
	//print_r($query->createCommand()->getRawSql());exit;
       
	   $activeDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $count,
            ],
            'sort' => [
                'attributes' => ['joining_date', 'id', 'first_name', 'email', 'username'],
            ],
        ]);
        $models = $activeDataProvider->getModels();
        return $this->render('review', ['activeDataProvider' => $activeDataProvider, 'models' => $models]);
    }
    /**
     * To register a guest
     * @return : view of registration form
     */
    public function actionRegister($usingApis = false) {
		$response = (new User())->register($usingApis);
        if (!empty($response['redirect'])) {
            return $this->redirect($response['url']);
        }
        return $this->render($response['render'], ['model' => $response['model']]);
    }

    /**
     * To add a record into the model (User)
     * @return : view of add record (User) form
     */
    public function actionSave() {
        if (!Yii::$app->user->isGuest) {
            $model = new User;
            $model->scenario = 'addUser';
            $modelUser = new UserDetail;
			$modelEmp = new EmpTiming;
            if ($model->load(Yii::$app->request->post())) {
				
				$file = \yii\web\UploadedFile::getInstance($model, 'img_path');
						if (isset($file) && !empty($file)) {
							$filePath = USER_DIRECTORY_PATH . DS . USER_PROFILE_IMAGES_DIRECTORY . DS;
							$model->img_path = $this->uploadFile($file, $filePath);
						}
				//print_r($model);exit;
				if ($model->validate()) {
                    $model->auth_key = User::generateNewAuthKey();
                    $model->password_hash = User::setNewPassword($model->password);
                    if ($model->save(false)) {
						$modelEmp->emp_id = $model->id;
						$modelEmp->time = $model->att_time;
						if(empty($model->att_date))
							$modelEmp->date = $model->doj;
						else
							$modelEmp->date = $model->att_date;
						$modelEmp->save(false) ? Yii::$app->session->setFlash('success', FLASH_1005, true) : Yii::$app->session->setFlash('danger', FLASH_1006, true);
                        //code by shubham
						//print_r($model);exit;
                        $modelUser->user_id = $model->id;
						$modelUser->gender = $model->gender;
						$modelUser->marital_status = $model->marital;
						$modelUser->father_name = $model->f_name;
						$modelUser->bday = $model->birth;
						$modelUser->designation = $model->designation;
						$modelUser->department = $model->dept;
						$modelUser->joining_date = $model->doj;
						$modelUser->pan_no = $model->pan_no;
						$modelUser->adhar_no = $model->adhar_no;
						$modelUser->pf_no = $model->pf_no;
						$modelUser->esic_no = $model->esic_no;
						$modelUser->bank_account_no = $model->bank_account_no;
						$modelUser->photo = $model->img_path;
                        $modelUser->save(false) ? Yii::$app->session->setFlash('success', FLASH_1005, true) : Yii::$app->session->setFlash('danger', FLASH_1006, true);
						 //code by gajendra
                        $userRole = new AuthAssignment;
						$userRole->item_name = $model->group;
						$userRole->user_id = $model->id;
						$userRole->created_at = date("Y-m-d");
						$model->link("userRole", $userRole);
						//
                    }
                    return $this->refresh();
                }
            }
            return $this->render('save', ['model' => $model]);
        } else {
            Yii::$app->session->setFlash("danger", FLASH_1007, true);
            $this->redirect(Url::to(['/usermgmt/user/login']));
        }
    }

    /**
     * To see the particular record information (User Profile)
     * @param type $id : record id to fetch the particular user Profile Detail (user_id)
     * @return : view of record information (User Profile)
     */
    public function actionView($id = NULL) {
        if (!Yii::$app->user->isGuest) {
            $assocDetails = ['userDetail','empTiming','userRole'];
            $model = User::find()->innerJoinWith($assocDetails)->onCondition(['users.id' => $id])->one();

            if (isset($model) && !empty($model)) {
                return $this->render("view", ['model' => $model]);
            }
        }
    }

    /**
     * To edit the record information (User Profile)
     * @param long $id : To get the particular user's id
     * @return : the view of edit User form
     */
    public function actionEdit($id = NULL) { 
		    if (!Yii::$app->user->isGuest) {
			$userRoleData = User::find()->innerJoinWith('userRole')->onCondition(['users.id' => $id])->one();
            $userRoleName = $userRoleData->userRole[0]->item_name;

			//print_r($userRoleData->userRole[0]);exit;
            $typeRoleModel = '';
            $assocDetails = ['userDetail','empTiming'];
            $model = User::find()->innerJoinWith($assocDetails)->onCondition(['users.id' => $id])->one();
			$model->group = $userRoleName;
			
				if (isset($model) && !empty($model)) {
					
					$model->scenario = 'editProfileByAdmin';
					$model->att_date = $model->empTiming[0]->date;
					$model->att_time = $model->empTiming[0]->time;
					for($i=1;$i<count($model->empTiming);$i++)
					{
						if($model->att_date < $model->empTiming[$i]->date)
						{
							$model->att_date = $model->empTiming[$i]->date;
							$model->att_time = $model->empTiming[$i]->time;
						}
					}
					$old_time = $model->att_time;	
					$model->designation = $model->userDetail->designation;
					$model->f_name = $model->userDetail->father_name;
					$model->marital = $model->userDetail->marital_status;
					$model->dept = $model->userDetail->department;
					$model->doj = $model->userDetail->joining_date;
					$model->pf_no = $model->userDetail->pf_no;
					$model->esic_no = $model->userDetail->esic_no;
					$model->bank_account_no = $model->userDetail->bank_account_no;
					$model->pan_no = $model->userDetail->pan_no;
					$model->adhar_no = $model->userDetail->adhar_no;
                    $model->permanent_address= $model->userDetail->permanent_address;
                    $model->residence_address= $model->userDetail->residence_address;
        

			 $modelUser = $model->userDetail;

            if ($model->load(Yii::$app->request->post())) {
					if ($model->validate()) {
						$modelUser->gender = $model->gender;
						$modelUser->marital_status = $model->marital;
						$modelUser->father_name = $model->f_name;
						$modelUser->bday = $model->birth;
						$modelUser->designation = $model->designation;
						$modelUser->department = $model->dept;
						$modelUser->joining_date = $model->doj;
						$modelUser->pan_no = $model->pan_no;
						$modelUser->adhar_no = $model->adhar_no;
						$modelUser->pf_no = $model->pf_no;
						$modelUser->esic_no = $model->esic_no;
						$modelUser->bank_account_no = $model->bank_account_no;
                        $modelUser->permanent_address = $model->permanent_address;
                        $modelUser->residence_address = $model->residence_address;

						$file = \yii\web\UploadedFile::getInstance($model, 'img_path');
						if (isset($file) && !empty($file)) {
							$filePath = USER_DIRECTORY_PATH . DS . USER_PROFILE_IMAGES_DIRECTORY . DS;
							$model->img_path = $this->uploadFile($file, $filePath);
							$modelUser->photo = $model->img_path;
						}
						else
							$model->img_path = $modelUser->photo;
                    
                    ///added by rabendra begin
                       $docfile =\yii\web\UploadedFile::getInstances($model, 'doc_file');
                       $docfilePath = USER_DIRECTORY_PATH . DS."user_documents/";
                        foreach ($docfile as $file) 
                        {
                         $Docmodel = new UserDocument();
                         $Docmodel->user_id = $id;
                         $Docmodel->file_name = $file->baseName . '.' . $file->extension;   
                            if($Docmodel->save()){
                             $file->saveAs($docfilePath.$file->baseName . '.' . $file->extension);
                            }
                        }
                       ////end

                      $model->auth_key = User::generateNewAuthKey();
                       if ($model->save(false)) {
			
						if($old_time != $model->att_time)
						{
							$modelEmp = new EmpTiming;
							$modelEmp->emp_id = $model->id;
							$modelEmp->time = $model->att_time;
							$modelEmp->date = $model->att_date;
							$modelEmp->save(false) ? Yii::$app->session->setFlash('success', FLASH_1008, true) : Yii::$app->session->setFlash('danger', FLASH_1009, true);
						}
                        //code by shubham
						//print_r($model);exit;
                        $modelUser->save(false) ? Yii::$app->session->setFlash('success', FLASH_1008, true) : Yii::$app->session->setFlash('danger', FLASH_1009, true);
						 //code by gajendra
                        $userRole = $userRoleData->userRole[0];
						$userRole->item_name = $model->group;
						$model->link("userRole", $userRole);
                    }
                    return $this->refresh();
                }
            }

            return $this->render("edit", ['model' => $model]);

		}
			
			//print_r($model->errors);exit;
        } else {
            Yii::$app->session->setFlash("danger", FLASH_1007, true);
            $this->redirect(Url::to(['/usermgmt/user/login']));
        }
    }

    public function actionChangeUserPassword($id = NULL) {
        if (!Yii::$app->user->isGuest) {
            $model = User::find()->onCondition(['users.id' => $id])->one();
            if (isset($model) && !empty($model)) {
                $model->scenario = 'changeUserPassword';
                if ($model->load(Yii::$app->request->post())) {
                    if ($model->validate()) {
                        $model->auth_key = User::generateNewAuthKey();
                        $model->password_hash = User::setNewPassword($model->password);
                        $model->update() ? Yii::$app->session->setFlash('success', FLASH_1010, true) : Yii::$app->session->setFlash('danger', FLASH_1011, true);
                        return $this->refresh();
                    }
                }
            } else {
                Yii::$app->session->setFlash("danger", FLASH_1015, true);
            }
            return $this->render('change-user-password', ['model' => $model]);
        } else {
            Yii::$app->session->setFlash("danger", FLASH_1007, true);
            $this->redirect(Url::to(['/usermgmt/user/index']));
        }
    }

    /**
     * To show the user dashboard
     * @return : view of user's dashboard 
     */
    public function actionDashboard() {
        if (!Yii::$app->user->isGuest) {
            $model = Yii::$app->user->getIdentity();
            $userRoleData = User::find()->innerJoinWith('userRole')->onCondition(['users.id' => Yii::$app->user->getId()])->one();
            $render = DEFAULT_DASHBOARD;
            if (!empty($userRoleData)) {
                $userRoleName = $userRoleData->userRole[0]->item_name;
                if ($userRoleName == ADMIN_ROLE_ALIAS || $userRoleName == SUPERADMIN_ROLE_ALIAS) {
                    $render = ADMIN_DASHBOARD;
                }
            }
            return $this->render($render, ['model' => $model]);
        } else {
            Yii::$app->session->setFlash("danger", FLASH_1007, true);
            $this->redirect(Url::to(['/usermgmt/user/login']));
        }
    }

    /**
     * To show the currently logged in user's profile view
     * @return : view for the currently logged in user profile
     */
    public function actionMyProfile() {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->getId();
            $userRoleData = User::find()->innerJoinWith('userRole')->onCondition(['users.id' => $user_id])->one();
            $userRoleName = $userRoleData->userRole[0]->item_name;
            $assocDetails = ['userDetail'];
            /*if (in_array($userRoleName, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))) {
                $assocDetails = [];
            } elseif ($userRoleName == DEFAULT_ROLE_NAME) {
                $assocDetails = ['userDetail'];
            }*/
            $model = User::find()->innerJoinWith($assocDetails)->onCondition(['users.id' => $user_id])->one();
            if (isset($model) && !empty($model)) {
                return $this->render("my-profile", ['model' => $model]);
            }
        }
        else
		{
			Yii::$app->session->setFlash("danger", FLASH_1007, true);
            $this->redirect(Url::to(['/usermgmt/user/login']));
		}
    }

    /**
     * To show the edit profile form to the currently logged in user
     * @return : view for the edit form to edit the profile information (of the currently logged in user)
     */
    public function actionEditProfile() { 
		    
            if (!Yii::$app->user->isGuest) {
			$user_id = Yii::$app->user->getId();
			$userRoleData = User::find()->innerJoinWith('userRole')->onCondition(['users.id' => $user_id])->one();
            $userRoleName = $userRoleData->userRole[0]->item_name;
            $typeRoleModel = '';
            $assocDetails = ['userDetail','empTiming'];
            $model = User::find()->innerJoinWith($assocDetails)->onCondition(['users.id' => $user_id])->one();
			$model->group = $userRoleName;
			
				if (isset($model) && !empty($model)) {
					
					$model->scenario = 'editProfileByAdmin';
					$model->att_date = $model->empTiming[0]->date;
					$model->att_time = $model->empTiming[0]->time;
					for($i=1;$i<count($model->empTiming);$i++)
					{
						if($model->att_date < $model->empTiming[$i]->date)
						{
							$model->att_date = $model->empTiming[$i]->date;
							$model->att_time = $model->empTiming[$i]->time;
						}
					}
					$old_time = $model->att_time;	
					$model->designation = $model->userDetail->designation;
					$model->f_name = $model->userDetail->father_name;
					$model->marital = $model->userDetail->marital_status;
					$model->dept = $model->userDetail->department;
					$model->doj = $model->userDetail->joining_date;
					$model->pf_no = $model->userDetail->pf_no;
					$model->esic_no = $model->userDetail->esic_no;
					$model->bank_account_no = $model->userDetail->bank_account_no;
					$model->pan_no = $model->userDetail->pan_no;
					$model->adhar_no = $model->userDetail->adhar_no;

			$modelUser = $model->userDetail;
            if ($model->load(Yii::$app->request->post())) {
				
						
				if ($model->validate()) {
					$modelUser->gender = $model->gender;
						$modelUser->marital_status = $model->marital;
						$modelUser->father_name = $model->f_name;
						$modelUser->bday = $model->birth;
						$modelUser->designation = $model->designation;
						$modelUser->department = $model->dept;
						$modelUser->joining_date = $model->doj;
						$modelUser->pan_no = $model->pan_no;
						$modelUser->adhar_no = $model->adhar_no;
						$modelUser->pf_no = $model->pf_no;
						$modelUser->esic_no = $model->esic_no;
						$modelUser->bank_account_no = $model->bank_account_no;
						$file = \yii\web\UploadedFile::getInstance($model, 'img_path');
						if (isset($file) && !empty($file)) {
							$filePath = USER_DIRECTORY_PATH . DS . USER_PROFILE_IMAGES_DIRECTORY . DS;
							$model->img_path = $this->uploadFile($file, $filePath);
							$modelUser->photo = $model->img_path;
						}
						else
							$model->img_path = $modelUser->photo;
                    $model->auth_key = User::generateNewAuthKey();
                    if ($model->save(false)) {
			
						if($old_time != $model->att_time)
						{
							$modelEmp = new EmpTiming;
							$modelEmp->emp_id = $model->id;
							$modelEmp->time = $model->att_time;
							$modelEmp->date = $model->att_date;
							$modelEmp->save(false) ? Yii::$app->session->setFlash('success', FLASH_1008, true) : Yii::$app->session->setFlash('danger', FLASH_1009, true);
						}
                        //code by shubham
						//print_r($model);exit;
                        $modelUser->save(false) ? Yii::$app->session->setFlash('success', FLASH_1008, true) : Yii::$app->session->setFlash('danger', FLASH_1009, true);
						 //code by gajendra
                       $userRole = $userRoleData->userRole[0];
						$userRole->item_name = $model->group;
						$model->link("userRole", $userRole);
                    }
                    return $this->refresh();
                }
            }
            return $this->render("edit-profile", ['model' => $model]);
		}
			
			//print_r($model->errors);exit;
        } else {
            Yii::$app->session->setFlash("danger", FLASH_1007, true);
            $this->redirect(Url::to(['/usermgmt/user/login']));
        }
    }

    /**
     * To show the Change Password for the currently logged in user
     * @return : view for the change password (For the currently logged in user)
     */
    public function actionChangePassword() {
		//echo "manu";exit;
        if (!Yii::$app->user->isGuest) {
            $model = Yii::$app->user->getIdentity();
            $abc = Yii::$app->session->get("accessToken");
            if (!empty($abc) || $model->email_recieved == 0) {
                $model->scenario = 'changePasswordAfterApi';
            } else {
                $model->scenario = 'changePassword';
            }
            //echo $model->scenario;exit;
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
					if($model->scenario == 'changePasswordAfterApi') {
						$model->email_recieved = 1;
					}
                    $model->auth_key = User::generateNewAuthKey();
                    $model->password_hash = User::setNewPassword($model->password);
                    if ($model->update()) {
                        if (SEND_PASSWORD_CHANGE_MAIL) {
                            User::sendMail('/mail/change-password-email', $model, $model->email, 'Password changed for - ' . SITE_NAME);
                        }
                        Yii::$app->session->setFlash('success', FLASH_1020, true);
                        return $this->redirect(Url::to(['/usermgmt/user/logout']));
                    } else {
                        Yii::$app->session->setFlash('danger', FLASH_1021, true);
                    }
                } //$model->errors;
            }
            return $this->render('change-password', ['model' => $model]);
        } else {
            $this->goHome();
        }
    }

    public function actionSendVerifyEmail() {
        $model = Yii::$app->user->getIdentity();
        if (!empty($model)) {
            if (User::sendMail('/mail/verifyEmail', $model, $model->email, 'Verify Your Email Address for - ' . SITE_NAME)) {
                $message = str_replace('%EMAIL%', $model->email, FLASH_1022);
                Yii::$app->session->setFlash('success', $message);
                return $this->redirect(['/usermgmt/user/my-profile']);
            }
        } else {
            $model = new User;
            $model->scenario = "sendMail";
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $userDetail = User::find()->where(["email" => $model->email])->one();
                if (User::sendMail('/mail/verifyEmail', $userDetail, $userDetail->email, 'Verify Your Email Address for - ' . SITE_NAME)) {
                    $message = str_replace('%EMAIL%', $userDetail->email, FLASH_1024);
                    Yii::$app->session->setFlash('success', $message, true);
                } else {
                    Yii::$app->session->setFlash('danger', "Email sending was not successful", true);
                }
                return $this->redirect(['/']);
            }
            return $this->render("send-verify-email", ["model" => $model]);
        }
    }

    public function actionVerifyEmail($id = NULL, $token = NULL) {
        if (Yii::$app->request->isAjax) {
            $model = User::findOne($id);
            if (isset($model) && !empty($model)) {
                $model->email_verified = ($model->email_verified == VERIFIED) ? NOT_VERIFIED : VERIFIED;
                $model->scenario = 'emailVerification';
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->update() ? ['status' => 'success', 'recordEmailVerified' => $model->email_verified] : ['status' => 'failure'];
            }
        } else {
            $model = User::find()->onCondition(['id' => $id, 'auth_key' => $token])->one();
            if (isset($model) && !empty($model)) {
                if ($model->email_verified != VERIFIED) {
                    $model->scenario = 'emailVerification';
                    $model->email_verified = VERIFIED;
                    $model->sms_token = NULL;
                    $model->auth_key = User::generateNewAuthKey();
                    if ($model->update()) {
                        Yii::$app->session->setFlash("success", FLASH_1026, true);
                    }
                } else {
                    Yii::$app->session->setFlash("danger", FLASH_1027, true);
                }
            } else {
                Yii::$app->session->setFlash("danger", FLASH_1028, true);
            }
            return $this->redirect(['/usermgmt/user/login']);
        }
    }

    public function actionVerifySms($email = NULL) {
        $model = User::find()->where(['email' => $email])->one();
        if (isset($model) && !empty($model)) {
            if ($model->sms_verified != VERIFIED) {
                $model->scenario = 'smsVerify';
                if ($model->load(Yii::$app->request->post())) {
                    $model->sms_verified = VERIFIED;
                    $model->sms_token = NULL;
                    if ($model->validate() && $model->update()) {
                        Yii::$app->session->setFlash("success", FLASH_1029, true);
                        return $this->redirect(['/usermgmt/user/login']);
                    }
                }
                return $this->render('verify-sms', ['model' => $model]);
            } else {
                Yii::$app->session->setFlash("danger", FLASH_1030, true);
                return $this->redirect(['/usermgmt/user/login']);
            }
        } else {
            Yii::$app->session->setFlash("danger", FLASH_1031, true);
            return $this->redirect(['/usermgmt/user/login']);
        }
    }

    public function actionOnline($count = DEFAULT_PAGE_SIZE) {
        if (Yii::$app->request->isAjax) {
            Yii::$app->controller->module->layout = false;
        }
        $where_clause = null;
        if (isset(\Yii::$app->controller->searchFields)) {
            $argument_data = null;
            if (Yii::$app->request->isAjax) {
                $argument_data = $_REQUEST;
            }
            $where_clause = searchBehavior::search_behavior($argument_data);
        }
        //added by gajendra
        $date = date("Y-m-d h:i:s");
		$time = strtotime($date);
		$time = $time - (VIEW_ONLINE_USER_TIME * 60);
		$date = date("Y-m-d h:i:s", $time);
		$query = UserActivity::find()->where($where_clause)->andWhere(['>=', 'created', $date]);
		//
        $activeDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $count,
            ],
            'sort' => [
                'defaultOrder' => ['created' => SORT_DESC],
                'attributes' => ['created', 'id', 'name', 'email', 'username'],
            ],
        ]);
        $models = $activeDataProvider->getModels();
        return $this->render('online', ['activeDataProvider' => $activeDataProvider, 'models' => $models]);
    }

    public function actionClearCache() {
        if (Yii::$app->cache->flush()) {
            Yii::$app->session->setFlash("success", FLASH_1032, true);
        } else {
            Yii::$app->session->setFlash("danger", FLASH_1033, true);
        }
        return $this->redirect(Url::to(['/usermgmt/user/dashboard']));
    }

    #################################### AJAX FUNCTIONS ####################################

    public function actionStatus() {
        if (!empty(Yii::$app->request->isAjax)) {
            $id = $_POST['id'];
            $model = User::findOne($id);
            if (isset($model) && !empty($model)) {
                $model->status = ($model->status == ACTIVE) ? INACTIVE : ACTIVE;
                $model->scenario = 'statusChange';
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->update() ? ['status' => 'success', 'recordStatus' => $model->status] : ['status' => 'failure'];
            }
        }
    }

    public function actionApprove($id = NULL) {
        $model = User::findOne($id);
        if (isset($model) && !empty($model)) {
            $model->approved = ($model->approved == ACTIVE) ? INACTIVE : ACTIVE;
            $result = ($model->approved == ACTIVE) ? 'approved' : 'disapproved';
            $model->scenario = 'approve';
            if ($model->update()) {

                /*                 * * SMS/MAIL EVENTS starts here *** */
                /*$eventDetail['role'] = ucwords(Helper::findUserRole($model->id));
                $eventDetail['receiver_id'] = $model->id;
                $eventDetail['receiver_email'] = $model->email;
                \frontend\models\Event::addEvent(EVENT_MAIL_TYPE, EVENT_ACCOUNT_APPROVAL, $eventDetail);*/
                /*                 * * SMS/MAIL EVENTS ends here *** */
                $message = str_replace('%OPERATION%', $result, FLASH_1034);
                Yii::$app->session->setFlash("success", $message, true);
            } else {
                $message = str_replace('%OPERATION%', $result, FLASH_1035);
                Yii::$app->session->setFlash("danger", $message, true);
            }
            return $this->redirect(Url::toRoute(['/usermgmt/user/'], true));
        }
    }

    public function actionStatusUser() {
        if (Yii::$app->request->isAjax) {
            $model = User::findOne($_POST['id']);
            $modelActivity = UserActivity::findOne(['user_id' => $_POST['id']]);
            if (isset($model) && !empty($model)) {
                $model->status = ($model->status == ACTIVE) ? INACTIVE : ACTIVE;
                $modelActivity->status = $model->status;
                $model->scenario = 'statusChange';
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ($model->update() & $modelActivity->update()) ? ['status' => 'success', 'recordStatus' => $model->status] : ['status' => 'failure'];
            }
        }
    }

    public function actionLogoutUser() {
        if (Yii::$app->request->isAjax) {
            $model = UserActivity::findOne(['ip_address' => $_POST['ip']]);
            if (isset($model) && !empty($model)) {
                $model->logout = ACTIVE;
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ($model->update()) ? ['status' => 'success', 'recordLoggedout' => $model->logout] : ['status' => 'failure'];
            }
        }
    }

    public function actionDelete() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $model = User::find()->innerJoinWith('userDetail')->onCondition(['users.id' => $id])->one();
            if (isset($model) && !empty($model)) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ($model->delete($id) && UserDetail::deleteAll(['user_id' => $id])) ? ['status' => 'success', 'recordDeleted' => DELETED] : ['status' => 'failure'];
            }
        }
    }

    #################################### AJAX FUNCTIONS ####################################
    #################################### PROTECTED FUNCTIONS ###############################

    /**
     * Function to upload a user profile image
     * @param string $model : model name to make object and use object 
     * @param string $filePath : Actual folder absolute path to save the file
     */
    protected function uploadFile($file, $filePath) {
        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, true);
        }
        $fileName = rand(1, 1000) . time() . $file->name;
        $file->saveAs($filePath . $fileName);
        return $fileName;
    }

    /**
     * Function to reset the search filter
     * @return string : redirect url  
     */
    public function actionResetFilter(){
		unset($_SESSION['generic_search']);
		$url = $_GET['href'];
		return $this->redirect($url);
	}
	
	public function actionTwitterCallBack()
    {
		//echo "manu";exit;
         /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && Yii::$app->session['oauth_token'] !== $_REQUEST['oauth_token']) {
            Yii::$app->session['oauth_status'] = 'oldtoken';
        }
		$twitter1 = new Twitter();
        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $twitter = $twitter1->getTwitterTokened(Yii::$app->session['oauth_token'], Yii::$app->session['oauth_token_secret']);   

        /* Request access tokens from twitter */
        $access_token = $twitter->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        Yii::$app->session['access_token'] = $access_token;

        /* Remove no longer needed request tokens */
        unset(Yii::$app->session['oauth_token']);
        unset(Yii::$app->session['oauth_token_secret']);

        if (200 == $twitter->http_code) {
            /* The user has been verified and the access tokens can be saved for future use */
            Yii::$app->session['status'] = 'verified';

            //get an access twitter object
            $twitter = $twitter1->getTwitterTokened($access_token['oauth_token'],$access_token['oauth_token_secret']);

            //get user details
            $twuser= $twitter->get("account/verify_credentials",['email'=>true]);
			$infoArr = array();
			$infoArr['twt_id'] = $twuser->id;
			$infoArr['twt_access_token'] = $access_token['oauth_token'];
			$infoArr['twt_access_secret'] = $access_token['oauth_token_secret'];
			$infoArr['first_name'] = $twuser->name;
			$infoArr['last_name'] = '';
			$infoArr['username'] = $twuser->screen_name;
			$infoArr["email"] = $twuser->screen_name."@twittermail.com";
			$infoArr["picture"]['url']= $twuser->profile_image_url;
			$userApi = new User();
			$user_data = $userApi::find()->where("twt_id = '".$twuser->id."'")->asArray()->one();
			$response = $userApi->addApiUser($infoArr, "twt", false, 0);
            if(!empty($response['redirect'])){
                    return $this->redirect($response['url']);
			}
			if(isset($_SESSION['redirect_url_session']) && !empty($_SESSION['redirect_url_session'])){
					return $this->redirect($_SESSION['redirect_url_session']);
			}
			$userDetail = Yii::$app->user->getIdentity();
			if(!empty($user_data)){
				return $this->redirect(Url::home());
			}
			else
			{
				return $this->redirect(Url::to(['/usermgmt/user/change-password']));
			}

        } else {
            /* Save HTTP status for error dialog on connnect page.*/
            //header('Location: /clearsessions.php');
            return $this->redirect(Url::home());
        }
    } 
    
}
