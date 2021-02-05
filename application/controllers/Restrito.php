<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrito extends CI_Controller{
	
	public function __construct() {
		parent::__construct();
		$this->load->library("session");
	}
	public function index(){

		if ($this->session->userdata("user_id")) {
			$data = array(
				"styles" => array(
					"dataTables.bootstrap.min.css",
					"datatables.min.css"
				),
				"scripts" => array(
					"sweetalert2.all.min.js",
					"dataTables.bootstrap.min.js",
					"datatables.min.js",
					"util.js",
					"restrito.js"
			),
			"user_id" => $this->session->userdata("user_id") 
		);
			$this->template->show("restrito.php", $data);
		} else {
			$data = array(
				"scripts" => array(
					"util.js",
					"login.js"
		)
	);	
			$this->template->show("login.php", $data);
	}
}

public function logoff() {
	$this->session->sess_destroy();
	header("Location: " . base_url() . "restrito");
}
public function ajax_login() {

	if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

	$json = array();
	$json["status"] = 1;
	$json["error_list"] = array();

$username = $this->input->post("username");
$password = $this->input->post("password");

if (empty($username)) {
	$json["status"] = 0;
	$json["error_list"]["#username"] = "Usuário não pode ser vazio!";
} else {
	$this->load->model("users_model");
	$result = $this->users_model->get_user_data($username);
	if ($result) {
		$user_id = $result->user_id;
		$password_hash = $result->password;
		if (password_verify($password, $password_hash)) {
			$this->session->set_userdata("user_id", $user_id);
		} else {
			$json["status"] = 0;
		}
	} else {
		$json["status"] = 0;
	}
	if ($json["status"] == 0) {
		$json["error_list"]["#btn_login"] = "Usuário e/ou senha incorretos!";
	}
}
	echo json_encode($json);
}

public function ajax_save_user() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("users_model");

		$data = $this->input->post();

		if (empty($data["user_login"])) {
			$json["error_list"]["#user_login"] = "Login é obrigatório!";
		} else {
			if ($this->users_model->is_duplicated("user_login", $data["user_login"], $data["user_id"])) {
				$json["error_list"]["#user_login"] = "Login já existente!";
			}
		}

		if (empty($data["user_nome"])) {
			$json["error_list"]["#user_nome"] = "Nome Completo é obrigatório!";
		} 

		if (empty($data["user_email"])) {
			$json["error_list"]["#user_email"] = "E-mail é obrigatório!";
		} else {
			if ($this->users_model->is_duplicated("user_email", $data["user_email"], $data["user_id"])) {
				$json["error_list"]["#user_email"] = "E-mail já existente!";
			} else {
				if ($data["user_email"] != $data["user_email_confirm"]) {
					$json["error_list"]["#user_email"] = "";
					$json["error_list"]["#user_email_confirm"] = "E-mails não conferem!";
				}
			}
		}

		if (empty($data["user_password"])) {
			$json["error_list"]["#user_password"] = "Senha é obrigatório!";
		} else {
			if ($data["user_password"] != $data["user_password_confirm"]) {
				$json["error_list"]["#user_password"] = "";
				$json["error_list"]["#user_password_confirm"] = "Senhas não conferem!";
			}
		}

		if (!empty($json["error_list"])) {
			$json["status"] = 0;	
		} else {

			$data["password"] = password_hash($data["user_password"], PASSWORD_DEFAULT);

			unset($data["user_password"]);
			unset($data["user_password_confirm"]);
			unset($data["user_email_confirm"]);

			if (empty($data["user_id"])) {
				$this->users_model->insert($data);
			} else {
				$user_id = $data["user_id"];
				unset($data["user_id"]);
				$this->users_model->update($user_id, $data);
			}
		}

		echo json_encode($json);
	}
	public function ajax_get_user_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["input"] = array();

		$this->load->model("users_model");

		$user_id = $this->input->post("user_id");
		$data = $this->users_model->get_data($user_id)->result_array()[0];
		$json["input"]["user_id"] = $data["user_id"];
		$json["input"]["user_login"] = $data["user_login"];
		$json["input"]["user_nome"] = $data["user_nome"];
		$json["input"]["user_email"] = $data["user_email"];
		$json["input"]["user_email_confirm"] = $data["user_email"];
		$json["input"]["user_password"] = $data["password"];
		$json["input"]["user_password_confirm"] = $data["password"];

		echo json_encode($json);
	}

	public function ajax_delete_user_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("users_model");
		$user_id = $this->input->post("user_id");
		$this->users_model->delete($user_id);

		echo json_encode($json);
	}
	public function ajax_list_user() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("users_model");
		$users = $this->users_model->get_datatable();

		$data = array();
		foreach ($users as $user) {

			$row = array();
			$row[] = $user->user_login;
			$row[] = $user->user_nome;
			$row[] = $user->user_email;

			$row[] = '<div style="display: inline-block;">
						<button class="btn btn-primary btn-edit-user" 
							user_id="'.$user->user_id.'">
							<i class="fa fa-edit"></i>
						</button>
						<button class="btn btn-danger btn-del-user" 
							user_id="'.$user->user_id.'">
							<i class="fa fa-times"></i>
						</button>
					</div>';

			$data[] = $row;

		}

		$json = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->users_model->records_total(),
			"recordsFiltered" => $this->users_model->records_filtered(),
			"data" => $data,
		);

		echo json_encode($json);
	}


}