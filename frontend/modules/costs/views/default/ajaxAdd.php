<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\helpers\Url;
use yii\jui\AutoComplete;
//use yii\jui\DatePicker ;
use yii\web\JsExpression;
use frontend\helpers\DateHelper;

//use yii\bootstrap\Modal;
//use kartik\form\ActiveForm;
use kartik\date\DatePicker;

?>

<div class="panel-body">
    <?php $form = ActiveForm::begin([
        'id' => 'contact-form',
        'method' => 'POST',
        'action' => 'costs/archive',
        'enableAjaxValidation' => true
    ]); ?>
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        $categoriesUser,
        ['prompt'=>'Select...', 'class' => 'select-category form-control']);
    ?>

    <p class="create-category">
        Моя категорія <i class="fa fa-plus"></i>
    </p>
    <p class="new-category" style="display: none;">
        <?=Html::activeTextInput($model, 'createCategory', ['class' => 'form-control']); ?>
        <br/>
    </p>
    <div class="form-group">
        <?= $form->field($model, 'cost', [
            'inputOptions' => [
                'class' => 'numericOnly form-control',
                'placeholder' => '0.00'
            ]
        ]); ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'description')->textarea(); ?>
    </div>
    <div class="form-group">
        <input type="text" value="<?=$model->date; ?>" name="CostsUsers[date]" id="idTourDateDetails" readonly="readonly" class="form-control clsDatePicker">
    </div>
    <?= Html::hiddenInput('CostsUsers[id]', $model->id); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success col-lg-12', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>




