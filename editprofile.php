<?php 
	require_once('header.php');
	if(!Func::checkLogin($con)){
        header("location: index.php");
    }
    $num = -1;
    require_once("nav.php");
    $id = $_SESSION['user_id'];
    $db = new DBConnection();
    $sql = "SELECT * FROM users WHERE user_id = ".$id.";";
    if(isset($_POST['submit'])){
        $sentencia = "UPDATE users SET user_firstname = '".$_POST['user_firstname']."',".
        " user_birthday = '".$_POST['user_birthday']."',".
        " user_city = '".$_POST['user_city']."',".
        " user_state = '".$_POST['user_state']."',";

        if($_POST['user_password'] != "" && $_POST['passRepeat'] != null && $_POST['user_password'] == $_POST['passRepeat']){
            $sentencia .= " user_password = '".sha1($_POST['user_password'])."',";
        }

        if($_FILES['user_picture']['error'] == 0){
            $suf = USER::sufijo();
            $imgsrc = $_FILES['user_picture']['name'];
            $array = explode('.', $imgsrc);
            $nuevonombre = $array[0]."".$suf.".".$array[1];
            $filename = $_FILES['user_picture']['tmp_name'];
            $destination = "./imgs/".$nuevonombre;
            if(move_uploaded_file($filename, $destination)){
                $user = new User($_POST);
				$user->setDestination($destination);
            }
            $sentencia .= " user_picture = '".$destination."',";
        }
        
        $sentencia .= " user_lastname = '".$_POST['user_lastname']."' WHERE user_id =".$id.";";           
        $db = new DBConnection();
        $num = $db->runQuery($sentencia);
    }
		
?>

<div class="limiter m-t-0 wrap-login100 d-flex flex-column flex-c flex-m anchoSingle">
        <div class="wrap-login100 d-flex flex-column justify-content-center todo m-b-20 m-t-20">
            
            <?php
                if($num == 1){
                    echo '<h1 class="text-center m-t-20 verde">The edition was a success</h1>';
                }
                if($num == 0){
                    echo '<h1 class="text-center m-t-20 rojo">Something went wrong</h1>';
                }
            ?>
            
        </div>
		<div class="wrap-login100 d-flex flex-column justify-content-center todo m-b-20 m-t-20">
            <h1 class="text-center m-t-20">Edit your profile</h1>
        </div>
        <div class="d-flex flex-col flex-sa flex-m todo">
        <form class="login100-form validate-form flex-m flex-w flex-col" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <?php
                foreach($db->getQuery($sql) as $row){
                    echo '<div class="d-flex flex-w flex-col p-t-20 p-l-20 p-r-20 p-b-20">';
                    echo "<img class='fotoSingle' src='".$row['user_picture']."'/>";
                    echo '</div>';
                    echo '<div class="wrap-input100 validate-input m-b-12">
                        <input type="hidden" name="MAX_FILE_SIZE" value="600000"/>
                            <div class="m-t-20 m-b-20">
                                <input type="file" name="user_picture" accept="image/png, image/jpg, image/jpeg" class="data"/>
                            </div>
                        <span class="focus-input100"></span>
                    </div>';

                    echo '<div class="wrap-input100 validate-input m-b-12">
                        <input class="input100" type="text" name="user_firstname" value="'.$row['user_firstname'].'" required>
                        <span class="focus-input100"></span>
                    </div>';

                    echo '<div class="wrap-input100 validate-input m-b-12">
                        <input class="input100" type="text" name="user_lastname"  value="'.$row['user_lastname'].'" required>
                        <span class="focus-input100"></span>
                    </div>';

                    echo '<div class="wrap-input100 validate-input m-b-12">
                        <input class="input100" type="date" name="user_birthday" value="'.$row['user_birthday'].'" required>
                        <span class="focus-input100"></span>
                    </div>';

                    echo '<div class="wrap-input100 validate-input m-b-12">
                        <input class="input100" type="text" name="user_state" value="'.$row['user_state'].'" required>
                        <span class="focus-input100"></span>
                    </div>';

                    echo '<div class="wrap-input100 validate-input m-b-12">
                        <input class="input100" type="text" name="user_city" value="'.$row['user_city'].'" required>
                        <span class="focus-input100"></span>
                    </div>';

                    echo '<span class="txt1 p-b-11">
                        Gender
                    </span>
                    <div class="wrap-input100 validate-input m-b-12">
                        <div class="d-flex flex-row justify-content-around m-t-20 m-b-20">';
                    if($row['user_gender']==1){
                        echo '<div>
                                <input type="radio" name="user_gender" value="1" checked> Male
                            </div>
                            <div>
                                <input type="radio" name="user_gender" value="2"> Female
                            </div>';
                    }
                    if($row['user_gender']==2){
                        echo '<div>
                                <input type="radio" name="user_gender" value="1"> Male
                            </div>
                            <div>
                                <input type="radio" name="user_gender" value="2" checked> Female
                            </div>';
                    }
                    echo '</div>
                        <span class="focus-input100"></span>
                    </div>';
                    
                    echo '<div class="wrap-input100 validate-input m-b-12">
                        <span class="btn-show-pass">
                            <i class="fa fa-eye"></i>
                        </span>
                        <input class="input100" placeholder="Password" type="password" name="user_password" name="pass" >
                        <span class="focus-input100"></span>
                    </div>';

                    echo '<div class="wrap-input100 validate-input m-b-12">
                        <span class="btn-show-pass">
                            <i class="fa fa-eye"></i>
                        </span>
                        <input class="input100" placeholder="Repeat Password" type="password" name="passRepeat" name="pass" >
                        <span class="focus-input100"></span>
                    </div>';
                }
            ?>
            <div class="container-login100-form-btn justify-content-center m-t-20 m-b-20">
                <input type="submit"  class="btn btn-default btn-lg" value="Edit" id="send" name="submit"/>
            </div>
        </form>
        </div>
</div>