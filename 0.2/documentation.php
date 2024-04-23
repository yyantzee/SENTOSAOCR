<!-- index.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PDF Text Extractor</title>
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

    <article class="px-20">
        <h1 class="text-5xl font-semibold mb-7">Documentation</h1>
        <hr class="border-2">
        <h1 class="text-3xl font-semibold mt-4 mb-7">Introduction</h1>
        <p class="text-xl mb-7">
            Aplikasi ini adalah sebuah layanan berbasis Flask untuk mengekstrak informasi teks dan data terstruktur dari file PDF menggunakan Optical Character Recognition (OCR) dan pengolahan gambar. Proses ekstraksi ini dilakukan untuk mendapatkan informasi spesifik seperti nomor faktur, tanggal faktur, jumlah total, nomor GR (Goods Receipt), tanggal GR, nomor DO (Delivery Order), dan tanggal DO. Selain itu, aplikasi juga dapat mengenali dan mengekstrak data dari barcode yang terdapat dalam gambar.</p>
        <hr class="border-2">
        <h1 class="text-3xl font-semibold mt-4 mb-7">How Program Works</h1>
        <p class="text-xl mb-7">
            Aplikasi menggunakan Tesseract OCR (Optical Character Recognition) melalui library pytesseract untuk mengenali teks dari gambar-gambar tersebut. Hasil teks yang diekstrak kemudian dianalisis menggunakan regular expression (regex) untuk mencari informasi yang spesifik seperti nomor faktur, tanggal, jumlah, dan barcode.

            Hasil ekstraksi teks dan informasi dari setiap halaman PDF kemudian disusun ke dalam struktur data yang sesuai (biasanya dalam format JSON) dan dikirimkan kembali sebagai respons dari endpoint</p>
        <hr class="border-2">
        <h1 class="text-3xl font-semibold mt-4 mb-7">Integration API</h1>
        <p class="text-xl mb-7">
            Untuk mengintegrasi kan program kami ke halaman website anda bisa mengikuti langkah langkah berikut <span class="text-red-500 text-sm">(PASTIKAN ANDA SUDAH MEMBUAT FORM DENGAN TYPE INPUT PDF)</span> : </p>
        <p class="text-xl mb-7">
            Buat skrip baru misal <code>process.php</code> lalu Implementasi skrip di bawah ini ke script PHP anda : </p>
        <!-- Mempercantik tampilan kode dengan Tailwind CSS -->
        <div class="bg-gray-800 rounded-lg p-4 mb-6">
            <pre class="text-gray-200"><code class="php">
<span class="text-blue-300">// Endpoint URL untuk mengirim file PDF</span>
$target_url = "http://localhost:5000/extract";

<span class="text-blue-300">// Membuat objek CURLFile untuk file PDF yang akan dikirim</span>
$cfile = new CURLFile($_FILES['pdf_file']['tmp_name'], 'application/pdf', $_FILES['pdf_file']['name']);

<span class="text-blue-300">// Menyiapkan data POST untuk dikirimkan melalui cURL</span>
$post = array(
    'file' => $cfile
);

<span class="text-blue-300">// Inisialisasi cURL session</span>
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

<span class="text-blue-300">// Eksekusi cURL request dan mendapatkan respons</span>
$response = curl_exec($ch);
curl_close($ch);

<span class="text-blue-300">// Mengembalikan respons dalam bentuk JSON yang telah di-decode</span>
json_decode($response, true);
            </code></pre>
        </div>
        <!-- Akhir dari mempercantik tampilan kode -->
        <p class="text-xl mb-7">
                Untuk mengetahui hasil yang dihasilkan dari skrip berikut tambah kan code seperti berikut ini : </p>
            <!-- Mempercantik tampilan kode dengan Tailwind CSS -->
            <div class="bg-gray-800 rounded-lg p-4 mb-6">
                <pre class="text-gray-200"><code class="php">
<span class="text-blue-300">// Untuk menampilkan json di web anda</span>
echo "&lt;pre&gt;";
echo $response;
echo "&lt;pre&gt;";
            </code></pre>
            </div>

            <p class="text-xl mb-7">
                Maka hasil nya akan seperti ini : </p>
            <!-- Mempercantik tampilan kode dengan Tailwind CSS -->
            <div class="bg-gray-800 rounded-lg p-4 mb-6 overflow-x-auto">
                <pre class="text-gray-200"><code class="php">
