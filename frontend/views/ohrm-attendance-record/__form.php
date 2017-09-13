<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\OhrmAttendanceRecordSearch;
use frontend\models\OhrmAttendanceRecord;
use kartik\time\TimePicker;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\OhrmAttendanceRecord */
/* @var $form yii\widgets\ActiveForm */
//print_r($model->id);exit;
?>

<!-- <div class="ohrm-attendance-record-form"> -->
<div class="container">
	<div class="radius_box" style="height:400px">
        <div class="row">
            <div class="col-md-12">
				<h2 class="dasbordTitle">
                        <?php echo "Update Attendance" ?>
                </h2>
            </div>
        </div>
    <?php $form = ActiveForm::begin(); ?>
		<?php if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){?>
			<div class="row">
			 <label class="col-sm-3 control-label" for="employee_id">Employee Name</label>
					<div class="col-sm-3">
						<?php
							$listData=OhrmAttendanceRecordSearch::getUserList();
							$do=$form->field($model, 'employee_id')->dropDownList($listData,['prompt'=>'select'])->label(false);
							echo $do;
						?>
					</div>				
			</div>
	    <?php }
	?>
			<div class="row">
			  <label class="col-sm-3 control-label" for="punch_in_user_time">Punch In Time </label>
				<div class="col-sm-3">
					<?= TimePicker::widget(['model' => $model, 'attribute' => 'punch_in_user_time', 'pluginOptions' =>[
		            'showSeconds' => true,
			        'showMeridian' => false,
			        'minuteStep' => 1,
			        'secondStep' => 5,
		            ],] );?>   
		       </div>	
			</div>
		<div class="row">
		 <label class="col-sm-3 control-label" for="punch_out_user_time">Punch Out Time </label>
			<div class="col-sm-3">
				<?= TimePicker::widget(['model' => $model, 'attribute' => 'punch_out_user_time', 'pluginOptions' =>
	            [
	              'showSeconds' => true,
		        'showMeridian' => false,
		        'minuteStep' => 1,
		        'secondStep' => 5,
	            ],] );?>
			</div>		
	    </div>

	    <div class="row">
			  <label class="col-sm-3 control-label" for="punch_in_date">Punch Date</label>
				<div class="col-sm-3">
					<?= $form->field($model,'punch_in_date')->widget(DatePicker::className(),['clientOptions' => ['defaultDate' => 'today'],'dateFormat' => 'yyyy-MM-dd'])->label(false) ?>
				</div>
			</div>
   
   
   
    <div class="row">
       <div class="col-sm-2">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
<!-- </div> -->
