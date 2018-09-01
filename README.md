<h1 align="center">
    <a href="https://odiseo.com.ar/" target="_blank" title="Odiseo">
        <img src="https://github.com/odiseoteam/SyliusBannerPlugin/blob/master/logo_odiseo.png" alt="Odiseo" width="200px" />
    </a>
    <br />
    Odiseo Sylius Banner Plugin
    <br />
    <a href="https://packagist.org/packages/odiseoteam/sylius-banner-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/odiseoteam/sylius-banner-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/odiseoteam/sylius-banner-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/odiseoteam/sylius-banner-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/odiseoteam/SyliusBannerPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/odiseoteam/SyliusBannerPlugin/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/odiseoteam/SyliusBannerPlugin/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/odiseoteam/SyliusBannerPlugin.svg" />
    </a>
    <a href="https://packagist.org/packages/odiseoteam/sylius-banner-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/odiseoteam/sylius-banner-plugin/downloads" />
    </a>
</h1>

## Description

This plugin add banners to the Sylius content. The banners are fully customizable by the admin.

<img src="https://github.com/odiseoteam/SyliusBannerPlugin/blob/master/screenshot_1.png" alt="Banners admin">

## Demo

You can see this plugin in action in our Sylius Demo application.

- Frontend: [sylius-demo.odiseo.com.ar](https://sylius-demo.odiseo.com.ar). 
- Administration: [sylius-demo.odiseo.com.ar/admin](https://sylius-demo.odiseo.com.ar/admin) with `odiseo: odiseo` credentials.

## Installation

1. Run `composer require odiseoteam/sylius-banner-plugin`.

2. Add the plugin to the AppKernel but add it before SyliusResourceBundle. To do that you need change the registerBundles like this:

```php
public function registerBundles(): array
{
    $preResourceBundles = [
        new \Odiseo\SyliusBannerPlugin\OdiseoSyliusBannerPlugin(),
    ];

    $bundles = [
        ...
        //This plugin use the vich uploader bundle
        new \Vich\UploaderBundle\VichUploaderBundle(),
    ];

    return array_merge($preResourceBundles, parent::registerBundles(), $bundles);
}
```
 
3. Import the configurations on your config.yml:
 
```yml
    - { resource: "@OdiseoSyliusBannerPlugin/Resources/config/config.yml" }
```

4. Add the admin and shop routes:

```yml
odiseo_sylius_banner_admin:
    resource: "@OdiseoSyliusBannerPlugin/Resources/config/routing/admin.yml"
    prefix: /admin
    
odiseo_sylius_banner_shop:
    resource: "@OdiseoSyliusBannerPlugin/Resources/config/routing/shop.yml"
    prefix: /{_locale}/banner
```

5. Finish the installation updatating the database schema and installing assets:
   
```
php bin/console doctrine:schema:update --force
php bin/console assets:install
php bin/console sylius:theme:assets:install

## Fixtures

This plugin comes with fixtures:

### Banners

Simply add this configuration on your fixture suite:

```yml
banner:
    options:
        banners_per_channel: 12
```

## Test the plugin

You can follow the instructions to test this plugins in the proper documentation page: [Test the plugin](doc/tests.md).
    
## Credits

This plugin is maintained by <a href="https://odiseo.com.ar">Odiseo</a>. Want us to help you with this plugin or any Sylius project? Contact us on <a href="mailto:team@odiseo.com.ar">team@odiseo.com.ar</a>.
