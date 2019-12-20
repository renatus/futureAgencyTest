<?php
/**
 * Page to display when we've failed to add new comment
 */

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t("app", "Failed to add comment");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Yii::t("app", "We have failed to save your comment. Please, try again later!") ?>
    </p>

</div>