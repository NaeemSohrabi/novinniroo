<?php
ob_start();
session_start();
/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

require dirname(__DIR__) . '/library/library.php';

define('APP_DIR' , dirname(__DIR__));


/**
 * Error and Exception handling
 */
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// set_error_handler('Core\Error::errorHandler');
// set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
//$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('', ['controller' => 'Home', 'action' => 'introPage']);
$router->add('home/index', ['controller' => 'Home', 'action' => 'index']);
$router->add('lng/{lng:\w+}', ['controller' => 'Home', 'action' => 'setLanguage']);
$router->add('admin', ['controller' => 'Home', 'action' => 'intro']);
$router->add('admin/dashboard', ['controller' => 'Admin', 'action' => 'dashboard']);
//$router->add('admin/register', ['controller' => 'Admin', 'action' => 'register']);
//$router->add('admin/login', ['controller' => 'Home', 'action' => 'login']);
$router->add('admin/logout', ['controller' => 'Admin', 'action' => 'logout']);
$router->add('admin/verify', ['controller' => 'Admin', 'action' => 'verify']);
$router->add('admin/edit/{id:\d+}', ['controller' => 'Admin', 'action' => 'edit']);
$router->add('admin/update', ['controller' => 'Admin', 'action' => 'update']);
$router->add('admin/list', ['controller' => 'Admin', 'action' => 'list']);
$router->add('admin/user/insert', ['controller' => 'Admin', 'action' => 'insert']);
$router->add('admin/user/store', ['controller' => 'Admin', 'action' => 'store']);
$router->add('admin/user/delete/{id:\d+}', ['controller' => 'Admin', 'action' => 'delete']);
$router->add('brand', ['controller' => 'Brand', 'action' => 'index']);
$router->add('product', ['controller' => 'Product', 'action' => 'index']);
$router->add('contact/email', ['controller' => 'Ajax ', 'action' => 'email']);
$router->add('about', ['controller' => 'Home', 'action' => 'about']);
$router->add('brand/{id:\d+}/review', ['controller' => 'Brand', 'action' => 'review']);
$router->add('product/{id:\d+}/review', ['controller' => 'Product', 'action' => 'review']);
$router->add('ajax/media/delete', ['controller' => 'Ajax ', 'action' => 'deleteMedia']);
$router->add('ajax/media/alt', ['controller' => 'Ajax ', 'action' => 'altMedia']);
$router->add('page/review/{slug:[a-zA-Z0-9-]+}', ['controller' => 'Page', 'action' => 'review']);


$router->add('admin/about/edit', ['controller' => 'AdminElement ', 'action' => 'aboutedit']);
$router->add('admin/about/element/update', ['controller' => 'AdminElement ', 'action' => 'aboutupdate']);
$router->add('admin/about/media/store', ['controller' => 'Home ', 'action' => 'aboutmediastore']);
$router->add('admin/about/meta/edit', ['controller' => 'AdminElement ', 'action' => 'aboutmetaedit']);
$router->add('admin/about/meta/update', ['controller' => 'AdminElement ', 'action' => 'aboutmetaupdate']);
$router->add('admin/employee/insert', ['controller' => 'AdminEmployee ', 'action' => 'insert']);
$router->add('admin/employee/store', ['controller' => 'AdminEmployee ', 'action' => 'store']);
$router->add('admin/employee/list', ['controller' => 'AdminEmployee ', 'action' => 'list']);
$router->add('admin/employee/edit/{id:\d+}', ['controller' => 'AdminEmployee ', 'action' => 'edit']);
$router->add('admin/employee/update', ['controller' => 'AdminEmployee ', 'action' => 'update']);
$router->add('admin/employee/delete/{id:\d+}', ['controller' => 'AdminEmployee ', 'action' => 'delete']);



$router->add('mkcaptcha', ['controller' => 'Captcha', 'action' => 'mkcaptcha']);



$router->add('admin/brand/list', ['controller' => 'AdminBrand', 'action' => 'list']);
$router->add('admin/brand/insert', ['controller' => 'AdminBrand', 'action' => 'insert']);
$router->add('admin/brand/store', ['controller' => 'AdminBrand', 'action' => 'Store']);
$router->add('admin/brand/edit/{id:\d+}', ['controller' => 'AdminBrand', 'action' => 'edit']);
$router->add('admin/brand/delete/{id:\d+}', ['controller' => 'AdminBrand', 'action' => 'delete']);
$router->add('admin/brand/update', ['controller' => 'AdminBrand', 'action' => 'Update']);
$router->add('admin/brand/media/store', ['controller' => 'AdminBrand', 'action' => 'mediastore']);

