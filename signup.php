<?php include 'db_connect.php' ?>
<?php 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM users where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		$$k  = $v;
	}
}
?>
<div class="container py-3">
	<div class="col-lg-12">
		<div class="card bg-light">
			<div class="card-body">
				<h3><b><?php echo isset($id) ? "Manage":'Create' ?> Account</b></h3>
				<hr>
				<form action="" id="manage_account">
					<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 border-right">
								<div class="form-group">
									<label class="control-label">First Name</label>
									<input type="text" class="form-control form-control-sm" name="firstname" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
								</div>
								<div class="form-group">
									<label class="control-label">Middle Name</label>
									<input type="text" class="form-control form-control-sm" name="middlename" value="<?php echo isset($middlename) ? $middlename : '' ?>">
								</div>
								<div class="form-group">
									<label class="control-label">Last Name</label>
									<input type="text" class="form-control form-control-sm" name="lastname" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
								</div>
								<div class="form-group">
									<label class="control-label">Contact #</label>
									<input type="text" class="form-control form-control-sm" name="contact" required value="<?php echo isset($contact) ? $contact : '' ?>">
								</div>
								<div class="form-group">
									<label class="control-label">Address</label>
									<textarea name="address" id="" cols="30" rows="4" class="form-control" required><?php echo isset($address) ? $address : '' ?></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">Avatar</label>
									<input type="file" class="form-control form-control-sm" name="img" onchange="displayImg(this,$(this))">
								</div>
								<div class="form-group d-flex justify-content-center">
									<img src="<?php echo isset($avatar) ? 'assets/uploads/'.$avatar :'' ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
								</div>
								<div class="form-group">
									<label class="control-label">Email</label>
									<input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
									<small id="#msg"></small>
								</div>
								<div class="form-group">
									<label class="control-label">Password</label>
									<input type="password" class="form-control form-control-sm" name="password" <?php echo isset($id) ? "":'required' ?>>
									<small><i><?php echo isset($id) ? "Leave this blank if you dont want to change you password":'' ?></i></small>
								</div>
								<div class="form-group">
									<label class="label control-label">Confirm Password</label>
									<input type="password" class="form-control form-control-sm" name="cpass" <?php echo isset($id) ? 'required' : '' ?>>
									<small id="pass_match" data-status=''></small>
								</div>
							</div>
						</div>
						<hr>
						<div class="col-lg-12 text-right justify-content-center d-flex">
							<button class="btn btn-primary mr-2"><?php echo isset($id) ? "Update":'Create' ?> Account</button>
							<button class="btn btn-secondary" type="reset">Clear</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<style>
	img#cimg{
		max-height: 15vh;
		/*max-width: 6vw;*/
	}
</style>
<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_account').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if($('#pass_match').attr('data-status') != 1){
			if($("[name='password']").val() !=''){
				$('[name="password"],[name="cpass"]').addClass("border-danger")
				end_load()
				return false;
			}
		}
		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>