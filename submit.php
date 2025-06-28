<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name      = htmlspecialchars($_POST["name"]);
    $email     = htmlspecialchars($_POST["email"]);
    $phone     = htmlspecialchars($_POST["phone"]);
    $education = htmlspecialchars($_POST["education"]);

    // استلام ملف CV
    $cv_file = $_FILES['cv'];
    $cv_name = basename($cv_file['name']);
    $cv_tmp  = $cv_file['tmp_name'];
    $cv_type = strtolower(pathinfo($cv_name, PATHINFO_EXTENSION));

    if ($cv_type !== 'pdf') {
        echo "Only PDF files are allowed!";
        exit;
    }

    // تحديد مجلد الحفظ
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir);
    }

    $new_cv_name = $upload_dir . uniqid("cv_", true) . ".pdf";
    move_uploaded_file($cv_tmp, $new_cv_name);

    // كتابة المعلومات داخل ملف
    $data = "Name: $name\nEmail: $email\nPhone: $phone\nEducation: $education\nCV: $new_cv_name\n\n";
    file_put_contents("submissions.txt", $data, FILE_APPEND);
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Thank You</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f0f8ff;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .message-box {
                background-color: #fff;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            h2 {
                color: #0077cc;
            }
        </style>
    </head>
    <body>
        <div class="message-box">
            <h2>Thank you, <?php echo $name; ?>! 🎉</h2>
            <p>Your application and CV have been received.</p>
        </div>
    </body>
    </html>

    <?php
} else {
    echo "Invalid request.";
}
?>