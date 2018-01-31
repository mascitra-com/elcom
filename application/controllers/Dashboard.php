<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Dashboard extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		$this->load->helper(array('dump'));
		$this->load->model(array('users_m', 'products_m'));
	}

	public function index()
	{
		$data['members'] = $this->users_m->where('id <>', 1)->count_rows();

		$data['boughted_products'] = $this->products_m->where('boughted <>', 0)->count_rows();
		$this->render('admin/dashboard/index', $data);
	}
}