<?php

use yii\helpers\Html;
use yii\helpers\Json;
use mdm\admin\AnimateAsset;


/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\Menu */

$this->title = Yii::t('app', 'Assign Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$opts = Json::htmlEncode([
    'menus' => $menus
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-sm-5">
        <div class="input-group">
            <input class="form-control search" data-target="avaliable"
                   placeholder="<?= Yii::t('app', 'Search for avaliable') ?>">
            <span class="input-group-btn">
                <?= Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['refresh'], [
                    'class' => 'btn btn-default',
                    'id' => 'btn-refresh'
                ]) ?>
            </span>
        </div>
        <select multiple size="20" class="form-control list" data-target="avaliable"></select>
    </div>
    <div class="col-sm-1">
        <br><br>
        <?php $id = Yii::$app->getRequest()->getQueryParam('id') ?>
        <?= Html::a('&gt;&gt;' . $animateIcon, ['assign','id' => (string)$id], [
            'class' => 'btn btn-success btn-assign',
            'data-target' => 'avaliable',
            'title' => Yii::t('app', 'Assign')
        ]) ?><br><br>
        <?= Html::a('&lt;&lt;' . $animateIcon, ['remove','id' => (string)$id], [
            'class' => 'btn btn-danger btn-assign',
            'data-target' => 'assigned',
            'title' => Yii::t('app', 'Remove')
        ]) ?>
    </div>
    <div class="col-sm-5">
        <input class="form-control search" data-target="assigned"
               placeholder="<?= Yii::t('app', 'Search for assigned') ?>">
        <select multiple size="20" class="form-control list" data-target="assigned"></select>
    </div>
</div>


