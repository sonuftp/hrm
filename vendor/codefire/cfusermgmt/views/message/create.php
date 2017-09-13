<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Message */

$this->title = 'Create Message';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
        <div class="radius_box">
            <div class="row">
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
	</div>
</div>
