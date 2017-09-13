<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Dashboard';
?>
<style>
    a.thumbnail:hover, a.thumbnail:focus, a.thumbnail.active{
        background-color: rgb(232, 233, 237);
		
    }
</style>
<div class="container">
    <div class="radius_box">
    <div class="row">
        <div class="col-md-12">
		   <h2 class="dasbordTitle">User <?php echo $this->title; ?></h2>
        </div>
    </div>
    <div class="row">
	  <div class="padding5">
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/user/my-profile']); ?>" class="thumbnail" title='My Profile'>
                <div class="caption text-center">
				<i class="fa fa-user icofont"></i>
				<h5>My Profile</h5>
                </div>
            </a>
        </div>
		<div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/ohrm-attendance-record']); ?>" class="thumbnail" title='Load Actions'>
                <div class="caption text-center">
				<i class="fa fa-list-alt icofont"></i>
				<h5>Attendance</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/ohrm-attendance-record/creater']); ?>" class="thumbnail" title='Add Attendance'>
                <div class="caption text-center">
                <i class="fa fa-pencil icofont"></i>
                <h5>Add Attendance</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Yii::$app->urlManager->createUrl(['workdays']);?>" class="thumbnail" title='Settings'>
                <div class="caption text-center">
				<i class="fa fa-desktop icofont"></i>
                    <h5>Workdays</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Yii::$app->urlManager->createUrl(['holiday']); ?>" class="thumbnail" title='Flush Cache(Frontend)'>
                <div class="caption text-center">
				<i class="fa fa-calendar icofont"></i>
				<h5>Holidays</h5>
                </div>
            </a>
        </div>
		<div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/user/birth']); ?>" class="thumbnail" title='Birthdays'>
                <div class="caption text-center">
				<i class="fa fa-birthday-cake icofont"></i>				
				<h5>Birthdays</h5>
                </div>
            </a>
        </div>
		<div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/leave/index']); ?>" class="thumbnail" title='Change Password'>
                <div class="caption text-center">
                <i class="fa fa-bed icofont"></i>
                    <h5> Leave</h5>
                </div>
            </a>
        </div>
		
		<div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/user/edit-profile']); ?>" class="thumbnail" title='Edit Profile'>
                <div class="caption text-center">
				<i class="fa fa-pencil-square-o icofont"></i>
				<h5>Edit Profile</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/user/change-password']); ?>" class="thumbnail" title='Change Password'>
                <div class="caption text-center">
				<i class="fa fa-unlock-alt icofont"></i>
                    <h5>Change Password</h5>
                </div>
            </a>
        </div>
      </div>
     </div>
    </div>
   </div>