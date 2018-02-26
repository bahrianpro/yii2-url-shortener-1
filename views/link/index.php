<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список ссылок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-index">

    <div class="row">
        <div class="col-xs-6">
            <h1 style="margin: 0; line-height: 34px;"><?= $this->title ?></h1>
        </div>
        <div class="col-xs-6">
            <p class="text-right">
                <?= Html::a('Создать новую ссылку', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'url',
            'description',
            'short_url',
            'counter',
            [
                'attribute' => 'expiration',
                'format' => 'date',
                'filter' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'buttonOptions' => [
                    'class' => 'action-button'
                ]
            ]
        ]
    ]); ?>
</div>
