<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SourceMessage */

$this->title = 'Update Source Message: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Source Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">
        <div class="radius_box">
            <div class="row">
<div class="source-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
	</div>
</div>