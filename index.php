<?php

#contoh token jwt
$contoh_token ='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZHBlbmdndW5hIjoiMyIsInBob25lIjoiKzYyODIyMzAwNDQ1NjciLCJuYW1hIjoiTWJhayBXdWxhbiIsImlhdCI6MTYwMzE1OTkxMywiZXhwIjoxNjA1NzUxOTEzfQ.z_a19XQU92huSVJvfV8izHjuHNl7s8EEw7qeuMV6Vbc';

#split menjadi 3 string
$hasil_split = explode(".",$contoh_token);

echo "<br>header : ".$hasil_split[0];
echo "<br>payload : ".$hasil_split[1];
echo "<br>signature : ".$hasil_split[2];

echo "<hr>";
echo "<b>Hasil decode base64</b> <br>";

echo "<br>header : ".base64_decode($hasil_split[0]);
echo "<br>payload : ".base64_decode($hasil_split[1]);
echo "<br>signature : ".$hasil_split[2];

#coba buat signature dengan algoritmanya
$secretkey='jlkwdfhasljkl324wflqwjwklj234j23423jkljkll';

$sign_jwt = hash_hmac('sha256',$hasil_split[0].".".$hasil_split[1],$secretkey,true);
//$sign_jwt = base64_encode($sign_jwt); #-> klo pake yg ini betul tpi bawaan php tidak standar versi url
#standarisasikan -> keterangan ada dibawah
$sign_jwt = base64url_encode($sign_jwt);

echo '<br>Hasil Verifikasi Signature : '.$sign_jwt;

if($hasil_split[2]==$sign_jwt){
	echo '<br>Verifikasi berhasil';
}else{
	echo '<br>GAGAL';
}

#contoh algoritma yang ada di php
echo '<br><hr>Contoh algoritma : <br>';
$algo = json_encode(hash_hmac_algos());
print_r($algo);


// PHP doesn’t support the Base64URL standard, but you can use built-in functions to normalize values. The only thing you have to change is to replace 62-63 index characters. More exactly, you should use “-” instead of “+” and “_” instead of “/”.
// refernsi : https://base64.guru/developers/php/examples/base64url
function base64url_encode($data)
{
  // First of all you should encode $data to Base64 string
  $b64 = base64_encode($data);

  // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
  if ($b64 === false) {
    return false;
  }

  // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
  $url = strtr($b64, '+/', '-_');

  // Remove padding character from the end of line and return the Base64URL result
  return rtrim($url, '=');
}