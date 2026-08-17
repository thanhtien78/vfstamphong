<?php
// MODULE: DATABASE MIGRATION ENGINE (ROBUST EDITION)
// ==========================================
// Require db connection helper (only connection logic remains here)
require_once dirname(__DIR__) . '/db.php';

if (php_sapi_name() !== 'cli') {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        $allowInitialMigration = false;
        try {
            $stmt = $db->query("SELECT COUNT(*) FROM users");
            $count = $stmt->fetchColumn();
            if ($count == 0) {
                $allowInitialMigration = true;
            }
        } catch (Exception $e) {
            // Table users doesn't exist, allow setup
            $allowInitialMigration = true;
        }

        if (!$allowInitialMigration) {
            header('HTTP/1.1 403 Forbidden');
            die("Truy cập bị từ chối: Vui lòng đăng nhập quyền quản trị viên.");
        }
    }
}

echo "=== STARTING DATABASE MIGRATION ===\n";

try {
    // 1. Create migrations table if not exists
    if ($driver === 'mysql') {
        $db->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration_name VARCHAR(191) UNIQUE,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } else {
        $db->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            migration_name TEXT UNIQUE,
            executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );");
    }

    // Helper function to check if migration has run
    function isMigrationExecuted($db, $name) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM migrations WHERE migration_name = ?");
        $stmt->execute([$name]);
        return $stmt->fetchColumn() > 0;
    }

    // Helper function to record migration execution
    function recordMigration($db, $name) {
        $stmt = $db->prepare("INSERT INTO migrations (migration_name) VALUES (?)");
        $stmt->execute([$name]);
    }

    // Helper function to run DDL safely (ignores duplicate column/index errors to support brownfield databases)
    function executeSqlSafely($db, $sql) {
        try {
            $db->exec($sql);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            // Check if it's a "duplicate column" or "already exists" error
            $isDuplicate = (
                strpos($msg, '1060 Duplicate column name') !== false ||
                strpos($msg, 'already exists') !== false ||
                strpos($msg, 'duplicate column') !== false ||
                strpos($msg, 'Duplicate key name') !== false
            );
            if (!$isDuplicate) {
                // Re-throw if it is a genuine database error
                throw $e;
            } else {
                echo "   (Column/Index already existed, skipping safely)\n";
            }
        }
    }

    // --- MIGRATION STEP 1: INITIAL SCHEMA ---
    $step = '001_initial_schema';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        
        if ($driver === 'mysql') {
            // Initial structures for MySQL
            $db->exec("CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(191) UNIQUE,
                password VARCHAR(255),
                fullname VARCHAR(255),
                role VARCHAR(255)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                summary TEXT,
                content TEXT,
                image TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS settings (
                `key` VARCHAR(191) PRIMARY KEY,
                `value` TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS cars (
                id INT AUTO_INCREMENT PRIMARY KEY,
                model_name VARCHAR(255) NOT NULL,
                segment VARCHAR(255),
                engine VARCHAR(255),
                power VARCHAR(255),
                torque VARCHAR(255),
                acceleration VARCHAR(255),
                top_speed VARCHAR(255),
                range_wltp VARCHAR(255),
                price VARCHAR(255),
                image TEXT,
                exterior_colors TEXT,
                description TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS leads (
                id INT AUTO_INCREMENT PRIMARY KEY,
                car_id INT,
                fullname VARCHAR(255) NOT NULL,
                phone VARCHAR(255) NOT NULL,
                email VARCHAR(255),
                preferred_date VARCHAR(255),
                status VARCHAR(255) DEFAULT 'Chưa liên hệ',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS customers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fullname VARCHAR(255) NOT NULL,
                phone VARCHAR(255) NOT NULL,
                email VARCHAR(255),
                classification VARCHAR(255) DEFAULT 'Tiềm năng',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS customer_cars (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                car_model VARCHAR(255) NOT NULL,
                purchase_date DATE,
                license_plate VARCHAR(255),
                price VARCHAR(255)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS customer_care_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                sale_id INT,
                notes TEXT,
                care_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS service_appointments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fullname VARCHAR(255) NOT NULL,
                phone VARCHAR(255) NOT NULL,
                email VARCHAR(255),
                license_plate VARCHAR(255) NOT NULL,
                car_model VARCHAR(255) NOT NULL,
                appointment_date DATETIME NOT NULL,
                service_type VARCHAR(255) DEFAULT 'Bảo dưỡng định kỳ',
                assigned_tech_id INT,
                status VARCHAR(255) DEFAULT 'Chờ tiếp nhận',
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS activity_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                username VARCHAR(255),
                action VARCHAR(255),
                detail TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS counselors (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fullname VARCHAR(255) NOT NULL,
                phone VARCHAR(255) NOT NULL,
                zalo VARCHAR(255) NOT NULL,
                avatar TEXT,
                status VARCHAR(255) DEFAULT 'ONLINE',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $db->exec("CREATE TABLE IF NOT EXISTS redirects (
                old_url VARCHAR(191) PRIMARY KEY,
                new_url VARCHAR(191),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        } else {
            // Initial structures for SQLite
            $db->exec("CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE,
                password TEXT,
                fullname TEXT,
                role TEXT
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS posts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT,
                summary TEXT,
                content TEXT,
                image TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS settings (
                `key` TEXT UNIQUE PRIMARY KEY,
                `value` TEXT
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS cars (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                model_name TEXT NOT NULL,
                segment TEXT,
                engine TEXT,
                power TEXT,
                torque TEXT,
                acceleration TEXT,
                top_speed TEXT,
                range_wltp TEXT,
                price TEXT,
                image TEXT,
                exterior_colors TEXT,
                description TEXT
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS leads (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                car_id INTEGER,
                fullname TEXT NOT NULL,
                phone TEXT NOT NULL,
                email TEXT,
                preferred_date TEXT,
                status TEXT DEFAULT 'Chưa liên hệ',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS customers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                fullname TEXT NOT NULL,
                phone TEXT NOT NULL,
                email TEXT,
                classification TEXT DEFAULT 'Tiềm năng',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS customer_cars (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                customer_id INTEGER NOT NULL,
                car_model TEXT NOT NULL,
                purchase_date TEXT,
                license_plate TEXT,
                price TEXT
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS customer_care_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                customer_id INTEGER NOT NULL,
                sale_id INTEGER,
                notes TEXT,
                care_date DATETIME DEFAULT CURRENT_TIMESTAMP
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS service_appointments (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                fullname TEXT NOT NULL,
                phone TEXT NOT NULL,
                email TEXT,
                license_plate TEXT NOT NULL,
                car_model TEXT NOT NULL,
                appointment_date TEXT NOT NULL,
                service_type TEXT DEFAULT 'Bảo dưỡng định kỳ',
                assigned_tech_id INTEGER,
                status TEXT DEFAULT 'Chờ tiếp nhận',
                notes TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS activity_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER,
                username TEXT,
                action TEXT,
                detail TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS counselors (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                fullname TEXT NOT NULL,
                phone TEXT NOT NULL,
                zalo TEXT NOT NULL,
                avatar TEXT,
                status TEXT DEFAULT 'ONLINE',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );");

            $db->exec("CREATE TABLE IF NOT EXISTS redirects (
                old_url TEXT PRIMARY KEY,
                new_url TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );");
        }

        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 2: LEADS VIP COLUMNS ---
    $step = '002_add_vip_columns_to_leads';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        if ($driver === 'mysql') {
            executeSqlSafely($db, "ALTER TABLE leads ADD COLUMN test_drive_type VARCHAR(255) DEFAULT 'Tại Showroom', ADD COLUMN test_drive_address TEXT;");
        } else {
            executeSqlSafely($db, "ALTER TABLE leads ADD COLUMN test_drive_type TEXT DEFAULT 'Tại Showroom';");
            executeSqlSafely($db, "ALTER TABLE leads ADD COLUMN test_drive_address TEXT;");
        }
        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 3: CARS STOCK AND VIDEO COLUMNS ---
    $step = '003_add_stock_columns_to_cars';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        if ($driver === 'mysql') {
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN video_url TEXT, ADD COLUMN stock_status VARCHAR(255) DEFAULT 'Còn hàng', ADD COLUMN stock_qty INT DEFAULT 5;");
        } else {
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN video_url TEXT;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN stock_status TEXT DEFAULT 'Còn hàng';");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN stock_qty INTEGER DEFAULT 5;");
        }
        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 4: ASSIGNED SALE TO LEADS ---
    $step = '004_add_assigned_sale_to_leads';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        if ($driver === 'mysql') {
            executeSqlSafely($db, "ALTER TABLE leads ADD COLUMN assigned_sale_id INT DEFAULT NULL;");
        } else {
            executeSqlSafely($db, "ALTER TABLE leads ADD COLUMN assigned_sale_id INTEGER DEFAULT NULL;");
        }
        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 5: NOTES TO LEADS ---
    $step = '005_add_notes_to_leads';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        executeSqlSafely($db, "ALTER TABLE leads ADD COLUMN notes TEXT;");
        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 6: SLUG AND SEO TO POSTS ---
    $step = '006_add_slug_and_category_to_posts';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        if ($driver === 'mysql') {
            executeSqlSafely($db, "ALTER TABLE posts 
                ADD COLUMN slug VARCHAR(191) DEFAULT NULL, 
                ADD COLUMN category VARCHAR(100) DEFAULT 'Khám phá VinFast', 
                ADD COLUMN views INT DEFAULT 0, 
                ADD COLUMN status VARCHAR(20) DEFAULT 'published',
                ADD COLUMN focus_keyword VARCHAR(255) DEFAULT NULL,
                ADD COLUMN seo_title VARCHAR(255) DEFAULT NULL,
                ADD COLUMN seo_desc TEXT DEFAULT NULL,
                ADD COLUMN seo_canonical VARCHAR(255) DEFAULT NULL;");
            
            executeSqlSafely($db, "CREATE INDEX idx_posts_slug ON posts(slug);");
            executeSqlSafely($db, "CREATE INDEX idx_posts_category ON posts(category);");
            executeSqlSafely($db, "CREATE INDEX idx_posts_created_at ON posts(created_at);");
        } else {
            executeSqlSafely($db, "ALTER TABLE posts ADD COLUMN slug TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE posts ADD COLUMN category TEXT DEFAULT 'Khám phá VinFast';");
            executeSqlSafely($db, "ALTER TABLE posts ADD COLUMN views INTEGER DEFAULT 0;");
            executeSqlSafely($db, "ALTER TABLE posts ADD COLUMN status TEXT DEFAULT 'published';");
            executeSqlSafely($db, "ALTER TABLE posts ADD COLUMN focus_keyword TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE posts ADD COLUMN seo_title TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE posts ADD COLUMN seo_desc TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE posts ADD COLUMN seo_canonical TEXT DEFAULT NULL;");
            
            executeSqlSafely($db, "CREATE INDEX idx_posts_slug ON posts(slug);");
            executeSqlSafely($db, "CREATE INDEX idx_posts_category ON posts(category);");
            executeSqlSafely($db, "CREATE INDEX idx_posts_created_at ON posts(created_at);");
        }
        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 7: SEED DEFAULT DATA ---
    $step = '007_seed_default_data';
    if (!isMigrationExecuted($db, $step)) {
        echo "Seeding default seeders...\n";

        // 1. Insert Administrator
        $stmt = $db->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $hash = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(['admin', $hash, 'Administrator', 'Quản trị viên']);
        }

        // 2. Sales & Techs
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = 'Chuyên viên Sale'");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $hash = password_hash('sale123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(['sale1', $hash, 'Nguyễn Hoài Nam (Sale)', 'Chuyên viên Sale']);
            $stmt->execute(['sale2', $hash, 'Phạm Minh Tuyến (Sale)', 'Chuyên viên Sale']);
        }

        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = 'Kỹ thuật viên'");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $hash = password_hash('tech123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(['tech1', $hash, 'Lê Anh Dũng (Kỹ thuật)', 'Kỹ thuật viên']);
            $stmt->execute(['tech2', $hash, 'Vũ Quốc Huy (Kỹ thuật)', 'Kỹ thuật viên']);
        }

        // 3. Counselors
        $stmt = $db->prepare("SELECT COUNT(*) FROM counselors");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $stmtInsert = $db->prepare("INSERT INTO counselors (fullname, phone, zalo, avatar, status) VALUES (?, ?, ?, ?, ?)");
            $stmtInsert->execute(['Nguyễn Thanh Hương', '0817777855', 'https://zalo.me/0817777855', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80', 'ONLINE']);
            $stmtInsert->execute(['Trần Minh Hoàng', '0817777855', 'https://zalo.me/0817777855', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=300&q=80', 'ONLINE']);
            $stmtInsert->execute(['Phạm Quỳnh Chi', '0817777855', 'https://zalo.me/0817777855', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=300&q=80', 'ONLINE']);
        }

        // 4. Default Settings
        $stmt = $db->prepare("SELECT COUNT(*) FROM settings");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $defaultSettings = [
                'about_commitments_desc' => 'Mọi khách hàng sở hữu xe VinFast chính hãng tại đại lý của chúng tôi đều nhận được lời cam kết vàng về chất lượng sản phẩm và dịch vụ tốt nhất.',
                'about_commitments_list' => '[{"icon":"layers","title":"100% Chính hãng Việt Nam","desc":"Toàn bộ danh mục xe từ các mẫu xe điện đô thị đến SUV cỡ lớn và xe buýt điện đều được sản xuất lắp ráp công nghệ cao châu Âu với đầy đủ chứng nhận chất lượng chính hãng toàn cầu."},{"icon":"lock","title":"Bảo hành 3 năm vô hạn KM","desc":"Bảo hành chính hãng 3 năm không giới hạn quãng đường di chuyển. Đối với dòng EV thuần điện, pin cao áp được bảo hành đặc quyền 8 năm hoặc 160,000 km."},{"icon":"wrench","title":"Linh kiện chuẩn VinFast 100%","desc":"Dịch vụ sửa chữa, thay thế cam kết chỉ sử dụng linh phụ kiện chính hãng cung cấp từ kho tổng VinFast Việt Nam, bảo chứng bởi thợ máy đạt chứng chỉ toàn cầu."}]',
                'about_commitments_tag' => 'Cam kết đại lý',
                'about_commitments_title' => 'An tâm tuyệt đối khi đồng hành',
                'about_ctas_list' => '[{"title":"Tư vấn trực tiếp Zalo","desc":"Anh cần tìm hiểu thêm về các chương trình ưu đãi chào hè hay báo giá xe lăn bánh chi tiết? Hãy chat Zalo trực tiếp với em nhé.","link":"https:\\/\\/zalo.me\\/0817777855?text=Chào%20VinFast,%20tôi%20muốn%20nhận%20thêm%20thông%20tin%20tư%20vấn%20và%20chương%20trình%20khuyến%20mãi%20đặc%20quyền","btn_text":"Liên hệ Chat Zalo","btn_class":"btn-about-zalo"},{"title":"Đăng ký trải nghiệm lái","desc":"Hãy trực tiếp cầm lái mẫu xe VinFast yêu thích của anh để cảm nhận công nghệ AWD bám đường cùng sự êm ái vượt bậc của động cơ EV.","link":"cars.php#booking-block","btn_text":"Đăng ký lái thử","btn_class":"btn-about-gold"},{"title":"Bảng giá xe chính hãng","desc":"Tham khảo ngay bảng báo giá chính thức tất cả các dòng xe VinFast đang được trưng bày tại các hệ thống Showroom trên toàn quốc.","link":"pricelist.php","btn_text":"Xem bảng giá xe","btn_class":"btn-about-outline"}]',
                'about_gallery_desc' => 'showroom trưng bày xe vinfast',
                'about_gallery_slides' => '[{"title":"VinFast Charging Lounge","desc":"Phòng chờ sạc nhanh chuẩn mực luxury, nơi khách hàng thư giãn trong khi xe EV sạc điện.","image":"https:\\/\\/images.unsplash.com\\/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80"},{"title":"Trải nghiệm dịch vụ 5 sao","desc":"Không gian sang trọng với quầy bar phục vụ trà, cafe hảo hạng cùng đội ngũ nhân viên nhiệt tình, tận tâm.","image":"https:\\/\\/images.unsplash.com\\/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80"},{"title":"Tiên phong hạ tầng điện hóa","desc":"Trạm sạc nhanh DC công suất lớn lên tới 180kW được lắp đặt trực tiếp tại showroom, sạc đầy 80% chỉ trong 20-30 phút.","image":"https:\\/\\/images.unsplash.com\\/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80"},{"title":"Khu vực trưng bày và bàn giao xe VIP","desc":"Mỗi chiếc xe giao tay khách hàng đều được chuẩn bị tinh tế trong không gian handover kín đáo, chuyên nghiệp.","image":"https:\\/\\/images.unsplash.com\\/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80"},{"title":"VinFast Terminal Tôn Đức Thắng","desc":"Thiết kế nhận diện tòa nhà sang trọng độc quyền từ VinFast Việt Nam, tọa lạc tại trung tâm Quận 1 sầm uất.","image":"https:\\/\\/images.unsplash.com\\/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=1200&q=80"}]',
                'about_gallery_tag' => 'KHÔNG GIAN TRẢI NGHIỆM',
                'about_gallery_title' => 'NƠI TINH HOA HỘI TỤ',
                'about_hero_desc' => 'Đại lý vinfast sài gòn là 1 trong những đại lý xe sang đầu tiên tại việt nam, chuyên bán xe vinfast, hỗ trợ tài chính mua xe vinfast...',
                'about_hero_image_url' => 'assets/uploads/vinfast-vf9-official.webp',
                'about_hero_tag' => 'SHOWROOM XE SANG VINFAST CHÍNH HÃNG',
                'about_hero_title' => 'ĐẠI LÝ VINFAST CHÍNH HÃNG TẠI SÀI GÒN',
                'about_history_desc' => 'Cùng nhìn lại các cột mốc lịch sử vĩ đại làm nền tảng cho sự phát triển công nghệ đột phá của VinFast ngày nay.',
                'about_history_tag' => 'Dòng chảy lịch sử',
                'about_history_timeline' => '[{"year":"2017","title":"Khởi công tổ hợp nhà máy","desc":"VinFast chính thức khởi công tổ hợp nhà máy sản xuất ô tô và xe máy điện quy mô 335 ha tại Hải Phòng với công nghệ hiện đại hàng đầu thế giới."},{"year":"2018","title":"Ra mắt thế giới tại Paris Motor Show","desc":"Gây tiếng vang lớn toàn cầu khi giới thiệu hai mẫu xe Lux A2.0 và Lux SA2.0 tại Triển lãm ô tô Paris, khẳng định vị thế và niềm tự hào Việt Nam."},{"year":"2021","title":"Bàn giao chiếc xe điện đầu tiên","desc":"Bàn giao mẫu xe ô tô điện thông minh đầu tiên VF e34 tại thị trường Việt Nam, mở đầu cho kỷ nguyên di chuyển xanh bền vững."},{"year":"2022","title":"Niêm yết Nasdaq & Chiến lược thuần điện","desc":"Công bố chiến lược thuần điện 100%, nộp hồ sơ IPO tại Mỹ và giới thiệu dải sản phẩm SUV điện thông minh từ VF 5 đến VF 9."},{"year":"2024","title":"Cơn sốt xe điện quốc dân VF 3","desc":"Chính thức ra mắt xe điện mini quốc dân VF 3, nhận kỷ lục hơn 27.000 đơn đặt hàng chỉ sau 66 giờ mở bán tại Việt Nam."},{"year":"2026","title":"Số hóa dịch vụ & Phủ sóng trạm sạc","desc":"Hoàn thiện hệ sinh thái số toàn diện, nâng cấp trợ lý ảo ViVi thế hệ mới và phủ sóng 150.000 cổng sạc trên toàn bộ 63 tỉnh thành."}]',
                'about_history_title' => 'Hành trình kiến tạo tương lai',
                'about_image_url' => 'assets/uploads/vinfast_showroom_banner.jpg',
                'about_intro_headline' => 'Mãnh liệt tinh thần Việt Nam - Tầm nhìn toàn cầu',
                'about_intro_tag' => 'Nhà phân phối xe VinFast chính hãng tại Việt Nam',
                'about_intro_text' => 'Đặc quyền thuê pin & Mạng lưới 150.000 cổng sạc toàn quốc',
                'about_map_iframe' => '',
                'about_quote_author' => 'VinFast Design Studio',
                'about_quote_author_title' => 'Đội ngũ Thiết kế Toàn cầu (Hợp tác Pininfarina & Torino Design)',
                'about_quote_bg_image' => 'assets/uploads/vinfast-banner-uu-dai.webp',
                'about_quote_text' => '"Thiết kế đột phá mang dấu ấn tinh hoa Việt kết hợp cùng công nghệ thông minh vượt trội là chìa khóa mở ra tương lai di động xanh và gắn kết mọi hành trình của bạn."',
                'about_seo_canonical' => '',
                'about_seo_desc' => 'Showroom VinFast Sài Gòn là showroom xe sang chính hãng phân phối các mẫu xe VinFast tại Việt Nam, đến showroom vinfast để trải nghiệm các mẫu xe VinFast ngay hôm nay',
                'about_seo_keywords' => 'showroom vinfast sài gòn, vinfast sài gòn, VinFast Việt Nam, đại lý vinfast',
                'about_seo_title' => 'Showroom VinFast Sài Gòn - Mua Xe VinFast Chính Hãng Tại Sài Gòn',
                'about_stats' => '[{"number":"150+","label":"Showroom & Đại lý","desc":"Hệ thống Showroom 3S đạt chuẩn dịch vụ và trải nghiệm khách hàng trên toàn quốc."},{"number":"150.000+","label":"Cổng sạc toàn quốc","desc":"Hạ tầng trạm sạc EV thông minh trải rộng khắp 63 tỉnh thành tại Việt Nam."},{"number":"10 Năm","label":"Bảo hành chính hãng","desc":"Đặc quyền bảo hành lâu nhất thị trường cho tất cả các dòng xe điện."},{"number":"24/7","label":"Cứu hộ khẩn cấp","desc":"Dịch vụ cứu hộ Roadside Assistance và sửa chữa lưu động Mobile Service chuyên nghiệp."}]',
                'about_tech_desc' => 'Khám phá các di sản kỹ thuật cơ khí đỉnh cao tạo nên linh hồn và sự khác biệt vượt bậc của mỗi chiếc xe VinFast.',
                'about_tech_list' => '[{"name":"Trợ lý ViVi","tag":"Trợ lý ảo thông minh tiếng Việt","title":"Giao tiếp tự nhiên đa vùng miền","desc":"Hiểu khẩu lệnh tiếng Việt đa vùng miền, giúp người lái dễ dàng điều khiển điều hòa, âm thanh, dẫn đường và cập nhật tin tức rảnh tay an toàn.","features":"Nhận diện giọng nói đa vùng miền; Điều khiển chức năng xe bằng giọng nói; Hỏi đáp thông tin trực tuyến","image":"https:\\/\\/images.unsplash.com\\/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80"},{"name":"ADAS","tag":"Hệ thống trợ lái nâng cao","title":"Tấm khiên bảo vệ chủ động","desc":"Hỗ trợ di chuyển an toàn với các tính năng cảnh báo chệch làn, hỗ trợ giữ làn, phanh khẩn cấp tự động và camera 360 độ sắc nét.","features":"Cảnh báo va chạm phía trước; Hỗ trợ đỗ xe thông minh; Phanh tự động khẩn cấp","image":"assets\\/uploads\\/01c1c5bbf92b05d64e78367e3605c38c.jpeg"},{"name":"Trạm Sạc","tag":"Hạ tầng trạm sạc phủ rộng","title":"An tâm di chuyển muôn nơi","desc":"Mạng lưới hơn 150.000 cổng sạc đa công suất được quy hoạch đồng bộ tại các bãi đỗ xe, trung tâm thương mại, chung cư và trạm dừng nghỉ quốc lộ.","features":"Trạm sạc nhanh DC 150kW\\/250kW; An toàn chống cháy nổ tiêu chuẩn châu Âu; Quản lý sạc qua App thông minh","image":"assets\\/uploads\\/23b6883b6692fd6cb5318f8312990474.jpg"}]',
                'about_tech_tag' => 'Công nghệ thông minh tiên phong',
                'about_tech_title' => 'Ba trụ cột công nghệ tiên phong',
                'about_title' => 'Giới thiệu VinFast Việt Nam',
                'about_values' => '[{"title":"Đỉnh Cao Thiết Kế","desc":"Ngôn ngữ thiết kế tối giản, khí động học xuất sắc kết hợp cùng dải đèn Matrix LED tiên phong định hình tương lai.","icon":"fas fa-pencil-ruler"},{"title":"Hiệu Suất Điện Hóa","desc":"Hệ dẫn động AWD huyền thoại kết hợp động cơ thuần điện EV mạnh mẽ, êm ái và bảo vệ môi trường.","icon":"fas fa-bolt"},{"title":"Đặc Quyền Thượng Lưu","desc":"Dịch vụ phòng chờ VIP 5 sao, đội ngũ cố vấn riêng biệt và chế độ hậu mãi chuẩn toàn cầu tại Showroom VinFast 3S.","icon":"fas fa-crown"}]',
                'agency_address' => '6B Tôn Đức Thắng, Phường Bến Nghé, Quận 1, Tp. Hồ Chí Minh',
                'agency_email' => 'info@vinfasttamphong.vn',
                'agency_hours' => 'Thứ 2 - Thứ 7: 8:00 - 18:00 | Chủ Nhật: 9:00 - 17:00',
                'agency_name' => 'VinFast Việt Nam - Chi nhánh Tp. Hồ Chí Minh',
                'agency_phone' => '0817777855',
                'dealer_image' => 'assets/uploads/vinfast_showroom_banner.jpg',
                'email_smtp_host' => 'smtp.gmail.com',
                'email_smtp_user' => 'notifications@vinfast.vn',
                'footer_col2_link1_text' => 'VinFast VF 8 & VF 9 (SUV hạng sang)',
                'footer_col2_link1_url' => 'cars.php',
                'footer_col2_link2_text' => 'VinFast VF 3 & VF 5 (SUV đô thị)',
                'footer_col2_link2_url' => 'cars.php',
                'footer_col2_link3_text' => 'VinFast VF 6 & VF 7 (SUV thể thao)',
                'footer_col2_link3_url' => 'cars.php',
                'footer_col2_link4_text' => 'Định giá xe & Lên đời',
                'footer_col2_link4_url' => 'index.php#tradein-block',
                'footer_col2_title' => 'Dòng xe nổi bật',
                'footer_col3_link1_text' => 'Mua xe VinFast trả góp',
                'footer_col3_link1_url' => 'http://localhost/vinfast111/installment.php',
                'footer_col3_link2_text' => 'Bảng giá xe VinFast',
                'footer_col3_link2_url' => 'http://localhost/vinfast111/pricelist.php',
                'footer_col3_link3_text' => 'Trang quản trị CRM',
                'footer_col3_link3_url' => 'admin.php',
                'footer_col3_link4_text' => 'Đặt lịch hẹn lái thử',
                'footer_col3_link4_url' => 'cars.php#booking-block',
                'footer_col3_title' => 'Liên kết dịch vụ',
                'footer_copyright' => '<p>Bản quyền &copy; 2026 VinFastvn.com. Tất cả quyền được bảo lưu. <br>C&aacute;c th&ocirc;ng số kỹ thuật, h&igrave;nh ảnh v&agrave; trang bị thực tế c&oacute; thể thay đổi bởi nh&agrave; sản xuất m&agrave; kh&ocirc;ng b&aacute;o trước. Bản quyền thiết kế website &copy; 2026 <a href="tel:0817777955">&Ocirc;ng Bụt Official</a></p>',
                'footer_facebook' => '#',
                'footer_instagram' => '#',
                'footer_tagline' => '<p>Đại L&yacute; VinFast S&agrave;i G&ograve;n - Showroom Xe VinFast tại S&agrave;i G&ograve;n ti&ecirc;n phong trong c&ocirc;ng nghệ điện h&oacute;a EV, n&acirc;ng tầm trải nghiệm l&aacute;i thể thao v&agrave; dịch vụ đẳng cấp 5 sao to&agrave;n cầu.</p>',
                'footer_youtube' => '#',
                'hero_banner_image' => 'assets/uploads/vinfast-vf9-official.webp',
                'hero_btn1' => 'Khám phá ưu đãi đặc biệt',
                'hero_btn2' => 'Đăng ký trải nghiệm xe VinFast',
                'hero_headline' => 'Định giá xe ô tô cũ chính xác trong 3 bước',
                'hero_subline' => 'Công cụ tra cứu giá xe cũ thị trường nhanh chóng và ký gửi xe bán được giá cao nhất.',
                'installment_banks' => '[{"name":"Vietcombank (Ngân hàng TMCP Ngoại thương Việt Nam)","rate":"6.9","max_loan":"80","max_years":"8"},{"name":"Techcombank (Ngân hàng TMCP Kỹ thương Việt Nam)","rate":"7.5","max_loan":"85","max_years":"8"},{"name":"Shinhan Bank (Ngân hàng Shinhan Việt Nam)","rate":"6.5","max_loan":"80","max_years":"8"},{"name":"MB Bank (Ngân hàng TMCP Quân đội)","rate":"7.2","max_loan":"80","max_years":"8"},{"name":"VIB (Ngân hàng TMCP Quốc tế Việt Nam)","rate":"7.9","max_loan":"85","max_years":"8"},{"name":"Sacombank (Ngân hàng TMCP Sài Gòn Thương Tín)","rate":"8","max_loan":"80","max_years":"8"}]',
                'installment_disclaimer' => 'Bảng tính lãi suất trả góp chỉ mang tính chất tham khảo trực quan tại thời điểm hiện tại. Lãi suất thực tế và các chương trình ưu đãi độc quyền có thể thay đổi tùy thuộc vào chính sách tín dụng của từng ngân hàng liên kết tại thời điểm giải ngân và xếp hạng tín dụng của khách hàng.',
                'installment_docs_business' => 'Hồ sơ pháp lý doanh nghiệp: Giấy chứng nhận đăng ký doanh nghiệp (GPKD), Điều lệ công ty, Biên bản họp bổ nhiệm người đại diện pháp luật.
Giấy tờ tùy thân người đại diện: CCCD/Hộ chiếu người đại diện pháp luật ký kết hợp đồng vay vốn.
Hồ sơ tài chính doanh nghiệp: Báo cáo tài chính nội bộ, Báo cáo thuế tối thiểu 1 - 2 năm gần nhất, Sao kê tài khoản ngân hàng công ty 6 tháng qua.
Hồ sơ mục đích vay: Hợp đồng mua bán xe ô tô ký giữa công ty và đại lý VinFast, Phiếu thu/Ủy nhiệm chi tiền đặt cọc xe.',
'installment_docs_personal' => 'Hồ sơ pháp lý: CCCD gắn chip (hoặc định danh VNeID mức độ 2), Giấy xác nhận độc thân hoặc Giấy đăng ký kết hôn của cả hai vợ chồng.
Hồ sơ chứng minh thu nhập: Hợp đồng lao động còn thời hạn hiệu lực, Bảng lương hoặc Sao kê lương ngân hàng 3 - 6 tháng gần nhất.
Thu nhập khác (nếu có): Hợp đồng cho thuê nhà, thuê xe ô tô, hoặc sổ tiết kiệm, giấy tờ sở hữu cổ phần kinh doanh.
Hồ sơ mục đích vay: Hợp đồng mua bán xe ô tô VinFast ký với đại lý chính hãng, Phiếu thu tiền đặt cọc xe.',
                'installment_eligibility' => 'Độ tuổi người vay: Tại thời điểm nộp hồ sơ vay từ đủ 18 tuổi và không quá 65 tuổi tại thời điểm tất toán toàn bộ khoản vay ngân hàng.
Lịch sử CIC tín dụng: Không có nợ nhóm 3, 4, 5 tại Trung tâm Thông tin Tín dụng Quốc gia (CIC) trong 2 năm gần nhất.
Nguồn thu nhập tối thiểu: Tổng thu nhập ổn định từ lương chuyển khoản ngân hàng tối thiểu 10 triệu/tháng (đối với cá nhân), hoặc có dòng tiền ổn định từ kinh doanh/cho thuê tài sản.
Nơi cư trú hợp pháp: Có hộ khẩu thường trú hoặc đăng ký tạm trú dài hạn (KT3) tại tỉnh/thành phố có chi nhánh giao dịch của ngân hàng liên kết vay.',
                'installment_faqs' => '[{"question":"Thủ tục mua xe trả góp cần chuẩn bị những hồ sơ cơ bản nào?","answer":"Đối với khách hàng cá nhân, anh\\/chị cần CCCD gắn chip (hoặc định danh VNeID mức độ 2), đăng ký kết hôn (nếu đã kết hôn) hoặc chứng nhận độc thân. Về hồ sơ thu nhập cần hợp đồng lao động, sao kê lương 3-6 tháng gần nhất. Với doanh nghiệp cần Giấy phép kinh doanh, báo cáo tài chính nội bộ hoặc sao kê tài khoản ngân hàng của công ty."},{"question":"Hạn mức vay mua xe VinFast tối đa là bao nhiêu và tôi cần trả trước bao nhiêu?","answer":"Các ngân hàng đối tác liên kết của VinFast Việt Nam hỗ trợ hạn mức cho vay tối đa từ 80% lên đến 85% giá trị xe trên hóa đơn (đối với dòng xe điện thông minh) và hỗ trợ tài sản thế chấp độc lập khác. Quý khách chỉ cần chuẩn bị tối thiểu 15% - 20% giá trị đối ứng xe để tiến hành làm thủ tục giải ngân."},{"question":"Thời gian phê duyệt khoản vay mất bao lâu và xe có được giải ngân nhận ngay không?","answer":"Nhờ quy trình số hóa và cam kết liên kết đặc quyền, thời gian thẩm duyệt hồ sơ tại các ngân hàng đối tác chỉ từ 4 đến 24 giờ làm việc kể từ khi nhận đủ tài liệu. Ngay sau khi có thông báo cho vay và quý khách hoàn tất thủ tục đăng ký xe lấy biển số, ngân hàng sẽ thực hiện giải ngân trong vòng 2 giờ để quý khách nhận bàn giao xe."},{"question":"Tôi có thể tất toán khoản vay trước hạn được không và mức phí phạt là bao nhiêu?","answer":"Quý khách hoàn toàn có thể tất toán (trả hết) khoản vay trước thời hạn đăng ký bất kỳ lúc nào. Phí tất toán trước hạn được áp dụng theo quy định của từng ngân hàng đối tác liên kết, thông thường dao động từ 1% đến 3% trên dư nợ gốc còn lại trong 3 năm đầu, và thường được miễn phí hoàn toàn kể từ năm thứ 4 hoặc thứ 5 trở đi."}]',
                'installment_features' => 'Hạn mức cho vay: Hỗ trợ lên tới 80% - 85% giá trị xe trên hóa đơn mua bán thực tế. Khách hàng chỉ cần chuẩn bị trước 15% - 20% đối ứng.
Thời gian vay vốn: Linh hoạt kéo dài từ 1 năm (12 tháng) tới tối đa 8 năm (96 tháng) giúp dàn đều chi phí gốc lãi hàng tháng.
Phương thức tính lãi: Tính lãi trên dư nợ thực tế giảm dần (không tính trên dư nợ bao đầu), số tiền trả lãi sẽ giảm cực kỳ mạnh qua các năm tiếp theo.
Tài sản bảo đảm: Chính chiếc xe VinFast quý khách dự định mua, hoặc bất động sản khác thuộc quyền sở hữu hợp pháp của quý khách.',
                'installment_gallery' => '[{"tag":"KHÁCH HÀNG DOANH NHÂN","title":"Bàn giao VinFast VF 9","desc":"\\"Hồ sơ phê duyệt chỉ trong 4 giờ và giải ngân nhanh chóng trong ngày giúp tôi kịp nhận xe trước chuyến công tác dài ngày. Rất hài lòng với sự chuyên nghiệp của đại lý.\\"","image":"assets\\/uploads\\/df05d0879f7580df4b1329b94e4a8a25.webp","customer_name":"Anh Trần Minh H.","customer_role":"CEO Công nghệ xanh"},{"tag":"KHÁCH HÀNG GIA ĐÌNH VIP","title":"Bàn giao VinFast VF 9 SUV","desc":"\\"Vợ chồng mình rất thích dòng VF 9 rộng rãi nhưng còn phân vân dòng tiền kinh doanh cuối năm. Nhờ phương án vay 8 năm lãi suất cố định của ngân hàng liên kết, mọi việc đã trở nên nhẹ nhàng.\\"","image":"assets\\/uploads\\/cc9c5bd4faef08a81fb641a8259d5eda.webp","customer_name":"Chị Đặng Thu T.","customer_role":"Kinh doanh chuỗi Nhà hàng"},{"tag":"PREMIUM VIP LOUNGE","title":"Làm thủ tục tại Showroom","desc":"\\"Lần đầu mua xe sang và lựa chọn trả góp nhưng nhân viên tư vấn tận tình từng con số lẻ, làm việc minh bạch rõ ràng không phát sinh chi phí ngoài dự kiến.\\"","image":"assets\\/uploads\\/0e01630d33cb4db4a28cfcd2db5956ec.webp","customer_name":"Anh Hoàng Vũ L.","customer_role":"Nhà đầu tư Tài chính"}]',
                'installment_interest_default' => '9',
                'installment_seo_canonical' => '',
                'installment_seo_desc' => '',
                'installment_seo_keywords' => '',
                'installment_seo_title' => '',
                'installment_showcases' => '[{"tag":"SUV CỠ B THỜI THƯỢNG","title":"VinFast VF 6 Plus","desc":"Trải nghiệm sự tinh tế vượt trội với mức chi phí đầu tư ban đầu cực kỳ nhẹ nhàng.","image":"assets/uploads/vinfast-vf6-official.webp","prepay":"Chỉ từ 150 Triệu","monthly":"7.5 Triệu / tháng","preset":"VinFast VF 6 Plus"},{"tag":"SUV CỠ D MẠNH MẼ","title":"VinFast VF 8 Plus","desc":"Không gian rộng rãi, tiện nghi ngập tràn cho cả gia đình cùng hệ dẫn động AWD mạnh mẽ.","image":"assets/uploads/vinfast-vf8-official.webp","prepay":"Chỉ từ 260 Triệu","monthly":"12 Triệu / tháng","preset":"VinFast VF 8 Plus"},{"tag":"SUV HẠNG SANG FLAGSHIP","title":"VinFast VF 9 Plus","desc":"Trải nghiệm kỷ nguyên xe điện thể thao hiệu năng cao đỉnh cao với ưu đãi thuế trước bạ 0%.","image":"assets/uploads/vinfast-vf9-official.webp","prepay":"Chỉ từ 420 Triệu","monthly":"20 Triệu / tháng","preset":"VinFast VF 9 Plus"}]',
                'installment_steps' => '[{"title":"Tư vấn & Lập phương án","desc":"Đội ngũ chuyên viên tài chính VinFast tiếp nhận nhu cầu, hỗ trợ phân tích ngân sách và đề xuất ngân hàng liên kết tối ưu nhất."},{"title":"Chuẩn bị & Thẩm định hồ sơ","desc":"Quý khách chuẩn bị các giấy tờ pháp lý và nguồn thu cơ bản. Ngân hàng tiến hành thu thập, thẩm định nhanh chóng."},{"title":"Phê duyệt & Đặt cọc","desc":"Sau khi có thông báo tài trợ cho vay từ ngân hàng, quý khách hoàn tất thủ tục ký hợp đồng mua bán và nộp phần đối ứng."},{"title":"Giải ngân & Nhận xe","desc":"Ngân hàng thực hiện giải ngân thanh toán nốt phần còn lại, quý khách đến nhận xe bàn giao kèm đầy đủ hồ sơ lăn bánh."}]',
                'policy_privacy_link' => '#',
                'policy_terms_link' => '#',
                'portal_cms_link' => 'login.php',
                'pricelist_editorial' => '<h2>Cẩm nang Mua xe &amp; Ph&acirc;n t&iacute;ch Bảng gi&aacute; xe VinFast tại Việt Nam</h2>
<p>Thương hiệu ô tô điện thông minh VinFast Việt Nam lu&ocirc;n l&agrave; biểu tượng của sự kết hợp ho&agrave;n hảo giữa c&ocirc;ng nghệ ti&ecirc;n phong (Mãnh liệt tinh thần Việt Nam), hiệu suất vận h&agrave;nh AWD đỉnh cao v&agrave; sự sang trọng tinh tế. Việc sở hữu một chiếc xe VinFast tại thị trường Việt Nam đ&ograve;i hỏi người mua cần nắm vững c&aacute;c th&ocirc;ng tin về bảng gi&aacute; xe, c&aacute;c chương tr&igrave;nh hỗ trợ t&agrave;i ch&iacute;nh trả g&oacute;p cũng như quy tr&igrave;nh t&iacute;nh to&aacute;n tổng chi ph&iacute; lăn b&aacute;nh ch&iacute;nh x&aacute;c.</p>
<h3>C&aacute;c D&ograve;ng Xe VinFast Nổi Bật v&agrave; Xu Hướng Gi&aacute; Cả</h3>
<p>Tại Việt Nam, VinFast ph&acirc;n phối đa dạng c&aacute;c ph&acirc;n kh&uacute;c xe đ&aacute;p ứng mọi nhu cầu c&aacute; nh&acirc;n h&oacute;a của kh&aacute;ch h&agrave;ng:</p>
<p><img style="max-width: 100%; height: auto; margin: 10px 0; border-radius: 6px; display: block;" src="assets/uploads/vinfast-banner-voucher.jpg" alt="7dc25c824dcbe5b954944460683417e3"></p>
<ul>
<li><strong>D&ograve;ng Sedan &amp; Plus (VinFast VF 6 EV, VF 6, VF 3, VF 5)</strong>: Mang lại kiểu d&aacute;ng kh&iacute; động học đột ph&aacute;, khoang nội thất cabin kỹ thuật số hiện đại c&ugrave;ng cảm gi&aacute;c l&aacute;i &ecirc;m &aacute;i, sang trọng vượt bậc. Ph&ugrave; hợp cho giới doanh nh&acirc;n v&agrave; những người y&ecirc;u th&iacute;ch sự lịch l&atilde;m.</li>
<li><strong>D&ograve;ng SUV Tiện Nghi (VinFast VF 7, VF 8, VF 9, VF 9)</strong>: Kh&ocirc;ng gian gầm cao rộng r&atilde;i, hệ dẫn động bốn b&aacute;nh to&agrave;n thời gian AWD lừng danh gi&uacute;p kiểm so&aacute;t lực b&aacute;m tối ưu tr&ecirc;n mọi địa h&igrave;nh thời tiết. Đ&acirc;y l&agrave; lựa chọn ho&agrave;n hảo cho c&aacute;c gia đ&igrave;nh năng động.</li>
<li><strong>Kỷ nguy&ecirc;n xe điện VinFast EV (VF 8, VF 9)</strong>: Đi ti&ecirc;n phong trong cuộc c&aacute;ch mạng xanh h&oacute;a giao th&ocirc;ng cao cấp. EV sở hữu c&ocirc;ng nghệ sạc cực nhanh, tầm hoạt động vượt trội v&agrave; c&ocirc;ng suất vận h&agrave;nh tức th&igrave; kh&ocirc;ng độ trễ.</li>
</ul>
<h3>Quy Tr&igrave;nh T&iacute;nh Gi&aacute; Lăn B&aacute;nh Xe VinFast Chi Tiết</h3>
<p>Để một chiếc xe VinFast ch&iacute;nh h&atilde;ng đủ điều kiện lưu h&agrave;nh hợp ph&aacute;p tr&ecirc;n đường phố Việt Nam, b&ecirc;n cạnh gi&aacute; ni&ecirc;m yết c&ocirc;ng bố từ nh&agrave; ph&acirc;n phối, chủ sở hữu cần chuẩn bị chi trả c&aacute;c khoản thuế v&agrave; lệ ph&iacute; bắt buộc do nh&agrave; nước quy định:</p>
<ol>
<li><strong>Lệ ph&iacute; trước bạ</strong>: Chiếm tỷ trọng lớn nhất trong c&aacute;c khoản chi ph&iacute; phụ trợ. Th&ocirc;ng thường mức ph&iacute; trước bạ l&agrave; 10% gi&aacute; trị xe đối với đa số c&aacute;c tỉnh th&agrave;nh v&agrave; TP. Hồ Ch&iacute; Minh. Ri&ecirc;ng tại H&agrave; Nội, mức ph&iacute; trước bạ &aacute;p dụng l&agrave; 12%. Đối với c&aacute;c d&ograve;ng xe thuần điện chạy pin như VinFast EV, nh&agrave; nước hỗ trợ &aacute;p dụng thuế trước bạ lần đầu l&agrave; 0%, gi&uacute;p tiết kiệm từ v&agrave;i chục đến h&agrave;ng trăm triệu đồng cho kh&aacute;ch h&agrave;ng mua xe điện.</li>
<li><img style="max-width: 100%; height: auto; margin: 10px 0; border-radius: 6px; display: block;" src="assets/uploads/vinfast-banner-uu-dai.webp" alt="90cd1b3be5d502a91924ddbff4beac98"></li>
</ol>
<p>2. <strong>Lệ ph&iacute; cấp biển số</strong>: H&agrave; Nội v&agrave; TP. Hồ Ch&iacute; Minh &aacute;p dụng mức ph&iacute; cố định l&agrave; 20.000.000 VNĐ cho mỗi lần đăng k&yacute; mới. Ở c&aacute;c tỉnh th&agrave;nh c&ograve;n lại, mức ph&iacute; n&agrave;y chỉ từ 1.000.000 VNĐ đến 2.000.000 VNĐ.</p>
<p>3. <strong>Ph&iacute; bảo tr&igrave; đường bộ</strong>: Mức thu quy định cho xe c&aacute; nh&acirc;n l&agrave; 130.000 VNĐ/th&aacute;ng (tương đương 1.560.000 VNĐ/năm).</p>
<p>4. <strong>C&aacute;c chi ph&iacute; kh&aacute;c</strong>: Bao gồm ph&iacute; kiểm định xe (đăng kiểm) trị gi&aacute; 340.000 VNĐ v&agrave; ph&iacute; bảo hiểm tr&aacute;ch nhiệm d&acirc;n sự bắt buộc l&agrave; 480.000 VNĐ/năm.</p>
<h3>Ch&iacute;nh S&aacute;ch Hỗ Trợ Mua Xe VinFast Trả G&oacute;p Ưu Đ&atilde;i</h3>
<p>Đại l&yacute; ủy quyền ch&iacute;nh h&atilde;ng phối hợp chặt chẽ với c&aacute;c ng&acirc;n h&agrave;ng lớn trong v&agrave; ngo&agrave;i nước cung cấp g&oacute;i vay t&agrave;i ch&iacute;nh linh hoạt. Kh&aacute;ch h&agrave;ng chỉ cần thanh to&aacute;n trước từ 20% đến 30% gi&aacute; trị xe, phần c&ograve;n lại được hỗ trợ vay trả g&oacute;p d&agrave;i hạn l&ecirc;n tới 84 th&aacute;ng (7 năm) với l&atilde;i suất &aacute;p dụng chỉ từ 7.9%/năm. C&aacute;c g&oacute;i t&agrave;i ch&iacute;nh được thiết kế linh hoạt theo cả hai h&igrave;nh thức: trả gốc đều l&atilde;i giảm dần hoặc trả ni&ecirc;n kim cố định h&agrave;ng th&aacute;ng để kh&aacute;ch h&agrave;ng chủ động d&ograve;ng tiền.</p>',
                'pricelist_faqs' => '[{"question":"Giá xe VinFast lăn bánh tại Việt Nam bao gồm những chi phí nào?","answer":"Giá xe VinFast lăn bánh bao gồm giá niêm yết xe từ nhà phân phối và các khoản chi phí bắt buộc theo luật định: lệ phí trước bạ (10% - 12% tùy địa phương), phí cấp biển số (20 triệu VNĐ tại HN & TP.HCM, 2 triệu VNĐ tại các tỉnh khác), phí đường bộ 12 tháng (1.560.000 VNĐ), bảo hiểm trách nhiệm dân sự bắt buộc (480.000 VNĐ) và phí đăng kiểm xe (340.000 VNĐ)."},{"question":"Mua xe điện VinFast EV được hưởng chính sách ưu đãi gì?","answer":"Hiện nay, theo chính sách khuyến khích xe xanh của nhà nước, xe ô tô điện chạy pin như VinFast EV được áp dụng mức lệ phí trước bạ là 0%. Điều này giúp tổng chi phí lăn bánh của xe điện tiết kiệm hơn xe động cơ xăng truyền thống tương đương hàng trăm triệu đồng."},{"question":"Tôi có thể mua xe VinFast trả góp với hạn mức tối đa bao nhiêu?","answer":"Đại lý VinFast liên kết với hệ thống ngân hàng lớn hỗ trợ khách hàng mua xe trả góp lên đến 70% - 80% giá trị xe niêm yết, thời hạn vay linh hoạt đến 84 tháng (7 năm). Lãi suất áp dụng cực kỳ ưu đãi chỉ từ 7.9%\\/năm với thủ tục xét duyệt hồ sơ nhanh gọn."}]',
                'pricelist_intro_desc' => 'Cập nhật bảng giá niêm yết chính hãng toàn bộ các dòng xe điện thông minh VinFast mới nhất tại thị trường Việt Nam.',
                'pricelist_intro_headline' => 'Bảng giá xe VinFast mới nhất tại Việt Nam',
                'pricelist_promos' => '[{\"model_name\":\"VinFast VF 3\",\"promo\":\"Hỗ trợ 100% lệ phí trước bạ xe điện (thuế suất 0%) + Tặng bộ thảm lót sàn cao cấp chính hãng.\",\"gifts\":\"Bộ sạc di động chính hãng tiện lợi | Thảm lót sàn cao su đúc logo VinFast | Móc khóa da VinFast sang trọng\"},{\"model_name\":\"VinFast VF 5 Plus\",\"promo\":\"Đặc quyền ưu đãi miễn phí sạc pin 1 năm đầu tại tất cả các trạm sạc nhanh VinFast toàn quốc.\",\"gifts\":\"Bộ sạc di động 2.2kW chính hãng | Gói phủ Ceramic bảo vệ sơn cao cấp | Thảm lót sàn da 5D thiết kế riêng\"},{\"model_name\":\"VinFast VF 6 Eco\",\"promo\":\"Hỗ trợ lãi suất vay cố định 5.0%/năm trong 2 năm đầu + Miễn phí hoàn toàn chi phí cứu hộ 24/7.\",\"gifts\":\"Bộ sạc treo tường thông minh 11kW | Dán phim cách nhiệt 3M chính hãng | Ô che nắng gấp gọn VinFast\"},{\"model_name\":\"VinFast VF 6 Plus\",\"promo\":\"Tặng ngay 1 năm bảo hiểm thân vỏ Liberty + Gói cứu hộ Roadside Assistance 24/7 độc quyền.\",\"gifts\":\"Bộ sạc treo tường 11kW | Camera hành trình Vietmap cảnh báo tốc độ | Vali du lịch VinFast Limited\"},{\"model_name\":\"VinFast VF 7 Base\",\"promo\":\"Hỗ trợ chiết khấu trực tiếp vào giá bán lẻ khi lựa chọn gói mua xe không kèm pin.\",\"gifts\":\"Bộ sạc di động chính hãng | Thảm lót sàn da cao cấp | Dù che mưa cán dài thời trang\"},{\"model_name\":\"VinFast VF 7 Plus\",\"promo\":\"Đặc quyền ưu đãi miễn phí sạc pin 2 năm đầu tại hệ thống trạm sạc công cộng VinFast toàn quốc.\",\"gifts\":\"Hộp sạc treo tường thông minh 11kW | Gói phủ thủy tinh bảo vệ bề mặt sơn | Ví da đựng hồ sơ xe cao cấp\"},{\"model_name\":\"VinFast VF 8 Eco\",\"promo\":\"Ưu đãi đặc biệt giảm ngay 50 triệu VNĐ tiền mặt trực tiếp cho khách hàng đặt cọc sớm trong tháng.\",\"gifts\":\"Bộ sạc treo tường thông minh 11kW | Camera hành trình 4K định vị GPS | Bạt phủ xe 3 lớp chống nắng nóng\"},{\"model_name\":\"VinFast VF 8 Plus\",\"promo\":\"Hỗ trợ lãi suất vay mua xe ưu đãi tối ưu cố định 4.8%/năm trong 3 năm đầu tại ngân hàng đối tác.\",\"gifts\":\"Trạm sạc treo tường 11kW | Gói bảo dưỡng xe định kỳ miễn phí 2 năm | Vali kéo du lịch VinFast Collection\"},{\"model_name\":\"VinFast VF 9 Eco\",\"promo\":\"Miễn phí 100% chi phí và nhân công bảo dưỡng chính hãng trong 3 năm đầu (hoặc 50.000 km).\",\"gifts\":\"Trạm sạc treo tường thông minh 11kW | Phim cách nhiệt cao cấp 3M Crystalline | Bạt phủ xe EV chống cháy\"},{\"model_name\":\"VinFast VF 9 Plus\",\"promo\":\"Đặc quyền VIP hỗ trợ giao xe tận nhà bằng xe chuyên dụng + Tặng thẻ thành viên VinClub hạng kim cương.\",\"gifts\":\"Hộp sạc treo tường 11kW | Gói spa làm đẹp xe phủ Ceramic kim cương | Ví đựng hồ sơ da thật cao cấp dập chìm logo chữ V\"}]',
                'pricelist_tax_note' => 'Giá niêm yết đã bao gồm thuế Giá trị gia tăng (VAT 10%), chưa bao gồm lệ phí trước bạ, phí đăng ký biển số, phí đăng kiểm, bảo hiểm dân sự bắt buộc và các chi phí lăn bánh khác.',
                'pseo_phone' => '0817777955',
                'pseo_website' => 'https://example.com',
                's5_privileges' => '[{"watermark":"Warranty","title":"Bảo hành 3 năm vô hạn km","desc":"Yên tâm tuyệt đối với chế độ bảo hành chính hãng toàn cầu không giới hạn quãng đường di chuyển.","link_text":"Tìm hiểu chính sách","link_href":"#catalog-block"},{"watermark":"EV","title":"Độc quyền sạc nhanh EV","desc":"Truy cập hệ thống trạm sạc nhanh cao cấp công suất lớn phủ sóng rộng rãi tại các showroom VinFast Việt Nam.","link_text":"Hệ thống trạm sạc","link_href":"#catalog-block"},{"watermark":"Roadside","title":"Cứu hộ VinFast Roadside 24/7","desc":"Đội ngũ kỹ sư hỗ trợ ứng cứu khẩn cấp trên mọi cung đường Việt Nam bất kể ngày đêm.","link_text":"Hotline cứu trợ","link_href":"#tradein-block"},{"watermark":"Trade-in","title":"Chính sách thu cũ đổi mới","desc":"Định giá xe cũ minh bạch và hỗ trợ lên đời dòng xe VinFast thế hệ mới với nhiều ưu đãi đặc quyền.","link_text":"Đăng ký định giá","link_href":"#tradein-block"}]',
                's6_desc' => '<p>VinFast khẳng định định hướng phát triển bền vững với dải sản phẩm xe điện thông minh 100%, bảo hành 10 năm cao nhất thị trường.</p>',
                's6_headline' => 'VinFast Việt Nam giới thiệu các dòng xe điện thông minh mới - Mở ra kỷ nguyên di chuyển xanh và bền vững.',
                's6_reasons' => '[{"title":"100% sản xuất lắp ráp công nghệ cao","desc":"Đảm bảo nguồn gốc xuất xứ chính hãng từ các nhà máy VinFast Việt Nam, đầy đủ hồ sơ thông quan Hải quan (C/O, C/Q) minh bạch tuyệt đối."},{"title":"Đội Ngũ Kỹ Sư Đạt Chuẩn Toàn Cầu","desc":"Đội ngũ cố vấn kỹ thuật và thợ máy chuyên trách được đào tạo bài bản, kiểm tra khắt khe và cấp chứng chỉ trực tiếp từ hãng mẹ VinFast Việt Nam theo chuẩn quốc tế."},{"title":"Hỗ Trợ Thủ Tục Siêu Tốc","desc":"Đội ngũ chuyên viên chuyên nghiệp hỗ trợ trọn gói mọi thủ tục đăng ký biển số, đăng kiểm lưu hành, dịch vụ tài chính liên kết và giao xe tận nhà chu đáo."},{"title":"Showroom Đạt Chuẩn Quốc Tế","desc":"Hệ thống cơ sở hạ tầng, phòng trưng bày sang trọng theo nhận diện toàn cầu (Showroom VinFast 3S), mang lại không gian trải nghiệm dịch vụ đỉnh cao 5 sao."}]',
                's6_signature_quote' => 'Mỗi hành trình cùng VinFast không chỉ đơn thuần là di chuyển, đó là lời khẳng định về một phong cách sống thời thượng, sự an tâm tuyệt đối trên mọi nẻo đường và đặc quyền dịch vụ chuẩn 5 sao toàn cầu.',
                's7_default_counselor_name' => 'Mr. Nguyễn Thành',
                's7_default_counselor_title' => 'Chuyên viên tư vấn VIP',
                's7_tradein_desc' => 'Chương trình hỗ trợ độc quyền của đại lý VinFast dành cho quý khách hàng đang sở hữu bất kỳ hãng xe nào muốn đổi sang dòng xe VinFast mới đẳng cấp.',
                's7_tradein_steps' => '[{"num":"01","title":"Gửi Thông Tin Trực Tuyến","desc":"Điền thông số xe hiện tại và cách liên hệ của anh\\/chị tại biểu mẫu bên cạnh chỉ trong 1 phút."},{"num":"02","title":"Thẩm Định Tại Nhà Miễn Phí","desc":"Đội ngũ kỹ sư VinFast Certified sẽ liên hệ trực tiếp và đến tận nhà thẩm định xe của anh\\/chị hoàn toàn miễn phí."},{"num":"03","title":"Lên Đời Xe Giao Tận Nơi","desc":"Hưởng ưu đãi thu mua xe cũ giá cao nhất thị trường, khấu trừ trực tiếp vào giá xe VinFast mới và hỗ trợ giao xe tận nhà chu đáo."}]',
                's7_tradein_title' => 'Thu cũ đổi mới - Lên đời xe VinFast chính hãng',
                's8_offers' => '[{"tag":"CHÀO HÈ 2026","title":"Hỗ trợ lệ phí trước bạ","desc":"Ưu đãi lên tới 100% lệ phí trước bạ hoặc khấu trừ trực tiếp giá trị giao dịch lên tới 300 triệu đồng áp dụng cho một số dòng xe ô tô điện thông minh.","bullets":["Áp dụng cho các dòng sedan và SUV VinFast VF 3, VF 5, VF 6, VF 7, VF 8, VF 9 chính hãng","Hỗ trợ thực hiện nhanh trọn gói mọi thủ tục nộp thuế siêu tốc","Sẵn sàng phương án quy trừ trực tiếp vào giá trị hợp đồng thanh toán"]},{"tag":"EV PRIVILEGE","title":"Đặc quyền sạc pin 1 năm","desc":"Miễn phí hoàn toàn chi phí sạc pin tại tất cả trạm sạc nhanh của hệ thống đại lý VinFast Việt Nam trong 12 tháng đầu tiên kể từ khi nhận xe điện.","bullets":["Áp dụng tại trạm sạc nhanh DC 180kW cao cấp nhất toàn quốc","Đặc quyền cung ứng sạc điện lưu động cứu hộ khẩn cấp 24/7","Giám sát dung lượng và chỉ đường trạm sạc thông minh qua ứng dụng"]},{"tag":"VINFAST ACCESSORIES","title":"Gói phụ kiện chính hãng","desc":"Tặng ngay bộ thảm sàn cao cấp thiết kế riêng, dù che nắng VinFast Collection, móc khóa da cao cấp cùng gói phủ Ceramic bảo vệ bề mặt sơn.","bullets":["Bộ thảm sàn chất liệu cao cấp thiết kế riêng chuẩn khí động học của xe","Gói phủ bảo vệ sơn ngoại thất Ceramic chuyên sâu tăng cứng bảo hành hãng","Bộ quà tặng thương hiệu VinFast Collection thời thượng đẳng cấp quốc tế"]},{"tag":"VINFAST CLUB VIP","title":"Thẻ thành viên VIP đặc quyền","desc":"Hòa mình vào cộng đồng VinFast EV Club, nhận ưu đãi giảm giá độc quyền tại các khách sạn 5 sao, khu resort cao cấp và sân golf hàng đầu.","bullets":["Thẻ đặc quyền kết nối cộng đồng chủ nhân xe VinFast thượng lưu toàn quốc","Ưu đãi giảm tới 25% các dịch vụ nghỉ dưỡng cao cấp, golf, ẩm thực","Thư mời tham dự đặc quyền mọi sự kiện giới thiệu dòng xe mới và âm nhạc"]}]',
                's9_dual_actions' => '[{"tag":"TRẢI NGHIỆM THỰC TẾ","title":"Đăng Ký Lái Thử Xe","desc":"Cảm nhận sức mạnh động cơ và sự tiện nghi sang trọng trực tiếp trên các cung đường cùng chuyên viên hỗ trợ của VinFast.","btn_text":"Đăng ký ngay","btn_href":"#catalog-block","bg_class":"action-tile__bg--test-drive","bg_image":""},{"tag":"CHĂM SÓC CHUYÊN NGHIỆP","title":"Đặt Lịch Hẹn Dịch Vụ","desc":"Bảo dưỡng định kỳ, kiểm tra sửa chữa chuyên sâu với đội ngũ kỹ sư được đào tạo chuyên sâu theo chuẩn VinFast toàn cầu.","btn_text":"Đặt lịch hẹn","btn_href":"admin.php?p=service","bg_class":"action-tile__bg--service","bg_image":""}]',
                'site_canonical' => '',
                'site_desc' => 'Chào mừng bạn đến với trang Website chính thức của VinFast tại Việt Nam. Khám phá các mẫu xe ô tô điện thông minh: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9.',
                'site_keywords' => 'vinfast, vinfast vietnam, xe dien vinfast, vf3, vf8, vf9',
                'site_title' => 'VinFast Việt Nam - Cổng thông tin chính thức',
                'sms_apikey' => 'VINFAST-MOCK-API-KEY-888999',
                'sms_gateway' => 'https://api.sms-vietnam.vn/v3/send',
                'spotlight_image' => 'assets/uploads/vinfast-banner-len-doi.webp',
                'vip_popup_cover_badge' => 'Đặc quyền VIP',
                'vip_popup_cover_desc' => 'Kiệt tác thiết kế thuần điện EV. Nhận gói đặc quyền ưu đãi chào hè trị giá tới 300 triệu đồng chính hãng.',
                'vip_popup_cover_image' => 'assets/uploads/vinfast-vf9-official.webp',
                'vip_popup_cover_title' => 'VinFast VF 9',
                'vip_popup_form_subtitle' => 'Để lại thông tin để chuyên viên VinFast liên hệ tư vấn dòng xe yêu thích cùng đặc quyền đăng ký lái thử VIP tại nhà riêng.',
                'vip_popup_form_tag' => 'Ưu đãi độc quyền 2026',
                'vip_popup_form_title' => 'Nhận Báo Giá & Ưu Đãi Đặc Biệt'
            ];
            
            $insSetting = $db->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?)");
            foreach ($defaultSettings as $k => $v) {
                $insSetting->execute([$k, $v]);
            }
        }

        // 5. Default News Posts
        $stmt = $db->prepare("SELECT COUNT(*) FROM posts");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $mockPosts = [
                [
                    'VinFast VF 3 Chính Thức Bàn Giao: Cơn Sốt Xe Điện Mini Quốc Dân',
                    'Mẫu xe S thuần điện đầu tiên của VinFast chính thức cập cảng Việt Nam, mở ra chuẩn mực hiệu suất thể thao đột phá cùng công nghệ sạc siêu tốc 270kW vượt bậc.',
                    '<h3>Thiết kế nhỏ gọn, cá tính và đậm chất đô thị</h3>
<p>Sau nhiều tháng chờ đợi, VinFast VF 3 - mẫu xe điện cỡ nhỏ thông minh chính thức lăn bánh trên đường phố Việt Nam, tạo nên một làn sóng mạnh mẽ trong cộng đồng yêu xe. Với chiều dài tổng thể chỉ khoảng 3.190 mm, VF 3 sở hữu thiết kế vuông vắn, cá tính và vô cùng năng động, hứa hẹn là lựa chọn lý tưởng cho giao thông đô thị đông đúc.</p>
<h3>Tầm hoạt động vượt trội cho nhu cầu di chuyển hàng ngày</h3>
<p>Mặc dù có kích thước nhỏ gọn, VinFast VF 3 được trang bị bộ pin LFP cho quãng đường di chuyển lên tới 210 km sau mỗi lần sạc đầy (theo tiêu chuẩn CLTC). Xe hỗ trợ sạc nhanh DC, cho phép sạc từ 10% đến 70% chỉ trong vòng 36 phút, giúp người dùng hoàn toàn an tâm khi di chuyển trong phố hay các chuyến dã ngoại ngắn ngày.</p>
<h3>Khoang cabin tối giản và tiện nghi công nghệ</h3>
<p>Nội thất VF 3 được thiết kế tối giản nhưng tích hợp đầy đủ công nghệ hiện đại. Điểm nhấn là màn hình cảm ứng trung tâm 10 inch sắc nét, hỗ trợ kết nối thông minh và hệ thống điều hòa mát sâu. Không gian nội thất 4 chỗ ngồi rộng rãi hơn mong đợi nhờ cách tối ưu hóa cabin thông minh từ các kỹ sư VinFast Việt Nam.</p>',
                    'assets/uploads/vinfast-vf3.webp',
                    'vinfast-vf3-chinh-thuc-ban-giao-con-sot-xe-dien-mini'
                ],
                [
                    'Mẹo Tối Ưu Tầm Hoạt Động Pin Cho Xe Điện VinFast Trong Mùa Hè',
                    'Bí quyết sử dụng hệ thống điều hòa khí hậu thông minh, chế độ lái Efficiency và tận dụng tối đa hệ thống phanh tái sinh năng lượng để đi xa hơn mỗi lần sạc.',
                    '<h3>Hiểu Đúng Về Tác Động Của Nhiệt Độ Đến Khối Pin</h3>
<p>Mùa hè nắng nóng oi bức tại Việt Nam với nền nhiệt độ ngoài trời thường xuyên vượt ngưỡng 38°C là thử thách không nhỏ cho mọi dòng xe điện. Đối với dòng xe thuần điện cao cấp VinFast, nhiệt độ cao không chỉ đòi hỏi hệ thống điều hòa cabin làm việc vất vả hơn mà còn kích hoạt hệ thống làm mát cưỡng bức cho khối pin để đảm bảo nhiệt độ an toàn. Hãy cùng bỏ túi 4 mẹo cực kỳ đơn giản giúp tối ưu hóa điện năng và đi xa hơn sau mỗi lần sạc.</p>
<h3>4 Bí Quyết Vàng Tối Ưu Quãng Đường Di Chuyển</h3>
<ol>
  <li><strong>Kích hoạt tính năng Làm mát cabin trước (Pre-conditioning):</strong> Sử dụng ứng dụng myVinFast để hẹn giờ bật điều hòa làm mát cabin ngay khi xe vẫn đang cắm sạc tại nhà. Việc này sử dụng trực tiếp nguồn điện lưới thay vì rút năng lượng từ khối pin của xe khi bắt đầu di chuyển.</li>
  <li><strong>Sử dụng chế độ lái Efficiency:</strong> Chuyển đổi chế độ lái sang "Efficiency" thông qua màn hình điều khiển trung tâm của xe. Hệ thống sẽ tối ưu hóa phản ứng chân ga mượt mà hơn và điều chỉnh công suất làm lạnh điều hòa thông minh để tiết kiệm tối đa điện năng.</li>
  <li><strong>Tận dụng triệt để Phanh tái sinh năng lượng (Recuperation):</strong> Sử dụng các mức độ phanh tái sinh năng lượng trên màn hình điều khiển. Khi giảm tốc hoặc xuống dốc, động cơ điện hoạt động như máy phát giúp sạc ngược dòng điện vào khối pin một cách tự nhiên.</li>
  <li><strong>Đậu xe dưới bóng râm và sử dụng tấm che nắng:</strong> Đậu xe trực tiếp dưới nắng nóng khiến khoang cabin tích tụ nhiệt rất cao, buộc điều hòa phải chạy hết công suất khi khởi hành. Đậu xe nơi mát mẻ sẽ giúp duy trì nhiệt độ khối pin ổn định, tiết kiệm đáng kể năng lượng.</li>
</ol>
<h3>An Tâm Với Hệ Thống Giám Sát Pin Tự Động</h3>
<p>Chủ sở hữu xe điện VinFast hoàn toàn có thể an tâm tuyệt đối vì xe tích hợp hệ thống quản lý pin thông minh BMS (Battery Management System). BMS sẽ tự động theo dõi, bảo vệ dòng điện và điều chỉnh hệ thống làm mát bằng dung dịch khép kín quanh khối pin 24/7, loại bỏ hoàn toàn nguy cơ quá nhiệt hay chai pin dưới thời tiết nắng nóng khắc nghiệt.</p>',
                    'assets/uploads/vinfast-vf5.webp',
                    'meo-toi-uu-tam-hoat-dong-pin-xe-dien-vinfast-trong-mua-he'
                ],
                [
                    'Tuyển dụng Đại diện Kinh doanh Xe Điện VinFast Premium Consultant',
                    'VinFast Việt Nam thông báo tuyển dụng nhân sự cao cấp cho chi nhánh phân phối xe sang chính hãng, cơ hội đào tạo và thu nhập hấp dẫn bậc nhất thị trường.',
                    '<h3>Gia nhập thương hiệu xe điện tiên phong toàn cầu</h3>
<p>Trở thành một phần của thương hiệu ô tô Việt Nam đang vươn tầm thế giới. VinFast Việt Nam đang tìm kiếm các ứng viên năng động, đam mê công nghệ xe điện để gia nhập đội ngũ Đại diện Tư vấn Bán hàng Xe điện chính hãng tại các chi nhánh Hà Nội, Đà Nẵng và Tp. Hồ Chí Minh.</p>
<h3>Mô tả công việc & Trách nhiệm chính</h3>
<ul>
  <li>Tư vấn, giới thiệu chi tiết các mẫu xe điện thông minh đột phá (VinFast VF 3, VF 5 Plus, VF 6, VF 7, VF 8, VF 9).</li>
  <li>Hỗ trợ khách hàng trải nghiệm dịch vụ lái thử xe điện tại nhà (Home Test Drive) và chuẩn hóa quy trình giao xe cá nhân chuẩn 5 sao.</li>
  <li>Thiết lập mối quan hệ bền vững với khách hàng, tư vấn dịch vụ pin và hệ thống trạm sạc phủ khắp 63 tỉnh thành.</li>
  <li>Tư vấn các gói tài chính trả góp, định giá thu cũ đổi mới (VinFast U-Car) trọn gói.</li>
</ul>
<h3>Yêu cầu ứng viên</h3>
<ul>
  <li>Có kinh nghiệm tối thiểu 1 năm trong lĩnh vực ô tô, bất động sản, tài chính hoặc các sản phẩm công nghệ cao cấp.</li>
  <li>Kỹ năng giao tiếp xuất sắc, ngoại hình lịch thiệp, phong cách phục vụ chu đáo, tận tâm.</li>
  <li>Có khả năng sử dụng các ứng dụng số hóa tốt và am hiểu về xu hướng sống xanh.</li>
  <li>Có giấy phép lái xe hạng B2 là một lợi thế bắt buộc.</li>
</ul>',
                    'assets/uploads/vinfast-vf9-official.webp',
                    'tuyen-dung-dai-dien-kinh-doanh-xe-dien-vinfast'
                ]
            ];

            $stmt = $db->prepare("INSERT INTO posts (title, summary, content, image, slug) VALUES (?, ?, ?, ?, ?)");
            foreach ($mockPosts as $p) {
                $stmt->execute($p);
            }
        }

        // 6. Default Cars (all 14 official VinFast Vietnam models)
        $defaultCars = [
            [
                'VinFast VF 2',
                'SUV mini đô thị',
                'Động cơ điện (Hậu động)',
                '41 mã lực (30 kW)',
                '65 Nm',
                '19.5 giây',
                '80 km/h',
                'Lên đến 210 km (NEDC)',
                '188.000.000 VNĐ (Đã gồm pin)',
                'assets/uploads/vinfast-vf2.jpg',
                'Vàng Brahminy|#ffd200,Trắng Glacier|#ffffff,Hồng phấn|#ffc0cb,Xanh dương|#00aaff',
                'Mẫu ô tô điện cỡ nhỏ 2 cửa – 4 chỗ ngồi linh hoạt, giải pháp di chuyển an toàn, tiết kiệm thay thế xe máy truyền thống cho đô thị Việt.',
                '',
                'Nhận đặt cọc',
                10
            ],
            [
                'VinFast VF 3',
                'SUV mini đô thị',
                'Động cơ điện (Hậu động)',
                '43 mã lực',
                '110 Nm',
                '19.3 giây',
                '100 km/h',
                'Lên đến 210 km (CLTC)',
                'Từ 240.000.000 VNĐ (Thuê pin) / 322.000.000 VNĐ (Mua pin)',
                'assets/uploads/vinfast-vf3.jpg',
                'Vàng sáng|#ffd200,Trắng Glacier|#ffffff,Hồng phấn|#ffc0cb,Xanh lá|#00ff00',
                'Mẫu xe ô tô điện mini quốc dân, nhỏ gọn, cá tính, thời thượng và di chuyển cực kỳ linh hoạt.',
                '',
                'Còn hàng',
                15
            ],
            [
                'VinFast VF 5',
                'SUV cỡ A',
                'Động cơ điện đơn (FWD)',
                '134 mã lực',
                '135 Nm',
                '9.0 giây',
                '130 km/h',
                'Lên đến 326 km (NEDC)',
                'Từ 468.000.000 VNĐ (Thuê pin) / 548.000.000 VNĐ (Mua pin)',
                'assets/uploads/vinfast-vf5.webp',
                'Đỏ Crimson|#b22222,Trắng Glacier|#ffffff,Xanh dương|#00aaff,Xám Neptune|#808080',
                'Lựa chọn SUV đô thị tối ưu cho gia đình trẻ với chi phí sử dụng tiết kiệm vượt trội.',
                '',
                'Còn hàng',
                8
            ],
            [
                'VinFast VF 6',
                'SUV cỡ B',
                'Động cơ điện đơn (FWD)',
                '174 mã lực',
                '250 Nm',
                '8.5 giây',
                '150 km/h',
                'Lên đến 399 km (WLTP)',
                'Từ 675.000.000 VNĐ (Thuê pin) / 765.000.000 VNĐ (Mua pin)',
                'assets/uploads/vinfast-vf6.webp',
                'Đỏ Crimson|#b22222,Trắng Glacier|#ffffff,Xanh dương|#00aaff,Xám Neptune|#808080',
                'Kiểu dáng thời trang, nội thất rộng rãi và khả năng vận hành êm ái hàng đầu phân khúc B.',
                '',
                'Còn hàng',
                5
            ],
            [
                'VinFast VF MPV 7',
                'MPV 7 chỗ gia đình',
                'Động cơ điện đơn (FWD)',
                '201 mã lực',
                '310 Nm',
                '8.0 giây',
                '160 km/h',
                'Lên đến 400 km (NEDC)',
                'Từ 730.000.000 VNĐ (Thuê pin) / 820.000.000 VNĐ (Mua pin)',
                'assets/uploads/vinfast-vf-mpv7.jpg',
                'Trắng Glacier|#ffffff,Xám Neptune|#808080,Đen mờ|#1a1a1a,Xanh Deep Ocean|#0b3f2e',
                'Mẫu xe gia đình 7 chỗ rộng rãi, tiện nghi, cấu hình 3 hàng ghế linh hoạt, giải pháp tối ưu cho gia đình đa thế hệ.',
                '',
                'Còn hàng',
                6
            ],
            [
                'VinFast VF 7',
                'SUV cỡ C',
                'Động cơ điện đôi (AWD)',
                '349 mã lực',
                '500 Nm',
                '5.8 giây',
                '175 km/h',
                'Lên đến 431 km (WLTP)',
                'Từ 850.000.000 VNĐ (Thuê pin) / 999.000.000 VNĐ (Mua pin)',
                'assets/uploads/vinfast-vf7.webp',
                'Trắng Glacier|#ffffff,Xám Neptune|#808080,Đỏ Crimson|#b22222,Xanh Deep Ocean|#0b3f2e',
                'Thiết kế đột phá từ Torino Design, hiệu suất thể thao mạnh mẽ và ngập tràn công nghệ thông minh.',
                '',
                'Còn hàng',
                7
            ],
            [
                'VinFast VF 8',
                'SUV cỡ D',
                'Động cơ điện đôi (AWD)',
                '348 mã lực',
                '500 Nm',
                '5.9 giây',
                '200 km/h',
                'Lên đến 471 km (WLTP)',
                'Từ 1.090.000.000 VNĐ (Thuê pin) / 1.290.000.000 VNĐ (Mua pin)',
                'assets/uploads/vinfast-vf8.webp',
                'Trắng Glacier|#ffffff,Xám Neptune|#808080,Xanh dương|#00aaff,Đen mờ|#1a1a1a',
                'Mẫu SUV cỡ trung hạng sang toàn cầu, sự cân bằng hoàn hảo giữa sang trọng, công nghệ và hiệu năng.',
                '',
                'Còn hàng',
                9
            ],
            [
                'VinFast VF 8 The All New',
                'SUV cỡ D cao cấp',
                'Động cơ điện đôi thế hệ mới (AWD)',
                '402 mã lực',
                '620 Nm',
                '5.3 giây',
                '210 km/h',
                'Lên đến 500 km (WLTP)',
                'Từ 1.150.000.000 VNĐ (Thuê pin) / 1.350.000.000 VNĐ (Mua pin)',
                'assets/uploads/vinfast-vf8-allnew.jpg',
                'Trắng Glacier|#ffffff,Xám Neptune|#808080,Xanh dương|#00aaff,Đen Jet Black|#0a0a0a',
                'Phiên bản nâng cấp toàn diện của dòng SUV D-segment, thiết kế khí động học mới, tăng tốc vượt trội và công nghệ lái thông minh ADAS cấp độ cao.',
                '',
                'Mới ra mắt',
                4
            ],
            [
                'VinFast VF 9',
                'SUV cỡ E',
                'Động cơ điện đôi (AWD)',
                '402 mã lực',
                '620 Nm',
                '6.5 giây',
                '200 km/h',
                'Lên đến 626 km (WLTP)',
                'Từ 1.491.000.000 VNĐ (Thuê pin) / 2.110.000.000 VNĐ (Mua pin)',
                'assets/uploads/vinfast-vf9.webp',
                'Trắng Glacier|#ffffff,Xám Neptune|#808080,Xanh Deep Ocean|#0b3f2e,Đen mờ|#1a1a1a',
                'SUV điện hạng sang đầu bảng, 3 hàng ghế rộng rãi đẳng cấp phi cơ mặt đất cùng các trang bị xa xỉ.',
                '',
                'Còn hàng',
                5
            ],
            [
                'Minio Green',
                'Xe dịch vụ | Minio Green',
                'Động cơ điện (Hậu động)',
                '43 mã lực',
                '110 Nm',
                '19.3 giây',
                '100 km/h',
                'Lên đến 210 km (CLTC)',
                'Từ 240.000.000 VNĐ',
                'assets/uploads/vinfast-vf3.jpg',
                'Xanh lục Cyan|#00ffcc,Trắng Glacier|#ffffff',
                'Dòng xe taxi mini chuyên dụng di chuyển linh hoạt, tối ưu chi phí vận hành cho đô thị xanh.',
                '',
                'Còn hàng',
                20
            ],
            [
                'Herio Green',
                'Xe dịch vụ | Herio Green',
                'Động cơ điện đơn (FWD)',
                '134 mã lực',
                '135 Nm',
                '9.0 giây',
                '130 km/h',
                'Lên đến 326 km (NEDC)',
                'Từ 468.000.000 VNĐ',
                'assets/uploads/vinfast-vf5.jpg',
                'Xanh lục Cyan|#00ffcc,Trắng Glacier|#ffffff',
                'Mẫu xe taxi đô thị cỡ A rộng rãi, bền bỉ, được tin dùng bởi các hãng xe công nghệ hàng đầu.',
                '',
                'Còn hàng',
                15
            ],
            [
                'Nerio Green',
                'Xe dịch vụ | Nerio Green',
                'Động cơ điện đơn (FWD)',
                '174 mã lực',
                '250 Nm',
                '8.5 giây',
                '150 km/h',
                'Lên đến 399 km (WLTP)',
                'Từ 675.000.000 VNĐ',
                'assets/uploads/vinfast-vf6.jpg',
                'Xanh lục Cyan|#00ffcc,Trắng Glacier|#ffffff',
                'Mẫu SUV hạng B dịch vụ cao cấp, nâng tầm trải nghiệm di chuyển của hành khách.',
                '',
                'Còn hàng',
                12
            ],
            [
                'Limo Green',
                'Xe dịch vụ | Limo Green',
                'Động cơ điện đôi (AWD)',
                '348 mã lực',
                '500 Nm',
                '5.9 giây',
                '200 km/h',
                'Lên đến 471 km (WLTP)',
                'Từ 1.090.000.000 VNĐ',
                'assets/uploads/vinfast-vf-mpv7.jpg',
                'Xanh lục Cyan|#00ffcc,Trắng Glacier|#ffffff',
                'Chuyên cơ dịch vụ 7 chỗ VIP đưa đón đối tác, doanh nhân và khách du lịch hạng sang.',
                '',
                'Còn hàng',
                10
            ],
            [
                'EC Van',
                'Xe dịch vụ | EC Van',
                'Động cơ điện đơn (FWD)',
                '134 mã lực',
                '135 Nm',
                '9.5 giây',
                '120 km/h',
                'Lên đến 250 km (NEDC)',
                'Từ 490.000.000 VNĐ',
                'assets/uploads/vinfast-vf5.jpg',
                'Trắng Glacier|#ffffff,Xám Neptune|#808080',
                'Xe tải van thuần điện chở hàng hóa thông minh, lưu thông 24/7 không lo cấm tải đô thị.',
                '',
                'Còn hàng',
                8
            ]
        ];

        foreach ($defaultCars as $car) {
            $modelName = $car[0];
            $stmt = $db->prepare("SELECT COUNT(*) FROM cars WHERE model_name = ?");
            $stmt->execute([$modelName]);
            if ($stmt->fetchColumn() == 0) {
                $ins = $db->prepare("INSERT INTO cars (model_name, segment, engine, power, torque, acceleration, top_speed, range_wltp, price, image, exterior_colors, description, video_url, stock_status, stock_qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $ins->execute($car);
            }
        }

        // 7. Default Customers, Purchase History & Care Logs
        $stmt = $db->prepare("SELECT COUNT(*) FROM customers");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $db->exec("INSERT INTO customers (id, fullname, phone, email, classification) VALUES 
                (1, 'Phan Văn Trị', '0912345678', 'phantri@gmail.com', 'VIP'),
                (2, 'Trần Minh Hoàng', '0987654321', 'hoangtm@yahoo.com', 'Tiềm năng'),
                (3, 'Đặng Thị Thu', '0905556667', 'thudang@gmail.com', 'Đã mua xe'),
                (4, 'Nguyễn Bảo Lâm', '0933445566', 'lamnb@outlook.com', 'Thành viên')
            ");

            $db->exec("INSERT INTO customer_cars (customer_id, car_model, purchase_date, license_plate, price) VALUES 
                (1, 'VinFast VF 9 Plus', '2025-12-15', '30A-999.99', 'Từ 1.560.000.000 VNĐ'),
                (3, 'VinFast VF 8 Plus', '2026-02-10', '51K-777.77', 'Từ 1.090.000.000 VNĐ')
            ");

            $db->exec("INSERT INTO customer_care_logs (customer_id, sale_id, notes) VALUES 
                (1, 2, 'Gọi điện chúc mừng sinh nhật VIP, gửi tặng voucher nghỉ dưỡng 20 triệu.'),
                (2, 2, 'Khách thích VinFast VF 6 màu xanh lục nhưng đại lý chưa có sẵn. Đang chờ xe về để liên hệ lại.'),
                (3, 3, 'Hướng dẫn khách hàng cài đặt ứng dụng VinFast App để theo dõi lịch trình bảo dưỡng.')
            ");
        }

        // 8. Service Appointments
        $stmt = $db->prepare("SELECT COUNT(*) FROM service_appointments");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $db->exec("INSERT INTO service_appointments (fullname, phone, email, license_plate, car_model, appointment_date, service_type, assigned_tech_id, status, notes) VALUES 
                ('Phan Văn Trị', '0912345678', 'phantri@gmail.com', '30A-999.99', 'VinFast VF 9 Plus', '2026-05-28 09:30:00', 'Bảo dưỡng định kỳ', 4, 'Đang sửa chữa', 'Kiểm tra hệ thống pin lithium-ion và phanh đĩa thể thao.'),
                ('Đặng Thị Thu', '0905556667', 'thudang@gmail.com', '51K-777.77', 'VinFast VF 8 Plus', '2026-05-27 14:00:00', 'Sửa chữa', 4, 'Chờ tiếp nhận', 'Khách báo vô lăng hơi rung nhẹ khi chạy ở vận tốc trên 80km/h.'),
                ('Nguyễn Thế Anh', '0977889900', 'theanh@gmail.com', '29B-555.55', 'VinFast VF 7 Plus', '2026-05-25 10:00:00', 'Đồng sơn', 5, 'Đã hoàn thành', 'Sơn lại cản trước và đánh bóng toàn bộ thân xe.')
            ");
        }

        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 2: PERFORMANCE INDEXES ---
    $step = '002_performance_indexes';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        if ($driver === 'sqlite') {
            executeSqlSafely($db, "CREATE INDEX IF NOT EXISTS idx_leads_car_status ON leads(car_id, status);");
            executeSqlSafely($db, "CREATE INDEX IF NOT EXISTS idx_activity_logs_created ON activity_logs(created_at);");
            executeSqlSafely($db, "CREATE INDEX IF NOT EXISTS idx_service_appointments_status ON service_appointments(status);");
        } else {
            executeSqlSafely($db, "CREATE INDEX idx_leads_car_status ON leads(car_id, status);");
            executeSqlSafely($db, "CREATE INDEX idx_activity_logs_created ON activity_logs(created_at);");
            executeSqlSafely($db, "CREATE INDEX idx_service_appointments_status ON service_appointments(status);");
        }
        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 8: SWITCH TO VINFAST EV ---
    $step = '008_switch_to_vinfast_ev';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        // Clear old cars
        $db->exec("DELETE FROM cars;");
        
        // Seed VinFast EV cars
        $vinfastCars = [
            [
                'VinFast VF 2', 'SUV mini đô thị', 'Động cơ điện (RWD)', '40 mã lực (30 kW)', '65 Nm', '18.0 giây', '80 km/h', 'Lên đến 210 km (NEDC)', 'Từ 188.000.000 VNĐ (Đã kèm pin)', 'assets/uploads/vinfast-vf2.png', 'Vàng sáng|#ffd200,Trắng Glacier|#ffffff,Hồng phấn|#ffc0cb,Xanh lá|#00ff00', 'Mẫu xe ô tô điện 2 cửa siêu tiết kiệm, thay thế xe máy đô thị tối ưu.', 'https://www.youtube.com/embed/jZ_y-oWwGhk', 'Còn hàng', 20
            ],
            [
                'VinFast VF 3', 'SUV mini đô thị', 'Động cơ điện (Hậu động)', '43 mã lực', '110 Nm', '19.3 giây', '100 km/h', 'Lên đến 210 km (CLTC)', 'Từ 240.000.000 VNĐ (Thuê pin) / 322.000.000 VNĐ (Mua pin)', 'assets/uploads/vinfast-vf3.webp', 'Vàng sáng|#ffd200,Trắng Glacier|#ffffff,Hồng phấn|#ffc0cb,Xanh lá|#00ff00', 'Mẫu xe ô tô điện mini quốc dân, nhỏ gọn, cá tính, thời thượng và di chuyển cực kỳ linh hoạt.', 'https://www.youtube.com/embed/jZ_y-oWwGhk', 'Còn hàng', 15
            ],
            [
                'VinFast VF 5 Plus', 'SUV cỡ A', 'Động cơ điện đơn (FWD)', '134 mã lực', '135 Nm', '9.0 giây', '130 km/h', 'Lên đến 326 km (NEDC)', 'Từ 468.000.000 VNĐ (Thuê pin) / 548.000.000 VNĐ (Mua pin)', 'assets/uploads/vinfast-vf5.webp', 'Trắng Glacier|#ffffff,Đen Mythos|#121212,Xanh dương|#1960d7,Đỏ Tango|#ac0a11', 'Lựa chọn SUV đô thị tối ưu cho gia đình trẻ với chi phí sử dụng tiết kiệm vượt trội.', 'https://www.youtube.com/embed/Vl9F11c6k2g', 'Còn hàng', 12
            ],
            [
                'VinFast VF e34', 'SUV cỡ C', 'Động cơ điện đơn (FWD)', '147 mã lực', '242 Nm', '9.0 giây', '130 km/h', 'Lên đến 285 km (NEDC)', 'Từ 710.000.000 VNĐ (Thuê pin) / 830.000.000 VNĐ (Mua pin)', 'assets/uploads/vinfast-vfe34.png', 'Xanh dương|#1960d7,Trắng Glacier|#ffffff,Đen Mythos|#121212,Đỏ Tango|#ac0a11', 'Mẫu xe C-SUV điện thông minh đầu tiên tại Việt Nam, mở đầu xu hướng di chuyển xanh với công nghệ vượt trội.', 'https://www.youtube.com/embed/HqD2l4JpCsk', 'Còn hàng', 10
            ],
            [
                'VinFast VF 6', 'SUV cỡ B', 'Động cơ điện đơn (FWD)', '174 mã lực', '250 Nm', '8.5 giây', '150 km/h', 'Lên đến 399 km (WLTP)', 'Từ 675.000.000 VNĐ (Thuê pin) / 765.000.000 VNĐ (Mua pin)', 'assets/uploads/vinfast-vf6.webp', 'Trắng Glacier|#ffffff,Đen Mythos|#121212,Xanh dương|#1960d7,Đỏ Tango|#ac0a11', 'Kiểu dáng thời trang, nội thất rộng rãi và khả năng vận hành êm ái hàng đầu phân khúc B.', 'https://www.youtube.com/embed/sU1t90wT1J0', 'Đặt trước', 8
            ],
            [
                'VinFast VF MPV 7', 'MPV 7 chỗ gia đình', 'Động cơ điện đơn (FWD)', '201 mã lực (150 kW)', '280 Nm', '8.5 giây', '150 km/h', 'Lên đến 400 km (NEDC)', 'Từ 819.000.000 VNĐ', 'assets/uploads/vinfast-vf-mpv7.png', 'Trắng Glacier|#ffffff,Đen Mythos|#121212,Xám Daytona|#4a4e52,Đỏ Tango|#ac0a11', 'Mẫu xe điện MPV 7 chỗ thông minh dành cho cả gia đình.', 'https://www.youtube.com/embed/1T9vYwL526E', 'Còn hàng', 8
            ],
            [
                'VinFast VF 7', 'SUV cỡ C', 'Động cơ điện đơn/đôi (AWD)', '349 mã lực', '500 Nm', '5.8 giây', '175 km/h', 'Lên đến 431 km (WLTP)', 'Từ 850.000.000 VNĐ (Thuê pin) / 999.000.000 VNĐ (Mua pin)', 'assets/uploads/vinfast-vf7.webp', 'Trắng Glacier|#ffffff,Đen Mythos|#121212,Xám Daytona|#4a4e52,Đỏ Tango|#ac0a11', 'SUV điện thể thao phong cách tương lai, hiệu năng mạnh mẽ đầy phấn khích.', 'https://www.youtube.com/embed/xP0t16p-csk', 'Còn hàng', 5
            ],
            [
                'VinFast VF 8', 'SUV cỡ D', 'Động cơ điện đôi (AWD)', '402 mã lực', '620 Nm', '5.5 giây', '200 km/h', 'Lên đến 425 km (WLTP)', 'Từ 1.090.000.000 VNĐ (Thuê pin) / 1.290.000.000 VNĐ (Mua pin)', 'assets/uploads/vinfast-vf8.webp', 'Trắng Glacier|#ffffff,Đen Mythos|#121212,Xanh dương|#1960d7,Đỏ Tango|#ac0a11', 'Mẫu SUV điện thông minh toàn cầu, tích hợp hệ thống trợ lái nâng cao ADAS chuyên sâu.', 'https://www.youtube.com/embed/VvD71a-jJBg', 'Đặt trước', 6
            ],
            [
                'VinFast VF 8 The New', 'SUV cỡ D thế hệ mới', 'Động cơ điện đôi (AWD)', '402 mã lực', '620 Nm', '5.4 giây', '200 km/h', 'Lên đến 450 km (WLTP)', 'Từ 999.000.000 VNĐ', 'assets/uploads/vinfast-vf8-allnew.png', 'Trắng Glacier|#ffffff,Đen Mythos|#121212,Xanh dương|#1960d7,Đỏ Tango|#ac0a11', 'Phiên bản nâng cấp All New của VF 8 với cách âm vượt trội và hỗ trợ sạc Qi2.', 'https://www.youtube.com/embed/VvD71a-jJBg', 'Đặt trước', 5
            ],
            [
                'VinFast VF 9', 'SUV cỡ E hạng sang', 'Động cơ điện đôi (AWD)', '402 mã lực', '620 Nm', '6.5 giây', '200 km/h', 'Lên đến 626 km (WLTP)', 'Từ 1.560.000.000 VNĐ (Thuê pin) / 2.110.000.000 VNĐ (Mua pin)', 'assets/uploads/vinfast-vf9.webp', 'Trắng Glacier|#ffffff,Đen Mythos|#121212,Bạc Floret|#dcdfe3,Xám Vesuvius|#3a3e42', 'Tuyệt phẩm SUV siêu sang 7 chỗ dành cho giới chủ chủ tịch, cabin rộng rãi tối đa.', 'https://www.youtube.com/embed/1T9vYwL526E', 'Còn hàng', 4
            ],
            [
                'VinFast Minio Green', 'Xe dịch vụ cỡ nhỏ', 'Động cơ điện (RWD)', '27 mã lực (20 kW)', '65 Nm', '19.5 giây', '80 km/h', 'Lên đến 170 km (NEDC)', 'Từ 188.000.000 VNĐ (Kèm ưu đãi sạc)', 'assets/uploads/minio-green.webp', 'Xanh lục GSM|#005d63,Trắng|#ffffff', 'Dòng xe dịch vụ đô thị siêu nhỏ gọn, tối ưu chi phí vận chuyển.', 'https://www.youtube.com/embed/jZ_y-oWwGhk', 'Còn hàng', 15
            ],
            [
                'VinFast Herio Green', 'A-SUV Dịch vụ', 'Động cơ điện đơn (FWD)', '134 mã lực', '135 Nm', '9.0 giây', '130 km/h', 'Lên đến 326 km (NEDC)', 'Liên hệ lô doanh nghiệp', 'assets/uploads/herio-green.png', 'Xanh lục GSM|#005d63', 'Mẫu xe dịch vụ A-SUV bền bỉ, tiết kiệm năng lượng tối ưu cho đối tác taxi.', 'https://www.youtube.com/embed/Vl9F11c6k2g', 'Còn hàng', 30
            ],
            [
                'VinFast Nerio Green', 'C-SUV Dịch vụ', 'Động cơ điện đơn (FWD)', '147 mã lực', '242 Nm', '9.0 giây', '130 km/h', 'Lên đến 318 km (NEDC)', 'Liên hệ lô doanh nghiệp', 'assets/uploads/nerio-green.webp', 'Xanh lục GSM|#005d63', 'Dòng xe dịch vụ C-SUV rộng rãi, êm ái, mang lại trải nghiệm VIP cho khách hàng.', 'https://www.youtube.com/embed/HqD2l4JpCsk', 'Còn hàng', 25
            ],
            [
                'VinFast Limo Green', 'MPV 7 chỗ Dịch vụ', 'Động cơ điện đơn (FWD)', '201 mã lực (150 kW)', '280 Nm', '8.8 giây', '150 km/h', 'Lên đến 450 km (NEDC)', 'Liên hệ lô doanh nghiệp', 'assets/uploads/limo-green.png', 'Xanh lục GSM|#005d63', 'Mẫu xe MPV 7 chỗ phục vụ dịch vụ chuyên nghiệp, vận tải hành khách cao cấp.', 'https://www.youtube.com/embed/1T9vYwL526E', 'Còn hàng', 15
            ],
            [
                'VinFast EC Van', 'Xe tải van điện', 'Động cơ điện đơn (FWD)', '80 mã lực', '190 Nm', '12.0 giây', '100 km/h', 'Lên đến 200 km (NEDC)', 'Từ 420.000.000 VNĐ', 'assets/uploads/ec-van.png', 'Trắng|#ffffff,Bạc|#dcdfe3', 'Dòng xe tải van điện vận chuyển hàng hóa đô thị 24/7 không lo cấm giờ.', 'https://www.youtube.com/embed/HqD2l4JpCsk', 'Còn hàng', 8
            ],
            [
                'VinFast EBus', 'Xe buýt điện', 'Động cơ điện lớn', '350 mã lực', '1200 Nm', 'N/A', '80 km/h', 'Lên đến 250 km', 'Liên hệ gói dự án', 'assets/uploads/ebus.png', 'Xanh lá/Đen|#008000', 'Xe buýt điện thông minh VinFast EBus, tương lai giao thông công cộng xanh.', 'https://www.youtube.com/embed/HqD2l4JpCsk', 'Còn hàng', 5
            ]
        ];

        $ins = $db->prepare("INSERT INTO cars (model_name, segment, engine, power, torque, acceleration, top_speed, range_wltp, price, image, exterior_colors, description, video_url, stock_status, stock_qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($vinfastCars as $car) {
            $ins->execute($car);
        }

        // Update default settings to VinFast branding
        $db->exec("UPDATE settings SET value = 'VinFast Việt Nam - Cổng thông tin chính thức' WHERE `key` = 'site_title';");
        $db->exec("UPDATE settings SET value = 'Chào mừng bạn đến với trang Website chính thức của VinFast tại Việt Nam. Khám phá các mẫu xe ô tô điện thông minh: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9.' WHERE `key` = 'site_desc';");
        $db->exec("UPDATE settings SET value = 'vinfast, vinfast vietnam, xe dien vinfast, vf3, vf8, vf9' WHERE `key` = 'site_keywords';");
        $db->exec("UPDATE settings SET value = 'VinFast Việt Nam - Chi nhánh Tp. Hồ Chí Minh' WHERE `key` = 'agency_name';");
        $db->exec("UPDATE settings SET value = 'VinFast Việt Nam giới thiệu các dòng xe điện thông minh mới - Mở ra kỷ nguyên di chuyển xanh và bền vững.' WHERE `key` = 's6_headline';");
        $db->exec("UPDATE settings SET value = '<p>VinFast khẳng định định hướng phát triển bền vững với dải sản phẩm xe điện thông minh 100%, bảo hành 10 năm cao nhất thị trường.</p>' WHERE `key` = 's6_desc';");
        $db->exec("UPDATE settings SET value = 'Giới thiệu VinFast Việt Nam' WHERE `key` = 'about_title';");
        $db->exec("UPDATE settings SET value = 'Mãnh liệt tinh thần Việt Nam - Tầm nhìn toàn cầu' WHERE `key` = 'about_intro_headline';");
        $db->exec("UPDATE settings SET value = 'Bảng giá xe VinFast mới nhất tại Việt Nam' WHERE `key` = 'pricelist_intro_headline';");
        $db->exec("UPDATE settings SET value = 'Cập nhật bảng giá niêm yết chính hãng toàn bộ các dòng xe điện thông minh VinFast mới nhất tại thị trường Việt Nam.' WHERE `key` = 'pricelist_intro_desc';");
        $db->exec("UPDATE settings SET value = 'Đặc quyền thuê pin & Mạng lưới 150.000 cổng sạc toàn quốc' WHERE `key` = 'about_intro_text';");

        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 9: ADD MISSING CARS COLUMNS AND PERFORMANCE INDEXES ---
    $step = '009_add_missing_cars_columns_and_indexes';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        
        if ($driver === 'mysql') {
            // Add missing details columns to cars table safely
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN slug VARCHAR(191) DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN brochure_url TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN core_features TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN tech_highlights TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN owner_benefits TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN image_exterior TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN image_interior TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN image_engine TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN image_specs TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN focus_keyword VARCHAR(255) DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN seo_title VARCHAR(255) DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN seo_desc TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN seo_canonical VARCHAR(255) DEFAULT NULL;");
            
            // Add performance indexes
            executeSqlSafely($db, "CREATE INDEX idx_cars_slug ON cars(slug);");
            executeSqlSafely($db, "CREATE INDEX idx_posts_slug ON posts(slug);");
            executeSqlSafely($db, "CREATE INDEX idx_leads_phone ON leads(phone);");
            executeSqlSafely($db, "CREATE INDEX idx_leads_created ON leads(created_at);");
        } else {
            // SQLite column additions (must be added individually)
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN slug TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN brochure_url TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN core_features TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN tech_highlights TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN owner_benefits TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN image_exterior TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN image_interior TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN image_engine TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN image_specs TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN focus_keyword TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN seo_title TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN seo_desc TEXT DEFAULT NULL;");
            executeSqlSafely($db, "ALTER TABLE cars ADD COLUMN seo_canonical TEXT DEFAULT NULL;");
            
            // Add performance indexes for SQLite
            executeSqlSafely($db, "CREATE INDEX IF NOT EXISTS idx_cars_slug ON cars(slug);");
            executeSqlSafely($db, "CREATE INDEX IF NOT EXISTS idx_posts_slug ON posts(slug);");
            executeSqlSafely($db, "CREATE INDEX IF NOT EXISTS idx_leads_phone ON leads(phone);");
            executeSqlSafely($db, "CREATE INDEX IF NOT EXISTS idx_leads_created ON leads(created_at);");
        }

        // Retroactively generate missing car slugs based on model_name
        try {
            $stmt = $db->query("SELECT id, model_name FROM cars WHERE slug IS NULL OR slug = ''");
            $carsToUpdate = $stmt->fetchAll();
            $updateStmt = $db->prepare("UPDATE cars SET slug = ? WHERE id = ?");
            foreach ($carsToUpdate as $carRow) {
                $slugStr = mb_strtolower($carRow['model_name'], 'UTF-8');
                $slugStr = preg_replace('/(á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ)/', 'a', $slugStr);
                $slugStr = preg_replace('/(é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ)/', 'e', $slugStr);
                $slugStr = preg_replace('/(í|ì|ỉ|ĩ|ị)/', 'i', $slugStr);
                $slugStr = preg_replace('/(ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ)/', 'o', $slugStr);
                $slugStr = preg_replace('/(ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự)/', 'u', $slugStr);
                $slugStr = preg_replace('/(ý|ỳ|ỷ|ỹ|ỵ)/', 'y', $slugStr);
                $slugStr = preg_replace('/(đ)/', 'd', $slugStr);
                $slugStr = preg_replace('/[^a-z0-9-\s]/', '', $slugStr);
                $slugStr = preg_replace('/([\s]+)/', '-', $slugStr);
                $cleanSlug = trim($slugStr, '-');
                $updateStmt->execute([$cleanSlug, $carRow['id']]);
            }
        } catch (Exception $e) {
            echo "   (Error updating car slugs: " . $e->getMessage() . ")\n";
        }

        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    // --- MIGRATION STEP 10: ADD ASSIGNED_AREAS TO COUNSELORS ---
    $step = '010_add_assigned_areas_to_counselors';
    if (!isMigrationExecuted($db, $step)) {
        echo "Running migration: $step...\n";
        executeSqlSafely($db, "ALTER TABLE counselors ADD COLUMN assigned_areas TEXT DEFAULT NULL;");
        recordMigration($db, $step);
        echo "Migration step $step executed successfully!\n";
    }

    echo "=== DATABASE MIGRATION COMPLETED SUCCESSFULLY ===\n";

} catch (Exception $e) {
    die("Database migration failed: " . $e->getMessage() . "\n");
}

