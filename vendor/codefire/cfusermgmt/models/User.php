<?php
namespace vendor\codefire\cfusermgmt\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;

use vendor\codefire\cfusermgmt\models\UserDetail;
use vendor\Linkedin\LinkedIn;
use vendor\Linkedin\OAuthToken;
use richweber\twitter\Twitter;
use frontend\models\Event;
use frontend\models\OhrmAttendanceRecord;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created
 * @property integer $modified
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    
    #################################### MODEL BASE ####################################
    
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const ROLE_USER = 10;
    
    /*Fields not the part of database fields...declare them public*/
    public $password;        
    public $old_password;
    public $new_password;
    public $confirm_password;
    public $verifyCode;
    public $file;
    public $sendMe;
    public $verify_code;
    public $item_name;
	public $marital;
	public $f_name;
	public $designation;
    //added by gajendra
    public $group;
	public $dept;
	public $doj;
	public $pan_no;
	public $adhar_no;
	public $pf_no;
	public $esic_no;
	public $bank_account_no;
	public $att_time;
	public $att_date;
    ////added by rabendra
    public $doc_file =[];
    public $permanent_address;
    public $residence_address;
	//
    /**
     * To tell the model which table to use for this model 
     * @return string : the table name with to use for this model (with auto prefix)
     */

    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * To specify the behaviors to use for this model
     * @return : behaviors to use for this model 
     */
    public function behaviors() 
    {
        return [
            'timestamp'=>[
                'class' =>'yii\behaviors\TimestampBehavior',
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['created'],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['modified']
                ],
                'value'=> function (){
                        return date('y-m-d h-i-s');
                }
            ],
        ];
    }
	

    /**
     * To validate the input fields
     * @return : the validation rules to validate and respective error messages
     */
    public function rules() 
    {
        $useCaptcha = USE_RECAPTCHA ? ['register'] : [];
        return [
            [['first_name', 'last_name', 'email', 'password','doj','dept','f_name','birth','gender','marital','att_time','designation'], 'required', 'message' => USER_FIRSTNAME_REQUIRED],    //default
			[['birth'], 'birthVerify'],
			['username', 'required', 'message' => 'Please enter Employee Code'],
			['img_path', 'required', 'message' => 'Please choose image', 'on'=>'register'],
            ['confirm_password', 'required', 'message' => USER_CONFIRMPASSWORD_REQUIRED],    //default
            ['email', 'email', 'message'=> USER_EMAIL_EMAIL],			//default
            //change by gajendra
			['gender', 'string'],
			['marital', 'string'],
			['f_name','string'],
			['dept','string'],
			['designation','string'],
			['marital', 'string'],
			['pf_no','string'],
			['esic_no','string'],
			['$bank_account_no','string'],
            ['permanent_address','string'],	
            ['residence_address','string'],		// change by shubham
            ['email', 'unique', 'targetClass' => '\vendor\codefire\cfusermgmt\models\User', 'message' => USER_EMAIL_UNIQUE, 'on'=>['register', 'editProfile','addUser', 'editUser', 'changePasswordAfterApi']],
            //
            ['username', 'unique', 'targetClass' => '\vendor\codefire\cfusermgmt\models\User', 'message' => USER_USERNAME_UNIQUE],
            ['password', 'string', 'min' => 6, 'message'=> USER_PASSWORD_STRING],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=> USER_CONFIRMPASSWORD_COMPARE],  //default
            ['username', 'verifyBannedUsernames'], //for user and admin both
            //change by gajendra
			['phone_number', 'required', 'message' => USER_PHONENUMBER_REQUIRED],   
            ['phone_number', 'match', 'pattern' => '/^[7-9]{1}[0-9]{9}$/', 'message' => USER_PHONENUMBER_MATCH],
			[['first_name','last_name'], 'match', 'pattern' => '/^[a-zA-Z]{3,20}$/', 'message' => 'Enter a valid name'],
			
			
            //changed by gajendra
			['accept_tnc', 'compare', 'compareValue' => "1", 'message' => USER_ACCEPTTNC_COMPARE, 'on'=>['register', 'addUser']],
			[['img_path'], 'file', 'extensions' => 'png, jpg, jpeg','skipOnEmpty' => true], 
            [['old_password', 'password', 'confirm_password'], 'required', 'on'=>'changePassword'],         //for user and admin both
            ['old_password', 'verifyOldPassword', 'on'=>'changePassword'],                                  //for user and admin both
            [['password', 'confirm_password', 'email'], 'required', 'on'=>'changePasswordAfterApi'],         //for user and admin both
             //changed by gajendra
            [['first_name', 'last_name', 'username', 'email','attendance_id'], 'required', 'on' => ['editProfile','editProfileByAdmin']], //   
			[['attendance_id'],'integer','message' => 'Must be numaric'],
            //by rabendrA
			['attendance_id', 'unique', 'targetClass' => '\vendor\codefire\cfusermgmt\models\User', 'message' => 'Alreday Taken'],
            [['password', 'confirm_password'], 'required', 'on'=>'changeUserPassword'],         //for admin only

            
            ######Default values to go 
            ['status', 'default', 'value' =>DEFAULT_STATUS_FOR_NEW_USER, 'on'=>['register', 'addUser']],      
            ['by_admin', 'default', 'value' =>BY_ADMIN, 'on'=>'addUser'],      
            //['verifyCode', 'captcha'],
            ['verifyCode', 'captcha', 'captchaAction' => '/usermgmt/user/captcha', 'on'=>$useCaptcha,],
            
            ["email", 'required', 'on' =>'sendMail'],
            ['email', 'sendVerifyEmailValidate', 
//                'targetClass' => '\vendor\codefire\cfusermgmt\models\User',
//                'filter' => ['email_verified' => NOT_VERIFIED],
//                'message' => USER_EMAIL_MESSAGE,
                'on' =>'sendMail'
            ],
            ['sendMe', 'required', 'message' => USER_SENDME_REQUIRED, 'on' =>'sendMail'],
            
            ["verify_code", 'required', 'message' => USER_VERIFYCODE_REQUIRED, 'on' =>'smsVerify'],
            ["verify_code", 'validateSmsToken', 'on' =>'smsVerify'],
            //added by gajendra
            ['group', 'required','on'=>['addUser','register','editProfile','editProfileByAdmin'],'message' => "Please Select Role",],
        
            [['att_time' ], 'required'],
			[['att_date' ], 'required','on' => ['editProfile','editProfileByAdmin']],
           
			
        ];
    }
    	public function birthVerify()
		{
			$date1 = new \DateTime($this->birth);
			$date2 = new \DateTime(date('Y-m-d'));
			$diff = $date1->diff($date2);
			if($diff->format('%y') < 20)
				$this->addError('birth','Age must be greater than 20');
		}
    
    /**
     * To define scenarios for this model (for validation purposes)
     * @return : different scenarios to use for this model
     */
    public function scenarios() 
    {
        /*$register = USE_RECAPTCHA 
            ? ['first_name', 'last_name', 'username', 'password', 'confirm_password', 'email', 'status', "phone_number", "dob", 'accept_tnc', 'type', 'img_path', 'verifyCode'] 
            : ['first_name', 'last_name', 'username', 'password', 'confirm_password', 'email', 'status', "phone_number", "dob", 'accept_tnc', 'type', 'img_path'];*/
            //changed by gajendra
		$register = USE_RECAPTCHA 
            ? ['first_name', 'last_name', 'username', 'password', 'confirm_password', 'email', 'status', 'accept_tnc','group', 'verifyCode','attendance_id'] 
            : ['first_name', 'last_name', 'username', 'password', 'confirm_password', 'email', 'status', 'accept_tnc','group'];
            //
        return [
            'login'=>['email', 'password'],
            'register'=>$register,
            'changePassword'=>['old_password', 'password', 'confirm_password'],
            'changePasswordAfterApi'=>['password', 'confirm_password', 'type', 'email'],
            //change by gajendra
            'editProfile'=>['first_name', 'last_name','username', 'email', 'phone_number', 'about', 'img_path', 'gender','birth','attendance_id'],
            //
            //added by admin
			'editProfileByAdmin'=>['first_name', 'last_name', 'username', 'email', 'status','gender','birth','f_name','dept','doj','attendance_id','att_time','att_date','pan_no','adhar_no','pf_no','esic_no','bank_account_no','designation','group','img_path','phone_number','about','marital','permanent_address','residence_address'],
			//
            #########Scenario for admin
            //change by gajendra
            'addUser'=>['first_name', 'last_name', 'username', 'password', 'confirm_password', 'email', 'status','gender','birth','marital','f_name','dept','doj','attendance_id','att_time','att_date','pan_no','adhar_no','pf_no','esic_no','bank_account_no','designation','by_admin','accept_tnc','group','img_path','phone_number','about','permanent_address','residence_address'],
            //
            'editUser'=>['first_name', 'last_name', 'username', 'email', 'status','attendance_id'],
            'statusChange'=>['status'],
            'approve'=>['approved'],
            'changeUserPassword'=>['password', 'confirm_password'],
            'emailVerification'=>['email_verified'],
            
            #######Password reset
            'resetPassword'=>['email'],
            'resetPass'=>['password'],
            
            #######Send Mail
            'sendMail' => ["email"],
            'smsVerify' => ['verify_code'],
            
            
        ];
        
    }
    
    /*
     * To Associate this model to another model(here associating with "UserDetail" Model)
     * @return : the relation with model
     */
    public function getUserDetail() 
    {
        return $this->hasOne(UserDetail::className(), ['user_id'=>'id']);
    }
    /*
     * To Associate this model to another model(here associating with "UserRole" Model)
     * @return : the relation with model
     */
    public function getUserRole() 
    {
        return $this->hasMany(UserRole::className(), ['user_id'=>'id']);
    }
    #################################### MODEL BASE ####################################
    
    
    
    
    
    #################################### STATIC ARRAY VALUES FUNCTIONS ####################################
    
    /**
     * To get all the gender options
     * @return array : array of all the gender options
     */
    public static function findGenderOptions()
    {
        return [
            'M'=>'Male',
            'F'=>'Female',
            'O'=>'Any Other',
        ];
    }
    
    /**
     * To get all the marital status options
     * @return array : array of marital status options
     */
    public static function findMaritalStatusOptions()
    {
        return [
            'M'=>'Married',
            'U'=>'Unmarried'
        ];
    }
    /**
     * To get all the departments status options
     * @return array : array of department status options
     */
    public static function findDepartmentStatusOptions()
    {
        return [
			'HR'=>'Human Resources', 
			'SD'=>'Software Development',
			'SL'=>'Sales',
			'PM'=>'Project Management',
			'SM'=>'Senior Management'
        ];
    }
	
	
	/**
     * To get all the designations status options
     * @return array : array of department status options
     */
    public static function findDesignationStatusOptions()
    {
        return [
			//'HR'=>'Human Resources', 
			//'DP'=>'Developer',  
			//'DG'=>'Deginer',
			//'TT'=>'Tester'
			'HRG'=> 'Human Resources Generalist',
			'HRD'=> 'Human Resources Director',
			'PD'=> 'PHP Developer',
			'AD'=> 'Android Developer',
			'JPD'=> 'Junior PHP Developer',
			'JST'=> 'Junior Software Tester',
			'SST'=> 'Senior Software Tester',
			'JD'=> 'Java Developer',
			'SJD'=> 'Senior Java Developer',
			'SPD'=> 'Senior PHP Developer',
			'TLP'=> 'Technical Lead PHP',
			'TLJ'=> 'Technical Lead Java',
			'BDA' => 'Business Development Associate',
			'BDM' => 'Business Development Manager',
			'PM' => 'Project Manager',
			'SEO' => 'Search Engine Optimizatio',
			'WD' => 'Web Designer',
			'SWD' => 'Senior Web Designer',
			'CEO' => 'Chief Executive Officer'
			
			
        ];
    }
	
	
    /**
     * function to get facebook user info
     */
    public function getFacebookUser($reDirTo, $reDirParams){
        $fb = new \Facebook\Facebook(["app_id" => FB_APP_ID, "app_secret" => FB_SECRET, 'default_graph_version' => 'v2.2']);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = explode(",", FB_SCOPE); // Optional permissions
        $redirUrlArr[0] = $reDirTo;
        $redirUrlArr = array_merge($redirUrlArr, $reDirParams);
        if (isset($_GET['code']) && !empty($_GET['code']) && isset($_GET['state']) && !empty($_GET['state'])) {
            $redirUrlArr['code'] = $_GET['code'];
            $redirUrlArr['state'] = $_GET['state'];
            $loginUrl = Url::toRoute($redirUrlArr, true);
        } else if(isset($_GET['error_code'])){
            Yii::$app->session->setFlash("warning", 'There was some error while connecting to facebook. (Error Message : '.$_GET["error_message"].')', true);
            return array("redirect"=>true, 'url'=>Url::to(["user/register"]));
        }else{
            $loginUrl = $helper->getLoginUrl(Url::toRoute($redirUrlArr, true), $permissions);
        }
        try {
            //$accessToken = isset($_GET["code"]) ? $_GET["code"] : false;
            $accessToken = $helper->getAccessToken($loginUrl);
             //print_r($accessToken);     exit;
            /** Get the long lived access token */
            if (!empty($accessToken)) {
                $oAuth2Client = $fb->getOAuth2Client();
                if (!$accessToken->isLongLived()) {
                    // Exchanges a short-lived access token for a long-lived one
                    try {
                        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                        $accessToken = $accessToken->getValue();
                    } catch (Facebook\Exceptions\FacebookSDKException $e) {
                        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                        exit;
                    }
                }
            }
            /*             * */
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        } catch(\Exception $e){
            Yii::$app->session->setFlash('danger', 'There was a problem while connecting with facebook. Please try again.');
            return array('redirect' => true , "url"=>  Url::toRoute($redirUrlArr, true));
        }
        if (!empty($accessToken)) {
            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get('/me?fields=id,name,first_name,last_name,email,gender,birth,birthday,picture,locale,timezone', $accessToken);
                $userInfo = $response->getGraphUser();
                return array('redirect' => false , "accessToken"=>(string)$accessToken, 'userInfo'=>$userInfo);
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            } catch(\Exception $e){
                Yii::$app->session->setFlash('danger', 'There was a problem while connecting with facebook. Please try again.');
                return array('redirect' => true , "url"=>  Url::toRoute($redirUrlArr, true));
            }
        } else {
            return array("redirect"=>true, 'url'=>$loginUrl);
        }
    }
    
    public function getLinkedInUser($reDirTo, $reDirParams){
        $ldn_array=array();
        $user_ApiArr = $user_profile = array();
        $ldnToken='';
        $ldnSecret='';

        $API_CONFIG = array(
            'appKey' => LDN_API_KEY,
            'appSecret' => LDN_SECRET_KEY,
            'callbackUrl' => NULL 
        );
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        $redirUrlArr[0] = $reDirTo;
        $redirUrlArr = array_merge($redirUrlArr, $reDirParams);
        $redirUrlArr[LINKEDIN::_GET_TYPE] = "initiate";
        $redirUrlArr[LINKEDIN::_GET_RESPONSE] = 1;
        $url = Url::toRoute($redirUrlArr, true);

        $API_CONFIG['callbackUrl'] = $url;
        $OBJ_linkedin = new LinkedIn($API_CONFIG);
        // check for response from LinkedIn
        $_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
		if(!$_GET[LINKEDIN::_GET_RESPONSE]) {

            // LinkedIn hasn't sent us a response, the user is initiating the connection
            // send a request for a LinkedIn access token
            try{
                $response = $OBJ_linkedin->retrieveTokenRequest();
            
                if($response['success'] === TRUE) {
                    // store the request token
                    $_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
                    // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
                    $ldn_array['url']=LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token'];

                    if(!$_GET[LINKEDIN::_GET_RESPONSE]) {
                        return array("redirect"=>true, 'url'=>$ldn_array['url']);
                    }

                } else {
                    // bad token request
                    $ldn_array['Request_Token_Failed_Response']=$response;
                    $ldn_array['Request_Token_Failed_Linkedin']=$OBJ_linkedin;
                }
            }catch(\Exception $e){
                Yii::$app->session->setFlash('danger', 'There was some error while connecting to linkedin. Please try again.');
                return array('redirect' => true , "url"=>  Url::toRoute($redirUrlArr, true));
            }
        } else {
			// LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
			try{
                $response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);
				if($response['success'] === TRUE) {
                    // the request went through without an error, gather user's 'access' tokens
                    $_SESSION['oauth']['linkedin']['access'] = $response['linkedin'];
                    // set the user as authorized for future quick reference
                    $_SESSION['oauth']['linkedin']['authorized'] = TRUE;
                    // redirect the user back to the demo page
                    //header('Location: ' . $_SERVER['PHP_SELF']);
                    $response = $OBJ_linkedin->profile('~:(id,first-name,last-name,email-address,picture-url)');
                    $user_profile='';
                    if($response['success'] === TRUE) {
                        $user_profile = new \SimpleXMLElement($response['linkedin']);
                        $ldnData = json_decode(json_encode($user_profile),TRUE);
                        $user_ApiArr['id'] = $ldnData['id'];
                        $user_ApiArr['first_name'] = $ldnData['first-name'];
                        $user_ApiArr['last_name'] = $ldnData['last-name'];
                        $user_ApiArr['email'] = $ldnData['email-address'];
                        if(isset($ldnData['picture-url'])) {
                            $user_ApiArr["picture"]['url'] = $ldnData['picture-url'];
                        }
                    }
                    $ldnSecret=$_SESSION['oauth']['linkedin']['request']['oauth_token_secret'];
                    $ldnToken=$_SESSION['oauth']['linkedin']['request']['oauth_token'];
                    Yii::$app->session->set("accessToken", $ldnToken);
                    if(!empty($user_ApiArr)) {
                        return array("accessToken"=>(string)$ldnToken, 'userInfo'=>$user_ApiArr);
                    }
                } else {
                    // bad token access
                    $ldn_array['Request_Token_Failed_Response']=$response;
                    $ldn_array['Request_Token_Failed_Linkedin']=$OBJ_linkedin;
                }
            }catch(\Exception $e){
				Yii::$app->session->setFlash('danger', 'There was some error while connecting to linkedin. Please try again.');
                return array('redirect' => true , "url"=>  Url::toRoute($redirUrlArr, true));
            }
            
        }
        $ldn_array['user_profile'] = $user_profile;
		return $ldn_array;
    }
    
    //Added by gajendra
    public function getGoogleUser($reDirTo, $reDirParams){
        $client_id = GMAIL_APP_ID;
        $client_secret = GMAIL_SECRET_ID;
        $redirUrlArr[0] = $reDirTo;
        $redirUrlArr = array_merge($redirUrlArr, $reDirParams);
        $redirect_uri = Url::toRoute($redirUrlArr, true);
        $client = new \Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $client->addScope("https://www.googleapis.com/auth/plus.login");
        $plus_service = new \Google_Service_Plus($client);
        $plus = new \Google_Service_Oauth2($client);
        if (isset($_GET['code']) && !empty($_GET['code'])) {
                $client->authenticate($_GET['code']);
                $_SESSION['access_token'] = $client->getAccessToken();
                $loginUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        } else if(isset($_GET['error_code'])){
                Yii::$app->session->setFlash("warning", 'There was some error while connecting to google. (Error Message : '.$_GET["error_message"].')', true);
                return array("redirect"=>true, 'url'=>Url::to(["user/register"]));
        }else{
                $loginUrl = $client->createAuthUrl();
        }
        if ($client->getAccessToken()){
                $_SESSION['access_token'] = $client->getAccessToken();
                $plus_data =  $plus_service->people->get('me');
                
                $userinfo = $plus->userinfo;
                $user_ApiArr['id']          = $userinfo->get()->id;
                $user_ApiArr['first_name']  = $userinfo->get()->givenName;
                $user_ApiArr['last_name']   = $userinfo->get()->familyName;
                $user_ApiArr['email']       = $userinfo->get()->email;
                $user_ApiArr["picture"]['url'] = $userinfo->get()->picture;
                $user_ApiArr["aboutMe"]     = $plus_data->aboutMe;
                $user_ApiArr["birthday"]     = $plus_data->birthday;
                $user_ApiArr["occupation"]     = $plus_data->occupation;
                $user_ApiArr["skills"]     =  $plus_data->skills;
                $user_ApiArr["tagline"]     =  $plus_data->tagline;
                $user_ApiArr["url"]     =  $plus_data->url;
                $user_ApiArr["gender"]     =  $plus_data->gender;
                $user_ApiArr["current_location"]     =  $plus_data->currentLocation;
                $user_ApiArr["organizations"]     = $plus_data->organizations;
                
                $googleToken = $_SESSION['access_token'];
                Yii::$app->session->set("accessToken", $googleToken);
                if(!empty($user_ApiArr)) {
                        return array("accessToken"=>(string)$googleToken, 'userInfo'=>$user_ApiArr);
                }
        }else {
                return array("redirect"=>true, 'url'=>$loginUrl);
        }
    }
    
    public function getTwitterUser($reDirTo, $reDirParams){
		//Twitter::consumer_key = TWT_APP_ID;
		$twitter1 = new Twitter();
        $twitter = $twitter1->getTwitter();
        $request_token = $twitter->getRequestToken();
        //set some session info
         Yii::$app->session['oauth_token'] = $token = $request_token['oauth_token'];
        Yii::$app->session['oauth_token_secret'] = $request_token['oauth_token_secret'];

        if ($twitter->http_code == 200){
            //get twitter connect url
            $url = $twitter->getAuthorizeURL($token,false);
            //send them
			return array("redirect"=>true, 'url'=>$url);
        } else {
            //error here
			return array("redirect"=>true, 'url'=>Url::home());
        }
		
    }
    
    //
    
    #################################### STATIC ARRAY VALUES FUNCTIONS ####################################
    
    
    
    
    
    #################################### USER FUNCTIONS ####################################
    
    
    /**
     * To get the identity of the user WITH STATUS
     * @param type $id : the user having this id
     * @return type record Object(User object)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->onCondition('username = :username or email = :email', [':username'=>$username, ':email'=>$username])->one();//'status' => ACTIVE
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Validate SMS verification code
     */
    public function validateSmsToken($attribute, $params){
        $record = $this->find()->select(['sms_token'])->where(["id" => $this->id])->one();
        if(empty($record->sms_token) || ($record->sms_token != $this->$attribute)){
            $this->addError($attribute, "Wrong SMS verification code");
        }
        
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * To set the password for the registering user
     * @param type string password
     * @return type string password_hash (generated)
     */
    public static function setNewPassword($password = NULL)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    
    /**
     * To set the auth_key for registering user
     * @return type string auth_key(generated)
     */
    public static function generateNewAuthKey()
    {
        return Yii::$app->security->generateRandomString();
    }
    
    /**
     * To calculate the attribute label names
     * @return : the attribute label names (tranlatable in other language)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'fb_id' => Yii::t('app', 'Fb ID'),
            'fb_access_token' => Yii::t('app', 'Fb Access Token'),
            'twt_id' => Yii::t('app', 'Twt ID'),
            'twt_access_token' => Yii::t('app', 'Twt Access Token'),
            'twt_access_secret' => Yii::t('app', 'Twt Access Secret'),
            'ldn_id' => Yii::t('app', 'Ldn ID'),
            'status' => Yii::t('app', 'Status'),
            'email_verified' => Yii::t('app', 'Email Verified'),
            'last_login' => Yii::t('app', 'Last Login'),
            'by_admin' => Yii::t('app', 'By Admin'),
            'created' => Yii::t('app', 'Created'),
            'modified' => Yii::t('app', 'Modified'),
        ];
    }
    
    /**
     * To validate the old password
     * @param string : $attribute attribute name
     * @param type : $params other params
     * adds the error in error's array if not match with old password(actual)
     */
    public function verifyOldPassword($attribute, $params)
    {
        $user = $this->findIdentity(Yii::$app->user->getId());
        if($user!=null){
          if(!$user->validatePassword($this->$attribute)){
            $this->addError($attribute, "Incorrect current password");
          }
        }
        
    }
   
    /**
     * To not allow the banned usernames 
     * @param string : $attribute attribute name
     * @param type : $params other params
     * adds the error in error's array if banned username requested to set
     */
    public function verifyBannedUsernames($attribute, $params)
    {
		//echo "<pre>";
		//print_r($params);
		//print_r($attribute);
		//exit;
        $bannedUsername = explode(',', BANNED_USERNAMES);
        
        if(in_array(strtolower(trim($this->$attribute)), array_map('strtolower', array_map('trim', $bannedUsername)))){
            $this->addError($attribute, "This username is reserved and can not be opted");
        }
    }
    
    public static function sendMail($templateFile, $details, $to, $subject){
		//echo Yii::getAlias('@cfusermgmt')."/views/mail/".$templateFile;exit;
        return \Yii::$app->mailer->compose($templateFile, ['details' => $details])
                    ->setFrom([EMAIL_FROM_ADDRESS => EMAIL_FROM_NAME]) //\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'
                    ->setTo($to)
                    ->setSubject($subject) //\Yii::$app->name
                    ->send();
    }
	
	public static function CheckPermission($event){
		
		$method = $event->action->actionMethod;
        $methodName = substr($method, 6);
        $objectName = $event->action->controller->id;
        $class = explode('\\', $objectName);
        $module = $event->action->controller->module->id;
        $modulePos = explode('app-', $module);
        if(!empty($modulePos[0])){
            $dbAction = $modulePos[0] .':'.  $objectName .':'.$methodName;
        }else{
            $dbAction = $modulePos[1].':'.$objectName.':'.$methodName;
        }
        $status = false;
		$user = AuthAssignment::find()->onCondition(['user_id'=>Yii::$app->user->getId()])->andWhere(['IN', 'item_name', [SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS, ADMIN_ROLE_NAME]])->one();
		//echo "<pre>";
		//print_r($user);exit;
		
        // Here Yii did not get the user id for guest user....so that we need to fetch actions from database allowed to perform by guest and need to check for that array
        $guestAllowedOnly = AuthItemChild::find()->where(['parent' => GUEST_ROLE_ALIAS])->asArray()->all();
        $guestAllowedArr = [];
        foreach($guestAllowedOnly as $guestAllowed){
            $guestAllowedArr[] = $guestAllowed['child'];
        }
        if(!in_array('usermgmt:user:Login', $guestAllowedArr)){
            $guestAllowedArr[] = 'usermgmt:user:Login';
        }
        if((!empty($user) && in_array($user->item_name, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS, ADMIN_ROLE_NAME))) && (!CHECK_PERMISSIONS_FOR_ADMIN || Yii::$app->user->can($dbAction))){
            $status = true;
        }elseif(
            !USE_PERMISSIONS_FOR_USERS 
            || in_array(
                $dbAction,
                $guestAllowedArr
                ) 
            || Yii::$app->user->can($dbAction)
           ) { 
            $status = true;
        }
        return $status;
	}
    
    /**
     * Function to create unique username
     */
    public function generateUsername(){
        if($username = $this->first_name){
            $i = 1;
            do{
                $username = strtolower($this->first_name.$i);
                $i++;
            }while(User::find()->where(["username" => $username])->one());
            return $username;
        }
    }
    
    #################################### USER FUNCTIONS ####################################
    
    public function findUsers($where_clause = null){
        $users = $this->find()->innerJoinWith("userRole")->where ($where_clause);
        $pagination = new \yii\data\Pagination(['defaultPageSize'=>DEFAULT_PAGE_SIZE, 'totalCount'=> $users->count()]);
        $users = $users->offset($pagination->offset)->limit($pagination->limit)->orderBy('created desc')->all();
        return array($users, $pagination);
    }
            
    public function register($usingApis){
        if(NEW_REGISTRATION_IS_ALLOWED){
            $modelDetail = new UserDetail;
            $model = new User;
            //$model->scenario = 'addUser';
            //changed by gajendra
				$model->scenario = 'register';
			//
            if(!empty($usingApis)){
                $response = $this->registerUsingApis($usingApis);
                if(!empty($response['redirect'])){
                    return $response;
                }
                $userDetail = Yii::$app->user->getIdentity();
                if(!empty($userDetail)){
                    if(empty($userDetail->password_hash)){
                        Yii::$app->session->setFlash("success", $response['message'], true);    
                        return array('redirect' => true, 'url' => Url::to(['/usermgmt/user/change-password']));
                    }else{
                        return array('redirect' => true, 'url' => Url::to(['/usermgmt/user/my-profile']));
                    }
                }
            }
			 
            if($model->load(Yii::$app->request->post())){
                $file = \yii\web\UploadedFile::getInstance($model, 'img_path');
                if(isset($file) && !empty($file)){
                    $filePath = USER_DIRECTORY_PATH.DS.USER_PROFILE_IMAGES_DIRECTORY.DS;
                    $model->img_path = Yii::$app->custom->uploadFile($file, $filePath);
                }
				;
                if($model->validate()){
                    $model->auth_key = User::generateNewAuthKey();
                    $model->password_hash = User::setNewPassword($model->password);
                    
                    if(isset($model->phone_number)){ $model->phone_number = str_replace("-", "", $model->phone_number); }
                   
                    if($model->save(false)){ 
                        
                        /** Associated Model linking ***/
                        $modelDetail->user_id = $model->id;
                        $model->link("userDetail", $modelDetail);
                       						
                        $userGroups = RoleAndPermission::find()->onCondition(['type'=>'1'])->asArray()->all();
                        $roleNames = [];
                        foreach($userGroups as $userGroup){
                            $roleNames[] = $userGroup['name'];
                        }
                        //comment by gajendra
                        /*if(in_array(DEFAULT_ROLE_NAME, $roleNames)){
                            $userRole = new AuthAssignment;
                            $userRole->item_name = DEFAULT_ROLE_NAME;
                            $userRole->user_id = $model->id;
                        }*/
                        //added by gajendra    
                        if(in_array($model->group, $roleNames)){
							$userRole = new AuthAssignment;
							$userRole->item_name = $model->group;
							$userRole->user_id = $model->id;
							
						}
						//
                        $model->link("userRole", $userRole);
                        /** Associated Model linking ***/
                      
                        if($model->save(false)){
                            if(SEND_REGISTRATION_MAIL){
                                User::sendMail('/mail/welcome-email', $model, $model->email, 'Welcome to - '.SITE_NAME);
                            }
                            //changed by gajendra
                            if(!EMAIL_VERIFICATION){ 
								//EMAIL_VERIFICATION from settings
								$model->email_verified = 1;
								$model->save(false);
								Yii::$app->session->setFlash('success', 'Your registration was successfully.');
							} else {
								User::sendMail('/mail/verifyEmail', $model, $model->email, 'Verify Your Email Address for - '.SITE_NAME);
								Yii::$app->session->setFlash('success', 'Please verify your Email. A verification link has been sent to your Email Address.');
							}
                            return array('redirect' => true, 'url' => Url::to(['/usermgmt/user/login']));
                        }else{
                            Yii::$app->session->setFlash('success', 'Your registration was not successful.');
                            return array('redirect' => true, 'url' => Yii::$app->homeUrl);
                        }
                    }    
                }
            }
            return array('render' => "register", 'model' => $model);
        }else{
            Yii::$app->session->setFlash('danger', 'Currently new registrations are not allowed by administrator. Please try later.');
            return array('redirect' => true, 'url' => Yii::$app->homeUrl);
        }  
    }
    
    /**
     * Function to register using apis
     * @param string $using : using which API the user wants to register
     */
    public function registerUsingApis($using = NULL, $functionality = 'registration'){
		if(isset($using) && !empty($using))
        {
            $justLogin = false;
            if($functionality == 'registration'){
				//echo "manu";exit;
                $reDirTo = '/usermgmt/user/register';
                $reDirParams = array('usingApis' => $using);
            }elseif($functionality == 'login'){
                $reDirTo = '/usermgmt/user/login';
                $reDirParams = array("apiLogin" => $using);
                $justLogin = true;
            }
            $response =  ['redirect' => false];
            switch($using){
                case 'facebook': 
                    $userInfo = User::getFacebookUser($reDirTo, $reDirParams);
                    //Yii::trace(json_encode($userInfo));
                    if(!empty($userInfo["redirect"])){
                        return array('redirect' => true, 'url' => $userInfo["url"]);
                    }
                    $infoArr = $userInfo["userInfo"]->asArray();
                    Yii::$app->session->set("accessToken", $userInfo["accessToken"]);
                    $infoArr['accessToken'] = $userInfo["accessToken"];
                    $email_not_recieved = 1;
                    if(!isset($infoArr['email']) || empty($infoArr['email']))
                    {
						$email_not_recieved = 0;
						$infoArr['email'] = $infoArr['id']."@facebookmail.com";
					}
                    $response = $this->addApiUser($infoArr, "fb", $justLogin, $email_not_recieved);
                    if(!empty($response["redirect"])){
                        return array('redirect' => true, 'url' => $response["url"]);
                    }
                    break;
                case 'Linkedin':
                    $userInfo = User::getLinkedInUser($reDirTo, $reDirParams);
                    if(!empty($userInfo["redirect"])){
                        return array('redirect' => true, 'url' => $userInfo["url"]);
                    }
                    if(!isset($userInfo["accessToken"]) || !isset($userInfo['userInfo'])){
                        Yii::$app->session->setFlash("warning", "There was some error while connecting to linkedin.".(isset($userInfo['Request_Token_Failed_Response']['error']) ? " Error message: ".$userInfo['Request_Token_Failed_Response']['error'] : ''), true);
                        return array('redirect' =>true, 'url' => Yii::$app->homeUrl);
                    }
                    Yii::$app->session->set("accessToken", $userInfo["accessToken"]);
                    $infoArr['accessToken'] = $userInfo["accessToken"];
                    $response = $this->addApiUser($userInfo['userInfo'], "ln", $justLogin);
                    
                    if(!empty($response["redirect"])){
                        return array('redirect' => true, 'url' => $response["url"]);
                    }
                    break;
				//added by gajendra
				 case 'Google':
                    $userInfo = User::getGoogleUser($reDirTo, $reDirParams);
                    if(!empty($userInfo["redirect"])){
                        return array('redirect' => true, 'url' => $userInfo["url"]);
                    }
                    if(!isset($userInfo["accessToken"]) || !isset($userInfo['userInfo'])){
                        Yii::$app->session->setFlash("warning", "There was some error while connecting to google.".(isset($userInfo['Request_Token_Failed_Response']['error']) ? " Error message: ".$userInfo['Request_Token_Failed_Response']['error'] : ''), true);
                        return array('redirect' =>true, 'url' => Yii::$app->homeUrl);
                    }
                    $response = $this->addApiUser($userInfo['userInfo'], "google", $justLogin);

                    if(!empty($response["redirect"])){
                        return array('redirect' => true, 'url' => $response["url"]);
                    }
                    break;
				case 'Twitter':
					$userInfo = User::getTwitterUser($reDirTo, $reDirParams);
					if(!empty($userInfo["redirect"])){
                        return array('redirect' => true, 'url' => $userInfo["url"]);
                    }
					break;
				//
            }
            return $response;
        }        
    }
    
    public function addApiUser ($infoArr, $s_type = "fb", $justLogin = false, $email_recieved = 1) {
		$modelLogin = new LoginForm();
		if(!isset($infoArr['email']) && empty($infoArr['email']))
		{
			if($s_type == "fb")
				$s_type = "Facebook";
				Yii::$app->session->setFlash("danger", "We not recive your email from ".$s_type.". So you can't Login/Register from ".$s_type, true);
            return array('redirect' => true, 'url' => Url::toRoute(['/usermgmt/user/login'], true));
		}
		
		if($justLogin == true && $email_recieved == 0 && $s_type == "fb")
			$userExists = User::find()->where(["fb_id"=>$infoArr["id"]])->one();
		elseif($justLogin == true && $email_recieved == 0 && $s_type == "twt")
			$userExists = User::find()->where(["twt_id"=>$infoArr["twt_id"]])->one();
		else
			$userExists = User::find()->where(["email"=>$infoArr['email']])->one();
		
        if(!empty($userExists)){
            $modelLogin->username = $userExists->toArray()['username'];
            if($justLogin){
                if($modelLogin->loginByEmail()){
                    Yii::$app->session->remove('accessToken');
                    $redirect = ['/usermgmt/user/dashboard'];
                    if(!$userExists->documents_updated){
                        $redirect = ['user/documents'];
                    }
                    if(!$userExists->profile_updated){
                        $redirect = ['user/edit-profile'];
                    }
                    return array('redirect' => true, 'url' => Url::toRoute($redirect, true));
                }
            }else{
                Yii::$app->session->setFlash("danger", "This email is already registered. You can not register again", true);
                return array('redirect' => true, 'url' => Url::toRoute(['/usermgmt/user/register'], true));
            }
        }elseif($justLogin == true){
            Yii::$app->session->setFlash("danger", "You need to register before you login.", true);
            return array('redirect' => true, 'url' => Url::toRoute(['/usermgmt/user/login'], true));
        }
        $savingArr = new User();
        $savingArr->id = NULL;
        if($s_type == "fb") {
            $savingArr->fb_id = $infoArr["id"];
            $savingArr->fb_access_token = $infoArr["accessToken"];
        } else if($s_type == "lk") {
            $savingArr->ldn_id = $infoArr["id"];
            //$savingArr->fb_access_token = $userInfo["accessToken"];
        }
        else if($s_type == "twt")
        {
			$savingArr->twt_id = $infoArr["twt_id"];
            $savingArr->twt_access_token = $infoArr["oauth_token"];
            $savingArr->twt_access_secret = $infoArr["oauth_token_secret"];
		}
        
        $savingArr->first_name = $infoArr["first_name"];
        $savingArr->last_name = $infoArr["last_name"];
        /***********      Please use generate user name after assigning first_name as depends on it **********/
        $savingArr->username = $savingArr->generateUsername();
        $savingArr->email = $infoArr["email"];
        $savingArr->gender = (isset($infoArr["gender"]) && $infoArr["gender"] == "male") ? "M" : ((isset($infoArr["gender"]) && $infoArr["gender"] == "F") ? "F" : "O");
        $savingArr->birth = isset($infoArr["birthday"]) ? $infoArr["birthday"] : "";
        $savingArr->status = DEFAULT_STATUS_FOR_NEW_USER;
        $savingArr->email_verified  = VERIFIED;
        $savingArr->email_recieved  = $email_recieved;
        if(isset($infoArr["picture"]['url'])) {
               $savingArr->img_path = $infoArr["picture"]['url'];
        }
        
        $string = "abcdefghijklmnopqrstuvwxyz";
        $randPassword = "";
        do{
            $randPassword .= $string[rand(0, strlen($string) -1)];
        }while(strlen($randPassword) <= 8);
//        $savingArr->auth_key = User::generateNewAuthKey();
//        $savingArr->password_hash = User::setNewPassword($randPassword);
        if($savingArr->save(false)){
            $modelDetail = new UserDetail();

            /** Associated Model linking ***/
            $modelDetail->user_id = $savingArr->id;
			
            $savingArr->link('userDetail', $modelDetail);
            $userGroups = RoleAndPermission::find()->onCondition(['type'=>'1'])->asArray()->all();
            $roleNames = [];
            foreach($userGroups as $userGroup){
                $roleNames[] = $userGroup['name'];
            }
            if(in_array(DEFAULT_ROLE_NAME, $roleNames)){
                $userRole = new AuthAssignment;
                $userRole->item_name = DEFAULT_ROLE_NAME;
                $userRole->user_id = $savingArr->id;
				
            }    
            $savingArr->link("userRole", $userRole);
            /** Associated Model linking ***/
            if($savingArr->username){
                $modelLogin->username = $savingArr->username;
                if($modelLogin->loginByEmail()){
                    return ['redirect' => false, 'message' => USER_ADDAPIUSER_STATUS];
                }
            }
        }
    }
    
    /**
     * Function to validate send-verify-email
     */
    public function sendVerifyEmailValidate($attribute, $params){
        $record = self::find()->where(['email' => $this->$attribute])->one();
        if(empty($record)){
            $this->addError($attribute, USER_EMAIL_DOES_NOT_EXIST);   
        }elseif(!empty($record->email_verified)){
            $this->addError($attribute, USER_EMAIL_MESSAGE);   
        }
    }
	public function getOhrmAttendanceRecord()
    {
        return $this->hasMany(OhrmAttendanceRecord::className(), ['employee_id' => 'id']);
    }
	public function getEmpTiming()
    {
        return $this->hasMany(EmpTiming::className(), ['emp_id' => 'id']);
    }
    public static function getEmpTimingById($id)
    {
        return $this->hasOne(EmpTiming::className(), ['emp_id' => $id]);
    }

    public static function getName($id)
    {
       $name=User::find()->where(['id'=>$id])->one();
       $username=$name['first_name']." ".$name['last_name'];
       return $username;
    }
    
}
