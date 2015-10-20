<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ChangePasswordForm */

$this->title = Yii::t('app', 'Update password');

?>
<div class="user-profile-change-password">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">
        <div class="row">
            <div class="col-lg-5">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>

</div>