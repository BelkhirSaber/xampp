<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      .Error, .success{
        margin: 20px 30px;
        background-color: #F5F5F5;
        font-size: 21px;
        font-family: Arial;
        font-weight: 600;
        padding: 10px;
        color: red
      }
      .success{
        color: green;
      }
    </style>
</head>
<body>
    <?php
      if($_SERVER['REQUEST_METHOD'] == "POST"){

        $uplodeFile = $_FILES['file'];
        // echo '<pre>';
        // print_r($uplodeFile);
        // echo '</pre>';
        $filename = $uplodeFile['name'];
        $filetype = $uplodeFile['type'];
        $filetmp_name = $uplodeFile['tmp_name'];
        $filesize = $uplodeFile['size'];
        $fileerror = $uplodeFile['error'];
        // echo getcwd() .  "<br>";
        // echo dirname(getcwd()) .  "<br>";
        // echo realpath(dirname(getcwd()));

        
        $AllowExtension = array('jpg', 'jpeg', 'gif');
        

        $i = 0;
        for(;;){
          if($fileerror[$i] == 0){

            $Error = array();
            $aux = explode('.', $filename[$i]);
            $extension = strtolower(end($aux));

            // Check File Extension
            if(!in_array($extension, $AllowExtension)){
              $Error[] = "<div class='Error'> " . $filename[$i] . " Extesion Not Valide plaise choise file with Extension jpg, jpeg, png, gif</div>";
            }
            echo $filesize[$i] . "<br>";
            // Check File Size
            if($filesize[$i] > 1000000){
              $Error[] = "<div class='Error'>" . $filename[$i] . " File Size More Then Valide Max Size</div>";
            }

          }else{
            // Error Where Not Uploaded File
            switch($fileerror[$i]){
              case 1:
                $Error[] = "<div class='Error'>" . $filename[$i] . "Size File More Then Max Size Confingure</div>";
                break;
              case 2:
                $Error[] = "<div class='Error'>" . $filename[$i] . "Size File More Then Max Size Formulaire Confingure</div>";
                break;
              case 3:
                $Error[] = "<div class='Error'>" . $filename[$i] . "Error Uploaed All File</div>";
                break;
              case 4:
                $Error[] = "<div class='Error'>" . $filename[$i] . "No File uploaded</div>";
                break;
              case 6:
                $Error[] = "<div class='Error'>" . $filename[$i] . "Error Temporary Directory</div>";
                break;
              case 7:
                $Error[] = "<div class='Error'>" . $filename[$i] . "Error Write File Uploaded</div>";
                break;
              case 8:
                $Error[] = "<div class='Error'>" . $filename[$i] . "Error Extension</div>";
                break;
              default :
                break;
            }
          }

          // Move File To Directory Or Display Error File
          if(empty($Error)){
            move_uploaded_file($filetmp_name[$i], realpath(dirname(getcwd())) . '\FileUplode\uploade\\' . $filename[$i]);
            echo "<div class='success'>File " . $filename[$i] . " Uploaded Successufuly</div>";
          }else{
            $errorCount = 0;
            do{
              echo $Error[$errorCount];
              $errorCount++;
  
            }while(count($Error) > $errorCount);
          }
          // Inccrement Boocle
          $i++;
          // Condition End Boocle
          if($i > count($filename) - 1){break;}
        }

        // echo $_SERVER['DOCUMENT_ROOT'];
        
        
        // echo $extension;
        // echo $filename . "<br>";
        // echo $filetype . "<br>";
        // echo $filetmp_name . "<br>";
        // echo $filesize . "<br>";
        // echo $fileerror . "<br>";

        /*
        

        if($fileerror == 0){
          

        }else{
  MAMè6  ·µº©¸ªº©·»°º·ºº¹ºª¸«¨¨§«¹©· ¹©¸©«	·º	º·ª¹¹	º§»¹ª
»
ª§ªº º
·°¹ ¹ª¸°
ª
¹»º© ºª¸«ºª¸º	ºº«ºº	©¹ºz              °z 
       °	   °°©   ª»°¹©©°«¨«¹°° ©¨    « 	                              á)ÆpO1q¢DºL$NfúÒ{þ9~í·þftð#MHÑWs"Qm;ùâ²#QaÚ"