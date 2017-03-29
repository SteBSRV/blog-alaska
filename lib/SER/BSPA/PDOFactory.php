<?php
/* lib/SER/BSPA/PDOFactory.php */
namespace SER\BSPA;
 
class PDOFactory
{
  public static function getMysqlConnexion()
  {
    $db = new \PDO('mysql:host=localhost;dbname=BSPA', 'web', 'Lk14Trm5');
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
    return $db;
  }
}
