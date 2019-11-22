<?php 
	require_once('header.php');
	if(!Func::checkLogin($con)){
        header("location: index.php");
	}
    require_once("nav.php");
    $perfiles = 8;
    $id = $_SESSION['user_id'];
    $respuestas = array();

    //rellenar array con toda la informacion de response referente al usuario
    $db = new DBConnection();
    $sql = "SELECT * FROM mismatch_response WHERE user_id='".$id."';";

    foreach($db->getQuery($sql) as $row){
        $respuestas[] = $row['topic_id']." ".$row['response'];
    }
    
    if(isset($_POST['submit'])){
        //Borramos todas las respuestas de ese usuario;
        $db = new DBConnection();
        $sql = "DELETE FROM mismatch_response WHERE user_id = '".$id."';";
        $db->runQuery($sql);

        //Insertamos las nuevas respuestas
        $topicos = array_keys($_POST['response']);
        for($i = 0 ; $i < sizeof($topicos); $i++){
            $db = new DBConnection();
            $sql = "INSERT INTO mismatch_response VALUES(NULL, '".$id."','".$topicos[$i]."','".$_POST['response'][$topicos[$i]]."');";
            $db->runQuery($sql);
        }
        header("location: questionnaire.php");
    }
?>

<div class="limiter m-t-0 wrap-login100 d-flex flex-column justify-content-center ancho">
		<div class="wrap-login100 d-flex flex-column justify-content-center todo m-b-40 m-t-20">
            <h1 class="text-center m-t-20">How do you feel about each topic?</h1>
        </div>
        <div class="d-flex flex-w flex-row flex-sa">
            <form class="login100-form validate-form flex-c flex-w" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <?php
                $db = new DBConnection();
                $sql = "SELECT * FROM mismatch_category;";
                foreach($db->getQuery($sql) as $row){
                    //Generamos las categorias
                    echo '<div class="ancho450 d-flex flex-w flex-col p-t-30 p-l-50 p-r-50 p-b-30">';
                    echo "<fieldset><legend class='m-b-10'>".$row['category_name']."</legend>";
                    $categorias = $row['category_id'];
                    $db = new DBConnection();
                    $sql = "SELECT * FROM mismatch_topic WHERE category_id = '".$categorias."';";

                    foreach($db->getQuery($sql) as $row){
                        //Obtenemos los tópicos de cada categoría
                        echo '<div class="d-flex flex-w flex-row flex-sb m-t-5">';
                        echo "<h5>".$row['name']."</h5>";
                        $resolucion = 0;

                        //Obtenemos la coincidencia de las respuestas con los tópicos
                        foreach($respuestas as $valor){
                            $respuesta = explode(" ",$valor);
                            if($row['topic_id'] == $respuesta[0]){
                                $resolucion = $respuesta[1];
                            }
                        }
                        
                        if($resolucion == 1){
                            echo '<div class="d-flex flex-row"><div class="m-r-10"><input type="radio" name="response['.$row['topic_id'].']" value="1" checked> Love</div>
                            <div><input type="radio" name="response['.$row['topic_id'].']" value="2"> Hate</div>';
                            echo '</div>';
                        }

                        if($resolucion == 2){
                            echo '<div class="d-flex flex-row"><div class="m-r-10"><input type="radio" name="response['.$row['topic_id'].']" value="1"> Love</div>
                            <div><input type="radio" name="response['.$row['topic_id'].']" value="2" checked> Hate</div>';
                            echo '</div>';
                        }

                        if($resolucion == 0){
                            echo '<div class="d-flex flex-row"><div class="m-r-10"><input type="radio" name="response['.$row['topic_id'].']" value="1"> Love</div>
                            <div><input type="radio" name="response['.$row['topic_id'].']" value="2"> Hate</div>';
                            echo '</div>';
                        }

                        echo '</div>';
                        
                    }
                    echo "</fieldset>";
                    echo '</div>';
                }
            ?>
                <div class="container-login100-form-btn justify-content-center m-t-20 m-b-20">
					<input type="submit"  class="btn btn-default btn-lg" value="Answer" id="send" name="submit"/>
				</div>
            </form>

        </div>
</div>