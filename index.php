<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$db = "upload";


$con = mysqli_connect($servername, $username, $password, $db);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected to the database.<br>";

if (isset($_FILES["files"])) {
    echo "File upload initiated.<br>";
    $name = $_FILES["files"]["name"];
    $tmpname = $_FILES["files"]["tmp_name"];
    $type = $_FILES["files"]["type"];
    $size = $_FILES["files"]["size"];
    
    // Allow only PDF and DOCX files
    $allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    if (in_array($type, $allowedTypes)) {
        
        $uploadPath = "uploads/" . basename($name);
        $uploadSuccess = move_uploaded_file($tmpname, $uploadPath);
        
        if ($uploadSuccess) {
            echo "File uploaded successfully.<br>";
        
            $sqlInsert = "INSERT INTO `info` (`name`, `type`, `size`, `path`) VALUES ('$name', '$type', '$size', '$uploadPath')";
            $res = mysqli_query($con, $sqlInsert);
            if ($res) {
                echo "Resume information saved successfully.";
            } else {
                echo "Error saving resume information: " . mysqli_error($con);
            }
        } 
    } else {
        echo "Only PDF and DOCX files are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resume</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to bottom, #56B3FA, #87CEEB); 
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #fff; 
    text-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

form {
    width: 50%;
    margin: 20px auto;
    padding: 20px;
    background-color: #F7F7F7; 
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #34A85A; 
}

label {
    display: block;
    margin-bottom: 10px;
    color: #333; 
    font-weight: bold;
}

input[type="file"] {
    width: 100%;
    margin-bottom: 20px;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #E5E5EA; 
    font-size: 16px;
}

input[type="submit"] {
    background-color: #8E44AD; 
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #7A288A; 
}



@media (max-width: 768px) {
    form {
        width: 80%;
    }
}

@media (max-width: 480px) {
    form {
        width: 100%;
    }
}

    </style>
    
</head>
<body>
    <h1>Upload Your Resume</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="uf">Select Resume File:</label>
        <input type="file" name="files" id="uf" required>
        <input type="submit" name="submit" value="Upload">
    </form>
</body>
</html>
