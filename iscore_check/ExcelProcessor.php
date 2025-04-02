<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelProcessor {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function processUpload($file) {
        // التحقق من نوع الملف
        $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!in_array($fileType, ['xlsx', 'xls'])) {
            return "خطأ: يجب أن يكون الملف بصيغة .xlsx أو .xls";
        }
        
        try {
            // قراءة ملف Excel مباشرة من المسار المحدد
            $spreadsheet = IOFactory::load($file['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // حذف البيانات القديمة
            $this->conn->query("TRUNCATE TABLE prodata");
            
            // إدراج البيانات الجديدة (تخطي الصف الأول إذا كان يحتوي على عناوين)
            $headerSkipped = false;
            $successCount = 0;
            
            foreach ($rows as $row) {
                if (!$headerSkipped) {
                    $headerSkipped = true;
                    continue;
                }
                
                // تأكد من أن الصف يحتوي على بيانات
                if (empty($row[0])) continue;
                
                // إعداد الاستعلام
                $stmt = $this->conn->prepare("INSERT INTO prodata (
                    national_id, loan_id, client_name_ar, loan_system, 
                    loan_amount, installments_number, loan_status, 
                    loan_date, paid_amount, loan_specialist, notes, 
                    client_code, lending_program, secondary_activity, 
                    tertiary_activity, region, current_branch, 
                    specialist, remaining_installment
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                
                // ربط القيم
                $stmt->bind_param(
                    "sisssdssssisssssssd",
                    $row[0], // national_id
                    $row[1], // loan_id
                    $row[2], // client_name_ar
                    $row[3], // loan_system
                    $row[4], // loan_amount
                    $row[5], // installments_number
                    $row[6], // loan_status
                    $row[7], // loan_date
                    $row[8], // paid_amount
                    $row[9], // loan_specialist
                    $row[10], // notes
                    $row[11], // client_code
                    $row[12], // lending_program
                    $row[13], // secondary_activity
                    $row[14], // tertiary_activity
                    $row[15], // region
                    $row[16], // current_branch
                    $row[17], // specialist
                    $row[18]  // remaining_installment
                );
                
                if ($stmt->execute()) {
                    $successCount++;
                }
                $stmt->close();
            }
            
            return "نجاح: تم تحديث $successCount سجل بنجاح واستبدال جميع البيانات القديمة";
            
        } catch (Exception $e) {
            return "خطأ: " . $e->getMessage();
        }
    }
}
?>