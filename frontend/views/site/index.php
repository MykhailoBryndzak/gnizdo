<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <?=Html::a('вхід', 'javascript:void(0);'); ?>
            </div>
            <div class="col-lg-6">
                <?=Html::a('реєстрація', 'javascript:void(0);'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username',[
                'inputOptions' => [
                    'placeholder' => 'Ваш email'
                ],
            ])->label(false); ?>
            <?= $form->field($model, 'password', [
                'inputOptions' => [
                    'placeholder' => 'Ваш пароль'
                ]
            ])->passwordInput()->label(false); ?>
            <div style="color:#999;margin:1em 0">
                If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
            </div>
            <div class="form-group">
                <?= Html::submitButton('Увійти', ['class' => 'btn btn-primary col-lg-12', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>