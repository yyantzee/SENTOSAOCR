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

    <menu class="w-full h-full mt-32">
        <div class="w-full h-full flex justify-center items-center">
            <a href="upload.php">
                <div class="w-72 h-72 mx-10 bg-red-600 rounded-2xl border-2 border-red-600 duration-200 hover:bg-white text-white hover:text-red-600 cursor-pointer">
                    <div class="flex justify-center items-center mt-16 mb-4">
                        <span class="material-symbols-outlined text-8xl duration-100">
                            add
                        </span>
                    </div>
                    <div class="flex justify-center items-center">
                        <h1 class=" text-2xl font-semibold duration-100">Upload File</h1>
                    </div>
                </div>
            </a>
            <a href="result.php">
                <div class="w-72 h-72 mx-10 bg-red-600 rounded-2xl border-2 border-red-600 duration-200 hover:bg-white text-white hover:text-red-600 cursor-pointer">
                    <div class="flex justify-center items-center mt-16 mb-4">
                        <span class="material-symbols-outlined text-8xl duration-100">
                            frame_inspect
                        </span>
                    </div>
                    <div class="flex justify-center items-center">
                        <h1 class=" text-2xl font-semibold duration-100">See Result</h1>
                    </div>
                </div>
            </a>
            <a href="documentation.php">
                <div class="w-72 h-72 mx-10 bg-red-600 rounded-2xl border-2 border-red-600 duration-200 hover:bg-white text-white hover:text-red-600 cursor-pointer">
                    <div class="flex justify-center items-center mt-16 mb-4">
                        <span class="material-symbols-outlined text-8xl duration-100">
                            Description
                        </span>
                    </div>
                    <div class="flex justify-center items-center">
                        <h1 class=" text-2xl font-semibold duration-100">Documentation</h1>
                    </div>
                </div>
            </a>
        </div>
    </menu>

</body>

</html>