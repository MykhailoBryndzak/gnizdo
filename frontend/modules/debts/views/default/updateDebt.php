<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

use yii\jui\AutoComplete;
use yii\jui\DatePicker ;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model frontend\models\ChangePasswordForm */

$this->title = Yii::t('app', 'Update debt');

?>

<div class="user-profile-change-password">

    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row">
        <div class="user-form col-lg-6">
            <div class="row">
                <div class="col-lg-5">

                    <?php $form = ActiveForm::begin([
                        'method' => 'POST'
                    ]); ?>

                    <?= $form->errorSummary($model); ?>


                    <div class="form-group">
                        <?= $form->field($model, 'debt', [
                            'inputOptions' => [
                                'class' => 'numericOnly',
                                'placeholder' => '0.00'
                            ]
                        ]); ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'who_lent', [
                            'inputOptions' => [
                                'placeholder' => 'name'
                            ]
                        ]); ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'description')->textarea(); ?>
                    </div>

                    <div class="form-group">
                        <?php

                        echo DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'date_debts',
                            'language' => 'uk',
                            'dateFormat' => 'yyyy-MM-dd',
                            'options' => [
                                'readonly' => 'readonly'

                            ]
                        ]);
                        ?>

                    </div>


                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>

    </div>


</div>
