<?php
// بداية الجلسة إذا كنت تحتاجها
session_start();
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام iScore Check</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            gap: 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            width: 200px;
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .icon {
            font-size: 50px;
            margin-bottom: 15px;
            color: #3498db;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            background-color: #2c3e50;
            color: white;
        }
        @media (max-width: 768px) {
            .card {
                width: 150px;
                height: 150px;
            }
            .icon {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>نظام iScore Check</h1>
        <p>إدارة ملفات العملاء ونتائج iScore</p>
    </div>

    <div class="container">
        <a href="upload_clients.php" class="card">
            <div class="icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="card-title">تحديث ملف العملاء</div>
        </a>

        <!-- تحديث ملف iScore -->
        <a href="upload_iscore.php" class="card">
            <div class="icon">
                <i class="fas fa-file-import"></i>
            </div>
            <div class="card-title">تحديث ملف iScore</div>
        </a>

        <!-- الكشف عن ملف استعلام -->
        <a href="query_check.php" class="card">
            <div class="icon">
                <i class="fas fa-search"></i>
            </div>
            <div class="card-title">الكشف عن ملف استعلام</div>
        </a>

        <!-- أيقونة احتياطية للتوسع المستقبلي -->
        <a href="#" class="card">
            <div class="icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="card-title">إضافة وظيفة جديدة</div>
        </a>
    </div>

    <div class="footer">
        <p>جميع الحقوق محفوظة &copy; <?php echo date('Y'); ?></p>
    </div>
</body>
</html>