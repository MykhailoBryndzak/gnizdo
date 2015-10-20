<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\ChangePasswordForm */

$this->title = Yii::t('app', 'Create category costs');

?>

<div class="">
    <div class="row">
        <div class="user-form col-lg-6 well">
            <div class="row">
                <div class="col-lg-5">

                    <?php $form = ActiveForm::begin([
                        'method' => 'POST',
                        'enableClientValidation' => false
                    ]); ?>

                    <?= $form->errorSummary($errors); ?>
                        <?= $form->field($model, 'name')->dropDownList(
                            ArrayHelper::map($categories, 'id', 'name'),
                            ['prompt'=>'Select...', 'class' => 'select-category form-control']);
                        ?>

                    <p class="create-category">
                        Створити категорію <i class="fa fa-plus"></i>
                    </p>
                    <p class="new-category" style="display: none;">
                        <?=Html::activeTextInput($model, 'createCategory', ['class' => 'form-control']); ?>
                    </p>
                    <div class="form-group">
                        <?= Html::submitButton('Добавити', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>

        <div class="col-lg-6">
            <ul class="pull-right list-group">
                <?php foreach($userCategories as $category) : ?>
                    <li class="list-group-item">
                        <?=$category; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>


</div>