<?php
/**
 * Individual comment to be displayed in a list of all comments
 */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="commentInList">
    <!-- Html::encode gives us plain text -->
    <span class="commentInList-UName"><?php echo Html::encode($model->user_name) ?></span>
    <span class="commentInList-Date"><?php echo Html::encode(Yii::$app->formatter->asDate($model->time_created, 'HH:mm dd.MM.yyyy')) ?></span>
    <br>
    <!-- HtmlPurifier::process gives us relatively safe HTML subset -->
    <span class="commentInList-Text"><?php echo HtmlPurifier::process($model->comment_text) ?></span>
    <br>
</div>