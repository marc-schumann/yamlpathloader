[![Build Status](https://travis-ci.org/marc-schumann/yamlpathloader.svg?branch=master)](https://travis-ci.org/marc-schumann/yamlpathloader)

# YamlPathLoader

Extends the YamlFileLoader from Symfony in order to load whole paths with yaml files in it. E.g. translation files.


## Installation

Install YamlPathLoader via your composer as follows:

```
	php composer.phar require marc-schumann/yamlpathloader:dev-master
```


## Usage

```php

	// Loading translations in silex microframework
	
	$app->register(new Silex\Provider\TranslationServiceProvider());
	$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
   		$translator->setLocale($app['locale']);

    	// Using YamlPathLoader - Extension for loading translation files from a directory
    	$translator->addLoader('yaml', new \MarcSchumann\YamlPathLoader\YamlPathLoader);
    	$translator->addResource('yaml', __DIR__.'/locales/en/', 'en');
    	$translator->addResource('yaml', __DIR__.'/locales/de/', 'de');

    	return $translator;
	}));
```


### ToDo

- packagist
