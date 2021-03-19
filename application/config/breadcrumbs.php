<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| BREADCRUMB CONFIG
| -------------------------------------------------------------------
| This file will contain some breadcrumbs' settings.
|
| $config['crumb_divider']		The string used to divide the crumbs
| $config['tag_open'] 			The opening tag for breadcrumb's holder.
| $config['tag_close'] 			The closing tag for breadcrumb's holder.
| $config['crumb_open'] 		The opening tag for breadcrumb's holder.
| $config['crumb_close'] 		The closing tag for breadcrumb's holder.
|
| Defaults provided for twitter bootstrap 2.0
*/

$config['crumb_divider'] = '>';
$config['tag_open'] = '<nav class="breadcrumb bg-white push">';
$config['tag_close'] = '</nav>';
$config['crumb_open'] = '<span class="breadcrumb-item">';
$config['crumb_last_open'] = '<span class="breadcrumb-item active">';
$config['crumb_close'] = '</span>';


/* End of file breadcrumbs.php */
/* Location: ./application/config/breadcrumbs.php */