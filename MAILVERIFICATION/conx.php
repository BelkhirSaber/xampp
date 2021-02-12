<?php  namespace conx;
    use PDO;
    class Conx extends PDO{

        private $dsn = "mysql:host=localhost;dbname=testingdb";
        private $username = "root";
        private $password = "";
        private $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");
        
        public function __construct(){
            parent::__construct($this->dsn, $this->username, $this->password, $this->option);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

?>