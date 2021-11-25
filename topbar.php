<style>
	.logo {
    margin: auto;
    font-size: 20px;
    background: white;
    padding: 7px 11px;
    border-radius: 50% 50%;
    color: #000000b3;
}
nav .nav-link{
	color:white !important;
}
nav .nav-item{
	width: auto !important
}
@media (min-width: 992px){
	.navbar-expand-lg .navbar-nav {
	    flex-direction: row;
	}
}
</style>

<nav class="navbar navbar-light navbar-expand-lg fixed-top bg-primary" style="padding:0">
  <div class="container">
	    <a class="navbar-brand js-scroll-trigger text-white" href="./"><img src="assets/img/logo.png" width="50" style="float: left;"></a>
	    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
	    <div class="col-sm-6 pt-2">
	    	<div class="input-group input-group-sm mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
			  </div>
			  <input type="text" id="search" value="<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
			</div>
	    </div>
	    <div class="collapse navbar-collapse" id="navbarResponsive">
	        <ul class="navbar-nav ml-auto my-2 my-lg-0">
	            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Home</a></li>
	            <?php if(isset($_SESSION['login_id'])): ?>
	            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=my_uploads">My Uploads</a></li>
	            <li class=" dropdown nav-item">
                	<a href="#" class="text-white dropdown-toggle nav-link"  id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo ucwords($_SESSION['login_firstname'].' '.$_SESSION['login_middlename']) ?> </a>
	              <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
	                <a class="dropdown-item" href="index.php?page=signup&id=<?php echo $_SESSION['login_id'] ?>" id=""><i class="fa fa-cog"></i> Manage Account</a>
	                <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
	              </div>
	            </li>
	          <?php else: ?>
	            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="javascript:void(0)" id="login_now">Login</a></li>
	          <?php endif; ?>
	           
	            
	         
	        </ul>
	    </div>
	</div>
</nav>

<script>
  $('#login_now').click(function(){
    uni_modal("LOGIN",'login.php')
  })
  $('#search').keypress(function(e){
  	if(e.which == 13){
  		location.href = "index.php?s="+$(this).val()
  	}
  })
</script>