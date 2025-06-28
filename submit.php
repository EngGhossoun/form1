<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name      = htmlspecialchars($_POST["name"]);
    $email     = htmlspecialchars($_POST["email"]);
    $education = htmlspecialchars($_POST["education"]);
    $dob       = htmlspecialchars($_POST["dob"]);

    $cvName = $_FILES["cv"]["name"];
    $cvTmp  = $_FILES["cv"]["tmp_name"];

    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $cvPath = $uploadDir . basename($cvName);
    move_uploaded_file($cvTmp, $cvPath);

    $submission = "Name: $name\nEmail: $email\nEducation: $education\nDate of Birth: $dob\nCV: $cvName\n----\n";
    file_put_contents("submissions.txt", $submission, FILE_APPEND);

    echo "Thank you, your application has been received!";
} else {
    echo "Invalid request.";
}
?>
