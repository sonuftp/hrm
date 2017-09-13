<?php

use yii\helpers\Html;
use yii\grid\GridView;
use vendor\codefire\cfusermgmt\controllers\UserController;
use frontend\models\OhrmAttendanceRecordSearch;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OhrmAttendanceRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ohrm Attendance Records';
$this->params['breadcrumbs'][] = $this->title;

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
               <!--      <p>
        <center><?= Html::a('Create Ohrm Attendance Record', ['creater'], ['class' => 'btn btn-success']) ?> 
        	<?php 		
        		if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){
        			echo Html::a('Panding Attendance', ['panding'], ['class' => 'btn btn-info']);
        		}?>
        </center>
    </p> -->  
        </div>
        <div class="padding5">	
            <div class="col-md-12" id="updateIndex">
			<div class="ohrm-attendance-record-index">
			<?php echo $this->render('_search', ['model' => $searchModel]); ?>
				 <?php if (!empty($data)) { ?>
							<table class="table table-striped table-bordered" >
							<thead>
							<tr>
							<th>#</th>
							<th><a href="#" data-sort="punch_in_date">Date</a></th>
							<th><a href="#" data-sort="punch_in_date">Day</a></th>
							<th><a href="#" data-sort="month">Punch In Time</a></th>
							<th><a href="#" data-sort="month">Punch Out Time</a></th>
							<?php
								if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){
									?>
										<th><a href="#" data-sort="month">Total Hours</a></th>
										<?PHP }?>
							<th><a href="#" data-sort="month">Late</a></th>
							<th><a href="#" data-sort="month">Status</a></th>
							<?php if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS))){

								echo '<th><a href="#" data-sort="month">Action</a></th>';
							}?>
							</tr>
							</thead>
							<tbody>
							<?php 
							$count =1;
							$total_notwork=0;$total_leave=0;$total_absent=0;$total_present=0;$total_holiday=0;
					         //print_r($data[0]['date']);exit;
					         $toal_late_mark=0;
					         $total_levy_time=0;
							foreach($data as $key => $value)
							{
								if($value['status']=='Not Working')
								{
								echo "<tr   style='background-color:#F0F8FF'>";
								$total_notwork++;
								}
								elseif($value['status']=='leave')
								{
								echo "<tr   style='background-color:#F5F5DC'>";
								$total_leave++;
								}
								elseif($value['status']=='Absent')
								{
								echo "<tr   style='background-color: PowderBlue  '>";
								$total_absent++;
								}
								elseif($value['status']=='')
				 				{
									echo "<tr>";
									$total_present++;
								}
								else
								{
								echo "<tr   style='background-color: PowderBlue  '>";
								$total_holiday++;
								}
								echo "<td>".$count++."</td>";
								echo "<td>".$value['date']."</td>";
								echo "<td>".$value['day']."</td>";
								
								if($value['in_time'] != '-')
								{  
									$dateOne = new DateTime($value['in_time']);
									$in_time = $dateOne->format('H:i:s');
								}
								else
									$in_time ='-';
								echo "<td>".$in_time."</td>";
								if($value['out_time'] != '-')
								{
									$dateTwo = new DateTime($value['out_time']);
									$out_time = $dateTwo->format('H:i:s');
								}
								else
									$out_time ='-';
								echo "<td>".$out_time."</td>";
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
								    	if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS)))
								    	
											echo "<td>".$t_hours."</td>";
								 
									if(strtotime($t_hours) == '')
									{
										
										echo "<td>  </td>";	
									}
      
                                    $data=(end($DefaultTime));
                                    $lastDefaultDate=$data['date'];
                                    $lastDefaultTime=$data['time'];
                         
                         ////begin added by rabendra
                           if(empty($value['status']))  
                           {      
                                    foreach ($DefaultTime as $key => $val) {
                      
									if (strtotime($value['date']) <= strtotime($val['date']))
									{	
										if (strtotime($in_time) > strtotime($val['time']))
										{
									     echo "<td style='color:red'> Yes </td>";
											$toal_late_mark++;
											$arrival_time=new DateTime($in_time);
											$levy_time=$arrival_time->diff(new DateTime($val['time']));
											if($levy_time->h >=1)
											{
												$total_minut=($levy_time->h)*60;
												$total_levy_time +=$total_minut;
											}
											
											$total_levy_time+=$levy_time->i;
									     
										}
										else
										{
											echo "<td> No </td>";
									     
										}
										break;

								  	}
								  	elseif(strtotime($value['date']) >= strtotime($lastDefaultDate))
								  	{
								  		if (strtotime($in_time) > strtotime($lastDefaultTime))
										{
									     echo "<td style='color:red'> Yes </td>";
									     $toal_late_mark++;
											$arrival_time=new DateTime($in_time);
											$levy_time=$arrival_time->diff(new DateTime($val['time']));
											if($levy_time->h >=1)
											{
												$total_minut=($levy_time->h)*60;
												$total_levy_time +=$total_minut;
											}
											
											$total_levy_time +=$levy_time->i;
										}
										else
										{
											echo "<td> No </td>";
									     
										}
								
										break;

								  	}
																 	
                                 }
                            }

                            ////end added by rabendra
								  echo "<td>".ucwords($value['status'])."</td>";
									if($value['status']!='')
									{
										if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS)))
											echo "<td></td>";
									}
									else
									{
										if(in_array(USER_ROLE, array(SUPERADMIN_ROLE_ALIAS, ADMIN_ROLE_ALIAS)))
										echo '<td>'.Html::a('<span class="glyphicon glyphicon-edit"></span>', ['view', 'id'=>$value['id']]).'</td>';	
									}
								
					              echo "</tr>";
							} ?>
							</tbody>
							</table>
					
                           <table class="table table-striped table-bordered">
                             <tr>
                           	  <th>Total Working Days</th>
                           	  <th>Total Presents </th>
                           	  <th>Total Absents</th>
                           	  <th>Total Leaves</th>
                           	  <th>Total Holidays</th>
                           	  <th>Total Late Marks</th>
                           	  <th>Levy Time used</th>
                             </tr>
                             <tr>
                             	<td style="color:blue;"><?php echo $total_present+$total_absent+$total_leave ;?></td>
                             	<td style="color: green"><?php echo $total_present; ?></td>
                             	<td style="color:red;"><?php echo $total_absent; ?></td>
                             	<td style="color:rgb(255,100,100);"><?php echo $total_leave; ?></td>
                             	<td style="color:red;"><?php echo $total_holiday; ?></td>
                             	<td style="color:red;"><?php echo $toal_late_mark; ?></td>
                             	<td style="color:red;"><?php if($total_levy_time > 45){echo'More than 45 minutes';}else{echo ($total_levy_time <10)?"$total_levy_time minute":"$total_levy_time minutes";}?></td>
                             </tr>
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
