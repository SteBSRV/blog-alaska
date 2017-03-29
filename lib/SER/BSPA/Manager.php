<?php
/* lib/SER/BSPA/Manager.php */
namespace SER\BSPA;
 
abstract class Manager
{
  protected $dao;
 
  public function __construct($dao)
  {
    $this->dao = $dao;
  }
}
