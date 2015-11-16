<?php

use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;

use yii\helpers\Url;

use kartik\form\ActiveForm;
use kartik\date\DatePicker;


?>

<div class="panel-body">


    <?php $form = ActiveForm::begin([
//        'method' => 'POST',
        'action' => '/costs/update/' . $model->id,
        'id' => 'costs-users',
//        'enableAjaxValidation' => true,
//        'enableClientValidation' => true,
        'validateOnSubmit'     => true,
    ]); ?>

    <?php

    echo ($form->errorSummary($model));

    ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        $categoriesUser,
        [
            'prompt'=>'Select...',
            'class' => 'form-control',
        ]);
    ?>

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
    <div class="col-sm-6">
        <?= DatePicker::widget([
            'name'=>'CostsUsers[date]',
            'value' => date('Y-m-d'),
            'options'=>[
                'placeholder'=>'Select Date...'
            ],
            'pluginOptions'=>[
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ]); ?>
    </div>

    <?= Html::hiddenInput('CostsUsers[id]', $model->id); ?>
    <div class="form-group">
        <button class='btn btn-success col-lg-12'>Save</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>




