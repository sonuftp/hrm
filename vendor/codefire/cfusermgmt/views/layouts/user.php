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
		<link href="<?= \Yii::$app->request->BaseUrl; ?>/images/favicon.png" rel="shortcut icon">
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
								<li class=""><a href="#">Attendance <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/ohrm-attendance-record']); ?>" title='My Profile'>View Attendance</a></li> 
                                        <li><a href="<?php echo Url::to(['/ohrm-attendance-record/creater']); ?>" title='My Profile'>Add Attendance</a></li>

                                    </ul>
                                </li>




								<li class=""><a href="#">Working Days <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/workdays']); ?>" title='My Profile'>View Workdays</a></li>
                                    </ul>
                                </li> 								
								<li class=""><a href="#">Holidays<span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/holiday']); ?>" title='My Profile'>View Holidays</a></li>
									</ul>
                                </li>  
								<li class=""><a href="#">Leave<span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
<!--
                                        <li><a href="<?php echo Url::to(['/leave/index']); ?>" title='Leave'>Leave</a></li>
-->
                                        <li><a href="<?php echo Url::to(['/leave/index']); ?>" title='Request Leave'>Request Leave</a></li>
									</ul>
                                </li>  
								<li class=""><a href="#">Notifications<span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/birth']); ?>" title='My Profile'>Birthdays Notifications</a></li>
									</ul>
                                </li>
								<li class=""><a href="#">Profile <span class="arrow">▼</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/my-profile']); ?>" title='My Profile'>My Profile</a></li>
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/edit-profile']); ?>" title='Edit Profile'>Edit Profile</a></li>					
                                        <li><a href="<?php echo Url::to(['/usermgmt/user/change-password']); ?>" title='Change Password'>Change Password</a></li>
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
