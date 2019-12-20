<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Comments;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            // Processes unresolvable URLs among other
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // List of all comments, with pagination
        $dataProvider = new ActiveDataProvider([
            'query' => Comments::find(),
            'pagination' => [
                // 10 comments per page
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    // Show newest comments first
                    'comment_id' => SORT_DESC,
                ]
            ],
        ]);

        // Render page
        $model = new Comments();
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Comments model
     * Maps to action ID "add-comment"
     * http://yoursite.com/site/add-comment
     *
     * @return mixed
     */
    public function actionAddComment()
    {
        $model = new Comments();
        // Yii CSRF protection is enabled by default.
        // Active Record properly uses PDO prepared statements,
        // so nothing to do to prevent SQL injections.
        // If you use raw queries or query builder instead,
        // you yourself have to use safe ways of passing data.
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // New comment was saved successfully
            return $this->redirect(['index']);
        }

        // We've faced an error trying to save new comment
        // Add message to YII2 app's error log
        Yii::error('Failed to save user-entered comment. Details below.');
        // Render error page
        return $this->redirect(['site/failed-to-add-comment']);
    }

    /**
     * Displays "Failed To Add A Comment" page.
     *
     * @return string
     */
    public function actionFailedToAddComment()
    {
        return $this->render('failedToAddComment');
    }
}