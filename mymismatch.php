<?php 
	require_once('header.php');
	if(!Func::checkLogin($con)){
        header("location: index.php");
	}
    require_once("nav.php");
    $perfiles = 8;
    $id = $_SESSION['user_id'];
    $divergencia = 0;
    $mismatch = 0;

    $db = new DBConnection();
    $sql = "SELECT * FROM mismatch_response WHERE user_id ='".$id."';";

    $misrespuestas = [];

    foreach($db->getQuery($sql) as $row){
        $misrespuestas[$row['topic_id']]= $row['response'];
    }

    $topicos_divergentes = [];
    $resultante = [];

    //echo $id;
    //var_export($misrespuestas);

    if($misrespuestas != null){
        $db = new DBConnection();
        $sql = "SELECT user_id FROM mismatch_response WHERE user_id !='".$id."' GROUP BY user_id;";
        

        foreach($db->getQuery($sql) as $row){
            //echo "usuario".$row['user_id']."<br/>";
            $db = new DBConnection();
            $sql = "SELECT user_id, topic_id, response FROM mismatch_response WHERE user_id =".$row['user_id'].";";
            $num = 0;
            foreach($db->getQuery($sql) as $row){
                //echo "topico".$row['topic_id']." con respuesta ".$row['response']."<br/>";
                if(isset($misrespuestas[$row['topic_id']])){
                    //echo "topic_id ".$row['topic_id'];
                    //echo "<br>entra</br>";
                    if($misrespuestas[$row['topic_id']] != $row['response']){
                        $topicos_divergentes[] = $row['topic_id'];
                        //echo $row['response']."<----<br/>";
                        //echo "<br>divergencia en </br>".$row['topic_id'];
                        $num++;
                        //echo "<br>".$num."</br>";
                    }
                }
            }
            if($num > $divergencia){
                $divergencia = $num;
                $mismatch = $row['user_id'];
                $resultante = $topicos_divergentes;
            }

            //echo "uuuuuuu".$mismatch;
            //echo "xxxx".$divergencia;
            //echo "<br>---".$num."---</br>";
        }


    }
    
?>

<div class="limiter m-t-0 wrap-login100 d-flex flex-column justify-content-center ancho">
        <?php
            if($mismatch != 0){
                $db = new DBConnection();
                $sql = "SELECT * FROM users WHERE user_id ='".$mismatch."';";
                foreach($db->getQuery($sql) as $row){
        ?>
            <div class="wrap-login100 d-flex flex-column justify-content-center todo m-b-40 m-t-20">
                <h1 class="m-t-20 m-b-30 text-center">My Mismatch!</h1>
                <h3 class="m-t-20">Your soul mate:</h3>
            </div>
            <div class="d-flex flex-w flex-row flex-c m-t-30 m-b-50">
                <div>
                    <h3><?php echo $row['user_firstname'].",".$row['user_lastname'] ?></h3>
                    <h3><?php echo $row['user_city'].", ".$row['user_state'] ?></h3>
                </div>
                <img class="fotoSingle"src="<?php echo $row['user_picture'] ?>"/>
            </div>

            <div class="d-flex flew-row flex-c m-t-30">
                <p class="visitar"><a href="profile.php?id=<?php echo $row['user_id'] ?>">View &rarr;</a> <?php echo $row['user_firstname']."'s profile"; ?></p>
            </div>
            <div class="m-t-30 m-b-40">
                <h2 class="m-b-20">You are mismatched on the following <?php echo $divergencia; ?> topics:<h2>
                <div class="d-flex flex-row flex-wrap">
                    <?php
                        foreach($resultante as $valor){
                            //echo $valor;
                            $db = new DBConnection();
                            $sql = "SELECT * FROM mismatch_topic WHERE topic_id =".$valor.";";
                            foreach($db->getQuery($sql) as $row){
                                echo "<h3 class='m-l-20'>".$row['name']."</h3>";
                            }
                        }
                    ?>
                </div>
            </div>
        <?php
                }
            }else{
                echo '<div class="wrap-login100 d-flex flex-column justify-content-center todo m-b-40 m-t-20">
                    <h1 class="m-t-20 m-b-30 text-center rojo">We cannot find your mismatch</h1>
                </div>';
            }
        ?>
</div>
<div>

</div>