$router->add('admin/brand/{id:\d+}/branch/insert', ['controller' => 'AdminBrand', 'action' => 'BranchInsert']);
$router->add('admin/brand/branch/store', ['controller' => 'AdminBrand', 'action' => 'BranchStore']);
$router->add('admin/brand/branch/update', ['controller' => 'AdminBrand', 'action' => 'BranchUpdate']);
$router->add('admin/brand/branch/edit/{id:\d+}', ['controller' => 'AdminBrand', 'action' => 'BranchEdit']);
$router->add('admin/brand/branch/delete/{id:\d+}', ['controller' => 'AdminBrand', 'action' => 'BranchDelete']);

$router->add('admin/service/list', ['controller' => 'AdminServices', 'action' => 'list']);
$router->add('admin/service/insert', ['controller' => 'AdminServices', 'action' => 'insert']);
$router->add('admin/service/store', ['controller' => 'AdminServices', 'action' => 'store']);
$router->add('admin/service/edit/{id:\d+}', ['controller' => 'AdminServices', 'action' => 'edit']);
$router->add('admin/service/delete/{id:\d+}', ['controller' => 'AdminServices', 'action' => 'delete']);
$router->add('admin/service/update', ['controller' => 'AdminServices', 'action' => 'Update']);

$router->add('admin/product/list', ['controller' => 'AdminProduct', 'action' => 'List']);
$router->add('admin/product/edit/{id:\d+}', ['controller' => 'AdminProduct', 'action' => 'Edit']);
$router->add('admin/product/delete/{id:\d+}', ['controller' => 'AdminProduct', 'action' => 'delete']);
$router->add('admin/product/insert', ['controller' => 'AdminProduct', 'action' => 'Insert']);
$router->add('admin/product/store', ['controller' => 'AdminProduct', 'action' => 'Store']);
$router->add('admin/product/update', ['controller' => 'AdminProduct', 'action' => 'Update']);
$router->add('admin/product/media/store', ['controller' => 'AdminProduct', 'action' => 'mediastore']);

$router->add('admin/customer/list', ['controller' => 'AdminCustomer', 'action' => 'List']);
$router->add('admin/customer/insert', ['controller' => 'AdminCustomer', 'action' => 'insert']);
$router->add('admin/customer/store', ['controller' => 'AdminCustomer', 'action' => 'Store']);
$router->add('admin/customer/edit/{id:\d+}', ['controller' => 'AdminCustomer', 'action' => 'Edit']);
$router->add('admin/customer/update', ['controller' => 'AdminCustomer', 'action' => 'update']);
$router->add('admin/customer/delete/{id:\d+}', ['controller' => 'AdminCustomer', 'action' => 'delete']);

$router->add('admin/home/slideshow/list', ['controller' => 'AdminHome', 'action' => 'slideshowList']);
$router->add('admin/home/slideshow/store', ['controller' => 'AdminHome', 'action' => 'slideshowStore']);
$router->add('admin/home/slideshow/edit/{id:\d+}', ['controller' => 'AdminHome', 'action' => 'slideshowedit']);
$router->add('admin/home/slideshow/delete/{id:\d+}', ['controller' => 'AdminHome', 'action' => 'slideshowdelete']);
$router->add('admin/home/slideshow/update', ['controller' => 'AdminHome', 'action' => 'slideshowupdate']);
$router->add('admin/home/meta/edit', ['controller' => 'AdminElement', 'action' => 'homemetaedit']);
$router->add('admin/home/meta/update', ['controller' => 'AdminElement', 'action' => 'homemetaupdate']);

$router->add('admin/element/list', ['controller' => 'AdminElement', 'action' => 'list']);
$router->add('admin/element/update', ['controller' => 'AdminElement', 'action' => 'update']);

