<?php

namespace MandaTheme\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;
use IO\Helper\TemplateContainer;
use Plenty\Plugin\Templates\Twig;
use IO\Helper\ResourceContainer;
use IO\Extensions\Functions\Partial;
use IO\Helper\ComponentContainer;
use Plenty\Plugin\ConfigRepository;
use IO\Services\ItemSearch\Helper\ResultFieldTemplate;


/**
 * Class MandaThemeServiceProvider
 * @package MandaTheme\Providers
 */
class MandaThemeServiceProvider extends ServiceProvider
{
    const PRIORITY = 0;

    public function register()
    {

    }

    public function boot(Twig $twig, Dispatcher $dispatcher)
    {

        $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
            $templateContainer->setTemplates([
                ResultFieldTemplate::TEMPLATE_SINGLE_ITEM   => 'MandaTheme::ResultFields.SingleItem'
            ]);
        }, 0);


        $dispatcher->listen('IO.tpl.home.category', function (TemplateContainer $container) {
            $container->setTemplate('MandaTheme::Homepage.HomepageCategory');
            return false;
        }, self::PRIORITY);


        $dispatcher->listen('IO.Resources.Import', function (ResourceContainer $container) {
            $container->addStyleTemplate('MandaTheme::Theme');
        }, self::PRIORITY);

        $dispatcher->listen('IO.init.templates', function (Partial $partial) {
            $partial->set('footer', 'MandaTheme::PageDesign.Partials.Footer');
            $partial->set('header', 'MandaTheme::PageDesign.Partials.Header.Header');
            return false;
        }, 0);

        // Override CategoryItem
        $dispatcher->listen('IO.tpl.category.item', function (TemplateContainer $container) {
            $container->setTemplate('MandaTheme::Category.Item.CategoryItem');
            return false;
        }, self::PRIORITY);

        $dispatcher->listen('IO.tpl.checkout', function (TemplateContainer $container) {
            $container->setTemplate('MandaTheme::Checkout.CheckoutView');
            return false;
        }, self::PRIORITY);

        $dispatcher->listen('IO.Component.Import', function (ComponentContainer $container) {
            if ($container->getOriginComponentTemplate() == 'Ceres::ItemList.Components.ItemList') {
                $container->setNewComponentTemplate('MandaTheme::ItemList.Components.ItemList');
            }

            if ($container->getOriginComponentTemplate() == 'Ceres::ItemList.Components.CategoryItem') {
                $container->setNewComponentTemplate('MandaTheme::ItemList.Components.CategoryItem');
            }

            if ($container->getOriginComponentTemplate() == 'Ceres::Item.Components.SingleItem') {
                $container->setNewComponentTemplate('MandaTheme::Item.Components.SingleItem');
            }

            if ($container->getOriginComponentTemplate() == 'Ceres::Item.Components.ItemImageCarousel') {
                $container->setNewComponentTemplate('MandaTheme::Item.Components.ItemImageCarousel');
            }

            if ($container->getOriginComponentTemplate() == 'Ceres::PageDesign.Components.MobileNavigation') {
                $container->setNewComponentTemplate('MandaTheme::PageDesign.Components.MobileNavigation');
            }

            if ($container->getOriginComponentTemplate() == 'Ceres::Basket.Components.AddToBasket') {
                $container->setNewComponentTemplate('MandaTheme::Basket.Components.AddToBasket');
            }

            if ($container->getOriginComponentTemplate() == 'Ceres::Customer.Components.LoginView') {
                $container->setNewComponentTemplate('MandaTheme::Customer.Components.LoginView');
            }

            return false;
        }, self::PRIORITY);

    }
}
