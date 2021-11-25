<?php
ob_start();
$action = $_GET['act'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		header('location:index.php');
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'save_upload'){
	$save = $crud->save_upload();
	if($save)
		echo $save;
}
if($action == 'delete_upload'){
	$delete = $crud->delete_upload();
	if($delete)
		echo $delete;
}
ob_end_flush();
?>
