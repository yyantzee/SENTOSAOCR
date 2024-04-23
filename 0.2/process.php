<!-- process.php -->

<?php
include 'config.php';

// Fungsi untuk mengirim permintaan cURL ke server Flask OCR
function sendOCRRequest($file_name_with_full_path)
{
    $target_url = "http://localhost:5000/extract";

    $cfile = new CURLFile($file_name_with_full_path, 'application/pdf', $_FILES['pdf_file']['name']);

    $post = array(
        'file' => $cfile
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $target_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Proses saat tombol 'validate' ditekan
if (isset($_POST['validate'])) {
    // Ambil nilai dari formulir
    $invoice_number = $_POST['invoice_number'];
    $invoice_date = $_POST['invoice_date'];
    $total_amount = $_POST['total_amount'];
    $tax = $_POST['tax'];
    $gr_number = $_POST['gr'];
    $do_number = $_POST['do'];
    $files_name = $_POST['files'];

    // Simpan data ke database
    $sql = "INSERT INTO ocr_data (invoice_number, invoice_date, total_amount, tax, gr_number, do_number, files_name) 
            VALUES ('$invoice_number', '$invoice_date', '$total_amount', '$tax', '$gr_number', '$do_number', '$files_name')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        // Menampilkan alert 'Data Saved'
        alert('Data Saved');
        
        // Mengarahkan ke halaman result.php
        window.location.href = 'result.php';
        </script>
        ";
        exit(); // Hentikan eksekusi skrip setelah mengalihkan
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Proses saat file PDF diunggah
if (!empty($_FILES['pdf_file']['tmp_name'])) {
    // Kirim permintaan ke server Flask OCR
    $result = sendOCRRequest($_FILES['pdf_file']['tmp_name']);

    // Periksa apakah ada hasil ekstraksi
    if ($result && isset($result["extracted_text"])) {
        // Ambil data hasil ekstraksi
        $invoice_number = $result["extracted_text"][0]["invoice_number"];
        $invoice_date = $result["extracted_text"][0]["invoice_date"];
        $total_amount = $result["extracted_text"][0]["total_amount"];
        $tax = isset($result["extracted_text"][1]["tax_barcode_real"]) ? $result["extracted_text"][1]["tax_barcode_real"] : null;
        $gr_number = isset($result["extracted_text"][2]["barcode"]) ? $result["extracted_text"][2]["barcode"] : null;
        $do_number = isset($result["extracted_text"][3]["DO_number"]) ? $result["extracted_text"][3]["DO_number"] : null;
        $files_name = isset($result["files"][0]["pdf"]) ? $result["files"][0]["pdf"] : null;

        // Tampilkan hasil di formulir (opsional)
        // Misalnya: echo '<script>document.getElementById("invoice_number").value = "' . $invoice_number . '";</script>';
    } else {
        echo "Error: Failed to extract text from PDF.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        body {
            font-family: "Titillium Web", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body>
    <nav class="bg-white border-b border-gray-200 py-4 mb-5">
        <div class="flex justify-center items-center">
            <a href="index.php"><img src="assets/images/logo.png" alt="Logo" class="h-14"></a>
        </div>
    </nav>

    <section class="w-full h-full flex justify-center my-32">
        <div class="w-max h-max border-2 px-4 py-4">
            <h3 class="font-semibold text-2xl">FORM VALIDATION</h3>
            <p class="text-red-600 mb-4 text-xs">*CEK TERLEBIH DAHULU SEBELUM SUBMIT</p>
            <form action="" method="post">
                <div class="flex mb-4">
                    <label for="invoice_number" class="mr-2">INVOICE NUMBER :</label>
                    <input type="text" name="invoice_number" value="<?php echo $invoice_number; ?>" class="border text-black mr-4">
                    <label for="invoice_dater" class="mr-2">INVOICE DATE :</label>
                    <input type="text" name="invoice_date" value="<?php echo $invoice_date; ?>" class="border text-black mr-4">
                    <label for="total_amount" class="mr-2">TOTAL AMOUNT :</label>
                    <input type="number" name="total_amount" value="<?php echo $total_amount; ?>" class="border text-black">
                </div>
                <div class="flex mb-4">
                    <label for="tax" class="mr-2">TAX :</label>
                    <input type="text" name="tax" value="<?php echo $tax; ?>" class="border text-black mr-4 w-60">
                    <label for="gr" class="mr-2">GOOD RECEIPTS :</label>
                    <input type="text" name="gr" value="<?php echo $gr_number; ?>" class="border text-black mr-4">
                    <label for="do" class="mr-2">DELIVERY ORDER :</label>
                    <input type="text" name="do" value="<?php echo $do_number; ?>" class="border text-black">
                </div>

                <div class="flex mb-6">
                    <a href="<?php echo $files_name; ?>">
                        <p class="text-blue-600 underline"><?php echo $files_name; ?></p>
                    </a>
                </div>

                <div class="mb-6 hidden">
                    <input type="text" name="files" value="<?php echo $files_name; ?>" class="border text-black">
                </div>
                <div class="flex">
                    <button type="submit" name="validate" class="w-full py-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition duration-300">VALIDATE</button>
                </div>
            </form>
        </div>
    </section>
</body>

</html>