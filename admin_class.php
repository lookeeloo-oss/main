<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where email = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 2;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:index.php");
	}

	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','cpass'))){
				if(!empty($data))
					$data .= ", ";
				$data .= " $k='$v' ";
			}
		}
		$chk = $this->db->query("Select * from users where email = '$email' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if($_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
			$id=$this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			$_SESSION['login_id'] = $id;
			foreach ($_POST as $key => $value) {
				if(!in_array($key,array('id','cpass')))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function save_upload(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','img','vid'))){
				if($k == 'description'){

				}
				if(!empty($data))
					$data .= ", ";
				$data .= " $k='$v' ";
			}
		}
		
		if(empty($id)){
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$i = 1;
			while($i == 1){
				$_name =substr(str_shuffle($chars), 0, 16);
				$chk = $this->db->query("SELECT * from uploads where code = '$_name' and id !='$id' ")->num_rows;
				if($chk <= 0){
					$i = 0;
				}
			}
			$data .= ", code = '$_name' ";
		}else{
			$_name = $this->db->query("SELECT * from uploads where id = '$id' ")->fetch_array()['code'];
		}
		if($_FILES['img']['tmp_name'] != ''){
			$ext = substr($_FILES['img']['name'], strrpos($_FILES['img']['name'], '.')+1);
			$fname = $_name.'.'.$ext;
			if(is_file('assets/uploads/thumbnail/'. $fname))
				unlink('assets/uploads/thumbnail/'. $fname);
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/thumbnail/'. $fname);
			$data .= ", thumbnail_path = '$fname' ";

		}
		if($_FILES['vid']['tmp_name'] != ''){
			$ext = substr($_FILES['vid']['name'], strrpos($_FILES['vid']['name'], '.')+1);
			$fname = $_name.'.'.$ext;
			if(is_file('assets/uploads/videos/'. $fname))
				unlink('assets/uploads/videos/'. $fname);
			$move = move_uploaded_file($_FILES['vid']['tmp_name'],'assets/uploads/videos/'. $fname);
			$data .= ", video_path = '$fname' ";

		}
		if(empty($id)){
			$data .= ", user_id = {$_SESSION['login_id']} ";
			$save = $this->db->query("INSERT INTO uploads set ".$data);
			$id=$this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE uploads set ".$data." where id = ".$id);
		}
		if($save){
				return 1;
		}
	}
	function delete_upload(){
		extract($_POST);
		$qry = $this->db->query("SELECT * from uploads where id = '$id' ")->fetch_array();
		$delete = $this->db->query("DELETE FROM uploads where id = '$id'");
		if($delete){
			if(!empty($qry['thumbnail_path'])){
				if(is_file('assets/uploads/thumbnail/'.$qry['thumbnail_path']))
					unlink('assets/uploads/thumbnail/'.$qry['thumbnail_path']);
			}
			if(!empty($qry['video_path'])){
				if(is_file('assets/uploads/videos/'.$qry['video_path']))
					unlink('assets/uploads/videos/'.$qry['video_path']);
			}
			return 1;
		}
	}
}