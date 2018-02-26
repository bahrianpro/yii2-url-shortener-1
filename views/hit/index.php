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
/* @var $searchModel app\models\HitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика переходов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-index">

    <div class="row">
        <div class="col-xs-6">
            <h1 style="margin: 0; line-height: 34px;"><?= $this->title ?></h1>
        </div>
        <div class="col-xs-6">
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Ссылка',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->link->hash, ['link/view', 'id' => $model->link->id]);
                },
                'filter' => false,
            ],
            'ip',
            [
                'label' => 'Местоположение',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model \app\models\Hit  */
                    return $model->country . ' (' . $model->city . ')';
                },
                'filter' => false,
            ],
            [
                'label' => 'ОС',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model \app\models\Hit  */
                    return $model->os . ' ' . $model->os_version;
                },
                'filter' => false,
            ],
            [
                'label' => 'Браузер',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model \app\models\Hit  */
                    return $model->browser . ' ' . $model->browser_version;
                },
                'filter' => false,
            ],
            [
                'attribute' => 'datetime',
                'format' => 'datetime',
                'filter' => false,
            ]
        ]
    ]); ?>
</div>
