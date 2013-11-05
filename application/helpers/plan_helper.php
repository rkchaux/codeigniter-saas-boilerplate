<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	Update the given metric for the company
*/
function updateMetric($companyId, $metricName, $qty) {

	$CI = &get_instance();
	$CI->load->model("plan_model");
	$CI->plan_model->updateMetric($companyId, $metricName, $qty);
}