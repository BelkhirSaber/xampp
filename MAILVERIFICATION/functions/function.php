<?php namespace tool;
    
    class Functions{
        
        function redirect($location, $msg){
            $url = $location . "&msg=" . $msg;
            echo $url;
            header("Location:$url");
            exit;
        }

        function refresh($location, $delay){
            echo "<div class='text-muted text-center text-uppercase'>redirect after $delay ...!<div>";
            header("Refresh:$delay;url=$location");
            exit;
        }

        function namePost($name="", $data=[] ){
            
            if(count($data) > 0){
                for($i = 0; $i < count($data); $i++ ){
                    echo $data[$i] . "<br>";
                }
            }else{
                echo "no data in array";
            }
        }

        function nameGet($name, $data){
            echo gettype($name) . "<br>" . gettype($data) ;
        }

        
    }

?>