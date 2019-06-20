<?php

namespace App\Controllers;

use App\Config;
use NilPortugues\Sitemap\Sitemap;
use NilPortugues\Sitemap\Item\Url\UrlItem;
use NilPortugues\Sitemap\SitemapException;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Page;
use App\Models\News;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class SitemapController extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function generetionAction()
    {
        try {
            $sitemap = new Sitemap(APP_DIR,'sitemap.xml');

            $item = new UrlItem(Config::URL_BASE);
            $item->setPriority('1.0'); //Optional
            $item->setChangeFreq('daily'); //Optional
            $item->setLastMod('2014-05-10T17:33:30+08:00'); //Optional
            $sitemap->add($item);

            $item = new UrlItem(Config::URL_BASE.'about');
            $item->setPriority('1.0'); //Optional
            $item->setChangeFreq('daily'); //Optional
            $item->setLastMod('2014-05-10T17:33:30+08:00'); //Optional
            $sitemap->add($item);

            $item = new UrlItem(Config::URL_BASE.'contact');
            $item->setPriority('1.0'); //Optional
            $item->setChangeFreq('daily'); //Optional
            $item->setLastMod('2014-05-10T17:33:30+08:00'); //Optional
            $sitemap->add($item);

            $item = new UrlItem(Config::URL_BASE.'news/review');
            $item->setPriority('1.0'); //Optional
            $item->setChangeFreq('daily'); //Optional
            $item->setLastMod('2014-05-10T17:33:30+08:00'); //Optional
            $sitemap->add($item);

            $brands = Brand::getAll();
            foreach ($brands as $brand){
                $item = new UrlItem(Config::URL_BASE.'brand/'.$brand['id'].'/review');
                $item->setPriority('1.0'); //Optional
                $item->setChangeFreq('daily'); //Optional
                $item->setLastMod('2014-05-10T17:33:30+08:00'); //Optional
                $sitemap->add($item);
            }

            $products = Product::getAll();
            foreach ($products as $product ) {
                $item = new UrlItem(Config::URL_BASE.'product/'.$product['id'].'/review');
                $item->setPriority('1.0'); //Optional
                $item->setChangeFreq('daily'); //Optional
                $item->setLastMod('2014-05-10T17:33:30+08:00'); //Optional
                $sitemap->add($item);
            }

            $pages = Page::getAll();
            foreach ($pages as $page) {
                $item = new UrlItem(Config::URL_BASE.'page/review/'.$page['slug']);
                $item->setPriority('1.0'); //Optional
                $item->setChangeFreq('daily'); //Optional
                $item->setLastMod('2014-05-10T17:33:30+08:00'); //Optional
                $sitemap->add($item);
            }


            $sitemap->build();

        } catch (SitemapException $e) {

            echo $e->getMessage();
        }
    }


    public function showAction(){

        header('Content-type: text/xml');
        $sitemap = file_get_contents(APP_DIR.'/sitemap.xml');
        echo $sitemap;
    }


}


