<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\time\TimePicker;
use vendor\codefire\cfusermgmt\views\helpers\Helper;
$this->title = 'Edit User';
//add by gajendra
use vendor\codefire\cfusermgmt\models\RoleAndPermission;
use vendor\codefire\cfusermgmt\models\User;
$userGroups = RoleAndPermission::find()->onCondition(['type'=>'1','allow_registration' => 1])->asArray()->all();
$loggedInRole = Helper::findUserRole();
//
?>
<style>.form-group {margin-bottom: 8px;}</style>
<div class="container">
<div class="radius_box mobile-radius_box">
<div class="modal-header">      
    <h4 class="modal-title"><?php echo $this->title; ?></h4>
</div>

<div class="modal-body">
    
	<?php //added by gajendra 
	if(!empty($userGroups)) { 
		$usersRole = array();
		foreach($userGroups as $key=>$value) {
			$usersRole[$value['name']] = $value['role_alias'];
		}?>
		<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">First Name*</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'first_name')->textInput(['placeholder' => USER_REGISTERASLENDER_FIRSTNAME])->label(false); ?></div>				  
		</div>
		<div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Last Name*</label>
			<div class="col-sm-8"><?php  echo $form->field($model, 'last_name')->textInput(['placeholder' => USER_SAVE_LASTNAME])->label(false); ?></div>				  
		</div>		
	</div>
	<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Father Name*</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'f_name')->textInput(['placeholder' => 'Please enter your Father Name'])->label(false); ?></div>				  
		</div>	
		<!-- <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Date of Birth*</label>
			<div class="col-sm-8">
			<?php //echo $form->field($model, 'birth')->widget(\yii\jui\DatePicker::classname(), [			'language' => 'ru','dateFormat' => 'yyyy-MM-dd'])->label(false) ?>			  
			</div>				  
		</div>	-->
		<div class="form-group col-lg-6 col-md-6">
				<label class="control-label col-xs-4 rgi_txt_lbl"><?php echo Html::label("Marital Status*"); ?></label>
				<div class="col-xs-8">
					<?php echo $form->field($model, 'marital')->dropDownList(User::findMaritalStatusOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label(false);
					?>
				</div>
			</div>
	</div>
		<div class="row">
			<div class="form-group col-lg-6 col-md-6">
					<label class="control-label col-xs-4 rgi_txt_lbl"><?php echo Html::label("Gender*"); ?></label>
					<div class="col-xs-8">
						<?php echo $form->field($model, 'gender')->dropDownList(User::findGenderOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label(false);
						?>
					</div>
			</div>
			<div class="form-group col-lg-6 col-md-6">
				<label class="col-sm-4 control-label">Mobile Number*</label>
				 <div class="col-sm-8"><?php echo $form->field($model, 'phone_number')->input('text', ['placeholder' => SHARED_EDITPROFILEBASICDETAIL_MOBILENUMBER])->label(false); ?></div>
			</div>				  
		</div>
			
		
		 
		<div class="row">
        	<div class="form-group col-lg-6 col-md-6">
				<label class="col-sm-4 control-label">About</label>
				<div class="col-sm-8"><?php echo $form->field($model, 'about')->textarea(['placeholder' => SHARED_EDITPROFILEBASICDETAIL_ABOUT, 'class' => 'form-control'])->label(false); ?></div>				  
			</div>		
		</div>
		</div>
	<?php }else{
	?>
		<input type="hidden" name= "User[group]" value = "<?php echo DEFAULT_ROLE_NAME; ?>">
	<?php
	} ?>
	<div class="clearfix"></div>
	</div>
</div>
