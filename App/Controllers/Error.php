<?php

namespace App\Controllers;

use Core\View;


/**
 * Home controller
 *
 * PHP version 7.0
 */
class Error extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function error404Action()
    {
        View::renderTemplate('404.html');
    }

    public function error500Action()
    {
        View::renderTemplate('500.html');
    }

}
