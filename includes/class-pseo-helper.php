<?php
/**
 * Programmatic Local SEO Unified Lookup & Spintax Engine
 * Indexes standard locations, old locations, and projects/apartments into MySQL/SQLite.
 * Provides blazing-fast lookups (< 0.1ms) and dynamic text spinning.
 */
class PSEO_Helper {
    private static $initialized = false;

    /**
     * Initializes the DB table and builds the index if empty
     */
    public static function init() {
        if (self::$initialized) {
            return;
        }
        global $db;
        if (!$db) {
            require_once __DIR__ . '/../db.php';
        }

        // Check if index table exists and has data
        $tableExists = false;
        $hasData = false;
        try {
            $stmt = $db->query("SELECT COUNT(*) FROM pseo_index LIMIT 1");
            $count = $stmt->fetchColumn();
            $tableExists = true;
            if ($count > 0) {
                $hasData = true;
            }
        } catch (Exception $e) {
            // Table doesn't exist
        }

        if (!$tableExists) {
            self::createSchema();
        }

        // Ensure campaigns table is created
        self::createCampaignsTable();

        if (!$hasData) {
            self::buildIndex();
        }

        self::$initialized = true;
    }

    /**
     * Creates the index database schema
     */
    private static function createSchema() {
        global $db;
        $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver === 'mysql') {
            $db->exec("CREATE TABLE IF NOT EXISTS pseo_index (
                slug VARCHAR(191) PRIMARY KEY,
                type VARCHAR(50) NOT NULL,
                display_name VARCHAR(255) NOT NULL,
                meta_data LONGTEXT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            
            try {
                $db->exec("CREATE INDEX idx_pseo_type ON pseo_index(type);");
            } catch (Exception $ex) {}
        } else {
            $db->exec("CREATE TABLE IF NOT EXISTS pseo_index (
                slug TEXT PRIMARY KEY,
                type TEXT NOT NULL,
                display_name TEXT NOT NULL,
                meta_data TEXT NOT NULL
            );");
            try {
                $db->exec("CREATE INDEX idx_pseo_type ON pseo_index(type);");
            } catch (Exception $ex) {}
        }
    }

