<?php

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <p style="padding: 10px;">
            Hello,
            <a href="<?=Url::toRoute('/user/update'); ?>">
                <?=Yii::$app->user->identity->username; ?>
            </a>

            <a href="<?=Url::toRoute('/user/logout'); ?>" data-method="post ">
                (Вийти)
            </a>
        </p>
        <ul class="sidebar-nav">
            <li>
                <a href="<?=Url::toRoute('/costs'); ?>">Мої витрати</a>
            </li>
            <li>
                <a href="<?=Url::toRoute('/income'); ?>">Мій заробіток</a>
            </li>
            <li>
                <a href="<?=Url::toRoute('/debts'); ?>">Моя заборгованість</a>
            </li>
            <li>
                <a href="<?=Url::toRoute('/savings'); ?>">Мої заощадження</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
           <?=$content;?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>


<!-- Menu Toggle Script -->
<script>
//    $("#menu-toggle").click(function(e) {
//        e.preventDefault();
//        $("#wrapper").toggleClass("toggled");
//    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
