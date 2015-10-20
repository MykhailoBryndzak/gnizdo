<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\jui\DatePicker ;
use yii\web\JsExpression;
//use frontend\models\CategoriesCosts;


/* @var $this yii\web\View */
/* @var $model frontend\models\ChangePasswordForm */

$this->title = Yii::t('app', 'Income');

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
                Всього: <?= $sumIncome; ?> грн.
            </div>

            <table class=" table">
                <thead>
                <th>Сума</th>
                <th>Опис</th>
                <th>Дата</th>
                <th>Дії</th>
                </thead>
                <tbody>
                <?php foreach($lastRecordIncome as $data) : ?>
                    <tr>
                        <td><?=$data->income / 100; ?> грн</td>
                        <td><?=$data->description; ?></td>
                        <td><?=$data->date; ?></td>
                        <td>
                            <a href="<?=Url::toRoute(['/income/update-income/' . $data->id]); ?>">
                                <i style="color: #5bc0de; font-size: 18px;" class="fa fa-retweet"></i>
                            </a>
                            <a href="<?=Url::toRoute(['/income/delete-income/' . $data->id]); ?>">
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
        <a href="<?=Url::toRoute('/income/archive'); ?>" class="btn btn-info">Архів заробітку</a>
        <a href="<?=Url::toRoute('/income/create-category'); ?>" class="btn btn-info">Категорії</a>
    </div>
    <div class="user-form col-lg-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Додати заробіток</div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin([
                            'method' => 'POST',
                            'enableClientValidation' => false
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
                            <?= $form->field($model, 'income', [
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
