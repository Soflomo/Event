Soflomo Event
===

Soflomo\Event is an [ensemble](http://ensemble.github.com) module that provides listing of past and upcoming events.

Installation
---
Soflomo\Event is available as a composer package. Currently, Soflomo\Event is not registered on Packagist, but you can add this repository to your `composer.json` file:

```
"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:Soflomo/Event.git"
        }
    ],
```

Then require `soflomo/event`. Currenly, Soflomo\Event is in development and alpha versions are tagged. The latest alpha release is `v0.1.0-alpha1`. To get the latest version of Soflomo\Event, require the `@alpha` version in your composer.json:

```
"require": {
    "soflomo/event": "@alpha"
}
```

Enable the module (named `Soflomo\Event`) in your application.config.php.

Configuration
---
Create your own configuration file in `config/autoload/` (e.g. `soflomo_event.config.global.php`). Check the configuration from `vendor/soflomo/event/config/module.config.php` for all the configuration options.
