

<?php
 include_once('header.php');
 
	include_once('connection.php');

 
if(isset($_SESSION["email"])){
    echo '<h3>successful login'.$_SESSION["email"].'</h3>';
}


if(isset($_POST['submit'])){

        $file=$_FILES['file']; //celotno ime datoteke

        echo $file;
        $fileName= $_FILES['file']['name'];
        $fileTmpName= $_FILES['file']['tmp_name'];
        $fileSize= $_FILES['file']['size'];
        $fileError= $_FILES['file']['error'];
        $fileType= $_FILES['file']['type'];

        $fileExt=explode('.',$fileName); //ki morem slice-at
        $fileActualExt= strtolower(end($fileExt)); //ce so velike crkev imenu dam vse v lower case

        
        $allowed=array('jpg','jpeg','png','jiff'); //zapisem kere dat dovolim dauporabnik uploada

        if(in_array($fileActualExt, $allowed)){ //preverim ce tip datoteke ustreza
            if($fileError===0){ //preverim ce so kake napake

                if($fileSize<10000000){ //preveerim velikost datoteke
                    $fileNameNew= uniqid('', true).".".$fileActualExt; 

                    //v primeru da je ime dat enako kot nase
                    // nastavljeno ime nardimo uniq id(timestamp) in dodamo lowecase ime

                    $fileDestination='C:\xampp\htdocs\Projektna\assets\.'.$fileNameNew; // kam naložimo novo datoteko
                    echo"   <img class='img-fluid rounded-circle mb-4 px-4' src='$fileDestination'  />";
               
                move_uploaded_file($fileTmpName, $fileDestination); //uploadamo datoteko iz lokacije kjer je trenutno v neko mapo
                header('Location: \Projektna\uporabnik.html');
                }else{
                    echo"prevelika datoteka";
                }
            }else{
                echo"napaka pri nalaganju";
            }

        }else{
            echo"ne mors nalozit te datoteke";
        }
        

}


?>



