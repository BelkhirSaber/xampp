<?php namespace connection;

    use PDO;
    use Exception;

    class Connexion{
        private $dsn = "mysql:host=localhost;dbname=vemail";
        private $username = "root";
        private $password = "";
        private $option  = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
        public $con;

        function __construct(){
            try{
                $this->con = new PDO($this->dsn, $this->username, $this->password, $this->option);
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "connection successfly";
                return $this->con;
            }catch(Exception $e){
                echo "connection failed " . $e->getMessage();
            }
        }
    }
?>