<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\app\models\Hollyday */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hollydays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<style>.form-group {margin-bottom: 8px;}</style>
	<div class="container">
	<div class="radius_box mobile-radius_box">
	<div class="modal-header">      
		<h4 class="modal-title"><?php echo $this->title; ?></h4>
	</div>
	<div class="modal-body">
			<div class="row">
			<div class="form-group col-lg-6 col-md-6">
					<div class="col-xs-8">
																		
								<p>
									<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
									<?= Html::a('Delete', ['delete', 'id' => $model->id], [
										'class' => 'btn btn-danger',
										'data' => [
											'confirm' => 'Are you sure you want to delete this item?',
											'method' => 'post',
										],
									]) ?>
								</p>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="form-group col-lg-4 col-md-6">
					<div class="col-xs-20">
							<div class="hollyday-view">
											<?= DetailView::widget([
												'model' => $model,
												'attributes' => [
													
													'date',
													'description',
													
												],
											]) ?>

										</div>
					</div>
			</div>
			</div>

		</div>
	   </div>
		
		</div>

