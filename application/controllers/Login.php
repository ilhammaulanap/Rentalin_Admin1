<?php  

/**
* 
*/
class login extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("m_user");
	}

	function index(){
		if (!empty($this->session->userdata("username")))
			redirect(base_url("iklan"));

		$this->load->view("v_login");
	}

	function login_proses(){
		$username=$this->input->post("username");
		$password=$this->input->post("password");
		$user=$this->m_user->login($username,$password);
		
		if ($user) {
			$this->session->set_userdata((array)$user);
			redirect(site_url("iklan"));
		}else{
			
			echo "<script>alert('username atau password salah!');(location.href='index');</script>";
			
		}
	}

	function logout(){
		$array_items = array('id_admin','username','password','email','nama','jenis_kelamin','alamat','photo');
		$this->session->unset_userdata($array_items);

		redirect($this->index());
	}
}

?>