<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\jui\DatePicker ;
use yii\web\JsExpression;
use frontend\helpers\DateHelper;
//use frontend\models\CategoriesCosts;


/* @var $this yii\web\View */
/* @var $model frontend\models\ChangePasswordForm */

$this->title = Yii::t('app', 'savings');

?>
<style>
    .cost-table, .cost-table td, .cost-table th{
        border: 1px solid darkolivegreen;
        padding: 5px;
    }
</style>
<div class="row">
    <div class="col-lg-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                Всього: <?= $sumCosts; ?> грн.
            </div>

            <table class=" table">
                <thead>
                <th>Сума</th>
                <th>Опис</th>
                <th>Дата</th>
                <th>Дії</th>
                </thead>
                <tbody>
                <?php foreach($lastRecordSavings as $data) : ?>
                    <tr>
                        <td><?=$data->saving / 100; ?> грн</td>
                        <td><?=$data->description; ?></td>
                        <td><?=DateHelper::formatDate($data->date); ?></td>
                        <td>
                            <a href="<?=Url::toRoute(['/savings/update/' . $data->id]); ?>">
                                <i style="color: #5bc0de; font-size: 18px;" class="fa fa-retweet"></i>
                            </a>
                            <a href="<?=Url::toRoute(['/savings/delete/' . $data->id]); ?>">
                                <i style="color: #d9534f; font-size: 18px;" class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                Фільтр
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs nav-justified">
                    <li role="presentation" class="active"><a href="#">День</a></li>
                    <li role="presentation"><a href="#">Місяць</a></li>
                    <li role="presentation"><a href="#">Рік</a></li>
                </ul>
            </div>
        </div>
        <a href="<?=Url::toRoute('/costs/archive'); ?>" class="btn btn-info">Архів заощаджень</a>
    </div>
    <div class="user-form col-lg-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Додати заощадження</div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin([
                            'method' => 'POST',
                            'enableClientValidation' => false
                        ]); ?>

                        <?= $form->errorSummary($model); ?>

                        <?= $form->field($model, 'goal_id')->dropDownList(
                            $goalsUser,
                            [
                                'prompt'=>'Select...',
                                'class' => 'select-category form-control',
                                'style' => empty($goalsUser) ? 'display: none;' : ''
                            ]);
                        ?>

                        <p class="create-category">
                            Нова ціль <i class="fa fa-plus"></i>
                        </p>
                        <p class="new-category" style="<?= !empty($goalsUser) ? 'display: none;' : ''; ?>">
                            <?=Html::activeTextInput($model, 'createGoal', ['class' => 'form-control']); ?>
                            <br/>
                        </p>


                        <div class="form-group">
                            <?= $form->field($model, 'saving', [
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
                            <?php

                            echo DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'date',
                                'language' => 'uk',
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => [
                                    'readonly' => 'readonly',
                                    'class' => 'form-control'

                                ]
                            ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success col-lg-12', 'name' => 'signup-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
