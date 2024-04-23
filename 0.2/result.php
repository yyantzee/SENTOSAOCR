<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OCR Data Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: "Titillium Web", sans-serif;
        }
        
        /* Mengatur lebar tabel */
        #ocrDataTable_wrapper {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Responsif untuk tabel */
        #ocrDataTable {
            overflow-x: auto;
            display: block;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <nav class="bg-white border-b border-gray-200 py-4 mb-5">
        <div class="flex justify-center items-center">
            <a href="index.php"><img src="assets/images/logo.png" alt="Logo" class="h-14"></a>
        </div>
    </nav>
    <div class="container mx-auto my-20">
        <table id="ocrDataTable" class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Invoice Number</th>
                    <th class="px-4 py-2">Invoice Date</th>
                    <th class="px-4 py-2">Total Amount</th>
                    <th class="px-4 py-2">Tax</th>
                    <th class="px-4 py-2">GR Number</th>
                    <th class="px-4 py-2">DO Number</th>
                    <th class="px-4 py-2">File Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <?php
                include 'config.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
                    $idToDelete = $_POST['delete'];
                    $sqlDelete = "DELETE FROM ocr_data WHERE id = $idToDelete";
                    if ($conn->query($sqlDelete) === TRUE) {
                        echo "<script>alert('Data Deleted')</script>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                $sql = "SELECT * FROM ocr_data";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='px-4 py-3'>" . $row['invoice_number'] . "</td>";
                        echo "<td class='px-4 py-3'>" . $row['invoice_date'] . "</td>";
                        echo "<td class='px-4 py-3'>" . $row['total_amount'] . "</td>";
                        echo "<td class='px-4 py-3'>" . $row['tax'] . "</td>";
                        echo "<td class='px-4 py-3'>" . $row['gr_number'] . "</td>";
                        echo "<td class='px-4 py-3'>" . $row['do_number'] . "</td>";
                        echo "<td class='px-4 py-3'>" . $row['files_name'] . "</td>";
                        echo "<td class='px-4 py-3'>
                                <form method='post' onsubmit='return confirmDelete();'>
                                    <input type='hidden' name='delete' value='" . $row['id'] . "'>
                                    <button type='submit' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='px-4 py-3 text-center'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ocrDataTable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [10, 25, 50, 75, 100],
                "pageLength": 10
            });
        });

        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>
</body>

</html>
