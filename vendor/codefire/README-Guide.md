Requirments:
* Yii 2 with advanced application template
* Init your application for development mode
* Php 5.4+
* MySql 5.6+

Steps To install the 'cfusermgmt' plugin:
-----------------------------------------------------------------------------------------
1. Extract (Give permission, init application)
2. Simply copy folder codefire in app vendor directory
3. add in application's frontend/web/index.php 
require(__DIR__ . '/../../vendor/codefire/cfusermgmt/config/main.php'),
before
require(__DIR__ . '/../config/main-local.php');   // JUST BEFORE THIS LINE


add after $application = new yii\web\Application($config);
require(__DIR__ . '/../../vendor/codefire/cfusermgmt/config/constants.php');

4.  - Delete common/model/User.php
    - Remove user component from application's frontend/config/main.php
    
5. create htaccess in frontend/web    
	Source code should be:
		<IfModule mod_rewrite.c>
			Options -MultiViews
			RewriteEngine On
			#RewriteBase /path/to/app
			RewriteCond %{REQUEST_FILENAME} !-f
			RewriteRule ^ index.php [L]
		</IfModule>

		Order allow,deny
		allow from all

6. update @SITE_URL alias with Current Site Url in "vendor/codefire/cfusermgmt/config/main.php"


NOTES:
-----------------------------
* make sure you have import database from yii_git_copied.sql file
* Admin credentials (codefire/111111)
Useful Url example:
* FrontEnd Url (http://localhost/BaseFolderName/frontend/web/usermgmt/user/login)

* Make sure below content should be enabled in "frontend/config/main.php"	
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
    ],
],




















        
