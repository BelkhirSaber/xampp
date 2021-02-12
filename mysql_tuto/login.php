<?php
    if(isset($_POST['username'], $_POST['pass'])){
        if($_POST['username'] == "saber" && $_POST['pass'] == "1234"){
            echo 1;
        }else{
            echo 0;
        }
    }
?>