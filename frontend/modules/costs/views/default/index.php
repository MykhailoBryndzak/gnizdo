<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\jui\DatePicker ;
use frontend\modules\costs\models\CategoriesCosts;
use frontend\modules\costs\models\CategoryCostsUsers;
use frontend\modules\costs\models\search\CostsUsersSearch;

use yii\bootstrap\Modal;

use kartik\popover\PopoverX;
use kartik\helpers\Html;
use kartik\form\ActiveForm;

$this->registerJs("
    $(function() {
       $('.popupModal').click(function(e) {
         e.preventDefault();
         $('#costModal').modal('show').find('.modal-body')
         .load($(this).attr('href'));
       });
    });
");

?>

<?php
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>

<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">
            Всього: <?= CostsUsersSearch::$sum; ?> грн.
        </div>
    </div>

    <?php //\yii\widgets\Pjax::begin(); ?>
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
                    'update' => function($url, $data)
                    {
                        return  Html::a(Yii::t('app', ' {modelClass}', [
                            'modelClass' => '<i style="color: #5bc0de; font-size: 18px;" class="fa fa-retweet"></i>',
                        ]), ['/costs/update/' . $data->id], [
                            'class' => 'popupModal',
                        ]);
                    },
                    'delete' => function($url, $model) {
                        $url = Url::toRoute(['/costs/delete/' . $model->id]);
                        $content = '<i style="color: #d9534f; font-size: 18px;" class="fa fa-times"></i>';
                        return \yii\helpers\Html::a($content, $url, [
                            'data-confirm' => 'Видалити цей запис?',
                            'data-method' =>'POST'
                        ]);
                    },
                ],
                'template' => '{update} {delete}',
                'contentOptions'=>['style'=>'width: 60px;']
            ],
        ],

    ]);

    ?>
    <?php //\yii\widgets\Pjax::end(); ?>
</div>
<!--<div id="osx-modal-content" tabindex="-1" role="dialog">-->
<!--    <div id="osx-modal-title"> Modal Dialog</div>-->
<!--    <div class="close"><a href="#" class="simplemodal-close">x</a></div>-->
<!--    <div id="osx-modal-data">-->
<!--    </div>-->
<!--</div>-->

<div class="col-lg-3">
    <?php

    Modal::begin([
        'header' => '<h3>Добавити витрату</h3>',
        'toggleButton' => [
            'tag' => 'button',
            'class' => 'btn btn-sm btn-block btn-info',
            'label' => 'Добавити',
        ],
    ]);

    echo $this->render('ajaxAdd', [
        'model' => $model,
        'categoriesUser' => $categoriesUser
    ]);

    Modal::end();

    ?>

    <?php
     Modal::begin([
         'header' => '<h3>Обновити витрату</h3>',
         'id' =>'costModal',
     ]);
     Modal::end();
    ?>
</div>
