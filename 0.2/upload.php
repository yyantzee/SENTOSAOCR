<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PDF Text Extractor</title>
    <!-- Menggunakan Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Menggunakan font Titillium Web -->
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Titillium Web", sans-serif;
        }
    </style>
</head>

<body>
    <nav class="bg-white border-b border-gray-200 py-4 mb-5">
        <div class="flex justify-center items-center">
            <a href="index.php"><img src="assets/images/logo.png" alt="Logo" class="h-14"></a>
        </div>
    </nav>
    <div class="max-w-md mx-auto my-32 p-8 bg-white rounded border">
        <h1 class="text-2xl font-bold mb-2">Finance Automation OCR</h1>
        <p class="text-red-600 mb-6">*PDF ONLY</p>
        <form action="process.php" method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="pdf_file" class="block font-medium">Choose PDF file:</label>
                <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required class="block w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="w-full py-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition duration-300">Extract Text</button>
        </form>
    </div>
</body>

</html>