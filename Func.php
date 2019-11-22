<?php

    class Func{
        public static function checkLogin($dbh){
            if(!isset($_SESSION)){
                session_start();
            }

            if(isset($_COOKIE['user_id']) && isset($_COOKIE['token']) && isset($_COOKIE['serial'])){
                $userid = $_COOKIE['user_id'];
                $token = $_COOKIE['token'];
                $serialcookie = $_COOKIE['serial'];

                $sentencia = "SELECT * FROM sessions WHERE session_userid = :userid AND session_serial = :serialcookie AND session_token = :token;";
                $stmt = $dbh->prepare($sentencia);
                $stmt->execute(array(':userid' => $userid, ':token' => $token, ':serialcookie' => $serialcookie));

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($row['session_userid'] > 0){
                    Func::createSession($_COOKIE['user_id'],$_COOKIE['token'],$_COOKIE['serial']);
                    return true;
                } 
            } else {
                if(isset($_SESSION['user_id'])){
                    $user_id = $_SESSION['user_id'];
                    $token = $_SESSION['token'];
                    $serial = $_SESSION['serial'];

                    $sentencia = "SELECT * FROM sessions WHERE session_userid = :userid AND session_serial = :serialcookie AND session_token = :token;";
                    $stmt = $dbh->prepare($sentencia);
                    $stmt->execute(array(':userid' => $user_id, ':token' => $token, ':serialcookie' => $serial));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($row['session_userid']){
                        if($row['session_userid'] == $_SESSION['user_id'] &&
                            $row['session_token'] == $_SESSION['token'] &&
                            $row['session_serial'] == $_SESSION['serial']){
                                return true;
                        }
                    }
                }
            }
        }

        public static function createSerial($longitud){
            /*mt_srand(time());
            $sufijo = "";*/
            $cadena = "lavincompaeestoesmasdifisilporqueembeseslavidaesduraXDJIOKE";
            /*for($i = 0; $i < $longitud;$i++){
                $numalea = mt_rand(0, strlen($cadena)-1);
                $sufijo .= substr($cadena,$numalea,1);
            }
            return $sufijo;*/
            return substr(str_shuffle($cadena),0,$longitud);
        } 

        public static function createSession($userid, $token, $serial){
            if(!isset($_SESSION)){
                session_start();
            }

            $_SESSION['token'] = $token;
            $_SESSION['serial'] = $serial;
            $_SESSION['user_id'] = $userid;
        }

        public static function deleteCookie(){
            setcookie('user_id', '', time() - 3600, "/");
            setcookie('token', '', time() - 3600, "/");
            setcookie('serial', '', time() - 3600, "/");
            setcookie('PHPSESSID', '', time() - 3600, "/");
        }

        public static function createCookie($user_id, $token, $serial){
            setcookie('user_id', $user_id, time() + (3600 * 24 * 7), "/");
            setcookie('token', $token, time() + (3600 * 24 * 7), "/");
            setcookie('serial', $serial, time() + (3600 * 24 * 7), "/");
        }

        public static function recordSession($con, $user_id, $remember){
            //borrar la tupla de la sesion antigua si es que existe
            $con->prepare("DELETE FROM sessions WHERE session_userid = :user_id;")->execute(array(':user_id'=>$user_id));
            //generar un token y un serial
            $token = Func::createSerial(32);
            $serial = Func::createSerial(32);
            //crear las cookies de sesion para la persistencia
            if($remember == 1){
                Func::createCookie($user_id, $token, $serial);
            }
            Func::createSession($user_id, $token, $serial);
            //nueva tupla con los datos de sesion en la tabla sesiones
            $con->prepare("INSERT INTO sessions VALUES (NULL, :token, :serial, now(), :user_id);")->execute(array(':user_id'=>$user_id, ':token'=>$token, ':serial'=>$serial));
        }
    }

?>