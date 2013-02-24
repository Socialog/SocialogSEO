SocialogSEO
===========

SEO module for Socialog

This module can be used without Socialog, it adds the following functions:

## Robots.txt

Adds a robots file on `/robots.txt` which can be configured using the module.config.php
so you can easily have different robots.txt in your development or production environment

```php
return array(
    'socialog-seo' => array(
        'robots' => array(
            // Which user agents are allowed
            'user-agent' => '*',
            'disallow' => array(
                // The routes which should be blocked for search engines
            ),
        ),
        'content' => 'all',
    )
);
```php

In a development environment you can tell search engines to ignore the website by configuring it as follows:

```php
return array(
    'socialog-seo' => array(
        'robots' => array(
            'disallow' => array( '/' )
        ),
    )
);
```

## Humans.txt

For more information on humans.txt see [humanstxt](http://humanstxt.org/)

Add a `humans.txt` route which serves a `humans.phtml` view

## Redirection

Easy configuration of 301 redirects

```php
'socialog-seo' => array(
    'redirect' => array(
        '/post/17' => '/manage-assets-in-zend-framework-2',
        '/post/16' => '/using-bootstrap-in-his-own-scope'
    )
)
```

Or use the advanced configuration


```php
'socialog-seo' => array(
    'redirect' => array(
        '/post/17' => array (
            'url' => '/manage-assets-in-zend-framework-2',
            'code' => 301
        )
    ),
),
```
