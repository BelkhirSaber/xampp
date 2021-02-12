<?php
    interface saber{
        function saber($name);
        public function getname();
    }

    abstract class home{
        public $name;
        public function getName(){
            return $name;
        }
        abstract public function saber();
    }

    class Users{
        public $name = "ali";
        public $age ;
        protected $familyName;
        private $price ;

        public function setValue($name, $age, $familyName, $price){
            $this->name = $name;
            $this->age = $age;
            $this->familyName = $familyName;
            $this->price = $price;
        }
        public function getname(){
            return $this->name;
        }
        public function getPrice(){
            return $this->price;
        }
    }

    class User extends Users{
        private $marque;

        public function setItem($name, $age, $familyName, $price, $marque){
            
            self::setValue($name, $age, $familyName, $price);
            $this->marque = $marque;
        }

        public function setMarque($m){
            $this->marque = $m;
        }

        public function getname(){
            echo $this->name;
        }
    }

    class block extends home{
        public function saber(){

        }
    }
    class chaine implements saber{
        public function saber($name){
            echo $name;
        }
        public function getname(){
            echo 'pravite name';
        }
    }
    $saber = new User();
    $saber->setItem("saber", 25, "belkhir", 1200, "saberbelkhir");
    $saber->getname();
    echo '<pre>';
    var_dump($saber);
    echo '</pre>';



    $mohamed = new User();
    $mohamed->setItem("mohamed", 25, "belkhir", 200, "saberbelkhir");
    echo $mohamed->getname();
    echo '<pre>';
    var_dump($mohamed);
    echo '</pre>';
?>
