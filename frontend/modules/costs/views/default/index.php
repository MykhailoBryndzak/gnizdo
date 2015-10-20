<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\jui\DatePicker ;
use frontend\modules\costs\models\CategoriesCosts;
use frontend\modules\costs\models\CategoryCostsUsers;
use frontend\modules\costs\models\search\CostsUsersSearch;

?>

<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">
            Всього: <?= $sumCosts; ?> грн.
        </div>
    </div>
    <button class="btn btn-info" id="addCost">
        Добавити
    </button>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showHeader' => true,
        'layout'=>"{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // Simple columns defined by the data contained in $dataProvider.
            // Data from the model's column will be used.
            [
                'attribute' => 'cost',
                'value' => function($data) {
                    return  $data->cost / 100;
                },
            ],
            [
                'attribute' => 'category_id',
                'filter'=> CategoryCostsUsers::categoriesOfUser(Yii::$app->user->id),
                'value' => function($data) {
                    return CategoriesCosts::getNameCategoryById($data->category_id);
                },
            ],
            'description',
            [
                'attribute' => 'date',
                'value' => function($data) {
                    return CostsUsersSearch::convertDate($data->date);
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'language' => 'uk',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
//                        'readonly' => 'readonly',
                        'class' => 'form-control'

                    ]
                ]),
                'format' => 'html'
            ],
            // More complex one.
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Дії',
                'buttons' => [
                    'update' => function($url, $model) {
//                        $url = Url::toRoute(['/costs/update-cost/' . $model->id]);
                        return \yii\helpers\Html::a('<i style="color: #5bc0de; font-size: 18px;" class="fa fa-retweet"></i>', '#', [
//                            'style' => 'float: left;'
                            'id' => 'update_' . $model->id
                        ]);
                    },
                    'delete' => function($url, $model) {
                        $url = Url::toRoute(['/costs/delete-cost/' . $model->id]);
                        $content = '<i style="color: #d9534f; font-size: 18px;" class="fa fa-times"></i>';
                        return \yii\helpers\Html::a($content, $url);
                    },
                ],
                'template' => '{update} {delete}',
                'contentOptions'=>['style'=>'width: 60px;']
            ],
        ],
    ]);

    ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>

<div id="osx-modal-content" tabindex="-1" role="dialog">
    <div id="osx-modal-title"> Modal Dialog</div>
    <div class="close"><a href="#" class="simplemodal-close">x</a></div>
    <div id="osx-modal-data">
    </div>
</div>



<script type="text/javascript">

</script>