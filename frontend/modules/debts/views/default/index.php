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

$this->title = Yii::t('app', 'Debts');

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
                Всього винен: <?= $sumDebts; ?> грн.
            </div>

            <table class=" table">
                <thead>
                    <th>Сума</th>
                    <th>Кому винен</th>
                    <th>Опис</th>
                    <th>Дата позики</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </thead>
                <tbody>
                <?php foreach($debtsUser as $data) : ?>
                    <tr>
                        <td><?=$data->debt / 100; ?> грн</td>
                        <td><?=$data->who_lent; ?></td>
                        <td><?=$data->description; ?></td>
                        <td><?=$data->date_debts; ?></td>
                        <td>
                            <a href="<?=Url::toRoute('/debts/change-status/' . $data->id); ?>">
                                <?=$data->status == 0 ?
                                    '<i style="color: #f0ad4e; font-size: 18px;" class="fa fa-exclamation-triangle"></i>' :
                                    '<i style="color: #5cb85c; font-size: 18px;" class="fa fa-check-square-o"></i>' ; ?>
                            </a>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-lg-2">
                                    <a href="<?=Url::toRoute(['/debts/update-debt/' . $data->id]); ?>">
                                        <i style="color: #5bc0de; font-size: 18px;" class="fa fa-retweet"></i>
                                    </a>
                                </div>
                                <div class="col-lg-2">
                                    <a href="<?=Url::toRoute(['/debts/delete-debt/' . $data->id]); ?>">
                                        <i style="color: #d9534f; font-size: 18px;" class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>



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
    </div>
    <div class="user-form col-lg-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Додати витрату</div>
                    <div class="panel-body">
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
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success col-lg-12', 'name' => 'signup-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
