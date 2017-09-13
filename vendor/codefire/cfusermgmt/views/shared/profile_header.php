<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="row">
    <div class="profiletopBox">
        <div class="col-md-2 col-sm-4 col-xs-4 profileImageDiv">
            <div class="profile_wrapper img-thumbnail">
					<?php 
						// echo USER_PROFILE_IMAGES_DIRECTORY;
						Yii::$app->custom->showImage(USER_PROFILE_IMAGES_DIRECTORY, $model->img_path);
					?>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-7 right_textDiv"><h3><strong><?php echo ($model->id == Yii::$app->user->getId()) ? 'Welcome ' : '' ;?> <?php echo (!empty($model->first_name)) ? (Html::encode($model->first_name) . ' ') : ''; ?></strong>
        &nbsp;<?php echo  ((Html::encode($model->status) == 1) ? '<i class="fa fa-circle" style="font-size:15px;color:lightgreen;"></i>' : '<i class="fa fa-circle" style="font-size:20px;color:red;"></i>')  ?></h3>
            <div class="bottom_btn">
                <?php if ($showEditLink) { ?>
                    <?php 
                    if($model->id != Yii::$app->user->getId()){
                        $urlParam = ['/usermgmt/user/edit', 'id' => $model->id];
                    }else{
                        $urlParam = ['/usermgmt/user/edit-profile'];
                    }
                    echo Html::a('Edit Profile', Url::to($urlParam), ['class' => 'btn btn-primary']); ?>
                <?php } ?>
                <?php if ($showViewLink) { ?>
                    <?php 
                    if($model->id != Yii::$app->user->getId()){
                        $urlParam = ['/usermgmt/user/view', 'id' => $model->id];
                    }else{
                        $urlParam = ['/usermgmt/user/my-profile'];
                    }
                    echo Html::a('View Profile', Url::to($urlParam), ['class' => 'btn btn-primary']); ?>
                <?php } ?>
                <?php 
					$loggedInRole = vendor\codefire\cfusermgmt\views\helpers\Helper::findUserRole();
					if (\Yii::$app->controller->action->id == 'my-profile' && $model->status == 1 && ALLOW_USERS_TO_DELETE_ACCOUNT == 1 && !in_array($loggedInRole, array(ADMIN_ROLE_ALIAS, SUPERADMIN_ROLE_ALIAS)))  { 
							echo Html::a('In-active', 'javascript:ableToChangeStatus(' . $model->id . ', "logout")', ['class' => 'btn btn-success', 'id' => 'ableToChangeStatus' . $model->id, 'url' => Url::to([Yii::$app->controller->id . "/status"]), 'title' => 'Do Inactive']); 
					  } 
                ?>
                
            </div>
        </div>
    </div>
</div>
