<?php
// Endpoint URL untuk mengirim file PDF
$target_url = "http://localhost:5000/extract";

// Membuat objek CURLFile untuk file PDF yang akan dikirim
$cfile = new CURLFile($_FILES['pdf_file']['tmp_name'], 'application/pdf', $_FILES['pdf_file']['name']);

// Menyiapkan data POST untuk dikirimkan melalui cURL
$post = array(
    'file' => $cfile
);

// Inisialisasi cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Eksekusi cURL request dan mendapatkan respons
$response = curl_exec($ch);
curl_close($ch);

// Mengembalikan respons dalam bentuk JSON yang telah di-decode
json_decode($response, true);

// Untuk menampilkan json di web anda
echo "<pre>";
echo $response;
echo "<pre>";
?>