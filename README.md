# TekowayRollbarBundle


Introduction
============

Rollbar-symfony is a symfony bundle compatible with symfony ~2.6|3.0 It reports errors and some logs to "Rollbar":http://www.rollbar.com 

Installation
============
Step 1: Download the Bundle
---------------------------
Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:
```
$ composer require tekoway/symfony-rollbar
```
This command requires you to have Composer installed globally, as explainedin the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

Step 2: Enable the Bundle
-------------------------
Then, enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Tekoway\Rollbar\TekowayRollbarBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Configure the Bundle
----------------------------
Enable the bundle's configuration in app/config/config.yml:
```yml
tekoway_rollbar: 
    access_token: YOUR_ROLLBAR_ACCESS_TOKEN
    environment: ~
    enabled: ~
    error_levels: ~
    exceptions_ignore_list: ~
```
Parameters explanation:
`environment`: a string value (Environment parameter which will be send to Rollbar).    
`enabled`: a bool value (true|false) - allow the bundle to send automatically errors/exceptions to rollbar (default value is false).   
`error_levels`: an array that contains the error types allowed to send to rollbar automatically (see [Predefined Constants](http://php.net/manual/en/errorfunc.constants.php) ).
`exceptions_ignore_list`: an array that contains the list of exceptions to be ignored in rollbar reporting process (see [Symfony Exceptions List](https://gist.github.com/feyyazesat/c65ccfde12839c03c610) ).   

Full config example:
```yml
    access_token: YOUR_ROLLBAR_ACCESS_TOKEN
    environment: production
    enabled: true
    error_levels: 
        - E_ERROR'
        - E_WARNING
        - E_PARSE
        - E_CORE_ERROR
        - E_CORE_WARNING
        - E_COMPILE_ERROR
        - E_COMPILE_WARNING
        - E_USER_ERROR
        - E_USER_WARNING
        - E_USER_NOTICE
        - E_STRICT
        - E_RECOVERABLE_ERROR
        - E_DEPRECATED
        - E_USER_DEPRECATED
        - E_ALL #include all above list
    exceptions_ignore_list: 
        - Symfony\Component\Security\Core\Exception\AccessDeniedException
        - Symfony/Component/Security/Core/Exception/AuthenticationException.php
        - #other exceptions
```
Step 4: use 
-----------
You can use the tekoway logger to write logs into Rollbar
```php
    $this->get('tekoway.logger.rollbar')->critical('critical message');
    $this->get('tekoway.logger.rollbar')->info('info message');
    $this->get('tekoway.logger.rollbar')->debug('debug message');
    $this->get('tekoway.logger.rollbar')->error('error message');
    $this->get('tekoway.logger.rollbar')->emergency('emergency message');
    $this->get('tekoway.logger.rollbar')->alert('alert message');
    $this->get('tekoway.logger.rollbar')->notice('notice message');
    $this->get('tekoway.logger.rollbar')->warning('warning message');
```

License
=======
This bundle is under the MIT license. See the complete license in the bundle

About
=====
TekowayRollbarBundle is a tekoway initiative. See also the list of contributors.

Reporting an issue or a feature request
=======================================
Issues and feature requests are tracked in the Github issue tracker.
When reporting a bug, it may be a good idea to reproduce it in a basic project built using the Symfony Standard Edition to allow developers of the bundle to reproduce the issue by simply cloning it and following some steps.