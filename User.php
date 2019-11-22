<?php

    class User{

        protected $user_username, $user_password, $user_firstname, $user_lastname, $user_status, $user_gender, $user_birthday, $user_city, $user_state, $user_picture;

        public function __construct($data){
            foreach($this as $clave => $valor){
                if(property_exists($this, $clave)){
                    if(isset($data[$clave])){
                        $this->$clave = $data[$clave];
                    }else{
                        $this->$clave = 0;
                    }
                }
            }
            $this->user_password = sha1($this->user_password);
        }

        public static function sufijo(){
            mt_srand(time());
            $sufijo = "";
            $cadena = "abcdefjhijklmnopqrstuvwxyz0123456789";
            for($i = 1; $i <= 8;$i++){
                $numalea = mt_rand(0, strlen($cadena)-1);
                $sufijo .= substr($cadena,$numalea,1);
            }
            return $sufijo;
        }

        public function setDestination($destino){
            $this->user_picture = $destino;
        }

        public function getAllData(){
            $fields = array();
            $fields[] = 'NULL';
            foreach( $this as $clave=>$valor){
                if(isset($this->$clave)){
                    $fields[] = "'".$this->$clave."'";
                }else{
                    $fields[] = "0";
                }
            }
            return $fields;
        }
    }    

?>