<?php

use yii\helpers\Html;
use yii\grid\GridView;
use vendor\codefire\cfusermgmt\models\User;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OhrmAttendanceRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ohrm Attendance Records';
$this->params['breadcrumbs'][] = $this->title;
// print_r($data);
// exit;
?>
<style>
        .glyphicon {font-size: 16px; margin-right: 3px;}
</style>

<div class="container">
    <div class="radius_box">
        <div class="row">
            <div class="col-md-12">
				<h2 class="dasbordTitle">
                        <?php echo $this->title; ?>
                </h2>
            </div>
            <p>
        <!-- <center><?= Html::a('Create Ohrm Attendance Record', ['creater'], ['class' => 'btn btn-success']) ?></center> -->
    </p>
                
        </div>
        <div class="padding5">	
            <div class="col-md-12" id="updateIndex">
			<div class="ohrm-attendance-record-index">
			
				 <?php if (!empty($data)) { ?>
							<table class="table table-striped table-bordered" >
							<thead>
							<tr>
							<th>#</th>
							<th><a href="#" data-sort="punch_in_date">Name</a></th>
							<th><a href="#" data-sort="punch_in_date">Date</a></th>
							<th><a href="#" data-sort="punch_in_date">Day</a></th>
							<th><a href="#" data-sort="month">Punch In Time</a></th>
							<th><a href="#" data-sort="month">Punch In Note</a></th>
							<th><a href="#" data-sort="month">Punch Out Time</a></th>
							<th><a href="#" data-sort="month">Punch Out Note</a></th>
							<th><a href="#" data-sort="month">Total Hours</a></th>
							<th><a href="#" data-sort="month">Action</a></th>
							</tr>
							</thead>
							<tbody>
							<?php 
							$count =1;
							foreach($data as $key => $value)
							{
								if($value['state']=='Not Working')
								{
								echo "<tr   style='background-color: red'>";
								}
								else
								{
									echo "<tr>";
								}
								echo "<td>".$count++."</td>";


                                $username=User::getName($value['employee_id']);
								echo "<td>".$username."</td>";
								echo "<td>".$value['punch_in_date']."</td>";
								$date = new DateTime($value['punch_in_date']);
								//echo $date->format('d/m/Y');

								echo "<td>".$date->format('D')."</td>";
									$dateOne = new DateTime($value['punch_in_user_time']);
									$in_time = $dateOne->format('H:i:s');
								
								echo "<td>".$in_time."</td>";
								echo "<td>".$value['punch_in_note']."</td>";
								
									$dateTwo = new DateTime($value['punch_out_user_time']);
									$out_time = $dateTwo->format('H:i:s');
								
								
								echo "<td>".$out_time."</td>";
								echo "<td>".$value['punch_out_note']."</td>";
								if($in_time !='-' || $out_time !='-')
								{
									if($dateTwo->format('H') == 0 )
									{
										$t_hours = '-';
									}
									else
									{
										$interval = $dateTwo->diff($dateOne);
										$time = new DateTime($interval->h.":".$interval->i.":".$interval->s);
										$t_hours = $time->format('H:i:s');
									}
								}
								else
									$t_hours ='-';
								echo "<td>".$t_hours."</td>";							
								echo "<td>".Html::a(Yii::t('app', '<span class="glyphicon glyphicon-ok"></span>'), ['accept', 'id' => $value['id']],
								 	['data' => ['confirm' => 'Are you sure want to Accept ?','method' => 'post',]])."
								 ".Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash"></span>'), ['reject', 'id' => $value['id']],
								 	['data' => ['confirm' => 'Are you sure want to Reject this request?','method' => 'post',]])."</td>";
								
								echo "</tr>";
							} ?>
							</tbody>
							</table>
                    <?php } else {
                        echo "<div class='loans text-center'>No Attendance Found.</div>";
                    }
                    ?>	
				 
					
			</div>
            </div>
        </div>
                    
	</div>
</div>
