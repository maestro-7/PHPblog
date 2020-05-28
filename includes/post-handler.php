<?php
if(isset($_POST['addButton']))
	{
		$title = $_POST['title'];
		$details = $_POST['details'];
		
		$result = $post->insertPost($userLoggedIn->id,$title,$details);
    }
    ?>