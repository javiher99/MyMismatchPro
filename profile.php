<?php 
	require_once('header.php');
	if(!Func::checkLogin($con)){
        header("location: index.php");
	}
    require_once("nav.php");
    $id = $_GET['id'];
    $db = new DBConnection();
    $sql = "SELECT * FROM users WHERE user_id = ".$id.";";
?>

<div class="limiter m-t-0 wrap-login100 d-flex flex-column justify-content-center anchoSingle">
		<div class="wrap-login100 d-flex flex-column justify-content-center todo m-b-20 m-t-20">
            <?php
                foreach($db->getQuery($sql) as $row){
                    echo '<h1 class="text-center m-t-20 verde">'.$row['user_firstname'] ." ".$row['user_lastname'].'</h1>';
                }
            ?>
            
        </div>
        <div class="d-flex flex-col flex-sa flex-m todo">

            <?php
                foreach($db->getQuery($sql) as $row){
                    echo '<div class="d-flex flex-w flex-col p-t-20 p-l-20 p-r-20 p-b-20">';
                    echo "<img class='fotoSingle' src='".$row['user_picture']."'/>";
                    echo '</div>';

                    echo '<div class="d-flex flex-w flex-col flex-l p-t-20 p-l-20 p-r-20 p-b-20">';
                    echo "<h3 class='m-b-10 m-t-10'>State: ".$row['user_state']."</h3>";
                    echo "<h3 class='m-b-10 m-t-10'>City: ".$row['user_city']."</h3>";
                    if($row['user_gender'] == 1){
                        echo "<h3 class='m-b-10 m-t-10'>Gender: Man</h3>";
                    }
                    if($row['user_gender'] == 2){
                        echo "<h3 class='m-b-10 m-t-10'>Gender: Woman</h3>";
                    }
                    echo "<h3 class='m-b-10 m-t-10'>Birthdate: ".$row['user_birthday']."</h3>";
                    echo '</div>';
                }
            ?>

        </div>
</div>