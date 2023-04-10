<!DOCTYPE html>
<html>
<head>
	<title>Digital Signatures</title>
</head>
<body>
	<h1>Digital Signatures</h1>
	<form method="post" enctype="multipart/form-data">
    <h2>Sign File</h2>
<label for="file">File to sign:</label>
<input type="file" name="file" required><br><br>
<label for="key">Private key:</label>
<input type="file" name="key" required><br><br>
<button type="submit" name="sign">Sign</button>
<!-- s -->
	</form>
	<hr>
	<form method="post" enctype="multipart/form-data">
		<h2>Verify Signature</h2>
		<label for="file">File to verify:</label>
		<input type="file" name="file" required><br><br>
		<label for="signature">Signature:</label>
		<input type="file" name="signature" required><br><br>
		<button type="submit" name="verify">Verify</button>
	</form>

	<?php
if (isset($_POST['sign'])) {
    // Get file path
    $file_path = $_FILES['file']['tmp_name'];
    // Get private key path
    $key_path = $_FILES['key']['tmp_name'];
    
    // Generate output file path
    $output_path = 'C:\xampp\htdocs\OIV\.' . $_FILES['file']['name'] . '.sig';
       // Load private key
       $key = openssl_pkey_get_private("file://$key_path");
       if (!$key) {
           echo "<p>Error loading private key!</p>";
           return;
       }  
       // Read file contents
       $data = file_get_contents($file_path); 
       // Create signature
       openssl_sign($data, $signature, $key);
       // Write signature to output file
       file_put_contents($output_path, $signature); 
       // Free resources
       openssl_free_key($key);
  
       echo "<p>File signed successfully!</p>";

}
	// Check if verify form is submitted
	if (isset($_POST['verify'])) { //če je gumb verify pritisnjen
		// Get file path
		$file_path = $_FILES['file']['tmp_name'];
		// Get signature path
		$signature_path = $_FILES['signature']['tmp_name'];	
	// Load public key
		$key = openssl_pkey_get_public(file_get_contents('C:\xampp\htdocs\OIV\public_key.pem'));
		// Read file contents
		$data = file_get_contents($file_path);
		// Read signature
		$signature = file_get_contents($signature_path);
		// Verify signature
		$valid = openssl_verify($data, $signature, $key);

		// Free resources
		openssl_free_key($key);

		if ($valid === 1) {
			echo "<p>Signature is valid!</p>";
		} elseif ($valid === 0) {
			echo "<p>Signature is invalid!</p>";
		} else {
			echo "<p>Verification error!</p>";
		}
	}
    	// Define function to verify signature
	?>
</body>
</html>
