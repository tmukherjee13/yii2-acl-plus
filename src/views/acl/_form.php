<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\acl\models\Acl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acl-form">

    <?php $form = ActiveForm::begin(); ?>


    <?=$form->field($model, 'user_id')->dropdownList(
            ArrayHelper::map(\common\modules\user\models\User::findAll(['status'=>1]), 'id', 'username'),
            ['prompt' =>' None ', 'class' => 'form-control']
        )?>

   
    <?=$form->field($model, 'menu_id')->dropdownList(
            ArrayHelper::map(\backend\modules\menu\models\Menu::findAll(['status'=>1]), 'id', 'name'),
            ['prompt' =>' None ', 'class' => 'form-control']
        )?>

   

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
