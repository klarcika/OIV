
<?php
 include_once('header.php');
 include_once('connection.php');

if(isset($_POST['email'])){
  echo $_POST['email'];
  $email=$_POST['email'];
  //to who
  $to =$email;
  //subject
  $subject = 'Welcome to our website';
  //message
  $message = '<p>Thank you for registering on our website. We hope you have a great time!</p>';
  //headers
  $headers = 'From: Lawliet-s Studio <klara.kirbis@student.um.si>\r\n' ;
 
  $headers .= 'Reply-To: klara.kirbis@student.um.si' . "\r\n" ;
  $headers .="Content-type: text/html\r\n";
  $headers .= 'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);

  if (mail($to, $subject, $message, $headers)) {
    echo "<script>alert('Email failed to send')</script>";
    header( "Location:\Projektna\index.html" );
//header( "Location:\Projektna\index.html");
} else {
$message = "This is an alert message";
$message = urlencode($message);
header("Location: index.php?message=$message");
}

//header( 'Location:\Projektna\uporabnik.html' );
}


?>