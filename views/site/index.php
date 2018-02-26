<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

/* @var $this yii\web\View */

$this->title = 'Yii2 URL Shortener';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Yii2 URL Shortener</h1>

        <p class="lead">Сервис для создания коротких ссылок.</p>

        <?php
        if (Yii::$app->user->isGuest) {
            echo \yii\helpers\Html::a('Вход на сайт', ['/site/login'], ['class'=>'btn btn-lg btn-success']);
        } else {
            echo \yii\helpers\Html::a('Создать новую ссылку', ['/link/create'], ['class'=>'btn btn-lg btn-success']);
        }
        ?>

    </div>
</div>
