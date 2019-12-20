<?php

/* If you've operational YII2 model, you only need this controller to create basic REST API
 * Class name maps to yoursite.com/commentrest URL
 * Validation rules are set for model, they'll be respected.
 * If you want to receive JSON requests, you should modify config/web.php file like this:
 * $config = [
 *   ...
 *   'components' => [
 *       'request' => [
 *           ...
 *           'parsers' => [
 *               'application/json' => 'yii\web\JsonParser',
 *           ]
 *       ],
 */

namespace app\controllers;

use yii\rest\ActiveController;

class CommentrestController extends ActiveController
{
    public $modelClass = 'app\models\Comments';
}