$router->add('admin/menu/list', ['controller' => 'AdminMenu', 'action' => 'list']);
$router->add('admin/menu/insert', ['controller' => 'AdminMenu', 'action' => 'insert']);
$router->add('admin/menu/store', ['controller' => 'AdminMenu', 'action' => 'store']);
$router->add('admin/menu/delete/{id:\d+}', ['controller' => 'AdminMenu', 'action' => 'delete']);
$router->add('admin/menu/edit/{id:\d+}', ['controller' => 'AdminMenu', 'action' => 'edit']);
$router->add('admin/menu/update', ['controller' => 'AdminMenu', 'action' => 'update']);

$router->add('admin/page/list', ['controller' => 'AdminPage', 'action' => 'list']);
$router->add('admin/page/insert', ['controller' => 'AdminPage', 'action' => 'insert']);
$router->add('admin/page/store', ['controller' => 'AdminPage', 'action' => 'Store']);
$router->add('admin/page/edit/{id:\d+}', ['controller' => 'AdminPage', 'action' => 'edit']);
$router->add('admin/page/delete/{id:\d+}', ['controller' => 'AdminPage', 'action' => 'delete']);
$router->add('admin/page/update', ['controller' => 'AdminPage', 'action' => 'Update']);
$router->add('admin/page/media/store', ['controller' => 'AdminPage', 'action' => 'mediastore']);

$router->add('admin/news/list', ['controller' => 'AdminNews', 'action' => 'list']);
$router->add('admin/news/insert', ['controller' => 'AdminNews', 'action' => 'insert']);
$router->add('admin/news/store', ['controller' => 'AdminNews', 'action' => 'store']);
$router->add('admin/news/edit/{id:\d+}', ['controller' => 'AdminNews', 'action' => 'edit']);
$router->add('admin/news/delete/{id:\d+}', ['controller' => 'AdminNews', 'action' => 'delete']);
$router->add('admin/news/update', ['controller' => 'AdminNews', 'action' => 'Update']);
$router->add('news/review', ['controller' => 'News', 'action' => 'review']);
$router->add('admin/news/meta/edit', ['controller' => 'AdminElement', 'action' => 'newsmetaedit']);
$router->add('admin/news/meta/update', ['controller' => 'AdminElement', 'action' => 'newsmetaupdate']);

$router->add('admin/contact/list', ['controller' => 'AdminContact', 'action' => 'list']);
$router->add('admin/contact/email/list', ['controller' => 'AdminElement', 'action' => 'email']);
$router->add('admin/element/emails/update', ['controller' => 'AdminElement', 'action' => 'emailsupdate']);
$router->add('admin/contact/insert', ['controller' => 'AdminContact', 'action' => 'insert']);
$router->add('admin/contact/store', ['controller' => 'AdminContact', 'action' => 'store']);
$router->add('admin/contact/edit/{id:\d+}', ['controller' => 'AdminContact', 'action' => 'edit']);
$router->add('admin/contact/delete/{id:\d+}', ['controller' => 'AdminContact', 'action' => 'delete']);
$router->add('admin/contact/update', ['controller' => 'AdminContact', 'action' => 'Update']);
$router->add('contact', ['controller' => 'Contact', 'action' => 'review']);
$router->add('admin/contact/meta/edit', ['controller' => 'AdminElement ', 'action' => 'contactmetaedit']);
$router->add('admin/contact/meta/update', ['controller' => 'AdminElement ', 'action' => 'contactmetaupdate']);

$router->add('admin/meta/update', ['controller' => 'AdminMeta', 'action' => 'Update']);
$router->add('admin/meta/store', ['controller' => 'AdminMeta', 'action' => 'store']);
$router->add('sitemapgeneration', ['controller' => 'SitemapController', 'action' => 'generetion']);
$router->add('sitemap.xml', ['controller' => 'SitemapController', 'action' => 'show']);

//$router->add('admin/contact/edit', ['controller' => 'AdminElement ', 'action' => 'contactedit']);
//$router->add('admin/contact/element/update', ['controller' => 'AdminElement ', 'action' => 'contactupdate']);


$router->add('admin/footer/edit', ['controller' => 'AdminFooter', 'action' => 'edit']);
$router->add('admin/footer/servicesupdate', ['controller' => 'AdminFooter', 'action' => 'servicesupdate']);
$router->add('admin/footer/agentsupdate', ['controller' => 'AdminFooter', 'action' => 'agentsupdate']);



$router->dispatch($_SERVER['QUERY_STRING']);

