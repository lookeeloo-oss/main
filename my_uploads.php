<?php include 'db_connect.php' ?>
<style>
	.vid-item{
		cursor: pointer;
		position: relative;
		width: calc(25%) !important;
	}
	.watch{
		position: absolute;
		top: 0;
		left: 0;
		height: calc(100%);
		width: calc(100%);
		opacity: 0;
	    background: #00000052;
	}
	.vid-item:hover .watch{
		opacity: 1;
	}
	.vid-details{
		width: calc(70%)!important;
	}
</style>
<div class="container py-2">
	<div class="col-lg-12">
		<div class="card bg-light">
			<div class="card-body">
				<div class="col-md-12 d-flex justify-content-between">
					<h3><b>My Videos</b></h3>
					<button class="btn btn-light bg-light border float-right" id="upload" type="button"><i class="fa fa-plus"></i> <i class="fa fa-video"></i> Upload</button>
				</div>
				<hr>
				<div class="row">
					<?php  
						$qry = $conn->query("SELECT * FROM uploads where user_id={$_SESSION['login_id']} ");
						while($row=$qry->fetch_assoc()):
					?>
					<div class="col-md-12 py-2 border-bottom">
						<div class="d-flex w-100">
						  <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
						  <div class="d-flex justify-content-center bg-dark border-dark img-thumbnail w-100 p-0 vid-item" data-id="<?php echo $row['code'] ?>">
							<video id="<?php echo $row['code'] ?>" class="img-fluid" <?php echo !empty($row['thumbnail_path']) ? "poster='assets/uploads/thumbnail/".$row['thumbnail_path']."'" : '' ?> muted>
								<source src="<?php echo !empty($row['video_path']) ? "assets/uploads/videos/".$row['video_path'] : '' ?>">
							</video>
							<div class="watch d-flex align-items-center justify-content-center"><h3><span class="fa fa-play text-white"></span></h3></div>
						</div>
						  <div class="d-bloc py-2 px-2 vid-details">
						    <h6 class="card-title"><b><?php echo ucwords($row['title']) ?></b></h6>
						    <p class="card-text truncate"><?php echo $row['description'] ?></p>
						    <div class="d-flex w-100">
						   		<button class="btn-sm btn-block btn-outline-primary col-sm-2 mr-2 edit_upload" type="button" data-id ="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i> Edit</button>
						   		<button class="btn-sm btn-block btn-outline-danger col-sm-2 m-0 delete_upload" type="button" data-id ="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i> Delete</button>
						    </div>
						  </div>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#upload').click(function(){
		uni_modal("<i class='fa fa-video'></i> Upload Video","upload.php","large")
	})
	$('.edit_upload').click(function(){
		uni_modal("<i class='fa fa-video'></i> Edit Uploaded Video","upload.php?id="+$(this).attr('data-id'),"large")
	})
	$('.vid-item').click(function(){
		location.href = "index.php?page=watch&code="+$(this).attr('data-id')
	})
	$('.vid-item').hover(function(){
		var vid = $(this).find('video')
		var id = vid.get(0).id;
			setTimeout(function(){
				vid.trigger('play')
				document.getElementById(id).playbackRate = 2.0
			},500)
	})
	$('.vid-item').mouseout(function(){
		var vid = $(this).find('video')
			setTimeout(function(){
				vid.trigger('pause')
			},500)
	})
	$('.delete_upload').click(function(){
		_conf("Are you sure to delete this data?","delete_upload",[$(this).attr('data-id')])
	})
	function delete_upload($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_upload',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>