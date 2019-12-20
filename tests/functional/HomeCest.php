<?php

/**
 * Functional tests for site's frontpage
 * Form to add comments is also being tested
 */
class HomepageCest
{
    public function _before(\FunctionalTester $I)
    {
        // Go to site's frontpage
        $I->amOnPage(['site/index']);
    }

    // Frontpage
    public function openHomePage(\FunctionalTester $I)
    {
        // If you'll expect translated version of the string, like 'Комментарии', test will fail,
        // since we've set 'language' => 'en-US' at config/test.php
        $I->see('Comments', 'h2');
        $I->see('(499) 340-94-71', 'a');
        $I->see('Leave comment', 'h3');
    }

    // Form to add comments
    public function submitFormSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#comments', [
            // Key is a name of corresponding <input> HTML tag, like name="Comments[user_name]"
            'Comments[user_name]' => 'Test User',
            'Comments[comment_text]' => 'Test Comment Text',
        ]);
        $I->see('Test User');
        $I->see('Test Comment Text');
        $I->dontSee('We have failed to save your comment. Please, try again later!');
    }

    public function submitFormWithoutUserName(\FunctionalTester $I)
    {
        $I->submitForm('#comments', [
            'Comments[comment_text]' => 'Test Comment Text',
        ]);
        $I->see('Failed to add comment');
        $I->see('We have failed to save your comment. Please, try again later!');
        $I->dontSee('Test Comment Text');
    }

    public function submitFormWithIncorrectUserName(\FunctionalTester $I)
    {
        $I->submitForm('#comments', [
            // Trying to set username of more than 1000 symbols
            'Comments[user_name]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
            'Comments[comment_text]' => 'Test Comment Text',
        ]);
        $I->see('We have failed to save your comment. Please, try again later!');
        $I->dontSee('Test Comment Text');
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#comments', []);
        $I->see('Failed to add comment');
        $I->see('We have failed to save your comment. Please, try again later!');
    }
}