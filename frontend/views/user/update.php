<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Update profile';

?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <a href="<?=Url::toRoute('user/change-password'); ?>">Change password</a>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
