<?php

use yii\helpers\Url;

?>
<style>
    .cost-table, .cost-table td, .cost-table th{
        border: 1px solid darkolivegreen;
        padding: 5px;
    }
</style>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">
            Всього: <?= $sumIncome; ?> грн.
        </div>
      <table class="table">
          <thead>
            <th>Сума</th>
            <th>Опис</th>
            <th>Дата</th>
            <th>Дії</th>
          </thead>
          <tbody>
            <?php foreach($incomeUser as $data) : ?>
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
</div>


