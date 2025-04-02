<?php
// اتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iscore_check";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تحميل ملف ExcelProcessor
require_once __DIR__ . '/ExcelProcessor.php';

// معالجة تحديد الملف
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["file_path"])) {
    $processor = new ExcelProcessor($conn);
    
    // التحقق من وجود الملف
    $file_path = $_POST["file_path"];
    if (!file_exists($file_path)) {
        $result = "خطأ: الملف المحدد غير موجود";
    } else {
        // محاكاة كائن $_FILES للمعالجة
        $file = [
            'name' => basename($file_path),
            'tmp_name' => $file_path,
            'error' => 0
        ];
        
        $result = $processor->processUpload($file);
    }
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تحديد ملف Excel لتحديث بيانات القروض</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
        #file_path {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        .path-example {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>تحديد ملف Excel لتحديث بيانات القروض</h1>
        <form action="upload_clients.php" method="post">
            <div class="form-group">
                <label for="file_path">مسار ملف Excel:</label>
                <input type="text" name="file_path" id="file_path" required 
                       placeholder="مثال: C:\data\loans.xlsx أو /var/www/uploads/loans.xlsx">
                <div class="path-example">
                    يجب كتابة المسار الكامل للملف بما في ذلك اسم الملف
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">تحديث البيانات من الملف</button>
            </div>
        </form>
        
        <?php if (isset($result)): ?>
            <div class="message <?php echo strpos($result, 'نجاح') !== false ? 'success' : 'error'; ?>">
                <?php echo $result; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>