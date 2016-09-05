<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$this->title = Yii::t('app', 'Create Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
