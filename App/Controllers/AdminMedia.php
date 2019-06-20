<?php

namespace App\Controllers;

use App\Config;
use App\Models\Brand;
use App\Models\Media;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminMedia extends \Core\Controller
{
    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(!isset($_SESSION['islogin'])){

            header("Location: ".Config::URL_BASE."#admin");
        }
    }

    /**
     * Show the index page
     *
     * @return void
     */

}
