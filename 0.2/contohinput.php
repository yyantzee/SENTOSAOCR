<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="contohoutput.php" method="post" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label for="pdf_file" class="block font-medium">Choose PDF file:</label>
            <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required class="block w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit" class="w-full py-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition duration-300">Extract Text</button>
    </form>
</body>

</html>