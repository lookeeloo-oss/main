<?php include 'db_connect.php' ?>
<?php 
if(isset($_GET['id'])){
	$upload = $conn->query("SELECT up.*,concat(u.firstname,' ',u.lastname) as name,u.avatar FROM uploads up inner join users u on u.id =up.user_id where up.id = '{$_GET['id']}' ");
	foreach ($upload->fetch_array() as $k => $v) {
		$$k = $v;
	}
}
?>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<form id="manage-upload">
				<input type="hidden" name="id" value="<?php echo isset($id)? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label"><b>Upload Video</b></label>
							<input type="file" class="form-control form-control-sm" name="vid" onchange="displayVID(this,$(this))">
						</div>
						<div class="form-group">
							<label for="" class="control-label"><b>Thumbnail/Poster</b></label>
							<input type="file" class="form-control form-control-sm" name="img" onchange="displayImg(this,$(this))">
						</div>
						<div class="form-group">
							<label for="" class="control-label"><b>Title</b></label>
							<textarea name="title" id="" cols="30" rows="2" class="form-control" style="resize:none"><?php echo isset($title) ? $title : '' ?></textarea>
						</div>
						<div class="form-group">
							<label for="" class="control-label"><b>Description</b></label>
							<textarea name="description" id="" cols="30" rows="5" class="form-control"><?php echo isset($title) ? $title : '' ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group d-flex justify-content-center bg-dark border-dark img-thumbnail">
							<video width="320" height="240" id="vid-field" controls class="img-fluid" poster="<?php echo isset($thumbnail_path) && !empty($thumbnail_path) ? "assets/uploads/thumbnail/".$thumbnail_path : '' ?>">
								<?php if(isset($video_path)): ?>
									<source src="<?php echo isset($video_path) && !empty($video_path) ? "assets/uploads/videos/".$video_path : '' ?>">
								<?php endif; ?>
							</video>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal-footer display py-2 px-0 row">
	<div class="row">
		<div class="col-lg-12">
			<button class="btn btn-secondary float-right mr-2" data-dismiss="modal">Cancel</button>
			<button class="btn btn-light bg-light border float-right mr-2" onclick="$('#manage-upload').submit()" type="button"><i class="fa fa-upload"></i> <?php echo isset($id) ? "Update" :'Upload' ?></button>
		</div>
	</div>
</div>
<style>
	#uni_modal .modal-footer{
		display: none;
	}
	#uni_modal .modal-footer.display{
		display: block;
	}
</style>
<script>
	function displayVID(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#vid-field').html("<source src='"+e.target.result+"'>");
	        	console.log(e.target.result)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#vid-field').attr('poster', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
$('#manage-upload').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?act=save_upload',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('<i class="fa fa-check text-white"></i> Video successfully uploaded.',"success");
					setTimeout(function(){
						location.reload()
					},750)
				}
				else {
					alert_toast('Video failed to upload!.',"success");
					setTimeout(function(){
						location.reload()
					},750)
				}
			}
		})
	})
</script>