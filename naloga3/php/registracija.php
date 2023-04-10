
<html>
<form  method="POST" action="registracija.php">
                                    <!-- Name input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="uporabnisko_ime" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                                        <label >Full name</label>
                                        <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                                    </div>
                                    <!-- Email address input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="email" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                                        <label for="email">Email address</label>
                                        <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                        <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                                    </div>
                                    <!-- Password number input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="geslo" type="password" placeholder="******" data-sb-validations="required" />
                                        <label for="password">Password</label>
                                        <div class="invalid-feedback" data-sb-feedback="password:required">Password is required.</div>
                                    </div>
                                   
                                       
                                    <div id="tukaj">

                                    </div>
                                    <div class="d-grid"><input  class="btn btn-primary btn-lg " id="submit" value="Insert Data"  name="submit" type="submit"></input></div>
                                    <div class="text-muted">
                                        <p> Already have and account? Click here to  <a href="vpis.html"> Login</a> </p>
                                       
                                    </div>
                                </form>
</html>
<?php
 //  include_once('header.php');
		//prijavni podatki
		#********* povezava na PB ********************************************************/
		include_once('connection.php');
       require_once('connection.php');
		#*********************************************************************************/	
		//preverimo, ce je uporabnik vnesel vse podatke v formo
        if(isset($_POST['submit'])){
		if (isset($_POST['uporabnisko_ime']) && isset($_POST['email'])
		&& isset($_POST['geslo']))
		{
			//pridobivanje podatkov iz obrazca in shranjevanje v spremelnjivke
			$uporabnisko_ime = $_POST['uporabnisko_ime']; 
			$email = $_POST['email'];
            $geslo=$_POST['geslo'];
            $salt = base64_encode(random_bytes(16));
			$hashed_password = password_hash($geslo . $salt, PASSWORD_BCRYPT);
		
			//vnos podatkov v PB (SQL)
			$pdoQuery="INSERT INTO  registriran_uporabnik(`uporabnisko_ime`, `email`,`geslo`, `salt`) VALUE (:uporabnisko_ime,:email, :geslo, :salt)"; //SPREMENI POIZVEDBO GLEDE NA PODATKOVNO BAZO		
			$pdoRezultat= $povezava->prepare($pdoQuery);
			$pdoRezultat->execute(array(":uporabnisko_ime"=>$uporabnisko_ime, ":email"=> $email, ":geslo"=>$hashed_password, ":salt"=>$salt));
		
			// ID NAZADNJE VSTAVLJENE VRSTICE
			$idVstavljeneVrstice = $povezava->lastInsertId();
			//echo $geslo;
            echo $hashed_password . " to je hashed password " . $salt . " to je  salt";
			header( 'Location:\OIV\naloga3\uporabnik.html' );

}
        }




	

		?>
		
