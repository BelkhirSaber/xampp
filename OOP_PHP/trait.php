<?php

    require('Device.php');
    require('Mantenance.php');

    spl_autoload_register(function ($class){
        require($class.".php");
    });

    
    class newSaber extends mainting\Mantenance{

    }

    $element = new newSaber();
    $element->hello();
    echo '<br>';
    $device = new work\Device();
    $device->hello();
    // $iphone6 = new Phone("Apple Brand", "Apple", "Iphone 6");
    // // $iphone6->loginFilter();
    // $iphone6->singupFilter();
?>