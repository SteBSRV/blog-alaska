<?php
/* public/index.php */

const DEFAULT_APP = 'Frontend';
 
// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404
if (!isset($_GET['app']) || !file_exists(__DIR__.'/../App/'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;

require __DIR__ . '/../lib/SER/BSPA/SplClassLoader.php';

$BSPALoader = new SplClassLoader('SER\BSPA', __DIR__.'/../lib');
$BSPALoader->register();
 
$appLoader = new SplClassLoader('App', __DIR__.'/..');
$appLoader->register();

$modelLoader = new SplClassLoader('Model', __DIR__.'/../lib/vendors');
$modelLoader->register();
 
$entityLoader = new SplClassLoader('Entity', __DIR__.'/../lib/vendors');
$entityLoader->register();

$formLoader = new SplClassLoader('FormBuilder', __DIR__.'/../lib/vendors');
$formLoader->register();

$formLoader = new SplClassLoader('SERMailer', __DIR__.'/../lib/vendors');
$formLoader->register();

$formLoader = new SplClassLoader('RSSParser', __DIR__.'/../lib/vendors');
$formLoader->register();

$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
 
$app = new $appClass;
$app->run();

?>