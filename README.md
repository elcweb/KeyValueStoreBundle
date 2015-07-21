KeyValueStoreBundle
===================

[![Latest Stable Version](https://poser.pugx.org/elcweb/keyvaluestore-bundle/v/stable.png)](https://packagist.org/packages/elcweb/keyvaluestore-bundle)
[![Total Downloads](https://poser.pugx.org/elcweb/keyvaluestore-bundle/downloads.png)](https://packagist.org/packages/elcweb/keyvaluestore-bundle)

Installation
------------

### Step 1: Download using composer

```js
{
    "require": {
        "elcweb/keyvaluestore-bundle": "dev-master"
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

### Step 3: Doctrine Migration (optional)

If you are upgrading from version 1.x you will need to do a migration.
We recommend using [DoctrineMigration](https://github.com/doctrine/DoctrineMigrationsBundle)

An migration example exist in

    DoctrineMigrations/Version20150715164320.php

Make sure that your parameter %secret% is 32 characters long.

Usage
-----
### Get a value
``` php
$ks = $this->get('elcweb.keyvaluestore');
$value = $ks->get('KeyName');
```

### Get all values starting with a pattern
``` php
$ks = $this->get('elcweb.keyvaluestore');
$values = $ks->getAll('KeyName');

// If you have a keys called foo.bar and foo.foo this will return an array with key bar and foo
```

### Set a value
``` php
$ks = $this->get('elcweb.keyvaluestore');
$ks->set('key', 'value', 'optional description');
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/elcweb/KeyValueStoreBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.
