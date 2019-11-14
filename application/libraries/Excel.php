<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * @author: Niraj Kumar
 * Dated: 30-oct-2017
 * 
 * Genrate dynamic Excel file
 * 
 */  
require_once APPPATH."/third_party/PHPExcel.php"; 
 
class Excel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
}