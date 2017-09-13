<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\app\models\Hollyday */

$this->title = 'Create Hollyday';
$this->params['breadcrumbs'][] = ['label' => 'Hollydays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?> 

<div class="holiday-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
