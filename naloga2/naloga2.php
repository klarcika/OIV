<?php
  $context = stream_context_create([
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
        "allow_self_signed" => true
    ]
]);
if (extension_loaded("openssl")==false) {
    echo "OpenSSL extension not loaded!";
} elseif(extension_loaded("openssl")==true) {
// Generate public and private key
$privateKey = openssl_pkey_new(array(
    'private_key_bits' => 2048,
    'private_key_type' => OPENSSL_KEYTYPE_RSA
));

// Get private key as string
openssl_pkey_export($privateKey, $privateKeyString);

// Get public key as string
$publicKey = openssl_pkey_get_details($privateKey);
$publicKeyString = $publicKey['key'];

// Save private key to file
file_put_contents('C:\xampp\htdocs\OIV\myprivateKey.pem', $privateKeyString);

// Save public key to file
file_put_contents('C:\xampp\htdocs\OIV\mypublicKey.pem', $publicKeyString);

// Upload file and private key
if(isset($_FILES['file']) && isset($_FILES['private_key'])) {
    
    // Read uploaded file
    $fileContent = file_get_contents($_FILES['file']['tmp_name']);
    
    // Read private key
    $privateKeyContent = file_get_contents($_FILES['private_key']['tmp_name']);

    // Sign the file
    openssl_sign($fileContent, $signature, $privateKeyContent, OPENSSL_ALGO_SHA256);
    
    // Download signed file
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="signed_file.txt"');
    echo $signature;
    
} else if(isset($_FILES['signed_file']) && isset($_FILES['public_key'])) {
    
    // Read uploaded signed file
    $signedFileContent = file_get_contents($_FILES['signed_file']['tmp_name']);
    
    // Read public key
    $publicKeyContent = file_get_contents($_FILES['public_key']['tmp_name']);

    // Verify the signature
    $fileContent = file_get_contents($_FILES['file']['tmp_name']);
    $result = openssl_verify($fileContent, $signedFileContent, $publicKeyContent, OPENSSL_ALGO_SHA256);
    
    // Print verification result
    if($result == 1) {
        echo 'Signature is valid';
    } else {
        echo 'Signature is invalid';
    }
    
}
}

?>
