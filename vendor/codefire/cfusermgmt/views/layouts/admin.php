<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use vendor\codefire\cfusermgmt\assets;
?>
<?php \vendor\codefire\cfusermgmt\assets\UsermgmtAsset::register($this); ?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script>
            var SITE_URL = '<?php echo yii\helpers\Url::home(true); ?>';
        </script>
    </head>
    <body>
        <div id="window_progress" class="ajax-loader" style="align:center"></div>
        <?php $this->beginBody() ?>
        <div class="wrap">
            <nav class="navbar navbar-default navbar-fixed-top">
                <?php include 'header.php'; ?>
            </nav>
            <div class="container">
                <div id="dashboard">
                    <div class="menu-wrap">
                        <nav class="menu">
                            <ul class="clearfix">
                                <li class="current-item"><?php echo Html::a("Dashboard", Url::to(['/usermgmt/user/dashboard'])); ?></li>
                                
                                <li class=""><a href="javascript:void(0)">User <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/save']); ?>" title='Add User'>Add User</a></li>
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/index']); ?>" title='All Users'>All Users</a></li> 
                                        <li> <a href="<?php echo Url::to(['/usermgmt/user/online']); ?>" title='Online Users'>Online Users</a></li>                     
                                    </ul>
                                </li>


								<li class=""><a href="#">Attendance <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/ohrm-attendance-record']); ?>" title='View Attendance'>View Attendance</a></li>
                                        <li><a href="<?php echo Url::to(['/ohrm-attendance-record/panding']); ?>" title='Pending Attendance'>Pending Attendance</a></li>
										<li><a href="<?php echo Url::to(['/ohrm-attendance-record/create']); ?>" title='Import Attendance'>Import Attendance</a></li>
                                        <li><a href="<?php echo Url::to(['/ohrm-attendance-record/creater']); ?>" title='Add Attendance'>Add Attendance</a></li>

                                    </ul>
                                </li>
								<li class=""><a href="#">Working Days <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/workdays']); ?>" title='View Workdays'>View Workdays</a></li>
										<li><a href="<?php echo Url::to(['/workdays/create']); ?>" title='Add Workdays'>Add Workdays</a></li>
                                    </ul>
                                </li> 
								
								<li class=""><a href="#">View Reports <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/ohrm-attendance-record/report']); ?>" title='View Reports'>View Reports</a></li>
										</ul>
								</li>										
                                    
								
								<li class=""><a href="#">Holidays<span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/holiday']); ?>" title='View Holidays'>View Holidays</a></li>
										<li><a href="<?php echo Url::to(['/holiday/create']); ?>" title='Add Holidays'>Add Holiday</a></li>
									</ul>
                                </li>  
								<li class=""><a href="#">Leave<span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/leave/index']); ?>" title='Panding Leaves'>Pending Leave</a></li>
                                        <li><a href="<?php echo Url::to(['/leave/viewleaves']); ?>" title='Accepted Leaves'>Leave Detail</a></li>
									</ul>
                                </li>
								
                                <li class=""><a href="#">Roles <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/usermgmt/role-and-permission/save']); ?>" title='Add Role'>Add Role</a></li>
                                        <li> <a href="<?php echo Url::to(['/usermgmt/role-and-permission/index']); ?>" title='All Roles'>All Roles</a></li>					
                                        <li><a href="<?php echo Url::to(['/usermgmt/group-permission/index']); ?>" title='Permissions'>Permissions</a></li>
                                        <li><a href="<?php echo Url::to(['/usermgmt/group-permission/load']); ?>" title='Load Actions'>Load Actions</a></li>
                                    </ul>
                                </li>
                               <!--  <li class=""><a href="#">Multilingual <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
										 <li><a href="<?php// echo Url::to(['/usermgmt/source-message/create']); ?>" title='Add Role'>Add Source Message</a></li>
                                         <li><a href="<?php //echo Url::to(['/usermgmt/source-message/index']); ?>" title='Add Role'>Source Messages</a></li>
                                         <li><a href="<?php //echo Url::to(['/usermgmt/message/create']); ?>" title='Add Role'>Add Message</a></li>
                                         <li> <a href="<?php //echo Url::to(['/usermgmt/message/index']); ?>" title='All Roles'>Messages</a></li>
                                    </ul>
                                </li>-->
                                <li class=""><a href="#">Profile <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/my-profile']); ?>" title='My Profile'>My Profile</a></li>
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/edit-profile']); ?>" title='Edit Profile'>Edit Profile</a></li>					
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/change-password']); ?>" title='Change Password'>Change Password</a></li>
                                    </ul>
                                </li>  
                                <li class=""><a href="#">Settings<span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/usermgmt/setting/index']); ?>" title='Configuration'>Configuration</a></li>
                                        <li><a href="<?php echo Yii::$app->urlManager->createUrl(['/usermgmt/user/clear-cache']); ?>" title='Flush Cache(Frontend)'>Flush Cache (F)</a></li>			 
                                    </ul>
                                </li> 
								<li class=""><a href="#">Notifications<span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/birth']); ?>" title='Birthdays'>Birthdays Notifications</a></li>
										<li><a href="<?php echo Url::to(['/usermgmt/user/review']); ?>" title='birthdays Reviews'>Review</a></li>
									</ul>
                                </li>  
								
                                <li><?php echo yii\helpers\Html::a("Sign Out", \yii\helpers\Url::to(['/usermgmt/user/logout'])); ?></li>
                            </ul>
                        </nav>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
            <div class="success_message">
                <?php echo $this->render("@cfusermgmtView/shared/flash_msg"); ?>
            </div>
            <?php echo $content; ?>
        </div>
        <?php include 'footer.php'; ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
