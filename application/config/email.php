<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['enable'] = FALSE;

$config['smtp'] = array();
$config['smtp']['user'] = "";
$config['smtp']['password'] = "";
$config['smtp']['host'] = "ssl://smtp.googlemail.com";
$config['smtp']['port'] = 465;

$config['sender'] = array();
$config['sender']['email'] = "admin@saas.com";
$config['sender']['name'] = "SAAS Admin";
