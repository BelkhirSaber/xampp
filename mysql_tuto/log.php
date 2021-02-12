<?php
    if(isset($_POST['username'], $_POST['pass'])){
        echo $_POST['username'] . "<br>";
        echo $_POST['pass'];
    }
?>