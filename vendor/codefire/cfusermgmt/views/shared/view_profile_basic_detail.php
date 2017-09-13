<?php 
    use yii\helpers\Html;
    use vendor\codefire\cfusermgmt\models\User;
    use vendor\codefire\cfusermgmt\models\UserDocument;

   
    $getdesignation = User::findDesignationStatusOptions();
    $getdepartment = User::findDepartmentStatusOptions();
    $getmarital = User::findMaritalStatusOptions();
    $getgender = User::findGenderOptions();
    $userdoc = UserDocument::getUserDocument($model->id);
?>


<div class="row">
<div class="col-sm-6">

<fieldset class="mar_bottom22">

    <div class="edit_pro_h">Personal Details</div>
     <div class="row">
        <div class="col-md-6"><?php echo Html::label("First name"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->first_name)) ? (Html::encode($model->first_name)) : NOT_FOUND_TEXT; ?></div>
    </div>

     <div class="row">
        <div class="col-md-6"><?php echo Html::label("Last name"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->last_name)) ? (Html::encode($model->last_name)) : NOT_FOUND_TEXT; ?></div>
    </div>

     <div class="row">
        <div class="col-md-6"><?php echo Html::label("Email"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->email)) ? (Html::encode($model->email)) : NOT_FOUND_TEXT; ?></div>
    </div>

    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Father name"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->father_name)) ? (Html::encode($model->userDetail->father_name)) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Gender"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->gender)) ? (Html::encode($getgender[$model->userDetail->gender])) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Marital Status"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->marital_status)) ? (Html::encode($getmarital[$model->userDetail->marital_status])) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <?php $label = 'Date of Birth';?>
        <div class="col-md-6"><?php echo Html::label($label); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->birth)) ? date(DATE_FORMAT, strtotime(Html::encode($model->birth))) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Mobile Number"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->phone_number)) ? (Html::encode($model->phone_number)) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("About"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->about)) ? (Html::encode($model->about)) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Permanent Address"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->permanent_address)) ? (Html::encode($model->userDetail->permanent_address)) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Residence Address"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->residence_address)) ? (Html::encode($model->userDetail->residence_address)) : NOT_FOUND_TEXT; ?></div>
    </div>
</fieldset>
</div>
<div class="col-sm-6">
<fieldset class="mar_bottom10">
     <div class="edit_pro_h">Professional Details</div>
     <div class="row">
        <div class="col-md-6"><?php echo Html::label("Role"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userRole[0]->item_name)) ? (Html::encode($model->userRole[0]->item_name)) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Emp Code"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->username)) ? (Html::encode($model->username)) : NOT_FOUND_TEXT; ?></div>
    </div>
     
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Joined"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->joining_date)) ? date(DATE_FORMAT, strtotime(Html::encode($model->userDetail->joining_date))) : NOT_FOUND_TEXT; ?></div>
    </div>

    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Designation"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->designation)) ? (Html::encode($getdesignation[$model->userDetail->designation])) : NOT_FOUND_TEXT; ?></div>
    </div>
     <div class="row">
        <div class="col-md-6"><?php echo Html::label("Department"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->department)) ? (Html::encode($getdepartment[$model->userDetail->department])) : NOT_FOUND_TEXT; ?></div>
        </div>
   
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("PF No"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->pf_no)) ? (Html::encode($model->userDetail->pf_no)) : NOT_FOUND_TEXT; ?></div>
    </div>
    <div class="row">
        <div class="col-md-6"><?php echo Html::label("ESIC No"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->esic_no)) ? (Html::encode($model->userDetail->esic_no)) : NOT_FOUND_TEXT; ?></div>
    </div>


    <div class="row">
        <div class="col-md-6"><?php echo Html::label("Pan Card No"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->pan_no)) ? (Html::encode($model->userDetail->pan_no)) : NOT_FOUND_TEXT; ?></div>
    </div>
     <div class="row">
        <div class="col-md-6"><?php echo Html::label("Adhar No"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->adhar_no)) ? (Html::encode($model->userDetail->adhar_no)) : NOT_FOUND_TEXT; ?></div>
    </div>

     <div class="row">
        <div class="col-md-6"><?php echo Html::label("Bank Account No"); ?></div>
        <div class="col-md-6"><?php echo (!empty($model->userDetail->bank_account_no)) ? (Html::encode($model->userDetail->bank_account_no)) : NOT_FOUND_TEXT; ?></div>
    </div>
</fieldset>
</div>
<!--by rabendra-->
<div class="col-sm-12">
<fieldset class="mar_bottom10">
     <div class="edit_pro_h">User Document</div>
      <div class="row">
        
        <?php 
          foreach ($userdoc as $key => $doc) {
        ?>
        <div class="col-md-3"> 
        <a href="<?php echo DOC_IMAGE_URL.$doc['file_name'];?>" target="_blank">
           <img src="<?php echo DOC_IMAGE_URL.$doc['file_name'];?>" width="100%"
           id="<?php echo $doc['id'];?>">  </a>
        </div>
        <?php }  ?>      
      </div>
</fieldset>
</div>
<!---->
</div>

