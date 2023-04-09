<!DOCTYPE html>
<html>
<head>
	<title>Elektronsko podpisovanje datotek</title>
</head>
<body>
	<h1>Elektronsko podpisovanje datotek</h1>
	<form method="post" enctype="multipart/form-data">
		<h2>Podpiši datoteko</h2>
        <div>
            <label for="fileToSign">Datoteka za podpis: </label>
            <input type="file" name="fileToSign" ><br>

            <label for="privateKey">Zasebni ključ/ potrdilo:</label>
            <input type="file" name="privateKey" ><br>

            <input type="submit" name="sign" value="Sign and Save"><br><br>
        </div>
		
		<hr>
        <div>
            <h2>Preverjanje podpisa</h2>
            <label for="signedFile">Podpisana datoteka:</label>
            <input type="file" name="signedFile" ><br>

            <label for="publicKey">Podpis:</label>
            <input type="file" name="publicKey"><br>

            <input type="submit" name="verify" value="Verify Signature"><br>	
        </div>
	</form>
</body>
</html>
<?php

if (extension_loaded("openssl") == false) {
    echo "OpenSSL extension not loaded!";
} else {
    //  echo "OpenSSL extension loaded!";
    if (isset($_POST['sign'])) {
        // Load the file to sign
        $file = $_FILES['fileToSign']['tmp_name'];
        $data = file_get_contents($file);

        // Load the private key from a file
        $privateKeyString = file_get_contents($_FILES['privateKey']['tmp_name']);
        $privateKey = openssl_get_privatekey($privateKeyString);
        if (!$privateKey) {
            echo "<p>Error loading private key!</p>";
            return;
        }
        $output_path= 'C:\xampp\htdocs\OIV\.'.'downloaded_file'. '.sig';
        // Sign the data
        openssl_sign($data, $signature, $privateKey);

        // Save the signed data to a file
       // $signedFile = 'podpisana_datoteka.txt';
        file_put_contents($output_path, $signature);
        openssl_free_key($privateKey);
        echo("Podpisana datoteka je naložena.");
    }

    if (isset($_POST['verify'])) {
        // Load the signed file
        $signedFile = $_FILES['signedFile']['tmp_name'];
        $signedData = file_get_contents($signedFile);

        // Split the signed data into data and signature parts
      /*  $signedDataArray = explode(PHP_EOL, $signedData);
        $data = $signedDataArray[0];
        $signature = base64_decode($signedDataArray[1]);
*/
        // Load the public key from a file
        $signature = file_get_contents($_FILES['publicKey']['tmp_name']);
        $publicKey = openssl_get_publickey($signature);
  
        // Verify the signature
        $isValid = openssl_verify($signedData, $signature, $publicKey);
        // Free resources
        openssl_free_key($publicKey);
        if (!$publicKey) {
            echo "<p>Error with public key!</p>";
            return;
        }
        // Print the result
        if ($isValid) {
            echo 'Podpis je veljaven.';
        } else {
            echo 'Podpis ni veljaven.';
        }
    }
}

?>
