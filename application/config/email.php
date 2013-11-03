<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	You can enable/disable email sending with following flag
*/
$config['enable'] = FALSE;

/*
	Configure SMTP information for sending email
*/
$config['smtp'] = array();
$config['smtp']['user'] = "";
$config['smtp']['password'] = "";
$config['smtp']['host'] = "ssl://smtp.googlemail.com";
$config['smtp']['port'] = 465;

/*
	Configure email of the sender. Used as the `from` email when sending emails
*/	
$config['sender'] = array();
$config['sender']['email'] = "admin@saas.com";
$config['sender']['name'] = "SAAS Admin";
