<?php
/**
 * VinFast Premium - Bộ Chẩn Đoán Lỗi Hệ Thống
 * Hỗ trợ xác định nguyên nhân gây ra màn hình trắng (White Screen of Death) trên Hosting thật.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 403 Forbidden');
    die("Truy cập bị từ chối: Vui lòng đăng nhập quyền quản trị viên.");
}

// Bật hiển thị mọi lỗi PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chẩn đoán lỗi hệ thống VinFast Premium</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 40px auto; padding: 0 20px; color: #333; background: #f9f9f9; }
        h1 { color: #0d121c; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .status { font-weight: bold; padding: 2px 8px; border-radius: 4px; font-size: 14px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .warning { background: #fff3cd; color: #856404; }
        pre { background: #272c34; color: #abb2bf; padding: 15px; border-radius: 6px; overflow-x: auto; font-family: monospace; }
        ul { padding-left: 20px; }
        li { margin-bottom: 8px; }
    </style>
</head>
<body>

    <h1>Chẩn Đoán Lỗi Hệ Thống Website VinFast</h1>
    <p>PHP Version đang chạy: <strong><?php echo PHP_VERSION; ?></strong></p>

    <!-- 1. KIỂM TRA FILE CONFIG (db.php) -->
    <div class="card">
        <h2>1. Kiểm tra cấu hình kết nối CSDL (db.php)</h2>
        <?php
        $dbPath = dirname(__DIR__) . '/db.php';
        if (!file_exists($dbPath)) {
            echo '<p><span class="status error">❌ LỖI</span> Không tìm thấy file <code>db.php</code> ở thư mục gốc.</p>';
            $dbConfig = null;
        } else {
            echo '<p><span class="status success">✓ OK</span> Đã tìm thấy file <code>db.php</code>.</p>';
            require_once $dbPath;
        }
        ?>
    </div>

    <!-- 2. KIỂM TRA KẾT NỐI DATABASE -->
    <div class="card">
        <h2>2. Kiểm tra trạng thái kết nối Cơ Sở Dữ Liệu</h2>
        <?php
        if (isset($dbConfig) && is_array($dbConfig)) {
            echo '<p>Thông số đang cấu hình:</p>';
            echo '<ul>';
            echo '<li><b>Driver:</b> ' . htmlspecialchars($dbConfig['driver'] ?? 'mysql') . '</li>';
            echo '<li><b>Host:</b> ' . htmlspecialchars($dbConfig['host'] ?? '127.0.0.1') . '</li>';
            echo '<li><b>Port:</b> ' . htmlspecialchars($dbConfig['port'] ?? '3306') . '</li>';
            echo '<li><b>Tên database:</b> ' . htmlspecialchars($dbConfig['dbname'] ?? 'VinFastvn') . '</li>';
            echo '<li><b>User đăng nhập:</b> ' . htmlspecialchars($dbConfig['username'] ?? 'root') . '</li>';
            echo '</ul>';

            try {
                if (($dbConfig['driver'] ?? 'mysql') === 'mysql') {
                    $dsn = "mysql:host=" . $dbConfig['host'] . ";port=" . ($dbConfig['port'] ?? '3306') . ";dbname=" . $dbConfig['dbname'] . ";charset=" . ($dbConfig['charset'] ?? 'utf8mb4');
                    $testDb = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
                    $testDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo '<p><span class="status success">✓ THÀNH CÔNG</span> Đã kết nối thành công tới Database MySQL!</p>';
                } else {
                    $testDb = new PDO('sqlite:' . dirname(__DIR__) . '/database.sqlite');
                    $testDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo '<p><span class="status success">✓ THÀNH CÔNG</span> Đã kết nối thành công tới Database SQLite!</p>';
                }
            } catch (Exception $e) {
                echo '<p><span class="status error">❌ THẤT BẠI</span> Kết nối CSDL bị lỗi.</p>';
                echo '<p><b>Chi tiết lỗi từ PHP:</b> <span style="color: red;">' . htmlspecialchars($e->getMessage()) . '</span></p>';
                echo '<p>👉 <b>Gợi ý khắc phục:</b> Hãy kiểm tra lại thông số trong mảng <code>$dbConfig</code> ở file <code>db.php</code> trên hosting của anh. Hãy đảm bảo tên database, username và mật khẩu do nhà cung cấp hosting cung cấp đã được điền chính xác.</p>';
            }
        } else {
            echo '<p><span class="status warning">⚠️ CẢNH BÁO</span> Chưa nạp được cấu hình kết nối.</p>';
        }
        ?>
    </div>

    <!-- 3. KIỂM TRA PHÂN QUYỀN THƯ MỤC GHI CACHE -->
    <div class="card">
        <h2>3. Kiểm tra phân quyền thư mục ghi Cache (scratch)</h2>
        <?php
        $scratchDir = dirname(__DIR__) . '/scratch';
        $cacheDir = dirname(__DIR__) . '/scratch/cache';

        if (!is_dir($scratchDir)) {
            echo '<p><span class="status error">❌ LỖI</span> Không tìm thấy thư mục <code>/scratch</code> ở thư mục gốc.</p>';
            echo '<p>-> Giải pháp: Vui lòng tạo một thư mục tên là <code>scratch</code> ở ngang hàng với file index.php.</p>';
        } else {
            $scratchWritable = is_writable($scratchDir);
            if ($scratchWritable) {
                echo '<p><span class="status success">✓ OK</span> Thư mục <code>/scratch</code> có quyền ghi ghi dữ liệu.</p>';
            } else {
                echo '<p><span class="status error">❌ LỖI</span> Thư mục <code>/scratch</code> KHÔNG cho phép ghi dữ liệu.</p>';
                echo '<p>👉 <b>Gợi ý khắc phục:</b> Sử dụng FTP (như FileZilla) hoặc Quản lý tệp (File Manager) của hosting để cấp quyền ghi (chạy lệnh <b>CHMOD 755</b> hoặc <b>777</b>) cho thư mục <code>scratch</code>.</p>';
            }

            if (!is_dir($cacheDir)) {
                echo '<p><span class="status warning">⚠️ CẢNH BÁO</span> Thư mục <code>/scratch/cache</code> chưa được tạo.</p>';
                if (@mkdir($cacheDir, 0755, true)) {
                    echo '<p><span class="status success">✓ OK</span> Đã tự động tạo thành công thư mục <code>/scratch/cache</code>.</p>';
                } else {
                    echo '<p><span class="status error">❌ LỖI</span> Không thể tự động tạo thư mục <code>/scratch/cache</code>. Lỗi phân quyền thư mục cha.</p>';
                }
            } else {
                $cacheWritable = is_writable($cacheDir);
                if ($cacheWritable) {
                    echo '<p><span class="status success">✓ OK</span> Thư mục <code>/scratch/cache</code> có quyền ghi.</p>';
                } else {
                    echo '<p><span class="status error">❌ LỖI</span> Thư mục <code>/scratch/cache</code> KHÔNG có quyền ghi.</p>';
                    echo '<p>👉 <b>Gợi ý khắc phục:</b> Hãy CHMOD 755 hoặc 777 cho thư mục <code>scratch/cache</code>.</p>';
                }
            }
        }
        ?>
    </div>

    <!-- 4. KIỂM TRA EXTENSION PHP -->
    <div class="card">
        <h2>4. Kiểm tra các thư viện PHP bắt buộc</h2>
        <ul>
            <?php
            $extensions = [
                'pdo' => 'Kết nối CSDL cơ bản',
                'pdo_mysql' => 'Kết nối CSDL MySQL (Bắt buộc nếu dùng MySQL)',
                'pdo_sqlite' => 'Kết nối CSDL SQLite (Dự phòng)',
                'zlib' => 'Nén trang GZIP (Tối ưu tốc độ LCP/Lighthouse)',
                'gd' => 'Xử lý hình ảnh thu nhỏ tự động (thumb.php)'
            ];

            foreach ($extensions as $ext => $desc) {
                $loaded = extension_loaded($ext);
                if ($loaded) {
                    echo '<li><span class="status success">Đã bật</span> <b>' . $ext . '</b> (' . $desc . ')</li>';
                } else {
                    echo '<li><span class="status error">Chưa bật</span> <b>' . $ext . '</b> (' . $desc . ') - <i>Lời khuyên: Vào cPanel/DirectAdmin mục "Select PHP Version" hoặc "PHP Extensions" để bật thư viện này lên.</i></li>';
                }
            }
            ?>
        </ul>
    </div>

    <!-- 5. CÁCH BẬT BÁO LỖI TRỰC TIẾP TRÊN TRANG WEB -->
    <div class="card">
        <h2>5. Cách bật hiển thị lỗi trực tiếp trên màn hình chính</h2>
        <p>Nếu trang web vẫn trắng xóa khi vào trang chủ, anh hãy tạm thời mở file <code>index.php</code> và dán 3 dòng này vào ngay sau thẻ mở <code>&lt;?php</code> ở dòng số 2:</p>
        <pre>&lt;?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);</pre>
        <p>Khi đó, thay vì màn hình trắng xóa, PHP sẽ in ra chi tiết dòng code bị lỗi và nguyên nhân để anh thấy ngay lập tức.</p>
    </div>

</body>
</html>




