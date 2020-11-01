<?php 


 ?>

 	<header style="background-color:#006666;color:white">
		<div>

			<div style=" float:left">
				<img src="../includes/sltb_logo.jpg" width="80" height="45">
			</div>

			<div>
				<h3>Welcome <?php echo($_SESSION['designation']) ; ?>
				<h3>
			</div>

			<div>
				<a style="float:right;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Settings
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="profile.php">Profile</a>
					<a class="dropdown-item" href="logout.php">Log Out</a>
					
				</div>
			</div>
			

		</div>
	</header>