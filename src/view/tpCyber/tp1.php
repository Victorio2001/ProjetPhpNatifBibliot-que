<?php
require_once '../../../config/localConfig.php';

echo '<h1> Fonction de hash (sha256) mot de passe (victorio) <h1/>';
echo hash('sha256', 'victorio');

echo '<h1> Génération de Clés RSA <h1/>';

$config = array(
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

// Create the private and public key
$res = openssl_pkey_new($config);

var_dump("message d'erreur".openssl_error_string());

// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey);

// Extract the public key from $res to $pubKey
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

echo "<h1>salut la public key<h1/>".$pubKey;
echo '<br>';
echo "<h1>salut la private key<h1/>".$privKey;

$data = 'plaintext data goes here';


echo '<h1> Exercice 2 <h1/>';

openssl_pkey_export(
    $privKey,
    $output,
);

var_dump("Notre fichier au format temp exporter".$output);
var_dump("Notre fichier au format temp exporter".$output);

$message = "salut victorio";

openssl_public_encrypt($message, $sortieMessage, $pubKey);
echo 'voici notre message chiffré'.$sortieMessage;


openssl_private_decrypt($sortieMessage, $messageDecrypted, $privKey);
echo 'voici notre message decrypter'.$messageDecrypted;

echo '<h1> Exercice 4 <h1/>';
openssl_sign($message, $signature, $privKey, OPENSSL_ALGO_SHA256);
echo 'Signature'.$signature;
echo 'Signature'.$signature;
echo 'Signature'.$signature;

$verification = openssl_verify($message, $signature, $privKey, OPENSSL_ALGO_SHA256);
echo $verification === 1 ? "signature valide" : "signature non valide";

