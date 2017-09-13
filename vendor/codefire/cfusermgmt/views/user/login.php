<?php

use yii \helpers\Url;
use yii\helpers\

Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<!--new code--->
<div class="container top-bottom_padding">
<!--today code for login page Start HERE--->
<div class="row">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div class="col-md-6 col-sm-8 col-sm-10 login_box">
	<div class="modal-header">      
        <h4 class="modal-title">Login</h4>
      </div>
       <!-- <div class="row">	
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <a class="btn btn-facebook btn-block btn-icon bg-primary log_fac" href="#">
                    <span class="icon-container">
                        <span class="fa fa-facebook fa-lg fa-fw"></span>
                    </span>
                    <span class="text-container"> Log in with Facebook </span>
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-google btn-block btn-icon log_gplus" href="#">
                    <span class="icon-container">
                        <span class="fa fa-google-plus fa-lg fa-fw"></span>
                    </span>
                    <span class="text-container"> Log in with Google </span>
                </a>
            </div>
        </div>-->
		
		<!--<div class="providerBox">
			<ul class="providers">
				<?php /*if(USE_FB_LOGIN) { ?> 
					<li id="facebook" title="Facebook Connect" onClick="javascript:document.getElementById('fb_link').click();">
						<?php echo Html::a("", Url::to(['/usermgmt/user/login', 'apiLogin' => 'facebook']), ['id' => 'fb_link']); ?>
					</li>
                <?php } ?>
                <?php if(USE_LDN_LOGIN) { ?> 
					<li id="linkedin" title="Linkedin Connect" onClick="javascript:document.getElementById('ln_link').click();">
						<?php echo Html::a('Login using Linkedin', Url::to(["/usermgmt/user/login", 'apiLogin' => 'Linkedin']), ['id'=>'ln_link', 'class' => 'last']); ?>
					</li>
                <?php } ?>
                <?php if(USE_GMAIL_LOGIN) { ?>
					<li id="google" title="Google Connect" onClick="javascript:document.getElementById('google_link').click();">
					  <?php echo Html::a("", Url::to(["/usermgmt/user/login", 'apiLogin' => 'Google']), ['id'=>'google_link', 'class' => 'last']); ?>
					</li>
				 <?php } ?>
				  <?php if(USE_TWT_LOGIN) { ?>
					<li id="twitter" title="Twitter Connect" onClick="javascript:document.getElementById('twitter_link').click();">
					  <?php echo Html::a("", Url::to(["/usermgmt/user/login", 'apiLogin' => 'Twitter']), ['id'=>'twitter_link', 'class' => 'last']); ?>
					</li>
				 <?php } */?>
			<div style="clear:both"></div>
			</ul>
		</div>
        <div class="login_divider"><div class="text">or</div></div>-->
		
		<div class="modal-body">
		<div class="form-group">
			  <label class="col-sm-3 control-label" for="inputEmail3">Emp Id</label>
				  <div class="col-sm-9">
					<?php echo $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('emp id')])->label(false); ?>
				  </div>
			  </div>
			<div class="form-group">
			  <label class="col-sm-3 control-label" for="inputPassword3">Password</label>
			  <div class="col-sm-9">
				  <?php echo $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false); ?></div>
			</div>
			<div class="form-group">
			 <label class="col-sm-3 hideClass">&nbsp;</label>
			  <div class="col-sm-9 loginNo_margin">
			  <div class="row">
			   <div class="col-sm-6">
				<div class="checkbox homeLogin">				 
					   <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
				</div>
				  </div>
				 <div class="col-sm-6">
				<!--<?php// echo Html::a('Forgot Password?', Url::to([ 'user/request-password-reset']), ['class' => 'pull-right']); ?>-->
			  </div>			
			</div>
		</div>
		</div>
		</div>
		
		<div class="clearfix"></div>
		<div class="modal-footer margin_top10">
		 <div class="row">    
            <div class="col-sm-6 col-xs-6 text-left verifyEmail">
                <?php //echo Html::a('Verify Email?', Url::to([ '/usermgmt/user/send-verify-email']), ['class' => 'pull-right']); ?>                
             </div>
        <div class="col-sm-6 col-xs-6"> <?php echo Html::submitButton('Login', [ 'class' => 'btn btn-primary  logi_submit', 'name' => 'login-button']) ?></div>
        </div>
	   </div>
		
	  </div>
	   </div>
			
    <?php ActiveForm::end();  ?>
</div>
