<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Criptografia extends CI_Controller {
//$this->load->library('encrypt');
	public function index()
	{
		$data = array(
				"scripts" => array(
					"owl.carousel.min.js",
					"theme-scripts.js"
					)
				);
		$this->template->show('criptografia');
	}

	public function criptografar($msg,$key) {
		$encrypted_string = $this->encrypt->encode($msg, $key);
		return $encrypted_string;
	}

}