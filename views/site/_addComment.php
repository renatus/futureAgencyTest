<?php
/**
 * Form to add new comments
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="add-comment">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'comments',
        'method' => 'post',
        'action' => ['site/add-comment'],
    ]); ?>

    <?php echo $form->field($model, 'user_name') ?>
    <?php echo $form->field($model, 'comment_text')->textarea(['rows' => '6']) ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary add-comment-submit']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>