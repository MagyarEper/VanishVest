<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            margin: 0;
            padding: 5px 0;
            display: block;
        }

        strong {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Data</h1>
        <?php
        // Read JSON file contents
        $json = file_get_contents('adatbázis\megrendelesek.json');

        // Check if file reading was successful
        if ($json === false) {
            echo "<p>Error reading JSON file.</p>";
        } else {
            // Decode JSON data into an associative array
            $userData = json_decode($json, true);

            // Check if decoding was successful
            if ($userData === null) {
                echo "<p>Error decoding JSON.</p>";
            } else {
                // Loop through each key-value pair in the array
                foreach ($userData as $key => $value) {
                    // If the value is an array, handle it appropriately
                    if (is_array($value)) {
                        echo "<p><strong>$key:</strong> ";
                        foreach ($value as $subKey => $subValue) {
                            echo "$subValue ";
                        }
                        echo "</p>";
                    } else {
                        // Display key and value
                        echo "<p><strong>$key:</strong> $value</p>";
                    }
                }
            }
        }
        ?>
    </div>
</body>
</html>
