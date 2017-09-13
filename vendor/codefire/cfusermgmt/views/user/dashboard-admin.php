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
		   <h2 class="dasbordTitle">Admin <?php echo $this->title; ?></h2>
        </div>
    </div>
    <div class="row">
	  <div class="padding5">
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/user/save']); ?>" class="thumbnail" title='Add User'>
                <div class="caption text-center">
				<i class="fa fa-user-plus icofont"></i>
                        <h5>Add User</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/user/index']); ?>" class="thumbnail" title='All Users'>
                <div class="caption text-center">
				<i class="fa fa-users icofont"></i>
                    <h5>All Users</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/role-and-permission/save']); ?>" class="thumbnail" title='Add Role'>
                <div class="caption text-center">
				<i class="fa fa-plus icofont"></i>
                    <h5>Add Role</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/role-and-permission/index']); ?>" class="thumbnail" title='All Roles'>
                <div class="caption text-center">
				<i class="fa fa-sitemap icofont"></i>

				<h5>All Roles</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/group-permission/index']); ?>" class="thumbnail" title='Permissions'>
                <div class="caption text-center">
				<i class="fa fa-key icofont"></i>
				<h5>Permissions</h5>
                </div>
            </a>

        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/ohrm-attendance-record/panding']); ?>" class="thumbnail" title='View Employee Attendance'>
                <div class="caption text-center">
				<i class="fa fa-list-alt icofont"></i>
				<h5>View Attendance</h5>
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
            <a href="<?php echo Yii::$app->urlManager->createUrl(['workdays']); ?>" class="thumbnail" title='Workdays'>
                <div class="caption text-center">
				<i class="fa fa-desktop icofont"></i>
                    <h5>Workdays</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Yii::$app->urlManager->createUrl(['holiday']); ?>" class="thumbnail" title='Holidays'>
                <div class="caption text-center">
				<i class="fa fa-calendar icofont"></i>
				<h5>Holidays</h5>
                </div>
            </a>
        </div>
		<div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/leave/index']); ?>" class="thumbnail" title='Panding Leaves'>
                <div class="caption text-center">
                <i class="fa fa-bed icofont"></i>
                    <h5>Pending Leave </h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/leave/viewleaves']); ?>" class="thumbnail" title='Accepted Leaves'>
                <div class="caption text-center">
                <i class="fa fa-list-alt icofont"></i>
                    <h5>Leave Details </h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/user/birth']); ?>" class="thumbnail" title='Birthdays Details'>
                <div class="caption text-center">
				<i class="fa fa-birthday-cake icofont"></i>				
				<h5>Birthdays</h5>
                </div>
            </a>
        </div>
		<div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/ohrm-attendance-record/create']); ?>" class="thumbnail" title='Import Attendance'>
                <div class="caption text-center">
				<i class="fa fa-upload icofont"></i>
				<h5>Import Attendance</h5>
                </div>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 menu_thumb">
            <a href="<?php echo Url::to(['/usermgmt/user/my-profile']); ?>" class="thumbnail" title='My Profile'>
                <div class="caption text-center">
				<i class="fa fa-user icofont"></i>
				<h5>My Profile</h5>
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
            <a href="<?php echo Yii::$app->urlManager->createUrl(['/usermgmt/user/clear-cache']); ?>" class="thumbnail" title='Flush Cache(Frontend)'>
                <div class="caption text-center">
				<i class="fa fa-trash-o icofont"></i>
				<h5>Flush Cache (F)</h5>
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
