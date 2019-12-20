<?php
/**
 * Frontpage
 */
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\Comments */
/* @var $form ActiveForm */

// Set page title
$this->title = Yii::t('app', 'Future Internet Agency - test task');
?>
<div class="site-index">
    <div class="body-content">
        <div class="comments-index">

            <!-- Render list of all user-entered comments, with pagination -->
            <?php echo
            ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'commentDisplayedInList'],
                // Display individual comment
                // Maps to views/site/_commentInList.php view
                'itemView' => '_commentInList',
                // Disable summary (like "Showing 1-64 of 64 items")
                'summary'=>'',
                'pager' => [
                    'firstPageLabel' => Yii::t('app', 'first'),
                    'lastPageLabel' => Yii::t('app', 'last'),
                    'prevPageLabel' => Yii::t('app', 'previous'),
                    'nextPageLabel' => Yii::t('app', 'next'),
                    'maxButtonCount' => 3,
                ],
            ])
            ?>

            <hr>

            <!-- Comment input form -->
            <h3 class="body-add-comment"><?php echo Yii::t('app', 'Leave Comment') ?></h3>
            <!-- Render comment input form from views/site/_addComment.php view -->
            <?php echo $this->render('_addComment', ['model' => $model]); ?>

        </div>
    </div>
</div>