    /**
     * Creates the campaigns database table and seeds default campaigns
     */
    public static function createCampaignsTable() {
        global $db;
        if (!$db) {
            require_once __DIR__ . '/../db.php';
        }
        $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver === 'mysql') {
            $db->exec("CREATE TABLE IF NOT EXISTS pseo_campaigns (
                id INT AUTO_INCREMENT PRIMARY KEY,
                keyword VARCHAR(255) NOT NULL,
                slug VARCHAR(191) NOT NULL UNIQUE,
                phone_number VARCHAR(50) NULL,
                website_link VARCHAR(255) NULL,
                title_templates TEXT NULL,
                image_ids TEXT NULL,
                content_template LONGTEXT NULL,
                type VARCHAR(50) NOT NULL DEFAULT 'location',
                status VARCHAR(50) NOT NULL DEFAULT 'published',
                created_at DATETIME NOT NULL,
                import_status VARCHAR(50) NOT NULL DEFAULT 'not_started',
                import_created INT NOT NULL DEFAULT 0,
                import_expected INT NOT NULL DEFAULT 0,
                import_start_time DATETIME NULL,
                import_end_time DATETIME NULL,
                import_log LONGTEXT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            // Add columns to existing table if they don't exist
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_status VARCHAR(50) NOT NULL DEFAULT 'not_started';"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_created INT NOT NULL DEFAULT 0;"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_expected INT NOT NULL DEFAULT 0;"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_start_time DATETIME NULL;"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_end_time DATETIME NULL;"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_log LONGTEXT NULL;"); } catch(Exception $e){}
        } else {
            $db->exec("CREATE TABLE IF NOT EXISTS pseo_campaigns (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                keyword TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                phone_number TEXT NULL,
                website_link TEXT NULL,
                title_templates TEXT NULL,
                image_ids TEXT NULL,
                content_template TEXT NULL,
                type TEXT NOT NULL DEFAULT 'location',
                status TEXT NOT NULL DEFAULT 'published',
                created_at TEXT NOT NULL,
                import_status TEXT NOT NULL DEFAULT 'not_started',
                import_created INTEGER NOT NULL DEFAULT 0,
                import_expected INTEGER NOT NULL DEFAULT 0,
                import_start_time TEXT NULL,
                import_end_time TEXT NULL,
                import_log TEXT NULL
            );");

            // Add columns to existing SQLite table if they don't exist
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_status TEXT NOT NULL DEFAULT 'not_started';"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_created INTEGER NOT NULL DEFAULT 0;"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_expected INTEGER NOT NULL DEFAULT 0;"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_start_time TEXT NULL;"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_end_time TEXT NULL;"); } catch(Exception $e){}
            try { $db->exec("ALTER TABLE pseo_campaigns ADD COLUMN import_log TEXT NULL;"); } catch(Exception $e){}
        }

        // Seed default campaigns if table is empty
        try {
            $count = $db->query("SELECT COUNT(*) FROM pseo_campaigns")->fetchColumn();
            if ($count == 0) {
                // Fetch settings if available
                $settingsQuery = $db->query("SELECT * FROM settings WHERE `key` LIKE 'pseo_%'");
                $settings = [];
                while ($row = $settingsQuery->fetch(PDO::FETCH_ASSOC)) {
                    $settings[$row['key']] = $row['value'];
                }

                $title_price = $settings['pseo_title_price'] ?? '{Bảng Giá Xe VinFast Lăn Bánh Mới Nhất Tại|Giá Lăn Bánh Xe Ô Tô VinFast Ưu Đãi Tại|Bảng Báo Giá Xe VinFast Mới Nhất Ở} {LOCATION} | Giao Xe Tận Nhà';
                $title_dealer = $settings['pseo_title_dealer'] ?? '{Đại Lý Xe VinFast Chính Hãng Tại|Showroom Ủy Quyền VinFast 5 Sẵn Sàng Phục Vụ Tại|Đại Lý Ủy Quyền Đạt Chuẩn VinFast Terminal Tại} {LOCATION} | VIP Service';
                $content_price = $settings['pseo_content_price'] ?? '';
                $content_dealer = $settings['pseo_content_dealer'] ?? '';

                $stmt = $db->prepare("INSERT INTO pseo_campaigns (keyword, slug, phone_number, website_link, title_templates, content_template, type, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                
                $stmt->execute([
                    'Bảng giá xe VinFast',
                    'gia-xe-VinFast',
                    '0975510794',
                    'https://example.com',
                    $title_price,
                    $content_price,
                    'location',
                    'published',
                    date('Y-m-d H:i:s')
                ]);

                $stmt->execute([
                    'Đại lý xe VinFast chính hãng',
                    'dai-ly-VinFast',
                    '0975510794',
                    'https://example.com',
                    $title_dealer,
                    $content_dealer,
                    'location',
                    'published',
                    date('Y-m-d H:i:s')
                ]);
            }
        } catch (Exception $e) {}
    }

    /**
     * Parses the JSON databases and builds the index table
     */
    /**
     * Drops and creates a temporary table for rebuilding index safely
     */
    public static function prepareTempTable() {
        global $db;
        if (!$db) {
            require_once __DIR__ . '/../db.php';
        }
        $db->exec("DROP TABLE IF EXISTS pseo_index_temp;");
        $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver === 'mysql') {
            $db->exec("CREATE TABLE pseo_index_temp (
                slug VARCHAR(191) PRIMARY KEY,
                type VARCHAR(50) NOT NULL,
                display_name VARCHAR(255) NOT NULL,
                meta_data LONGTEXT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $db->exec("CREATE INDEX idx_pseo_temp_type ON pseo_index_temp(type);");
        } else {
            $db->exec("CREATE TABLE pseo_index_temp (
                slug TEXT PRIMARY KEY,
                type TEXT NOT NULL,
                display_name TEXT NOT NULL,
                meta_data TEXT NOT NULL
            );");
            $db->exec("CREATE INDEX idx_pseo_temp_type ON pseo_index_temp(type);");
        }
    }

    /**
     * Scrapes all raw items from custom JSON files
     */
    public static function getAllRawItems() {
        $items = [];

        // 1. Chung cu
        $chungcuFile = __DIR__ . '/../seo-dia-danh-pro/chungcu/data.json';
        if (file_exists($chungcuFile)) {
            $projects = json_decode(file_get_contents($chungcuFile), true);
            if (is_array($projects)) {
                foreach ($projects as $proj) {
                    $name = $proj['ten_du_an'] ?? '';
                    if (empty($name)) continue;

                    $slug = self::slugify($name);
                    $meta = json_encode($proj, JSON_UNESCAPED_UNICODE);

                    $items[] = [
                        'slug' => $slug,
                        'type' => 'chungcu',
                        'display_name' => $name,
                        'meta_data' => $meta
                    ];

                    $items[] = [
                        'slug' => 'chung-cu-' . $slug,
                        'type' => 'chungcu',
                        'display_name' => $name,
                        'meta_data' => $meta
                    ];
                }
            }
        }

        // 2. Standard Locations (tree.json)
        $treeFile = __DIR__ . '/../seo-dia-danh-pro/json/tree.json';
        if (file_exists($treeFile)) {
            $tree = json_decode(file_get_contents($treeFile), true);
            if (is_array($tree)) {
                foreach ($tree as $province) {
                    $pName = $province['name'] ?? '';
                    if (empty($pName)) continue;

                    // Province itself
                    $pSlug = self::slugify($pName);
                    $items[] = [
                        'slug' => $pSlug,
                        'type' => 'location',
                        'display_name' => $pName,
                        'meta_data' => json_encode(['province' => $pName], JSON_UNESCAPED_UNICODE)
                    ];

                    if (isset($province['wards']) && is_array($province['wards'])) {
                        foreach ($province['wards'] as $ward) {
                            $wName = $ward['name'] ?? '';
                            if (empty($wName)) continue;

                            $slug = self::slugify($wName . '-' . $pName);
                            $items[] = [
                                'slug' => $slug,
                                'type' => 'location',
                                'display_name' => "$wName, $pName",
                                'meta_data' => json_encode(['ward' => $wName, 'province' => $pName], JSON_UNESCAPED_UNICODE)
                            ];
                        }
                    }
                }
            }
        }

        // 3. Old Locations (diadanhcu.json)
        $diadanhcuFile = __DIR__ . '/../seo-dia-danh-pro/diadanhcu/diadanhcu.json';
        if (file_exists($diadanhcuFile)) {
            $diadanhcu = json_decode(file_get_contents($diadanhcuFile), true);
            if (is_array($diadanhcu)) {
                foreach ($diadanhcu as $province) {
                    $pName = $province['name'] ?? '';
                    if (empty($pName)) continue;

                    if (isset($province['districts']) && is_array($province['districts'])) {
                        foreach ($province['districts'] as $district) {
                            $dName = $district['name'] ?? '';
                            if (empty($dName)) continue;

                            $dSlug = self::slugify($dName . '-' . $pName);
                            $items[] = [
                                'slug' => $dSlug,
                                'type' => 'diadanhcu',
                                'display_name' => "$dName, $pName",
                                'meta_data' => json_encode(['district' => $dName, 'province' => $pName], JSON_UNESCAPED_UNICODE)
                            ];

                            if (isset($district['wards']) && is_array($district['wards'])) {
                                foreach ($district['wards'] as $ward) {
                                    $wName = $ward['name'] ?? '';
                                    if (empty($wName)) continue;

                                    $slug = self::slugify($wName . '-' . $dName . '-' . $pName);
                                    $items[] = [
                                        'slug' => $slug,
                                        'type' => 'diadanhcu',
                                        'display_name' => "$wName, $dName, $pName",
                                        'meta_data' => json_encode(['ward' => $wName, 'district' => $dName, 'province' => $pName], JSON_UNESCAPED_UNICODE)
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        return $items;
    }

    /**
     * Rebuilds index synchronously (Legacy / Fallback support)
     */
    public static function buildIndex() {
        @set_time_limit(300);
        global $db;
        if (!$db) {
            require_once __DIR__ . '/../db.php';
        }
        
        self::prepareTempTable();
        $items = self::getAllRawItems();
        
        $db->beginTransaction();
        try {
            $stmt = $db->prepare("REPLACE INTO pseo_index_temp (slug, type, display_name, meta_data) VALUES (:slug, :type, :display_name, :meta_data)");
            foreach ($items as $item) {
                $stmt->execute([
                    ':slug' => $item['slug'],
                    ':type' => $item['type'],
                    ':display_name' => $item['display_name'],
                    ':meta_data' => $item['meta_data']
                ]);
            }
            $db->commit();
            self::finalizeRebuild();
        } catch (Exception $e) {
            $db->rollBack();
            self::cancelRebuild();
            throw $e;
        }
    }

    /**
     * Imports a slice of scraped items into temporary rebuild table
     */
    public static function importChunk($chunkIndex, $chunkSize) {
        global $db;
        if (!$db) {
            require_once __DIR__ . '/../db.php';
        }

        $items = self::getAllRawItems();
        $offset = $chunkIndex * $chunkSize;
        $chunk = array_slice($items, $offset, $chunkSize);

        if (empty($chunk)) {
            return 0;
        }

        $db->beginTransaction();
        try {
            $stmt = $db->prepare("REPLACE INTO pseo_index_temp (slug, type, display_name, meta_data) VALUES (:slug, :type, :display_name, :meta_data)");
            foreach ($chunk as $item) {
                $stmt->execute([
                    ':slug' => $item['slug'],
                    ':type' => $item['type'],
                    ':display_name' => $item['display_name'],
                    ':meta_data' => $item['meta_data']
                ]);
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        return count($chunk);
    }

    /**
     * Swaps temp table to live index table safely in single transaction
     */
    public static function finalizeRebuild() {
        global $db;
        if (!$db) {
            require_once __DIR__ . '/../db.php';
        }

        $db->beginTransaction();
        try {
            $db->exec("DELETE FROM pseo_index;");
            $db->exec("INSERT INTO pseo_index SELECT * FROM pseo_index_temp;");
            $db->commit();
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }

        // Execute DDL statement (DROP TABLE) outside of the transaction 
        // to prevent MySQL implicit commits from breaking PDO transaction state
        try {
            $db->exec("DROP TABLE IF EXISTS pseo_index_temp;");
        } catch (Exception $e) {
            // Silently swallow temp table cleanup failures if any
        }
    }

    /**
     * Drops temp table to rollback cancelation
     */
    public static function cancelRebuild() {
        global $db;
        if (!$db) {
            require_once __DIR__ . '/../db.php';
        }
        $db->exec("DROP TABLE IF EXISTS pseo_index_temp;");
    }

    /**
     * Retrieves all custom defined spintax keywords & campaign configurations from database
     */
    public static function getCustomKeywords($onlyPublished = true) {
        global $db;
        if (!$db) {
            require_once __DIR__ . '/../db.php';
        }

        try {
            self::init();
            $sql = "SELECT * FROM pseo_campaigns";
            if ($onlyPublished) {
                $sql .= " WHERE status = 'published'";
            }
            $sql .= " ORDER BY id ASC";
            
            $stmt = $db->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($rows)) {
                $keywords = [];
                foreach ($rows as $row) {
                    $keywords[$row['slug']] = [
                        'id' => $row['id'],
                        'slug' => $row['slug'],
                        'label' => $row['keyword'],
                        'keyword' => $row['keyword'],
                        'phone_number' => $row['phone_number'],
                        'website_link' => $row['website_link'],
                        'title_templates' => $row['title_templates'],
                        'title' => $row['title_templates'],
                        'image_ids' => $row['image_ids'],
                        'content_template' => $row['content_template'],
                        'type' => $row['type'],
                        'status' => $row['status'],
                        'created_at' => $row['created_at'],
                        'import_created' => (int)$row['import_created'],
                        'import_status' => $row['import_status']
                    ];
                }
                return $keywords;
            }
        } catch (Exception $e) {}

        // Absolute fallback standard keywords
        return [
            'gia-xe-VinFast' => [
                'slug' => 'gia-xe-VinFast',
                'label' => 'Bảng giá xe VinFast',
                'keyword' => 'Bảng giá xe VinFast',
                'phone_number' => '0975510794',
                'website_link' => 'https://example.com',
                'title_templates' => '{Bảng Giá Xe VinFast Lăn Bánh Mới Nhất Tại|Giá Lăn Bánh Xe Ô Tô VinFast Ưu Đãi Tại|Bảng Báo Giá Xe VinFast Mới Nhất Ở} {LOCATION} | Giao Xe Tận Nhà',
                'title' => '{Bảng Giá Xe VinFast Lăn Bánh Mới Nhất Tại|Giá Lăn Bánh Xe Ô Tô VinFast Ưu Đãi Tại|Bảng Báo Giá Xe VinFast Mới Nhất Ở} {LOCATION} | Giao Xe Tận Nhà',
                'image_ids' => '',
                'content_template' => '',
                'type' => 'location',
                'status' => 'published',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
    }

    /**
     * Looks up a slug in the index table and returns the matched row
     */
    public static function findLocationOrProject($slug) {
        try {
            self::init();
            global $db;
            $normalized = self::normalizeSlug($slug);
            $stmt = $db->prepare("SELECT * FROM pseo_index WHERE slug = :slug LIMIT 1");
            $stmt->execute([':slug' => $normalized]);
            $row = $stmt->fetch();
            if ($row) {
                $row['meta_data'] = json_decode($row['meta_data'], true);
                return $row;
            }
        } catch (Exception $e) {
            // Failover gracefully
        }
        return null;
    }

    /**
     * Normalizes slug by expanding common abbreviations to their full database names safely
     */
    public static function normalizeSlug($slug) {
        $slug = strtolower($slug);
        
        if ($slug === 'tp-hcm' || $slug === 'hcm') {
            return 'thanh-pho-ho-chi-minh';
        }
        if ($slug === 'ha-noi' || $slug === 'hn') {
            return 'thanh-pho-ha-noi';
        }
        if ($slug === 'da-nang' || $slug === 'dn') {
            return 'thanh-pho-da-nang';
        }
        if ($slug === 'hai-phong' || $slug === 'hp') {
            return 'thanh-pho-hai-phong';
        }
        
        if (strpos($slug, 'thanh-pho-ho-chi-minh') === false) {
            $slug = str_replace('-tp-hcm', '-thanh-pho-ho-chi-minh', $slug);
        }
        if (strpos($slug, 'thanh-pho-ha-noi') === false) {
            $slug = str_replace('-ha-noi', '-thanh-pho-ha-noi', $slug);
            $slug = str_replace('-tp-hn', '-thanh-pho-ha-noi', $slug);
        }
        if (strpos($slug, 'thanh-pho-da-nang') === false) {
            $slug = str_replace('-da-nang', '-thanh-pho-da-nang', $slug);
            $slug = str_replace('-tp-dn', '-thanh-pho-da-nang', $slug);
        }
        if (strpos($slug, 'thanh-pho-hai-phong') === false) {
            $slug = str_replace('-hai-phong', '-thanh-pho-hai-phong', $slug);
        }
        if (strpos($slug, 'thanh-pho-can-tho') === false) {
            $slug = str_replace('-can-tho', '-thanh-pho-can-tho', $slug);
        }
        
        return $slug;
    }

    /**
     * Retrieves all slugs in the index
     */
    public static function getAllSlugs($type = null) {
        try {
            self::init();
            global $db;
            if ($type) {
                $stmt = $db->prepare("SELECT slug FROM pseo_index WHERE type = :type ORDER BY slug ASC");
                $stmt->execute([':type' => $type]);
            } else {
                $stmt = $db->query("SELECT slug FROM pseo_index ORDER BY slug ASC");
            }
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Recursively processes spintax brackets (e.g. {a|b|{c|d}})
     */
    public static function processSpintax($text) {
        $pattern = '/\{([^{}]*)\}/';
        while (preg_match($pattern, $text, $matches)) {
            $parts = explode('|', $matches[1]);
            $random_part = $parts[array_rand($parts)];
            $text = substr_replace(
                $text,
                $random_part,
                strpos($text, $matches[0]),
                strlen($matches[0])
            );
        }
        return $text;
    }

    /**
     * Clean, UTF-8 safe Vietnamese accent stripping and slugification
     */
    public static function slugify($str) {
        $str = mb_strtolower($str, 'UTF-8');
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/u', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/u', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/u', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/u', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/u', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/u', 'y', $str);
        $str = preg_replace('/(đ)/u', 'd', $str);
        $str = preg_replace('/[^a-z0-9\s-]/u', '', $str);
        $str = preg_replace('/[\s-]+/u', '-', $str);
        return trim($str, '-');
    }

    /**
     * Finds 5-6 nearby locations/projects of the same type/province for cross-linking
     */
    public static function getNearbyLocations($slug, $limit = 6) {
        try {
            self::init();
            global $db;
            
            $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
            $randomFunc = ($driver === 'mysql') ? 'RAND()' : 'RANDOM()';
            
            // Get current matched row
            $normalized = self::normalizeSlug($slug);
            $stmt = $db->prepare("SELECT * FROM pseo_index WHERE slug = :slug LIMIT 1");
            $stmt->execute([':slug' => $normalized]);
            $current = $stmt->fetch();
            
            if (!$current) {
                // If not matched, just get 6 random locations as generic fallbacks
                $stmt = $db->prepare("SELECT slug, display_name, type FROM pseo_index ORDER BY $randomFunc LIMIT :limit");
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll();
            }
            
            $currentType = $current['type'];
            $meta = json_decode($current['meta_data'], true);
            
            // Determine a query parameter to fetch related/nearby items
            if ($currentType === 'chungcu') {
                // For projects, fetch other projects
                $stmt = $db->prepare("SELECT slug, display_name, type FROM pseo_index WHERE type = 'chungcu' AND slug != :slug ORDER BY $randomFunc LIMIT :limit");
                $stmt->bindValue(':slug', $current['slug'], PDO::PARAM_STR);
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll();
            } else {
                // For locations, fetch other locations in the same district first, then same province
                $district = $meta['district'] ?? '';
                $province = $meta['province'] ?? '';
                
                if (!empty($district)) {
                    // Filter by exact same district for maximum geographic relevance (e.g. Thanh Xuan district)
                    $stmt = $db->prepare("SELECT slug, display_name, type FROM pseo_index WHERE type = :type AND slug != :slug AND meta_data LIKE :district ORDER BY $randomFunc LIMIT :limit");
                    $stmt->bindValue(':type', $currentType, PDO::PARAM_STR);
                    $stmt->bindValue(':district', '%"district":"' . $district . '"%', PDO::PARAM_STR);
                } elseif (!empty($province)) {
                    // Fallback to same province
                    $stmt = $db->prepare("SELECT slug, display_name, type FROM pseo_index WHERE type = :type AND slug != :slug AND meta_data LIKE :province ORDER BY $randomFunc LIMIT :limit");
                    $stmt->bindValue(':type', $currentType, PDO::PARAM_STR);
                    $stmt->bindValue(':province', '%' . $province . '%', PDO::PARAM_STR);
                } else {
                    $stmt = $db->prepare("SELECT slug, display_name, type FROM pseo_index WHERE type = :type AND slug != :slug ORDER BY $randomFunc LIMIT :limit");
                    $stmt->bindValue(':type', $currentType, PDO::PARAM_STR);
                }
                $stmt->bindValue(':slug', $current['slug'], PDO::PARAM_STR);
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll();
            }
        } catch (Exception $e) {
            return [];
        }
    }
}





