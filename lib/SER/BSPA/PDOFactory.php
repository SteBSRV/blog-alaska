<?php
/* lib/SER/BSPA/PDOFactory.php */
namespace SER\BSPA;
 
class PDOFactory
{
  public static function getMysqlConnexion()
  {
  	$parameters = new Parameters();
  	$param = $parameters->getDbParam();

    $db = new \PDO(
    	'mysql:host='.
    	$param['host'].
    	';dbname='.
    	$param['dbname'],
    	$param['user'],
    	$param['pass']
    	);

    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
    return $db;
  }
}
