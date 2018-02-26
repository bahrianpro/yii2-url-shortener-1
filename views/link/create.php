<?php
/**
 * Yii2 URL Shortener
 *
 * @copyright Copyright &copy; Sergey Kupletsky, 2018
 * @license MIT
 * @author Sergey Kupletsky <s.kupletsky@gmail.com>
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Link */

$this->title = 'Создать короткую ссылку';
$this->params['breadcrumbs'][] = ['label' => 'Короткие ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="link-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'expiration')->widget(
            \kartik\date\DatePicker::class, [
            'type' => \kartik\date\DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format'    => 'dd.mm.yyyy'
            ]
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton('Уменьшить и сохранить', ['class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
