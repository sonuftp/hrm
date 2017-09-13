<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use frontend\widgets\Alert;
use vendor\codefire\cfusermgmt\helper\SearchHelper;
use vendor\codefire\cfusermgmt\helper\PageSize;

$model = new vendor\codefire\cfusermgmt\models\User;

$this->title = 'Upcoming Birthdays';
?>
<?php if (!Yii::$app->request->isAjax) { ?>
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
            </div>
            <div class="padding5">	
                <div class="col-md-12" id="updateIndex">
					
                <?php } ?>
                <?php if (!empty($models)) { ?>    
                    <?php \yii\widgets\Pjax::begin(['enablePushState' => true]); ?>
                    <?php echo PageSize::widget(['defaultPageSize'=>DEFAULT_PAGE_SIZE]); ?>
                    <?=
                    \yii\grid\GridView::widget([
                        'id' => 'gridId',
                        'dataProvider' => $activeDataProvider,
                        'pager' => ['class' => 'yii\widgets\LinkPager', 'lastPageLabel' => 'Last', 'firstPageLabel' => 'First', 'options' => ['class' => 'pagination']],
                        'emptyCell' => '-',
                        'filterSelector' => 'select[name="count"]',
                        'rowOptions' => function ($model, $key, $index, $column) {
                        return ['id' => 'rowId' . $model->id, 'class' => (($model->status == ACTIVE) ? 'success' : 'danger')];
                    },
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'label' => 'User ID', 'format' => 'raw',
                                'value' => function ($model, $key, $index, $column) {
                                    return Html::encode($model->id);
                                }
                            ],
                            [
                                'attribute' => 'first_name',
                                'label' => 'Name',
                                'value' => function ($model, $key, $index, $column) {
                                    return Html::encode($model->first_name . ' ' . $model->last_name);
                                }
                            ],
                            [
                                'attribute' => 'email',
                                'label' => 'Email',
                                'value' => function ($model, $key, $index, $column) {
                                    return Html::encode($model->email);
                                }
                            ],
                            [
                                'attribute' => 'username',
                                'label' => 'Username',
                                'value' => function ($model, $key, $index, $column) {
                                    return Html::encode($model->username);
                                }
                            ],
							[
                                'attribute' => 'birth',
                                'label' => 'Birth Date', 'format' => 'raw',
                                'value' => function ($model, $key, $index, $column) {
									//echo $model->birth,"<br>";
									$b_date = new DateTime($model->birth);
									
									/*
									$class = 'yellow';
									
									if(date('d') > $b_date->format('d'))
										$class = 'red';
									elseif(date('d') < $b_date->format('d'))
										$class = 'green';*/
									$class = 'green';
									if(date('m') > $b_date->format('m'))
											$class='red';
									else if( date('m') == $b_date->format('m'))
									{
										if(date('d') < $b_date->format('d'))
											$class = 'green';
										else if(date('d') == $b_date->format('d'))
										{
												$class = 'blue';
												
										}
										elseif(date('d') > $b_date->format('d'))
											$class = 'red';
									}
									else if(date('m') < $b_date->format('m'))
									{
										$class = 'green';
									}
									
									
									return Html::tag('p', Html::encode($model->birth), ['class' => $class]);
                                }
                            ]
                        ],
                    ]);  
                                ?>
                                
                     <?php \yii\widgets\Pjax::end(); ?>
                        <?php
                    } else {
                        echo "<div class='loans text-center'>No Users Found.</div>";
                    }
                    ?>
                        
                    </div>
                    </div>
                    
                    </div>
                </div>
<style>
.red {
    color: red;
	font-weight: bold;
}
.green {
    color: green;
	font-weight: bold;
}
.yellow {
    color: yellow;
	font-weight: bold;
}.blue {
    color: blue;
	font-weight: bold;
}
</style>