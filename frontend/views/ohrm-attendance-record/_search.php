<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\OhrmAttendanceRecordSearch;
use frontend\models\OhrmAttendanceRecord;
use yii\helpers\ArrayHelper;
use yii\web\UrlManager;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\OhrmAttendanceRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<style>.form-group {margin-bottom: 8px;}</style>
 <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
<div class="row">
<div class="ohrm-attendance-record-search">
		<?php if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){?>
		<div class="form-group col-lg-3 col-md-6">
		<label class="col-sm-5 control-label">Name</label>
				<div class="col-sm-6">
	            <?php 
					$listData=OhrmAttendanceRecordSearch::getUserList();

					$do=$form->field($model, 'employee_id')->dropDownList($listData,
						[
						   'prompt'=>"Select",
						])->label(false);
					    echo $do;
				?>

			</div>				
		</div>
			<?php } ?>
			
			
    	<div class="form-group col-lg-3 col-md-6">

				<div class="col-sm-6">
					<?php echo $form->field($model, 'year')->dropDownList(OhrmAttendanceRecord::findYearsOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label($model->getAttributeLabel('Year'));?>
				 
			</div>			
			</div>	
			<div class="form-group col-lg-3 col-md-6">

				<div class="col-sm-6">
					
				<?php echo $form->field($model, 'month')->dropDownList(OhrmAttendanceRecord::findMonthsOptions(),['class' =>'form-control','prompt'=>'Please Select'])->label($model->getAttributeLabel('Month'));?>
		  
				</div>				
			</div>		
			<div class="form-group col-lg-3 col-md-6">
				<div class="col-sm-6">
				<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
				</div>				
			</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script >
    
       $(document).ready(function(){        
         var joiningDate=0;
         var currentDate = new Date().toISOString().slice(0,10);
         $("#ohrmattendancerecordsearch-employee_id").change(function(){
	       var datastring ='id=' + $(this).val();
		   $.ajax({
		      type:"GET",
		      cache:false,
		      url:'<?php echo Url::to(['/ohrm-attendance-record/joining']) ;?>',    
		      data:datastring,
		      success: function (result){
		      joiningDate=result;
		      }}); 
           });

         $("#ohrmattendancerecordsearch-from_date").change(function(){
           var fromDate = Date.parse(document.getElementById('ohrmattendancerecordsearch-from_date').value);
            if(fromDate < Date.parse(joiningDate)){
           	$("#ohrmattendancerecordsearch-from_date").val(joiningDate);
            }
            $("#ohrmattendancerecordsearch-to_date").val(currentDate);  
          });

        $("#ohrmattendancerecordsearch-to_date").change(function(){
         var fromDate = Date.parse(document.getElementById('ohrmattendancerecordsearch-from_date').value);
         var toDate = Date.parse(document.getElementById('ohrmattendancerecordsearch-to_date').value);
          if(fromDate > toDate){
           alert("Please Select Correct date in To Date");
           $("#ohrmattendancerecordsearch-to_date").val(currentDate);
           }
           else if(toDate> Date.parse(currentDate))
           {
               $("#ohrmattendancerecordsearch-to_date").val(currentDate);
           }
        });
    });
</script>
