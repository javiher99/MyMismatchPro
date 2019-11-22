<?php 
	require_once('header.php');
	if(!Func::checkLogin($con)){
        header("location: index.php");
	}
    require_once("nav.php");
    $perfiles = 8;
    $id = $_SESSION['user_id'];
?>

<div class="limiter m-t-0 wrap-login100 d-flex flex-column justify-content-center ancho">
		<div class="wrap-login100 d-flex flex-column justify-content-center todo m-b-40 m-t-20">
            <h1 class="text-center m-t-20 verde">Our latest profiles</h1>
        </div>
        <div class="d-flex flex-w flex-row flex-sa">

            <?php
                $db = new DBConnection();
                $sql = "SELECT * FROM users WHERE user_id !=".$id." ORDER BY user_id DESC LIMIT ".$perfiles.";";
                foreach($db->getQuery($sql) as $row){
                    echo '<a href="profile.php?id='.$row['user_id'].'">';
                    echo '<div class="d-flex flex-w flex-col flex-m p-t-20 p-l-20 p-r-20 p-b-20">';
                    echo "<img class='foto' src='".$row['user_picture']."'/>";
                    echo "<p class='text-center letranormal'>".$row['user_firstname'] ." ".$row['user_lastname']."</p>";
                    echo '</div>';
                    echo "</a>";
                }
            ?>

        </div>
</div>