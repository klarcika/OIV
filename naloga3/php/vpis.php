<html>
<form   method="POST" action="vpis.php">
                                   <div class="form-floating mb-3">
                                       <input class="form-control" name="email" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                                       <label for="email">Email address</label>
                                       <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                       <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                                   </div>
                             
                                   <div class="form-floating mb-3">
                                       <input class="form-control"  name="geslo" type="password" placeholder="******" data-sb-validations="required" />
                                       <label for="password">Password</label>
                                       <div class="invalid-feedback" data-sb-feedback="password:required">Password is required.</div>
                                   </div>
                            
                                   <div class="d-grid"><input class="btn btn-primary btn-lg "  value="Insert Data"  name="potrdi" type="submit"></input></div>
                                   <div class="text-muted">
                                       <p> Don't have an account? Click here to <a href="registracija.html"> Sign in</a>
                                       </div></p>
                                       
                               </form>
</html>

<?php
include_once('connection.php');

if (isset($_POST["potrdi"])) {
    if (empty($_POST["email"]) || empty($_POST["geslo"])) {
        echo "Mankajoca polja";
    } else {
        $username = $_POST['email'];
        $password = $_POST['geslo'];
        $stmt = $povezava->prepare('SELECT * FROM registriran_uporabnik WHERE email= :email');
        $stmt->bindValue(':email', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt) echo "stmt je sel skoz "; else echo " to ne dela ";
        if ($user) echo "user je sel skoz "; else " user ni sel skoz ";
       
        //echo  password_verify($_POST['geslo'] . $user['salt'], $user['geslo']);
        // Check if user exists and password is correct
   
        if ( password_verify($_POST['geslo'] . $user['salt'], $user['geslo'])) {
            echo "Login successful!";
            header( 'Location:\OIV\naloga3\uporabnik.html');
        } else {
            echo " Incorrect username or password.";
            header( 'Location:\OIV\naloga3\vpis.html');
        }
    }
}
?>


