<?php

	session_start(); //get the session information
	

	include("includes/connection.php");
	include("includes/classes/Post.php");
	include("includes/classes/User.php");

	$userLoggedIn = null;

	if(isset($_SESSION['userLoggedIn'])) {
		$userLoggedIn = $_SESSION['userLoggedIn'];
		
	}
	$result = false;
	$post_ = new Post();

	if(isset($_POST['delete_id'])){
		$delete_id = $_POST['delete_id'];
		$result = $post_->deletePost($delete_id);

	}
	$user = new User();

	$allPosts = $post_->getAllPosts();

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script type="text/javascript">
				function deletePost(id){
					Swal.fire({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, delete it!'
						}).then((result) => {
						if (result.value) {
							document.getElementById("delete_id").value = id;
							document.getElementById("deletePost").submit();
							
						}
						})
				}
	</script>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<title>Home</title>

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="assets/css/font.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="assets/css/blog.css" rel="stylesheet">

	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>

</head>
<body>

		<form action="index.php" method="POST" id="deletePost">
			<input type="hidden" id="delete_id" name="delete_id" value="">
		</form>
	<div class="container">
		<header class="blog-header py-3">
			<div class="row flex-nowrap justify-content-between align-items-center">
		<a href="resume.php"><button class="btn btn-success" name="gotoresume" style="margin:15px;">Resume</button></a>
		
				<span class="m-title">Posts Blog</span>
		
				<div class="col-4 d-flex justify-content-end align-items-center">
					<?php if($userLoggedIn != null) {
						echo "
								<a class='btn btn-sm btn-outline-secondary' href='add_post.php' style='margin-right:2px;'>Add New
								</a>
								<a class='btn btn-sm btn-outline-secondary' href='logout.php'>Logout</a>
							";
						} else {
						 echo '<a class="btn btn-sm btn-outline-secondary" href="login.php">Login</a>';
						}
					?>
				</div>
			</div>
		</header>

  	</div>

	<main role="main" class="container">
		<div class="row">
			<div class="col-md-12 blog-main">
				<?php
					if($result != false)
					{
						echo "<div class='alert alert-danger' role='alert'> Post Successfully Deleted </div>";
						$result = false;
					}

					foreach($allPosts as $post){
				?>
					<div class="blog-post">
						<div class="title">
							<h2 class="blog-post-title"><?php echo "$post->title" ?></h2>
							<?php if($userLoggedIn != null && $post->user_id == $userLoggedIn->id){
									echo "<button  class='btn btn-danger' onclick='deletePost($post->id)'>X</button>";
							}?>
						</div>

						<p class="blog-post-meta">
						<?php  $date = strtotime($post->created_at);
								$con_date = date('F d, Y',$date);
								echo $con_date;
						?> by <a href="#"><?php echo $user->getName($post->user_id) ?></a></p>

						<p><?= $post->details?></p>
					</div><!-- /.blog-post -->

					<?php } ?>

			</div><!-- /.blog-main -->

		</div><!-- /.row -->

	</main><!-- /.container -->

	<script src="assets/js/jquery-3.3.1.min.js"/>
	
	</html>
