<?php
/**
 *  Standard layout to be used by many pages of this site
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?php echo Yii::$app->language ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?php echo Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <!-- Header -->
        <?php
        NavBar::begin([
            'options' => [
                'class' => 'navbar-fixed-top',
            ],
        ]);
        ?>

        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-left navbar-left-text">
                    <p class="text-contacts"><?php echo Yii::t('app', 'Telephone: ') ?>
                        <a class="text-underlined" href="tel: +74993409471">(499) 340-94-71</a>
                    </p>
                    <p class="text-contacts"><?php echo Yii::t('app', 'Email: ') ?>
                        <a class="text-underlined" href="mailto: info@future-group.ru">info@future-group.ru</a>
                    </p>
                    <h2 class="header-comments"><?php echo Yii::t('app', 'Comments') ?></h2>
                </div>

                <a class="navbar-brand" href="#">
                    <img alt="Brand" src="/images/Future_logo.png">
                </a>
            </div>
        </nav>

        <?php NavBar::end() ?>

        <!-- Content -->
        <div class="container page-content-main">
            <!-- Display page content itself -->
            <?php echo $content ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">

            <a class="footer-brand" href="#">
                <img alt="Brand" src="/images/Future_logo.png">
            </a>

            <p class="text-contacts"><?php echo Yii::t('app', 'Telephone: ') ?>
                <a class="text-underlined" href="tel: +74993409471">(499) 340-94-71</a>
            </p>
            <p class="text-contacts"><?php echo Yii::t('app', 'Email: ') ?>
                <a class="text-underlined" href="mailto: info@future-group.ru">info@future-group.ru</a>
            </p>
            <p class="text-contacts"><?php echo Yii::t('app', 'Address: ') ?>
                <a class="text-underlined" href="https://future-group.ru/contact/">115088 Москва, ул. 2-я Машиностроения, д.
                    7 стр. 1</a>
            </p>
            <p class="text-copyright"><?php echo Yii::t('app', '&copy; 2010 - 2014 Future. All rights reserved') ?></p>

        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>