<span class="text-blue-300">// Untuk menampilkan json di web anda</span>
{
    "extracted_text": [
        {
            "barcode": "N/A",
            "invoice_date": "2 Feb 2022",
            "invoice_number": "23301",
            "page_number": 1,
            "text": "INVOICE\n\nPT XYZ\nJI. TB Simatupang No 28\nJakarta\n\nInvoice No. : 23301\nInvoice Date : 2 Feb 2022\n\nB001 — Bottle 1It 5.000 1.000 100.000\nPembayaran : Sub Total 100.000\nBank Central Asia VAT 11% 50.000\nPT. XYZ Total 150.000\n522000010\n\nHormat kami\n\nIY\n\nSentosa\nFinance Manager\n",
            "total_amount": "150000"
        },
        {
            "page_number": 2,
            "tax_barcode_real": "https://kraftinvoicehandling.azurewebsites.net/dummy.xml",
            "text": "Faktur Pajak\n\nKade dan Nomor Seri Faktur Pajak : 010.002-22.98048471\n\nPengusaha Kena Pajak\n\nPT XYZ\nJI. TB Simatupang No 28, Jakarta\nNPWP :01.000.111.2-333.444\n\nPembeli Barang Kena Pajak / Penerima Jasa Kena Pajak\nNama* PT Hightech Compamy\n\nAlamat: Mensana Tower Lt 5\n\nNPWP: 01.001.01.000001\n\n| me | Nama Barang Kena Pajak / Jasa Kena Pajak Hera 1 oe eae\nBottle ilt\n\n1 | p.5.000 x 1.000 5.000.000,00'\n\nHarga Jual / Penggantian 5.000.000,00\"\n\nDikurangi Potongan Harga 0.00\n\n0,00\n5.000.000,00:\n550.000,00.\n\n0,00\n\nTotal PPnBM (Pajak Penjualan Barang Mewah)\n\nSesuai dengan ketentuan yang bertaku, Direktorat Jenderal Pajak mengatur bahwa Faktur Pajak ini telah ditandatangant\nsecara elektronik-sehinaga tidak diperlukan tanda tangan basah pada Faktur Pajak ini.\n\nJAKARTA SELATAN, 03 Januari 2022\n\nSentosa\nRicaruy irevat ret\n004.01,2022\nPEMBERITAHUAN. Faitur Pasnk ini telah dilaporken ke Ovektorat Jenderal Pajak can telah mempesoieh pevseajuan sesuat 1 dari q\n\n‘dengan ketenhian pecaturan perpalakan yang boraku. PERINGATAN: PKP yang renerbikan Fakiut Pajsk yang dak sesuai\nengi headaan yang sebecaerya éanvatau Sesanggutnya sebagoimana dimaksud Pasal 13 eyat (9) UU PPN Skene! sarkei\nsesuai dengan Pasa! 14:ayat (4) UU KUP\n"
        },
        {
            "GR_date": "N/A",
            "GR_number": "410124",
            "barcode": "N/A",
            "page_number": 3,
            "text": "puns Buss oo Rage ‘nea . =\n5 ; : Warehouse ane 03 HighTech Company\n\nReceiver Ho\nPO Mumber 410124 tine = 1\n\nsttesitaeseintenntie Workstation\n* Receiver Ticket * UseriD iat Goods Receipt Note\nttittereaesteniest i : ine 15:5 -\nSeEEEEEIES! EOD woe Bukti Penerimaan Barang\n\nAivice Note 12345\n\nVendor- Vendor Naae~ Buyer TranCd\nStatus Reason Reason Code Description PERHATIAN !!\n00010 XYZ, PT — HARAP BUKTI INI DILAMPIRKAN\n= tg PADA SAAT PENAGIHAN\n-Unit of Measure-\n\nType Item Number Description Rec Pur -Stock Due\n\nBottle 1it RL ORL OR\n\nBottle 1It\n\nVendor Lot\n\nPenerima :\n\n"
        },
        {
            "DO_date": "2 Jan 2022",
            "DO_number": "12345",
            "barcode": "N/A",
            "page_number": 4,
            "text": "DELIVERY ORDER\n\nPT XYZ\nJI. TB Simatupang No 28\nJakarta\n\nDONo. :12345\nDO Date : 2 Jan 2022\n\nB001 — Bottle 1It 5.000 1.000 5.000.000\nPembayaran : Sub Total 5.000.000\nBank Central Asia VAT 11% 550.000\nPT. XYZ Total 5.550.000\n522000010\n\nHormat kami\n\nAll\n\nSentosa\nFinance Manager\n"
        }
    ],
    "files": [
        {
            "images": "images/page_1_processed.jpeg",
            "pdf": "pdf\\sentosa_merge_2.pdf"
        },
        {
            "images": "images/page_2_processed.jpeg",
            "pdf": "pdf\\sentosa_merge_2.pdf"
        },
        {
            "images": "images/page_3_processed.jpeg",
            "pdf": "pdf\\sentosa_merge_2.pdf"
        },
        {
            "images": "images/page_4_processed.jpeg",
            "pdf": "pdf\\sentosa_merge_2.pdf"
        }
    ]
}
            </code></pre>
            </div>
        <hr class="mt-7 border-2">
        <h1 class="text-3xl font-semibold mt-4 mb-7">Conclusion</h1>
        <p class="text-xl mb-7">
        Keseluruhan, aplikasi ini memberikan fungsionalitas untuk mengunggah file PDF, mengekstrak teks dari halaman-halaman PDF, melakukan pengenalan barcode (jika ada), dan mencari informasi spesifik (seperti nomor faktur, tanggal, dll.) dari teks yang diekstrak. Respons akhir berupa struktur JSON yang berisi informasi hasil ekstraksi dan informasi terkait lainnya.
    Dan kami ber terima kasih kepada <a href="https://tesseract-ocr.github.io/" class="text-blue-600 hover:underline">Tesseract, </a> <a href="https://opencv.org/" class="text-blue-600 hover:underline">OPENCV, </a> <a href="https://sentosasolutions.com/" class="text-blue-600 hover:underline">PT SENTOSA SOLUSI INDONESIA, </a></p>
        <hr class="mt-7 border-2">
        <p>PROGRAM VERSION 0.2</p>
    </article>

</body>

</html>