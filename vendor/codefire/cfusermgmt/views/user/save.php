<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\time\TimePicker;

$this->title = 'Add User';
//add by gajendra
use vendor\codefire\cfusermgmt\models\RoleAndPermission;
use vendor\codefire\cfusermgmt\models\User;
$userGroups = RoleAndPermission::find()->onCondition(['type'=>'1','allow_registration' => 1])->asArray()->all();
//
?>
<style>.form-group {margin-bottom: 8px;}</style>
<div class="container">
<div class="radius_box mobile-radius_box">
<div class="modal-header">      
    <h4 class="modal-title"><?php echo $this->title; ?></h4>
</div>

<div class="modal-body">
   <?php //$form = ActiveForm::begin();?>
     <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?php //added by gajendra 
	if(!empty($userGroups)) { 
		$usersRole = array();
		foreach($userGroups as $key=>$value) {
			$usersRole[$value['name']] = $value['role_alias'];
		}?>
		<div class="row">
			<div class="form-group col-lg-6 col-md-6">
				<label class="control-label col-xs-4 rgi_txt_lbl"><?php echo Html::label("Role*"); ?></label>
				<div class="col-xs-8">
					<?php echo $form->field($model, 'group')->dropDownList($usersRole,['class' =>'form-control','prompt'=>'Please Select'])->label(false);
					?>
				</div>
			</div>
			<div class="form-group col-lg-6 col-md-6">
				<label class="col-sm-4 control-label">Designation*</label>
				<div class="col-xs-8">
					<?php echo $form->field($model, 'designation')->dropDownList(User::findDesignationStatusOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label(false);
					?>
				</div>				
		</div>
		</div>
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
		<div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Date of Birth*</label>
			<div class="col-sm-8">
			<?php echo $form->field($model, 'birth')->widget(\yii\jui\DatePicker::classname(), [
			//'language' => 'ru',
			'dateFormat' => 'yyyy-MM-dd',
			'clientOptions' => [
        		//'minDate' => 0,
        		 //'dateFormat' => 'dd-mm-yyyy',
                        'showAnim'=>'fold',
                        'value'  => '1995-05-25',
                        'changeMonth'=> true,
                        'changeYear'=> true,
                        'changeDate'=> true,
                        'autoSize'=>true,
                        'htmlOptions'=>[
                        'style'=>'width:80px;',
                        'font-weight'=>'x-small',
                        ],

                        ]
			])->label(false) ?>			  
			</div>				  
		</div>	
	</div>
	<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Emp Code*</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'username')->textInput(['placeholder' => 'Please enter the Employee Code'])->label(false); ?></div>				  
		</div>
		<div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Email*</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'email')->textInput(['placeholder' => USER_SAVE_EMAIL])->label(false); ?></div>				  
		</div>		
	</div>
	
	<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Password*</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'password')->passwordInput(["placeholder" => USER_SAVE_PASSWORD])->label(false); ?></div>				  
		</div>
		<div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Confirm Password*</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'confirm_password')->passwordInput(["placeholder" => USER_SAVE_CONFIRMPASSWORD])->label(false); ?></div>				  
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
				<label class="control-label col-xs-4 rgi_txt_lbl"><?php echo Html::label("Marital Status*"); ?></label>
				<div class="col-xs-8">
					<?php echo $form->field($model, 'marital')->dropDownList(User::findMaritalStatusOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label(false);
					?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-lg-6 col-md-6">
				<label class="control-label col-xs-4 rgi_txt_lbl"><?php echo Html::label("Department*"); ?></label>
				<div class="col-xs-8">
					<?php echo $form->field($model, 'dept')->dropDownList(User::findDepartmentStatusOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label(false);
					?>
				</div>
			</div>
			<div class="form-group col-lg-6 col-md-6">
				<label class="col-sm-4 control-label">Date of Joining*</label>
				<div class="col-sm-8">
				<?= $form->field($model, 'doj')->widget(\yii\jui\DatePicker::classname(), [
					//'language' => 'ru',
						'dateFormat' => 'yyyy-MM-dd',
						'clientOptions' => [
        		//'minDate' => 0,
        		 //'dateFormat' => 'dd-mm-yyyy',
                        'showAnim'=>'fold',
                        'value'  => '1995-05-25',
                        'changeMonth'=> true,
                        'changeYear'=> true,
                        'changeDate'=> true,
                        'autoSize'=>true,
                        'htmlOptions'=>[
                        'style'=>'width:80px;',
                        'font-weight'=>'x-small',
                        ],],
					])->label(false) ?>	
				</div>				
			</div>		
		</div>
		<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Timing*</label>
			<div class="col-sm-8">
			<?= TimePicker::widget(['model' => $model, 'attribute' => 'att_time']);?>
			</div>				  
		</div>
		
		</div>
		<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Pan Card No</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'pan_no')->textInput(["placeholder" =>'Please enter your pan no'])->label(false); ?></div>				  
		</div>
		<div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Adhar No</label>
			<div class="col-sm-8"><?php  echo $form->field($model, 'adhar_no')->textInput(["placeholder" =>'Please enter your adhar no'])->label(false); ?></div>				  
		</div>		
		</div>
		<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Attendance Id</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'attendance_id')->textInput(["placeholder" =>'Please enter Attendance Id'])->label(false); ?></div>				  
		</div>
		 <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">PF No</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'pf_no')->textInput(["placeholder" =>'Please enter PF Number'])->label(false); ?></div>				  
		</div>
		</div>
		<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">ESIC No</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'esic_no')->textInput(["placeholder" =>'Please enter ESIC Number'])->label(false); ?></div>				  
		</div>
		 <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Bank Account No</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'bank_account_no')->textInput(["placeholder" =>'Please enter Bank Account Number'])->label(false); ?></div>				  
		</div>
		</div>
		<div class="row">
        <div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">Photo</label>
			<div class="col-sm-8"><?php echo $form->field($model, 'img_path')->fileInput(['class' => 'form-control'])->label(false); ?></div>				  
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
			<div class="form-group col-lg-6 col-md-6">
			<label class="col-sm-4 control-label">* Required fields</label>
			 <div class="col-sm-8"></div>
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
	<div class="modal-footer">
		<div class="row">             
		  <div class="col-sm-12 text-center">
		  <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			  </div>
		</div>
   </div>
<?php ActiveForm::end(); ?>
<div class="clearfix"></div> 
</div>
</div>
