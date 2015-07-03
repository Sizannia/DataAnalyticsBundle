## Installation

Require the bundle in your composer.json file:

```js
{
    "require": {
        "sizannia/data-analytics-bundle": "1.0.*",
    }
}
```

Install the bundle:

``` bash
$ php composer.phar update
```

Add Sizannia Translation bundle to your AppKernel.php file:

``` php
<?php
 public function registerBundles() {
        $bundles = array(
            ...
            new Sizannia\DataAnalyticsBundle\SizanniaDataAnalyticsBundle(),
            ...
        );
}
```