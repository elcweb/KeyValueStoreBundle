KeyValueStoreBundle
===================

Installation
------------

### Step 1: Download using composer

```js
{
    "require": {
        "elcweb/keyvaluestore-bundle": "1.0.*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update elcweb/keyvaluestore-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Elcweb\KeyValueStoreBundle\ElcwebKeyValueStoreBundle(),
    );
}
```