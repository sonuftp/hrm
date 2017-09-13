<?php
//add by gajendra
use vendor\codefire\cfusermgmt\models\RoleAndPermission;
use vendor\codefire\cfusermgmt\views\helpers\Helper;
$userGroups = RoleAndPermission::find()->onCondition(['type'=>'1','allow_registration' => 1])->asArray()->all();
$loggedInRole = Helper::findUserRole();

?>
<fieldset class="mar_bottom22">
    <div class="edit_pro_h">Profile Details</div>
    <?php //$form = yii\bootstrap\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<?php echo $form->field($model, 'username')->textInput(['placeholder' => SHARED_EDITPROFILEBASICDETAIL_USERNAME, 'class' => 'form-control', 'readOnly' => !ALLOW_CHANGE_USERNAME])->label($model->getAttributeLabel('username')); ?>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
			 <?php if(!empty($userGroups) && in_array($loggedInRole, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))) { 
						$usersRole = array();
						foreach($userGroups as $key=>$value) {
							$usersRole[$value['name']] = $value['role_alias'];
						}
						echo $form->field($model, 'group')->dropDownList($usersRole,['class' =>'form-control','prompt'=>'Please Select'])->label($model->getAttributeLabel('Role'));
					}
					else
					{
						echo $form->field($model, 'group')->textInput(['class' => 'form-control', 'readOnly' => 'readonly'])->label($model->getAttributeLabel('Role'));
					}
			?>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $form->field($model, 'first_name')->textInput(['placeholder' => SHARED_EDITPROFILEBASICDETAIL_FIRSTNAME])->label($model->getAttributeLabel('first_name')); ?></div>
        <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $form->field($model, 'last_name')->textInput(['placeholder' => SHARED_EDITPROFILEBASICDETAIL_LASTNAME])->label($model->getAttributeLabel('last_name')); ?></div>
    </div>        
    <div class="row">
        <?php $label = 'Date of Birth'; ?>
        <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $form->field($model, 'dob')->textInput(['placeholder' => SHARED_EDITPROFILEBASICDETAIL_DOB, 'class' => 'form-control user-dob-datepicker', 'value' => (!empty($model->birth) ? date("d-m-Y", strtotime($model->birth)) : "")])->label($label); ?></div>
        <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $form->field($model, 'phone_number')->input('text', ['placeholder' => SHARED_EDITPROFILEBASICDETAIL_MOBILENUMBER])->label("Mobile Number"); ?></div>
    </div>
    <div class="row">
        <div class="col-md-12"><?php echo $form->field($model, 'about')->textarea(['placeholder' => SHARED_EDITPROFILEBASICDETAIL_ABOUT, 'class' => 'form-control'])->label("About"); ?></div>
    </div>
    <div class="row">	
        <div class="col-md-6 col-sm-6 col-xs-12">					
            <?php echo $form->field($model, 'img_path')->fileInput(['class' => 'form-control'])->label($model->getAttributeLabel('photo')); ?>
        </div>
    </div>
</fieldset>
