<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! class_exists('Smarty'))
{
     require_once(APPPATH.'libraries/Smarty'.EXT);
}

$obj =& get_instance();
$obj->smarty = new Smarty();
$obj->ci_is_loaded[] = 'smarty';

?>
