<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	Update the given metric for the company
*/
function updateMetric($companyId, $metricName, $qty) {

	$CI = &get_instance();
	$CI->load->model("plan_model");
	$CI->plan_model->updateMetric($companyId, $metricName, $qty);
}

/*
	Update the given metric for the currently selected company of loggedIn user
*/
function updateMetricForUser($metricName, $qty) {

	$CI = &get_instance();

	$email = $CI->session->userdata("email");
	$companyInfo = $CI->session->userdata("company");

	$CI->load->model("plan_model");
	$CI->plan_model->updateMetric($companyInfo['id'], $metricName, $qty);
}