<?php

$autoload = require_once __DIR__.'/autoload.php';
require_once __DIR__.'/AppKernel.php';

use Symfony\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Symfony\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

$kernel = new AppKernel('test', true); // create a "test" kernel
$kernel->boot();

$application = new Application($kernel);
$application->setAutoExit(false);

deleteDatabase();
//executeCommand($application, "doctrine:database:drop");
executeCommand($application, "doctrine:schema:create");

/**
 * @param       $application
 * @param       $command
 * @param array $options
 */
function executeCommand($application, $command, Array $options = array()) {
    $options["--env"] = "test";
    $options["--quiet"] = true;
    $options = array_merge($options, array('command' => $command));

    $application->run(new ArrayInput($options));
}

function deleteDatabase() {
    $folder = __DIR__ . '/cache/';
    foreach(array('test.db','test.db.bk') AS $file){
        if(file_exists($folder . $file)){
            unlink($folder . $file);
        }
    }
}
