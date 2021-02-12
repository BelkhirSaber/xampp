<?php
    // require_once "connexion.php";
    // use connection\Connexion;

    // $connexion = new Connexion();
    // echo "<pre>";
    // var_dump($connexion);
    // echo "</pre>";



    // $dsn = "mysql:host=localhost;dbname=vemail";
    // $username = "root";
    // $pass = "";
    // $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");
    // global $con;
    // try{
    //     $con = new PDO($dsn, $username, $pass, $option);
    //     $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     echo "<br>";
    //     echo "<pre>";
    //     var_dump($con);
    //     echo "</pre>";
    //     echo 'connection successfuly';
    // }catch(Exception $e){
    //     echo "conneciton failed" . $e->getMessage();
    // }
    

    require_once "conx.php";
    use conx\Conx;
    
    
    class API {
        function select(){
            $users = array();
            try{
                $con = new Conx();
                $query  = "SELECT * FROM users ORDER BY id";
                $data = $con->prepare($query);
                $data->execute();
                while($outPut = $data->fetch(PDO::FETCH_ASSOC)){
                    $users[$outPut['id']] = array(
                        "id" => $outPut['id'],
                        "firstname" => $outPut['firstname'],
                        "lastname" => $outPut['lastname'],
                        "email" => $outPut['email'],
                    );
                }
                // echo 'connection succesfuly';
            }catch(Exception $e){
                echo "connextion failed " . $e->getMessage();
            }
            return json_encode($users);
        }
    }

    $api = new API();
    echo $api->select();
?>