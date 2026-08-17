      <?php
        $postIdToEdit = isset($_GET['edit_post_id']) ? (int)$_GET['edit_post_id'] : 0;
        $editPost = null;
        if ($postIdToEdit > 0) {
            $stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->execute([$postIdToEdit]);
            $editPost = $stmt->fetch();
        }

        // Fetch SEO settings
        $stmt = $db->query("SELECT * FROM settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['key']] = $row['value'];
        }

        // Decode dynamic section variables
        $homepage_faqs_data = json_decode($settings['homepage_faqs'] ?? '', true);
        if (!is_array($homepage_faqs_data) || empty($homepage_faqs_data)) {
            $homepage_faqs_data = [
                [
                    "question" => "Thời gian sạc đầy của xe điện EV là bao lâu?",
                    "answer" => "Với các trạm sạc nhanh DC công suất lớn tại showroom của VinFast Việt Nam, xe có thể sạc từ 5% lên 80% chỉ trong khoảng 22.5 phút. Đối với sạc AC tại nhà thông dụng, thời gian sạc đầy hoàn toàn qua đêm là từ 6 đến 8 tiếng."
                ],
                [
                    "question" => "Chính sách bảo hành pin của xe điện VinFast như thế nào?",
                    "answer" => "Pin Lithium-ion trang bị trên dòng xe VinFast EV được áp dụng chính sách bảo hành đặc biệt chính hãng lên đến 8 năm hoặc 160.000 km (tùy điều kiện nào đến trước), bảo vệ tối đa lợi ích và giá trị của khách hàng."
                ],
                [
                    "question" => "Showroom có hỗ trợ mua xe trả góp liên kết với ngân hàng không?",
                    "answer" => "Có. VinFast Việt Nam liên kết chặt chẽ với tất cả các khối ngân hàng lớn trong và ngoài nước (Vietcombank, Techcombank, Shinhan Bank...) hỗ trợ hạn mức vay lên đến 80% giá trị xe, thời hạn lên đến 7 năm cùng lãi suất vô cùng ưu đãi."
                ],
                [
                    "question" => "Chi phí bảo dưỡng định kỳ của xe VinFast tại hãng là bao nhiêu?",
                    "answer" => "Chi phí bảo dưỡng định kỳ của VinFast được tối ưu hóa tối đa nhờ các gói bảo dưỡng trọn gói linh hoạt. Xe động cơ xăng thông thường cần bảo dưỡng mỗi 10.000 km hoặc 1 năm với chi phí hợp lý tại xưởng dịch vụ ủy quyền. Riêng xe điện EV có chi phí bảo dưỡng cực kỳ tiết kiệm, thấp hơn từ 30% đến 50% so với xe xăng do cấu tạo động cơ điện không cần thay dầu máy, lọc dầu hay bugi định kỳ."
                ],
                [
                    "question" => "Đại lý có hỗ trợ giao xe tận nhà trên toàn quốc và lễ bàn giao đặc biệt không?",
                    "answer" => "Có. Tất cả khách hàng sở hữu xe VinFast chính hãng đều được trải nghiệm đặc quyền bàn giao xe VIP cá nhân hóa (Private Handover Ceremony) tại phòng chờ trưng bày sang trọng của Showroom hoặc hỗ trợ vận chuyển bằng xe chuyên dụng bàn giao tận nhà trên toàn quốc, đi kèm bộ quà tặng đặc quyền thương hiệu VinFast Collection."
                ]
            ];
        }

        $s6_headline = $settings['s6_headline'] ?? 'VinFast Việt Nam giới thiệu VinFast VF 9 - Mẫu SUV thuần điện phân khúc E hạng sang đầu tiên tại Việt Nam, mở ra kỷ nguyên di chuyển xanh.';
        $s6_desc = $settings['s6_desc'] ?? '<p>Đây là cột mốc quan trọng trong chiến lược điện hóa của thương hiệu, đồng thời khẳng định định hướng mang đến trải nghiệm di chuyển bền vững nhưng vẫn giữ trọn DNA hiệu suất, công nghệ và sự sang trọng đặc trưng của VinFast. Giá khởi điểm từ 1.560.000.000 VNĐ.</p>';

        $s5_privileges_data = json_decode($settings['s5_privileges'] ?? '', true);
        if (!is_array($s5_privileges_data) || count($s5_privileges_data) < 4) {
            $s5_privileges_data = [
                ["watermark" => "Warranty", "title" => "Bảo hành 3 năm vô hạn km", "desc" => "Yên tâm tuyệt đối với chế độ bảo hành chính hãng toàn cầu không giới hạn quãng đường di chuyển.", "link_text" => "Tìm hiểu chính sách", "link_href" => "#catalog-block"],
                ["watermark" => "EV", "title" => "Độc quyền sạc nhanh EV", "desc" => "Truy cập hệ thống trạm sạc nhanh cao cấp công suất lớn phủ sóng rộng rãi tại các showroom VinFast Việt Nam.", "link_text" => "Hệ thống trạm sạc", "link_href" => "#catalog-block"],
                ["watermark" => "Roadside", "title" => "Cứu hộ VinFast Roadside 24/7", "desc" => "Đội ngũ kỹ sư hỗ trợ ứng cứu khẩn cấp trên mọi cung đường Việt Nam bất kể ngày đêm.", "link_text" => "Hotline cứu trợ", "link_href" => "#tradein-block"],
                ["watermark" => "Trade-in", "title" => "Chính sách thu cũ đổi mới", "desc" => "Định giá xe cũ minh bạch và hỗ trợ lên đời dòng xe VinFast thế hệ mới với nhiều ưu đãi đặc quyền.", "link_text" => "Đăng ký định giá", "link_href" => "#tradein-block"]
            ];
        }

        $s6_signature_quote = $settings['s6_signature_quote'] ?? 'Mỗi hành trình cùng VinFast không chỉ đơn thuần là di chuyển, đó là lời khẳng định về một phong cách sống thời thượng, sự an tâm tuyệt đối trên mọi nẻo đường và đặc quyền dịch vụ chuẩn 5 sao toàn cầu.';

        $s6_reasons_data = json_decode($settings['s6_reasons'] ?? '', true);
        if (!is_array($s6_reasons_data) || count($s6_reasons_data) < 4) {
            $s6_reasons_data = [
                ["title" => "100% Chính Hãng Việt Nam", "desc" => "Đảm bảo nguồn gốc xuất xứ chính hãng từ tổ hợp nhà máy sản xuất ô tô hiện đại bậc nhất VinFast Hải Phòng."],
                ["title" => "Đội Ngũ Kỹ Sư Đạt Chuẩn Toàn Cầu", "desc" => "Đội ngũ cố vấn kỹ thuật và thợ máy chuyên trách được đào tạo bài bản, kiểm tra khắt khe và cấp chứng chỉ trực tiếp từ VinFast Việt Nam theo chuẩn quốc tế."],
                ["title" => "Hỗ Trợ Thủ Tục Siêu Tốc", "desc" => "Đội ngũ chuyên viên chuyên nghiệp hỗ trợ trọn gói mọi thủ tục đăng ký biển số, đăng kiểm lưu hành, dịch vụ tài chính liên kết và giao xe tận nhà chu đáo."],
                ["title" => "Showroom Đạt Chuẩn Quốc Tế", "desc" => "Hệ thống cơ sở hạ tầng, phòng trưng bày sang trọng theo nhận diện toàn cầu (VinFast Terminal), mang lại không gian trải nghiệm dịch vụ đỉnh cao 5 sao."]
            ];
        }

        $s8_offers_data = json_decode($settings['s8_offers'] ?? '', true);
        if (!is_array($s8_offers_data) || count($s8_offers_data) < 4) {
            $s8_offers_data = [
                [
                    "tag" => "CHÀO HÈ 2026",
                    "title" => "Hỗ trợ lệ phí trước bạ",
                    "desc" => "Ưu đãi lên tới 100% lệ phí trước bạ hoặc khấu trừ trực tiếp giá trị giao dịch lên tới 300 triệu đồng áp dụng cho một số dòng xe điện thông minh.",
                    "bullets" => [
                        "Áp dụng cho các dòng sedan và SUV VinFast VF 3, VF 5, VF 6, VF 7, VF 8, VF 9 chính hãng",
                        "Hỗ trợ thực hiện nhanh trọn gói mọi thủ tục nộp thuế siêu tốc",
                        "Sẵn sàng phương án quy trừ trực tiếp vào giá trị hợp đồng thanh toán"
                    ]
                ],
                [
                    "tag" => "EV PRIVILEGE",
                    "title" => "Đặc quyền sạc pin 1 năm",
                    "desc" => "Miễn phí hoàn toàn chi phí sạc pin tại tất cả trạm sạc nhanh của hệ thống đại lý VinFast Việt Nam trong 12 tháng đầu tiên kể từ khi nhận xe điện.",
                    "bullets" => [
                        "Áp dụng tại trạm sạc nhanh DC 180kW cao cấp nhất toàn quốc",
                        "Đặc quyền cung ứng sạc điện lưu động cứu hộ khẩn cấp 24/7",
                        "Giám sát dung lượng và chỉ đường trạm sạc thông minh qua ứng dụng"
                    ]
                ],
                [
                    "tag" => "VinFast ACCESSORIES",
                    "title" => "Gói phụ kiện chính hãng",
                    "desc" => "Tặng ngay bộ thảm sàn cao cấp thiết kế riêng, dù che nắng VinFast Collection, móc khóa da cao cấp cùng gói phủ Ceramic bảo vệ bề mặt sơn.",
                    "bullets" => [
                        "Bộ thảm sàn chất liệu cao cấp thiết kế riêng chuẩn khí động học của xe",
                        "Gói phủ bảo vệ sơn ngoại thất Ceramic chuyên sâu tăng cứng bảo hành hãng",
                        "Bộ quà tặng thương hiệu VinFast Collection thời thượng đẳng cấp quốc tế"
                    ]
                ],
                [
                    "tag" => "VinFast CLUB VIP",
                    "title" => "Thẻ thành viên VIP đặc quyền",
                    "desc" => "Hòa mình vào cộng đồng VinFast Club Vietnam, nhận ưu đãi giảm giá độc quyền tại các khách sạn 5 sao, khu resort cao cấp và sân golf hàng đầu.",
                    "bullets" => [
                        "Thẻ đặc quyền kết nối cộng đồng chủ nhân xe VinFast thượng lưu toàn quốc",
                        "Ưu đãi giảm tới 25% các dịch vụ nghỉ dưỡng cao cấp, golf, ẩm thực",
                        "Thư mời tham dự đặc quyền mọi sự kiện giới thiệu dòng xe mới và âm nhạc"
                    ]
                ]
            ];
        }

        $s7_tradein_title = $settings['s7_tradein_title'] ?? "Thu cũ đổi mới - Lên đời xe VinFast chính hãng";
        $s7_tradein_desc = $settings['s7_tradein_desc'] ?? "Chương trình hỗ trợ độc quyền của đại lý VinFast dành cho quý khách hàng đang sở hữu bất kỳ hãng xe nào muốn đổi sang dòng xe VinFast mới đẳng cấp.";
        $s7_default_counselor_name = $settings['s7_default_counselor_name'] ?? "Mr. Nguyễn Thành";
        $s7_default_counselor_title = $settings['s7_default_counselor_title'] ?? "Chuyên viên tư vấn VIP";

        $s7_tradein_steps_data = json_decode($settings['s7_tradein_steps'] ?? '', true);
        if (!is_array($s7_tradein_steps_data) || count($s7_tradein_steps_data) < 3) {
            $s7_tradein_steps_data = [
                ["num" => "01", "title" => "Gửi Thông Tin Trực Tuyến", "desc" => "Điền thông số xe hiện tại và cách liên hệ của anh/chị tại biểu mẫu bên cạnh chỉ trong 1 phút."],
                ["num" => "02", "title" => "Thẩm Định Tại Nhà Miễn Phí", "desc" => "Đội ngũ kỹ sư thẩm định xe VinFast sẽ liên hệ trực tiếp và đến tận nhà thẩm định xe của anh/chị hoàn toàn miễn phí."],
                ["num" => "03", "title" => "Lên Đời Xe Giao Tận Nơi", "desc" => "Hưởng ưu đãi thu mua xe cũ giá cao nhất thị trường, khấu trừ trực tiếp vào giá xe VinFast mới và hỗ trợ giao xe tận nhà chu đáo."]
            ];
        }

        $s9_dual_actions_data = json_decode($settings['s9_dual_actions'] ?? '', true);
        if (!is_array($s9_dual_actions_data) || count($s9_dual_actions_data) < 2) {
            $s9_dual_actions_data = [
                [
                    "tag" => "TRẢI NGHIỆM THỰC TẾ",
                    "title" => "Đăng Ký Lái Thử Xe",
                    "desc" => "Cảm nhận sức mạnh động cơ và sự tiện nghi sang trọng trực tiếp trên các cung đường cùng chuyên viên hỗ trợ của VinFast.",
                    "btn_text" => "Đăng ký ngay",
                    "btn_href" => "#catalog-block",
                    "bg_class" => "action-tile__bg--test-drive"
                ],
                [
                    "tag" => "CHĂM SÓC CHUYÊN NGHIỆP",
                    "title" => "Đặt Lịch Hẹn Dịch Vụ",
                    "desc" => "Bảo dưỡng định kỳ, kiểm tra sửa chữa chuyên sâu với đội ngũ kỹ sư được đào tạo bài bản theo tiêu chuẩn toàn cầu của VinFast.",
                    "btn_text" => "Đặt lịch hẹn",
                    "btn_href" => "admin.php?p=service",
                    "bg_class" => "action-tile__bg--service"
                ]
            ];
        }

        // New pages variables
        $about_title = $settings['about_title'] ?? 'Giới thiệu VinFast Việt Nam';
        $about_intro_headline = $settings['about_intro_headline'] ?? 'Tiên phong trong công nghệ & Trải nghiệm xứng tầm';
        $about_intro_text = $settings['about_intro_text'] ?? '';
        $about_image_url = $settings['about_image_url'] ?? '';
        $about_map_iframe = $settings['about_map_iframe'] ?? '';
        $about_values_data = json_decode($settings['about_values'] ?? '', true);
        if (!is_array($about_values_data) || count($about_values_data) < 3) {
            $about_values_data = [
                ["title" => "Đỉnh Cao Thiết Kế", "desc" => "Ngôn ngữ thiết kế tối giản, khí động học xuất sắc kết hợp cùng dải đèn Matrix LED tiên phong định hình tương lai.", "icon" => "fas fa-pencil-ruler"],
                ["title" => "Hiệu Suất Điện Hóa", "desc" => "Hệ dẫn động AWD huyền thoại kết hợp động cơ thuần điện EV mạnh mẽ, êm ái và bảo vệ môi trường.", "icon" => "fas fa-bolt"],
                ["title" => "Đặc Quyền Thượng Lưu", "desc" => "Dịch vụ phòng chờ VIP 5 sao, đội ngũ cố vấn riêng biệt và chế độ hậu mãi chuẩn toàn cầu tại VinFast Terminal.", "icon" => "fas fa-crown"]
            ];
        }
        
        // Extended About Us Dynamic Variables
        $about_hero_image_url = $settings['about_hero_image_url'] ?? '';
        $about_hero_tag = $settings['about_hero_tag'] ?? 'Mãnh liệt Tinh thần Việt Nam';
        $about_hero_title = $settings['about_hero_title'] ?? 'Khai phóng tương lai<br>bằng công nghệ';
        $about_hero_desc = $settings['about_hero_desc'] ?? 'Tầm nhìn tiên phong mang khát vọng Việt Nam vươn tầm thế giới, mở ra tương lai di động xanh bền vững cùng VinFast.';
        $about_intro_tag = $settings['about_intro_tag'] ?? 'Chúng tôi là ai?';
        
        $about_gallery_tag = $settings['about_gallery_tag'] ?? 'Không gian trải nghiệm';
        $about_gallery_title = $settings['about_gallery_title'] ?? 'VinFast Showroom & Charging Lounge';
        $about_gallery_desc = $settings['about_gallery_desc'] ?? 'Không gian dịch vụ cao cấp chuẩn mực quốc tế kết hợp cùng phòng chờ sạc nhanh thuần điện sang trọng hàng đầu Việt Nam.';
        $about_gallery_slides_data = json_decode($settings['about_gallery_slides'] ?? '', true);
        if (!is_array($about_gallery_slides_data) || empty($about_gallery_slides_data)) {
            $about_gallery_slides_data = [
                ["image" => "https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80", "title" => "VinFast Charging Lounge", "desc" => "Phòng chờ sạc nhanh chuẩn mực luxury, nơi khách hàng thư giãn trong khi xe EV sạc điện."],
                ["image" => "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80", "title" => "Trải nghiệm dịch vụ 5 sao", "desc" => "Không gian sang trọng với quầy bar phục vụ trà, cafe hảo hạng cùng đội ngũ nhân viên nhiệt tình, tận tâm."],
                ["image" => "https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80", "title" => "Tiên phong hạ tầng điện hóa", "desc" => "Trạm sạc nhanh DC công suất lớn được lắp đặt trực tiếp tại showroom, sạc đầy 80% chỉ trong 20-30 phút."],
                ["image" => "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80", "title" => "Khu vực trưng bày và bàn giao xe VIP", "desc" => "Mỗi chiếc xe giao tay khách hàng đều được chuẩn bị tinh tế trong không gian bàn giao xe handover kín đáo, chuyên nghiệp."],
                ["image" => "https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=1200&q=80", "title" => "VinFast Showroom Tôn Đức Thắng", "desc" => "Thiết kế nhận diện tòa nhà sang trọng độc quyền tọa lạc tại trung tâm Quận 1 sầm uất."]
            ];
        }
        
        $about_stats_data = json_decode($settings['about_stats'] ?? '', true);
        if (!is_array($about_stats_data) || count($about_stats_data) < 4) {
            $about_stats_data = [
                ["number" => "150+", "label" => "Showroom & Đại lý", "desc" => "Hệ thống Showroom 3S đạt chuẩn dịch vụ và trải nghiệm khách hàng trên toàn quốc."],
                ["number" => "150.000+", "label" => "Cổng sạc toàn quốc", "desc" => "Hạ tầng trạm sạc EV thông minh trải rộng khắp 63 tỉnh thành tại Việt Nam."],
                ["number" => "10 Năm", "label" => "Bảo hành chính hãng", "desc" => "Đặc quyền bảo hành lâu nhất thị trường cho tất cả các dòng xe điện."],
                ["number" => "24/7", "label" => "Cứu hộ khẩn cấp", "desc" => "Dịch vụ cứu hộ Roadside Assistance và sửa chữa lưu động Mobile Service chuyên nghiệp."]
            ];
        }
        
        $about_quote_text = $settings['about_quote_text'] ?? 'Thiết kế đột phá mang dấu ấn tinh hoa Việt kết hợp cùng công nghệ thông minh vượt trội là chìa khóa mở ra tương lai di động xanh và gắn kết mọi hành trình của bạn.';
        $about_quote_author = $settings['about_quote_author'] ?? 'VinFast Design Studio';
        $about_quote_author_title = $settings['about_quote_author_title'] ?? 'Đội ngũ Thiết kế Toàn cầu (Hợp tác Pininfarina & Torino Design)';
        $about_quote_bg_image = $settings['about_quote_bg_image'] ?? 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1920&q=80';
        
        $about_history_tag = $settings['about_history_tag'] ?? 'Dòng chảy lịch sử';
        $about_history_title = $settings['about_history_title'] ?? 'Hành trình kiến tạo tương lai';
        $about_history_desc = $settings['about_history_desc'] ?? 'Cùng nhìn lại các cột mốc lịch sử vĩ đại làm nền tảng cho sự phát triển công nghệ đột phá của VinFast ngày nay.';
        $about_history_timeline_data = json_decode($settings['about_history_timeline'] ?? '', true);
        if (!is_array($about_history_timeline_data) || empty($about_history_timeline_data)) {
            $about_history_timeline_data = [
                ["year" => "2017", "title" => "Khởi công tổ hợp nhà máy", "desc" => "VinFast chính thức khởi công tổ hợp nhà máy sản xuất ô tô và xe máy điện quy mô 335 ha tại Hải Phòng với công nghệ hiện đại hàng đầu thế giới."],
                ["year" => "2018", "title" => "Ra mắt thế giới tại Paris Motor Show", "desc" => "Gây tiếng vang lớn toàn cầu khi giới thiệu hai mẫu xe Lux A2.0 và Lux SA2.0 tại Triển lãm ô tô Paris, khẳng định vị thế và niềm tự hào Việt Nam."],
                ["year" => "2021", "title" => "Bàn giao chiếc xe điện đầu tiên", "desc" => "Bàn giao mẫu xe ô tô điện thông minh đầu tiên VF e34 tại thị trường Việt Nam, mở đầu cho kỷ nguyên di chuyển xanh bền vững."],
                ["year" => "2022", "title" => "Niêm yết Nasdaq & Chiến lược thuần điện", "desc" => "Công bố chiến lược thuần điện 100%, nộp hồ sơ IPO tại Mỹ và giới thiệu dải sản phẩm SUV điện thông minh từ VF 5 đến VF 9."],
                ["year" => "2024", "title" => "Cơn sốt xe điện quốc dân VF 3", "desc" => "Chính thức ra mắt xe điện mini quốc dân VF 3, nhận kỷ lục hơn 27.000 đơn đặt hàng chỉ sau 66 giờ mở bán tại Việt Nam."],
                ["year" => "2026", "title" => "Số hóa dịch vụ & Phủ sóng trạm sạc", "desc" => "Hoàn thiện hệ sinh thái số toàn diện, nâng cấp trợ lý ảo ViVi thế hệ mới và phủ sóng 150.000 cổng sạc trên toàn bộ 63 tỉnh thành."]
            ];
        }
        
        $about_commitments_tag = $settings['about_commitments_tag'] ?? 'Cam kết đại lý';
        $about_commitments_title = $settings['about_commitments_title'] ?? 'An tâm tuyệt đối khi đồng hành';
        $about_commitments_desc = $settings['about_commitments_desc'] ?? 'Mọi khách hàng sở hữu xe VinFast chính hãng tại đại lý của chúng tôi đều nhận được lời cam kết vàng về chất lượng sản phẩm và dịch vụ tốt nhất.';
        $about_commitments_list_data = json_decode($settings['about_commitments_list'] ?? '', true);
        if (!is_array($about_commitments_list_data) || count($about_commitments_list_data) < 3) {
            $about_commitments_list_data = [
                ["icon" => "layers", "title" => "100% Sản xuất lắp ráp công nghệ cao", "desc" => "Toàn bộ danh mục xe từ xe điện mini đến SUV cỡ lớn đều được sản xuất lắp ráp trực tiếp tại tổ hợp nhà máy hiện đại Hải Phòng đạt tiêu chuẩn xuất khẩu toàn cầu."],
                ["icon" => "lock", "title" => "Bảo hành 10 năm vượt trội", "desc" => "Đặc quyền bảo hành chính hãng lên tới 10 năm hoặc 200.000 km cao nhất thị trường. Pin xe điện được bảo hành chính hãng từ 8 - 10 năm không giới hạn số km."],
                ["icon" => "wrench", "title" => "Linh kiện chính hãng 100%", "desc" => "Dịch vụ sửa chữa, bảo dưỡng cam kết chỉ sử dụng linh phụ kiện chính hãng cung cấp trực tiếp từ kho tổng nhà máy Hải Phòng, bảo chứng bởi thợ máy lành nghề."]
            ];
        }
        
        $about_ctas_list_data = json_decode($settings['about_ctas_list'] ?? '', true);
        if (!is_array($about_ctas_list_data) || count($about_ctas_list_data) < 3) {
            $about_ctas_list_data = [
                ["title" => "Tư vấn trực tiếp Zalo", "desc" => "Anh cần tìm hiểu thêm về các chương trình ưu đãi chào hè hay báo giá xe lăn bánh chi tiết? Hãy chat Zalo trực tiếp với em nhé.", "link" => "https://zalo.me/0817777855?text=Chào%20VinFast,%20tôi%20muốn%20nhận%20thêm%20thông%20tin%20tư%20vấn%20và%20chương%20trình%20khuyến%20mãi%20đặc%20quyền", "btn_text" => "Liên hệ Chat Zalo", "btn_class" => "btn-about-zalo"],
                ["title" => "Đăng ký trải nghiệm lái", "desc" => "Hãy trực tiếp cầm lái mẫu xe VinFast yêu thích của anh để cảm nhận động cơ điện bám đường cùng sự êm ái vượt bậc của xe thông minh.", "link" => "cars.php#booking-block", "btn_text" => "Đăng ký lái thử", "btn_class" => "btn-about-gold"],
                ["title" => "Bảng giá xe chính hãng", "desc" => "Tham khảo ngay bảng báo giá chính thức tất cả các dòng xe VinFast đang được trưng bày tại các hệ thống Showroom trên toàn quốc.", "link" => "pricelist.php", "btn_text" => "Xem bảng giá xe", "btn_class" => "btn-about-outline"]
            ];
        }
        
        // Tech Showcase variables
        $about_tech_tag = $settings['about_tech_tag'] ?? 'Công nghệ thông minh tiên phong';
        $about_tech_title = $settings['about_tech_title'] ?? 'Ba trụ cột công nghệ tiên phong';
        $about_tech_desc = $settings['about_tech_desc'] ?? 'Khám phá các di sản kỹ thuật cơ khí đỉnh cao tạo nên linh hồn và sự khác biệt vượt bậc của mỗi chiếc xe VinFast.';
        $about_tech_list_data = json_decode($settings['about_tech_list'] ?? '', true);
        if (!is_array($about_tech_list_data) || count($about_tech_list_data) < 3) {
            $about_tech_list_data = [
                [
                    "name" => "Trợ lý ViVi",
                    "tag" => "Trợ lý ảo thông minh tiếng Việt",
                    "title" => "Giao tiếp tự nhiên đa vùng miền",
                    "desc" => "Hiểu khẩu lệnh tiếng Việt đa vùng miền, giúp người lái dễ dàng điều khiển điều hòa, âm thanh, dẫn đường và cập nhật tin tức rảnh tay an toàn.",
                    "features" => "Nhận diện giọng nói đa vùng miền; Điều khiển chức năng xe bằng giọng nói; Hỏi đáp thông tin trực tuyến",
                    "image" => "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80"
                ],
                [
                    "name" => "ADAS",
                    "tag" => "Hệ thống trợ lái nâng cao",
                    "title" => "Tấm khiên bảo vệ chủ động",
                    "desc" => "Hỗ trợ di chuyển an toàn với các tính năng cảnh báo chệch làn, hỗ trợ giữ làn, phanh khẩn cấp tự động và camera 360 độ sắc nét.",
                    "features" => "Cảnh báo va chạm phía trước; Hỗ trợ đỗ xe thông minh; Phanh tự động khẩn cấp",
                    "image" => "https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&q=80"
                ],
                [
                    "name" => "Trạm Sạc",
                    "tag" => "Hạ tầng trạm sạc phủ rộng",
                    "title" => "An tâm di chuyển muôn nơi",
                    "desc" => "Mạng lưới hơn 150.000 cổng sạc đa công suất được quy hoạch đồng bộ tại các bãi đỗ xe, trung tâm thương mại, chung cư và trạm dừng nghỉ quốc lộ.",
                    "features" => "Trạm sạc nhanh DC 150kW/250kW; An toàn chống cháy nổ tiêu chuẩn châu Âu; Quản lý sạc qua App thông minh",
                    "image" => "https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80"
                ]
            ];
        }

        $installment_interest_default = $settings['installment_interest_default'] ?? '6.9';
        $installment_disclaimer = $settings['installment_disclaimer'] ?? '';
        $installment_features = $settings['installment_features'] ?? '';
        $installment_eligibility = $settings['installment_eligibility'] ?? '';
        $installment_docs_personal = $settings['installment_docs_personal'] ?? '';
        $installment_docs_business = $settings['installment_docs_business'] ?? '';
        
        $installment_banks_data = json_decode($settings['installment_banks'] ?? '', true);
        if (!is_array($installment_banks_data)) {
            $installment_banks_data = [
                ["name" => "Vietcombank (Ngân hàng TMCP Ngoại thương Việt Nam)", "rate" => "6.9", "max_loan" => "80", "max_years" => "8"],
                ["name" => "Techcombank (Ngân hàng TMCP Kỹ thương Việt Nam)", "rate" => "7.5", "max_loan" => "85", "max_years" => "8"],
                ["name" => "Shinhan Bank (Ngân hàng Shinhan Việt Nam)", "rate" => "6.5", "max_loan" => "80", "max_years" => "8"],
                ["name" => "MB Bank (Ngân hàng TMCP Quân đội)", "rate" => "7.2", "max_loan" => "80", "max_years" => "8"],
                ["name" => "VIB (Ngân hàng TMCP Quốc tế Việt Nam)", "rate" => "7.9", "max_loan" => "85", "max_years" => "8"],
                ["name" => "Sacombank (Ngân hàng TMCP Sài Gòn Thương Tín)", "rate" => "7.0", "max_loan" => "80", "max_years" => "8"]
            ];
        }

        $installment_steps_data = json_decode($settings['installment_steps'] ?? '', true);
        if (!is_array($installment_steps_data)) {
            $installment_steps_data = [
                ["title" => "Tư vấn & Lập phương án", "desc" => "Đội ngũ chuyên viên tài chính VinFast tiếp nhận nhu cầu, hỗ trợ phân tích ngân sách và đề xuất ngân hàng liên kết tối ưu nhất."],
                ["title" => "Chuẩn bị & Thẩm định hồ sơ", "desc" => "Quý khách chuẩn bị các giấy tờ pháp lý và nguồn thu cơ bản. Ngân hàng tiến hành thu thập, thẩm định nhanh chóng."],
                ["title" => "Phê duyệt & Đặt cọc", "desc" => "Sau khi có thông báo tài trợ cho vay từ ngân hàng, quý khách hoàn tất thủ tục ký hợp đồng mua bán và nộp phần đối ứng."],
                ["title" => "Giải ngân & Nhận xe", "desc" => "Ngân hàng thực hiện giải ngân thanh toán nốt phần còn lại, quý khách đến nhận xe bàn giao kèm đầy đủ hồ sơ lăn bánh."]
            ];
        }

        $allCarsForSettings = [];
        try {
            $stmt = $db->query("SELECT model_name FROM cars ORDER BY segment ASC, price ASC");
            $allCarsForSettings = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
        } catch (Exception $e) {}

        $installment_showcases_data = json_decode($settings['installment_showcases'] ?? '', true);
        if (!is_array($installment_showcases_data)) {
            $installment_showcases_data = [
                [
                    "tag" => "SUV ĐÔ THỊ ĐA DỤNG",
                    "title" => "VinFast VF 3 / VF 5 Plus",
                    "desc" => "Trải nghiệm sự tinh tế vượt trội với mức chi phí đầu tư ban đầu cực kỳ nhẹ nhàng.",
                    "image" => "https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?auto=format&fit=crop&w=600&q=80",
                    "prepay" => "Chỉ từ 36 Triệu",
                    "monthly" => "3.5 Triệu / tháng",
                    "preset" => "VinFast VF 3"
                ],
                [
                    "tag" => "SUV CỠ TRUNG THỜI THƯỢNG",
                    "title" => "VinFast VF 6 / VF 8 AWD",
                    "desc" => "Không gian rộng rãi, tiện nghi ngập tràn cho cả gia đình cùng hệ dẫn động AWD danh tiếng.",
                    "image" => "https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=600&q=80",
                    "prepay" => "Chỉ từ 150 Triệu",
                    "monthly" => "7.5 Triệu / tháng",
                    "preset" => "VinFast VF 8"
                ],
                [
                    "tag" => "SIÊU PHẨM ĐIỆN TƯƠNG LAI",
                    "title" => "VinFast VF 9 / SUV",
                    "desc" => "Trải nghiệm kỷ nguyên xe điện thể thao hiệu năng cao đỉnh cao với ưu đãi thuế trước bạ 0%.",
                    "image" => "https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=600&q=80",
                    "prepay" => "Chỉ từ 280 Triệu",
                    "monthly" => "15 Triệu / tháng",
                    "preset" => "VinFast VF 9 AWD"
                ]
            ];
        }

        $installment_gallery_data = json_decode($settings['installment_gallery'] ?? '', true);
        if (!is_array($installment_gallery_data)) {
            $installment_gallery_data = [
                [
                    "tag" => "KHÁCH HÀNG DOANH NHÂN",
                    "title" => "Bàn giao VinFast VF 9",
                    "desc" => "\"Hồ sơ phê duyệt chỉ trong 4 giờ và giải ngân nhanh chóng trong ngày giúp tôi kịp nhận xe trước chuyến công tác dài ngày. Rất hài lòng với sự chuyên nghiệp của đại lý.\"",
                    "image" => "https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80",
                    "customer_name" => "Anh Trần Minh H.",
                    "customer_role" => "CEO Công nghệ xanh"
                ],
                [
                    "tag" => "KHÁCH HÀNG GIA ĐÌNH VIP",
                    "title" => "Bàn giao VinFast VF 9 SUV",
                    "desc" => "\"Vợ chồng mình rất thích dòng VF 9 rộng rãi nhưng còn phân vân dòng tiền kinh doanh cuối năm. Nhờ phương án vay 8 năm lãi suất cố định của ngân hàng liên kết, mọi việc đã trở nên nhẹ nhàng.\"",
                    "image" => "https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=600&q=80",
                    "customer_name" => "Chị Đặng Thu T.",
                    "customer_role" => "Kinh doanh chuỗi Nhà hàng"
                ],
                [
                    "tag" => "PREMIUM VIP LOUNGE",
                    "title" => "Làm thủ tục tại Showroom",
                    "desc" => "\"Lần đầu mua xe sang và lựa chọn trả góp nhưng nhân viên tư vấn tận tình từng con số lẻ, làm việc minh bạch rõ ràng không phát sinh chi phí ngoài dự kiến.\"",
                    "image" => "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=600&q=80",
                    "customer_name" => "Anh Hoàng Vũ L.",
                    "customer_role" => "Nhà đầu tư Tài chính"
                ]
            ];
        }

        $installment_faqs_data = json_decode($settings['installment_faqs'] ?? '', true);
        if (!is_array($installment_faqs_data)) {
            $installment_faqs_data = [
                [
                    "question" => "Thủ tục mua xe trả góp cần chuẩn bị những hồ sơ cơ bản nào?",
                    "answer" => "Đối với khách hàng cá nhân, anh/chị cần CCCD gắn chip (hoặc định danh VNeID mức độ 2), đăng ký kết hôn (nếu đã kết hôn) hoặc chứng nhận độc thân. Về hồ sơ thu nhập cần hợp đồng lao động, sao kê lương 3-6 tháng gần nhất. Với doanh nghiệp cần Giấy phép kinh doanh, báo cáo tài chính nội bộ hoặc sao kê tài khoản ngân hàng của công ty."
                ],
                [
                    "question" => "Hạn mức vay mua xe VinFast tối đa là bao nhiêu và tôi cần trả trước bao nhiêu?",
                    "answer" => "Các ngân hàng đối tác liên kết của VinFast Việt Nam hỗ trợ hạn mức cho vay tối đa từ 80% lên đến 85% giá trị xe trên hóa đơn (đối với dòng xe xăng thông thường) và hỗ trợ tài sản thế chấp độc lập khác. Quý khách chỉ cần chuẩn bị tối thiểu 15% - 20% giá trị đối ứng xe để tiến hành làm thủ tục giải ngân."
                ],
                [
                    "question" => "Thời gian phê duyệt khoản vay mất bao lâu và xe có được giải ngân nhận ngay không?",
                    "answer" => "Nhờ quy trình số hóa và cam kết liên kết đặc quyền, thời gian thẩm duyệt hồ sơ tại các ngân hàng đối tác chỉ từ 4 đến 24 giờ làm việc kể từ khi nhận đủ tài liệu. Ngay sau khi có thông báo cho vay và quý khách hoàn tất thủ tục đăng ký xe lấy biển số, ngân hàng sẽ thực hiện giải ngân trong vòng 2 giờ để quý khách nhận bàn giao xe."
                ],
                [
                    "question" => "Tôi có thể tất toán khoản vay trước hạn được không và mức phí phạt là bao nhiêu?",
                    "answer" => "Quý khách hoàn toàn có thể tất toán (trả hết) khoản vay trước thời hạn đăng ký bất kỳ lúc nào. Phí tất toán trước hạn được áp dụng theo quy định của từng ngân hàng đối tác liên kết, thông thường dao động từ 1% đến 3% trên dư nợ gốc còn lại trong 3 năm đầu, và thường được miễn phí hoàn toàn kể từ năm thứ 4 hoặc thứ 5 trở đi."
                ]
            ];
        }

        $pricelist_intro_headline = $settings['pricelist_intro_headline'] ?? 'Bảng giá xe VinFast mới nhất tại Việt Nam';
        $pricelist_intro_desc = $settings['pricelist_intro_desc'] ?? '';
        $pricelist_tax_note = $settings['pricelist_tax_note'] ?? '';
        $pricelist_editorial = $settings['pricelist_editorial'] ?? '';
        
        $pricelist_downloads_data = json_decode($settings['pricelist_downloads'] ?? '', true);
        if (!is_array($pricelist_downloads_data)) {
            $pricelist_downloads_data = [
                ["title" => "Bảng giá lăn bánh chi tiết các dòng xe VinFast 2026", "url" => "#"],
                ["title" => "Catalog thông số kỹ thuật xe thuần điện VinFast VF 9", "url" => "#"],
                ["title" => "Catalog & Đặc tính kỹ thuật dòng SUV cao cấp VinFast VF 9 AWD", "url" => "#"]
            ];
        }

        $pricelist_promos_data = json_decode($settings['pricelist_promos'] ?? '', true);
        if (!is_array($pricelist_promos_data)) {
            $pricelist_promos_data = [
                [
                    "model_name" => "VinFast VF 9 AWD",
                    "promo" => "Hỗ trợ 100% lệ phí trước bạ (trị giá 0đ theo chính sách hỗ trợ phát triển xe xanh của Chính phủ) + Tặng gói dịch vụ cứu hộ Roadside Assistance độc quyền 3 năm.",
                    "gifts" => "Bộ sạc treo tường thông minh B? s?c VinFast Wallbox 11kW chính hãng (trị giá 45 triệu VNĐ) | Thảm lót sàn da EV cao cấp thiết kế riêng biệt | Móc khóa lưu niệm VinFast carbon thời thượng"
                ],
                [
                    "model_name" => "VinFast VF 6 Plus",
                    "promo" => "Tặng 50% lệ phí trước bạ (khấu trừ trực tiếp 35 triệu VNĐ vào giá trị hợp đồng) + Tặng thêm bảo hiểm vật chất 1 năm.",
                    "gifts" => "Thảm lót sàn da 5D cao cấp thiết kế riêng biệt theo phom xe | Ví da cao cấp VIP đựng hồ sơ giấy tờ xe của VinFast | Dù che mưa VinFast Collection gấp gọn thời trang"
                ],
                [
                    "model_name" => "VinFast VF 8 Plus",
                    "promo" => "Tặng 100% lệ phí trước bạ (trị giá lên tới 120 triệu VNĐ) + Tặng thêm gói miễn phí bảo dưỡng chính hãng trong 3 năm đầu.",
                    "gifts" => "Camera hành trình 4K định vị GPS tích hợp bản đồ dẫn đường | Bệ bước chân lên xuống hợp kim cao cấp chịu lực | Vali kéo du lịch kéo tay VinFast VIP thời thượng"
                ]
            ];
        }

        $pricelist_faqs_data = json_decode($settings['pricelist_faqs'] ?? '', true);
        if (!is_array($pricelist_faqs_data)) {
            $pricelist_faqs_data = [
                [
                    "question" => "Giá xe VinFast lăn bánh tại Việt Nam bao gồm những chi phí nào?",
                    "answer" => "Giá xe VinFast lăn bánh bao gồm giá niêm yết xe từ nhà phân phối và các khoản chi phí bắt buộc theo luật định: lệ phí trước bạ (10% - 12% tùy địa phương), phí cấp biển số (20 triệu VNĐ tại HN & TP.HCM, 2 triệu VNĐ tại các tỉnh khác), phí đường bộ 12 tháng (1.560.000 VNĐ), bảo hiểm trách nhiệm dân sự bắt buộc (480.000 VNĐ) và phí đăng kiểm xe (340.000 VNĐ)."
                ],
                [
                    "question" => "Mua xe điện VinFast EV được hưởng chính sách ưu đãi gì?",
                    "answer" => "Hiện nay, theo chính sách khuyến khích xe xanh của nhà nước, xe ô tô điện chạy pin như VinFast EV được áp dụng mức lệ phí trước bạ là 0%. Điều này giúp tổng chi phí lăn bánh của xe điện tiết kiệm hơn xe động cơ xăng truyền thống tương đương hàng trăm triệu đồng."
                ],
                [
                    "question" => "Tôi có thể mua xe VinFast trả góp với hạn mức tối đa bao nhiêu?",
                    "answer" => "Đại lý VinFast liên kết với hệ thống ngân hàng lớn hỗ trợ khách hàng mua xe trả góp lên đến 70% - 80% giá trị xe niêm yết, thời hạn vay linh hoạt đến 84 tháng (7 năm). Lãi suất áp dụng cực kỳ ưu đãi chỉ từ 7.9%/năm với thủ tục xét duyệt hồ sơ nhanh gọn."
                ]
            ];
        }

        $activeCmsTab = 'homepage';
        if (isset($_GET['edit_post_id']) || (isset($_POST['action']) && in_array($_POST['action'], ['create_post', 'edit_post', 'delete_post', 'save_seo']))) {
            $activeCmsTab = 'news';
        } elseif (isset($_POST['action'])) {
            if ($_POST['action'] === 'save_about') $activeCmsTab = 'about';
            elseif ($_POST['action'] === 'save_installment_info') $activeCmsTab = 'installment';
            elseif ($_POST['action'] === 'save_pricelist_info') $activeCmsTab = 'pricelist';
            elseif ($_POST['action'] === 'save_forms_config') $activeCmsTab = 'forms';
        }
      ?>

      <!-- Sleek Horizontal Navigation Tabs -->
      <div class="cms-tabs-container" style="margin-bottom: 24px;">
        <div class="cms-tabs" style="display: flex; gap: 8px; border-bottom: 1px solid var(--color-border); padding-bottom: 12px; overflow-x: auto; -webkit-overflow-scrolling: touch;">
          <button class="cms-tab-btn" onclick="switchCmsTab('homepage')" style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-border); color: var(--color-text-white); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; border-radius: 6px; transition: all 0.3s ease;">🏠 Trang Chủ</button>
          <button class="cms-tab-btn" onclick="switchCmsTab('forms')" style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-border); color: var(--color-text-white); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; border-radius: 6px; transition: all 0.3s ease;">📋 Form Đăng Ký & Popup</button>
          <button class="cms-tab-btn" onclick="switchCmsTab('about')" style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-border); color: var(--color-text-white); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; border-radius: 6px; transition: all 0.3s ease;">ℹ️ Giới Thiệu</button>
          <button class="cms-tab-btn" onclick="switchCmsTab('installment')" style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-border); color: var(--color-text-white); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; border-radius: 6px; transition: all 0.3s ease;">💰 Trả Góp</button>
          <button class="cms-tab-btn" onclick="switchCmsTab('pricelist')" style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-border); color: var(--color-text-white); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; border-radius: 6px; transition: all 0.3s ease;">🏷️ Bảng Giá</button>
          <button class="cms-tab-btn" onclick="switchCmsTab('news')" style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-border); color: var(--color-text-white); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; border-radius: 6px; transition: all 0.3s ease;">📰 Tin Tức & Lái Thử</button>
        </div>
      </div>

      <style>
        .cms-tab-btn.active-tab {
          background: rgba(25, 96, 215, 0.12) !important;
          color: var(--color-primary) !important;
          border-color: var(--color-primary) !important;
          box-shadow: 0 0 10px rgba(25, 96, 215,0.15);
        }
        .cms-tab-content {
          animation: fadeInTab 0.4s ease;
        }
        @keyframes fadeInTab {
          from { opacity: 0; transform: translateY(6px); }
          to { opacity: 1; transform: translateY(0); }
        }
      </style>

      <!-- 1. HOMEPAGE TAB CONTENT -->
      <?php include __DIR__ . '/cms/homepage.php'; ?>

      <!-- 6. REGISTRATION FORMS & POPUPS TAB CONTENT -->
      <?php include __DIR__ . '/cms/forms.php'; ?>

      <!-- 2. ABOUT US TAB CONTENT -->
      <?php include __DIR__ . '/cms/about.php'; ?>

      <!-- 3. INSTALLMENT TAB CONTENT -->
      <?php include __DIR__ . '/cms/installment.php'; ?>

      <!-- 4. PRICELIST TAB CONTENT -->
      <?php include __DIR__ . '/cms/pricelist.php'; ?>

      <!-- 5. NEWS TAB CONTENT -->
      <?php include __DIR__ . '/cms/news.php'; ?>

      <!-- Helper Scripts for Partner banks list & downloads list -->
      <script>
        function removeBankRow(btn) {
            const row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) {
                row.remove();
            } else {
                alert('Phải giữ lại ít nhất một ngân hàng liên kết!');
            }
        }
        function removeShowcaseRow(btn) {
            const row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) {
                row.remove();
            } else {
                alert('Phải giữ lại ít nhất một phân khúc!');
            }
        }
        const availableCarModels = <?php echo json_encode($allCarsForSettings, JSON_UNESCAPED_UNICODE); ?>;

        function addShowcaseRow() {
            const tbody = document.querySelector('#showcases-editor-table tbody');
            const newRow = document.createElement('tr');
            let selectOptions = '';
            availableCarModels.forEach(car => {
                selectOptions += `<option value="${car}">${car}</option>`;
            });
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_tag[]" required value="" placeholder="Ví dụ: SEDAN SANG TRỌNG"></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_title[]" required value="" placeholder="Ví dụ: VinFast VF 5 / VF 8"></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_desc[]" required value=""></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_image[]" required value="" placeholder="Dán URL ảnh..."></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_prepay[]" required value="" placeholder="Ví dụ: Chỉ từ 360 Triệu"></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_monthly[]" required value="" placeholder="Ví dụ: 18 Triệu / tháng"></td>
              <td>
                <select class="form-input" style="height:32px; font-size:11px; padding: 4px;" name="showcase_preset[]" required>
                  ${selectOptions}
                </select>
              </td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeShowcaseRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }

        function removeGalleryRow(btn) {
            const row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) {
                row.remove();
            } else {
                alert('Phải giữ lại ít nhất một slide bàn giao!');
            }
        }
        function addGalleryRow() {
            const tbody = document.querySelector('#gallery-editor-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_tag[]" required value="" placeholder="Ví dụ: KHÁCH HÀNG DOANH NHÂN"></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_title[]" required value="" placeholder="Ví dụ: Bàn giao VinFast VF 9"></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_desc[]" required value=""></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_image[]" required value="" placeholder="Dán URL ảnh..."></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_customer_name[]" required value="" placeholder="Ví dụ: Anh Trần Minh H."></td>
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_customer_role[]" required value="" placeholder="Ví dụ: CEO Công nghệ xanh"></td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeGalleryRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }

        function removeFaqRow(btn) {
            const row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) {
                row.remove();
            } else {
                alert('Phải giữ lại ít nhất một câu hỏi FAQ!');
            }
        }
        function addFaqRow() {
            const tbody = document.querySelector('#faqs-editor-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="faq_question[]" required value="" placeholder="Ví dụ: Thủ tục mua xe trả góp gồm những gì?"></td>
              <td><textarea class="form-input" style="min-height: 50px; font-size:11px; line-height: 1.4; padding: 4px 6px;" name="faq_answer[]" required></textarea></td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeFaqRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }

        function removePromoRow(btn) {
            const row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) {
                row.remove();
            } else {
                alert('Phải giữ lại ít nhất một dòng ưu đãi!');
            }
        }
        function addPromoRow() {
            const tbody = document.querySelector('#promos-editor-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="promo_model_name[]" required value="" placeholder="Ví dụ: VinFast VF 9 AWD"></td>
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="promo_text[]" required value="" placeholder="Ưu đãi trước bạ..."></td>
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="promo_gifts[]" required value="" placeholder="Quà tặng 1 | Quà tặng 2..."></td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removePromoRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }

        function removePrFaqRow(btn) {
            const row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) {
                row.remove();
            } else {
                alert('Phải giữ lại ít nhất một câu hỏi FAQ!');
            }
        }
        function addPrFaqRow() {
            const tbody = document.querySelector('#pr-faqs-editor-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="faq_question[]" required value="" placeholder="Ví dụ: Giá lăn bánh gồm những gì?"></td>
              <td><textarea class="form-input" style="min-height: 50px; font-size:11px; line-height: 1.4; padding: 4px 6px;" name="faq_answer[]" required></textarea></td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removePrFaqRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }

        function removeHmFaqRow(btn) {
            const row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) {
                row.remove();
            } else {
                alert('Phải giữ lại ít nhất một câu hỏi FAQ!');
            }
        }
        function addHmFaqRow() {
            const tbody = document.querySelector('#homepage-faq-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td style="padding: 8px 4px;"><input class="form-input" style="height:32px; font-size:11px;" type="text" name="faq_question[]" required value="" placeholder="Nhập câu hỏi..."></td>
              <td style="padding: 8px 4px;"><textarea class="form-input" style="min-height: 50px; font-size:11px; line-height: 1.4; padding: 4px 6px;" name="faq_answer[]" required></textarea></td>
              <td style="padding: 8px 4px; text-align: center;"><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeHmFaqRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }

        function addBankRow() {
            const tbody = document.querySelector('#banks-editor-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="bank_name[]" required value="" placeholder="Tên ngân hàng mới"></td>
              <td><input class="form-input" style="height:32px; font-size:12px;" type="number" step="0.01" name="bank_rate[]" required value="7.0"></td>
              <td><input class="form-input" style="height:32px; font-size:12px;" type="number" name="bank_max_loan[]" required value="80"></td>
              <td><input class="form-input" style="height:32px; font-size:12px;" type="number" name="bank_max_years[]" required value="8"></td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeBankRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }

        // Slides dynamic adding
        function addSlideRow() {
            const tbody = document.querySelector('#slides-editor-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="about_gallery_slide_title[]" required value="" placeholder="Tiêu đề slide mới"></td>
              <td>
                <input type="file" name="about_gallery_slide_file[]" accept="image/*" style="font-size:10px; display:block; margin-bottom:4px;">
                <input class="form-input" style="height:28px; font-size:11px; padding: 2px 6px;" type="text" name="about_gallery_slide_image[]" value="" placeholder="Dán URL ảnh hoặc để trống nếu tải lên...">
              </td>
              <td><textarea class="form-input" style="height:55px; font-size:12px; font-family:inherit; line-height:1.4; resize:vertical;" name="about_gallery_slide_desc[]" placeholder="Mô tả chi tiết slide..." required></textarea></td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeSlideRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }
        function removeSlideRow(btn) {
            btn.closest('tr').remove();
        }

        // Timeline dynamic adding
        function addTimelineRow() {
            const tbody = document.querySelector('#timeline-editor-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="about_history_year[]" required value="" placeholder="Ví dụ: 1980"></td>
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="about_history_milestone_title[]" required value="" placeholder="Tiêu đề mốc lịch sử"></td>
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="about_history_milestone_desc[]" required value="" placeholder="Mô tả cột mốc lịch sử"></td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeTimelineRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }
        function removeTimelineRow(btn) {
            btn.closest('tr').remove();
        }

        function removeDownloadRow(btn) {
            const row = btn.closest('tr');
            if (row.parentElement.rows.length > 1) {
                row.remove();
            } else {
                alert('Phải giữ lại ít nhất một tài liệu PDF!');
            }
        }
        function addDownloadRow() {
            const tbody = document.querySelector('#downloads-editor-table tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="dl_title[]" required value="" placeholder="Tên file tài liệu mới"></td>
              <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="dl_url[]" required value="#"></td>
              <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeDownloadRow(this)">Xóa</button></td>
            `;
            tbody.appendChild(newRow);
        }

        // Sleek JavaScript Tab Switcher
        function switchCmsTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.cms-tab-content').forEach(el => el.style.display = 'none');
            // Remove active class from all buttons
            document.querySelectorAll('.cms-tab-btn').forEach(btn => btn.classList.remove('active-tab'));
            
            // Show target content
            const targetContent = document.getElementById('cms-tab-' + tabId);
            if (targetContent) {
                targetContent.style.display = 'block';
            }
            
            // Activate target button
            const btn = document.querySelector(`button[onclick="switchCmsTab('${tabId}')"]`);
            if (btn) {
                btn.classList.add('active-tab');
            }
        }
        
        // Auto-activate default/routed tab
        document.addEventListener('DOMContentLoaded', function() {
            switchCmsTab('<?php echo $activeCmsTab; ?>');
        });

        // ==========================================================================
        // DYNAMIC SEO WRITING ASSISTANT & GOOGLE SERP PREVIEW ENGINE (20 CRITERIA SYSTEM)
        // ==========================================================================
        document.addEventListener("DOMContentLoaded", () => {
            const titleInput = document.getElementById("post_title");
            const summaryInput = document.getElementById("post_summary");
            const categorySelect = document.getElementById("post_category");

            if (!titleInput || !summaryInput) return;

            // Live Elements in Sidebar
            const previewTitle = document.getElementById("seo-preview-title");
            const previewSnippet = document.getElementById("seo-preview-snippet");
            const previewSlug = document.getElementById("seo-preview-slug");
            const scoreBadge = document.getElementById("seo-score-badge");
            
            // Rules status elements - Pillar 1: SEO Tiêu Đề & URL
            const ruleTitleLenIcon = document.getElementById("rule-title-len-icon");
            const ruleTitleLenText = document.getElementById("rule-title-len-text");
            const ruleTitleKwIcon = document.getElementById("rule-title-kw-icon");
            const ruleTitleKwText = document.getElementById("rule-title-kw-text");
            const ruleTitleStartKwIcon = document.getElementById("rule-title-start-kw-icon");
            const ruleTitleStartKwText = document.getElementById("rule-title-start-kw-text");
            const ruleSlugKwIcon = document.getElementById("rule-slug-kw-icon");
            const ruleSlugKwText = document.getElementById("rule-slug-kw-text");
            const ruleTitlePowerIcon = document.getElementById("rule-title-power-icon");
            const ruleTitlePowerText = document.getElementById("rule-title-power-text");

            // Pillar 2: Tóm tắt & Nội dung chính
            const ruleDescLenIcon = document.getElementById("rule-desc-len-icon");
            const ruleDescLenText = document.getElementById("rule-desc-len-text");
            const ruleDescKwIcon = document.getElementById("rule-desc-kw-icon");
            const ruleDescKwText = document.getElementById("rule-desc-kw-text");
            const ruleWordsIcon = document.getElementById("rule-words-icon");
            const ruleWordsText = document.getElementById("rule-words-text");
            const ruleDensityIcon = document.getElementById("rule-density-icon");
            const ruleDensityText = document.getElementById("rule-density-text");
            const ruleIntroKwIcon = document.getElementById("rule-intro-kw-icon");
            const ruleIntroKwText = document.getElementById("rule-intro-kw-text");

            // Pillar 3: Cấu Trúc & Độ Dễ Đọc
            const ruleConclusionKwIcon = document.getElementById("rule-conclusion-kw-icon");
            const ruleConclusionKwText = document.getElementById("rule-conclusion-kw-text");
            const ruleHeadingsIcon = document.getElementById("rule-headings-icon");
            const ruleHeadingsText = document.getElementById("rule-headings-text");
            const ruleHeadingKwIcon = document.getElementById("rule-heading-kw-icon");
            const ruleHeadingKwText = document.getElementById("rule-heading-kw-text");
            const ruleBoldingIcon = document.getElementById("rule-bolding-icon");
            const ruleBoldingText = document.getElementById("rule-bolding-text");
            const ruleReadabilityIcon = document.getElementById("rule-readability-icon");
            const ruleReadabilityText = document.getElementById("rule-readability-text");

            // Pillar 4: Liên Kết & Hình Ảnh
            const ruleImgPresenceIcon = document.getElementById("rule-img-presence-icon");
            const ruleImgPresenceText = document.getElementById("rule-img-presence-text");
            const ruleImgAltIcon = document.getElementById("rule-img-alt-icon");
            const ruleImgAltText = document.getElementById("rule-img-alt-text");
            const ruleImgAltKwIcon = document.getElementById("rule-img-alt-kw-icon");
            const ruleImgAltKwText = document.getElementById("rule-img-alt-kw-text");
            const ruleLinkPresenceIcon = document.getElementById("rule-link-presence-icon");
            const ruleLinkPresenceText = document.getElementById("rule-link-presence-text");
            const ruleLinkAnchorIcon = document.getElementById("rule-link-anchor-icon");
            const ruleLinkAnchorText = document.getElementById("rule-link-anchor-text");

            // Pillar Score Trackers
            const scorePillarBasic = document.getElementById("score-pillar-basic");
            const scorePillarContent = document.getElementById("score-pillar-content");
            const scorePillarStructure = document.getElementById("score-pillar-structure");
            const scorePillarLinks = document.getElementById("score-pillar-links");

            const smartTagsContainer = document.getElementById("seo-smart-tags");

            // Smart Keywords based on Category
            const categoryKeywords = {
                "Chương trình khuyến mãi": ["ưu đãi", "khuyến mãi", "giá lăn bánh", "trước bạ", "quà tặng", "trả góp"],
                "Thế giới VinFast": ["VinFast EV", "AWD", "matrix led", "xe điện", "xe điện thông minh", "đẳng cấp"],
                "Bảo dưỡng & Bảo hành": ["bảo dưỡng", "chính hãng", "phụ tùng chính hãng", "bảo hành", "kỹ thuật viên"],
                "Tin tuyển dụng": ["tuyển dụng", "việc làm", "cơ hội nghề nghiệp", "VinFast", "hồ chí minh"],
                "Báo giá theo địa phương": ["báo giá", "VinFast sài gòn", "lăn bánh tphcm", "showroom VinFast", "giá xe"]
            };

            // Helper to generate dynamic slugs
            const getSlug = (text) => {
                return text.toString().toLowerCase()
                    .replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a')
                    .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e')
                    .replace(/í|ì|ỉ|ĩ|ị/g, 'i')
                    .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o')
                    .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u')
                    .replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y')
                    .replace(/đ/g, 'd')
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');            // Trim - from end of text
            };

            const updateSeoAnalysis = () => {
                const titleVal = titleInput.value.trim();
                const summaryVal = summaryInput.value.trim();
                const categoryVal = categorySelect.value;
                
                const focusKeywordEl = document.getElementById("seo_focus_keyword");
                const keywordVal = focusKeywordEl ? focusKeywordEl.value.trim().toLowerCase() : "";
                const cleanKw = keywordVal.trim();
                
                // Get content from TinyMCE if active, fallback to textarea value
                let contentVal = "";
                if (typeof tinymce !== "undefined" && tinymce.get("post_content")) {
                    contentVal = tinymce.get("post_content").getContent();
                } else {
                    const textarea = document.getElementById("post_content");
                    if (textarea) {
                        contentVal = textarea.value;
                    }
                }
                
                // Strip HTML tags for clean text analysis
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = contentVal;
                const textOnly = tempDiv.textContent || tempDiv.innerText || "";
                
                // Clean words count
                const words = textOnly.trim().split(/\s+/).filter(w => w.length > 0);
                const wordCount = words.length;
                
                let score = 0;
                
                // Pillar passed rules trackers
                let basicPassed = 0;
                let contentPassed = 0;
                let structurePassed = 0;
                let linksPassed = 0;

                // ===================================================
                // PILLAR 1: TIÊU ĐỀ & URL (Title & URL - Max 5 Rules)
                // ===================================================
                
                // 1.1 Title Length (Ideal: 50 - 65 chars)
                const titleLength = titleVal.length;
                if (titleLength === 0) {
                    previewTitle.textContent = "Tiêu đề bài viết của anh... | VinFast Việt Nam";
                    ruleTitleLenIcon.textContent = "🔴";
                    ruleTitleLenText.innerHTML = "Độ dài tiêu đề (Mục tiêu: 50 - 65 ký tự - Hiện là 0).";
                } else {
                    previewTitle.textContent = `${titleVal} | VinFast Việt Nam`;
                    previewSlug.textContent = getSlug(titleVal);
                    
                    if (titleLength >= 50 && titleLength <= 65) {
                        score += 5;
                        basicPassed++;
                        ruleTitleLenIcon.textContent = "🟢";
                        ruleTitleLenText.innerHTML = `<span style='color:#a5d6a7;'>Độ dài lý tưởng! (${titleLength} ký tự)</span>`;
                    } else if (titleLength > 0 && titleLength < 50) {
                        score += 2;
                        ruleTitleLenIcon.textContent = "🟡";
                        ruleTitleLenText.innerHTML = `<span style='color:#ffe082;'>Tiêu đề hơi ngắn (${titleLength}/50 ký tự).</span>`;
                    } else {
                        score += 1;
                        ruleTitleLenIcon.textContent = "🔴";
                        ruleTitleLenText.innerHTML = `<span style='color:#ff8a80;'>Tiêu đề quá dài (${titleLength}/65 ký tự - Google sẽ cắt bớt).</span>`;
                    }
                }

                // 1.2 Focus Keyword in Title
                if (cleanKw !== "") {
                    if (titleVal.toLowerCase().includes(cleanKw)) {
                        score += 5;
                        basicPassed++;
                        ruleTitleKwIcon.textContent = "🟢";
                        ruleTitleKwText.innerHTML = `<span style='color:#a5d6a7;'>Đã chèn từ khóa chính vào Tiêu đề!</span>`;
                    } else {
                        ruleTitleKwIcon.textContent = "🔴";
                        ruleTitleKwText.innerHTML = `<span style='color:#ff8a80;'>Từ khóa "${cleanKw}" chưa xuất hiện trong Tiêu đề.</span>`;
                    }
                } else {
                    ruleTitleKwIcon.textContent = "🔴";
                    ruleTitleKwText.textContent = "Hãy nhập từ khóa chính ở ô phía trên.";
                }

                // 1.3 Focus Keyword at Start of Title (within first 3 words or first 50%)
                if (cleanKw !== "" && titleVal.length > 0) {
                    const lowercaseTitle = titleVal.toLowerCase();
                    const kwPos = lowercaseTitle.indexOf(cleanKw);
                    if (kwPos !== -1) {
                        const wordsBefore = lowercaseTitle.substring(0, kwPos).trim().split(/\s+/).filter(w => w.length > 0).length;
                        if (wordsBefore <= 3 || kwPos < titleVal.length / 2) {
                            score += 5;
                            basicPassed++;
                            ruleTitleStartKwIcon.textContent = "🟢";
                            ruleTitleStartKwText.innerHTML = `<span style='color:#a5d6a7;'>Từ khóa xuất hiện tại vị trí đầu tiêu đề (Rất tốt cho SEO).</span>`;
                        } else {
                            score += 2;
                            ruleTitleStartKwIcon.textContent = "🟡";
                            ruleTitleStartKwText.innerHTML = `<span style='color:#ffe082;'>Từ khóa nằm hơi sâu. Hãy đẩy từ khóa lên đầu tiêu đề.</span>`;
                        }
                    } else {
                        ruleTitleStartKwIcon.textContent = "🔴";
                        ruleTitleStartKwText.innerHTML = `<span style='color:#ff8a80;'>Chưa có từ khóa chính để kiểm tra vị trí.</span>`;
                    }
                } else {
                    ruleTitleStartKwIcon.textContent = "🔴";
                    ruleTitleStartKwText.textContent = "Từ khóa xuất hiện ở phần đầu Tiêu đề.";
                }

                // 1.4 Focus Keyword in Slug / URL
                if (cleanKw !== "" && titleVal.length > 0) {
                    const slugTitle = getSlug(titleVal);
                    const slugKw = getSlug(cleanKw);
                    if (slugTitle.includes(slugKw)) {
                        score += 5;
                        basicPassed++;
                        ruleSlugKwIcon.textContent = "🟢";
                        ruleSlugKwText.innerHTML = `<span style='color:#a5d6a7;'>Hoàn hảo! URL chứa cụm từ khóa chính.</span>`;
                    } else {
                        ruleSlugKwIcon.textContent = "🔴";
                        ruleSlugKwText.innerHTML = `<span style='color:#ff8a80;'>Từ khóa chính chưa hiển thị trong URL/Slug.</span>`;
                    }
                } else {
                    ruleSlugKwIcon.textContent = "🔴";
                    ruleSlugKwText.textContent = "Từ khóa chính xuất hiện trong Slug (URL).";
                }

                // 1.5 Title Click Attractiveness (Sentiment check - numbers or power words)
                if (titleVal.length > 0) {
                    const powerWords = ["mới nhất", "giá", "trả góp", "khuyến mãi", "ưu đãi", "chính hãng", "bảo hành", "bảo dưỡng", "thông số", "đánh giá", "EV", "xe sang", "lăn bánh", "sài gòn", "hà nội"];
                    const hasNumber = /\d+/.test(titleVal);
                    let hasPowerWord = false;
                    
                    for (let w of powerWords) {
                        if (titleVal.toLowerCase().includes(w)) {
                            hasPowerWord = true;
                            break;
                        }
                    }

                    if (hasNumber || hasPowerWord) {
                        score += 5;
                        basicPassed++;
                        ruleTitlePowerIcon.textContent = "🟢";
                        ruleTitlePowerText.innerHTML = `<span style='color:#a5d6a7;'>Tiêu đề hấp dẫn! Chứa ${hasNumber ? 'con số' : ''} ${hasPowerWord ? 'từ khóa kích thích click' : ''}.</span>`;
                    } else {
                        score += 2;
                        ruleTitlePowerIcon.textContent = "🟡";
                        ruleTitlePowerText.innerHTML = `<span style='color:#ffe082;'>Nên chèn thêm con số (năm 2026) hoặc các từ khóa như "Giá", "Ưu đãi", "Lăn bánh".</span>`;
                    }
                } else {
                    ruleTitlePowerIcon.textContent = "🔴";
                    ruleTitlePowerText.textContent = "Tiêu đề chứa số hoặc từ khóa thu hút click (CTR).";
                }

                // Update Pillar 1 Score
                if (scorePillarBasic) {
                    scorePillarBasic.textContent = basicPassed + "/5 Đạt";
                    scorePillarBasic.style.color = (basicPassed === 5) ? "#a5d6a7" : "var(--color-text-muted)";
                }


                // ===================================================
                // PILLAR 2: TỐI ƯU TÓM TẮT & NỘI DUNG (Max 5 Rules)
                // ===================================================
                
                // 2.1 Description Length (Ideal: 120 - 165 chars)
                const summaryLength = summaryVal.length;
                if (summaryLength === 0) {
                    previewSnippet.textContent = "Nhập tóm tắt ngắn cho bài viết tin tức hoặc chương trình ưu đãi để Google hiển thị mô tả bài viết tại đây...";
                    ruleDescLenIcon.textContent = "🔴";
                    ruleDescLenText.innerHTML = "Độ dài tóm tắt / Mô tả (Mục tiêu: 120 - 165 ký tự - Hiện là 0).";
                } else {
                    previewSnippet.textContent = summaryVal;
                    if (summaryLength >= 120 && summaryLength <= 165) {
                        score += 5;
                        contentPassed++;
                        ruleDescLenIcon.textContent = "🟢";
                        ruleDescLenText.innerHTML = `<span style='color:#a5d6a7;'>Độ dài tóm tắt hoàn hảo! (${summaryLength} ký tự)</span>`;
                    } else if (summaryLength > 0 && summaryLength < 120) {
                        score += 2;
                        ruleDescLenIcon.textContent = "🟡";
                        ruleDescLenText.innerHTML = `<span style='color:#ffe082;'>Tóm tắt hơi ngắn (${summaryLength}/120 ký tự).</span>`;
                    } else {
                        score += 1;
                        ruleDescLenIcon.textContent = "🔴";
                        ruleDescLenText.innerHTML = `<span style='color:#ff8a80;'>Tóm tắt quá dài (${summaryLength}/165 ký tự - Google sẽ cắt bớt).</span>`;
                    }
                }

                // 2.2 Keyword in Description
                if (cleanKw !== "") {
                    if (summaryVal.toLowerCase().includes(cleanKw)) {
                        score += 5;
                        contentPassed++;
                        ruleDescKwIcon.textContent = "🟢";
                        ruleDescKwText.innerHTML = `<span style='color:#a5d6a7;'>Đã chèn từ khóa chính vào Tóm tắt!</span>`;
                    } else {
                        ruleDescKwIcon.textContent = "🔴";
                        ruleDescKwText.innerHTML = `<span style='color:#ff8a80;'>Từ khóa "${cleanKw}" chưa xuất hiện trong Tóm tắt.</span>`;
                    }
                } else {
                    ruleDescKwIcon.textContent = "🔴";
                    ruleDescKwText.textContent = "Hãy nhập từ khóa chính ở ô phía trên.";
                }

                // 2.3 Article Word Count (Min 600 words)
                if (wordCount === 0) {
                    ruleWordsIcon.textContent = "🔴";
                    ruleWordsText.textContent = "Mục tiêu tối thiểu 600 từ cho bài viết chuyên sâu.";
                } else {
                    if (wordCount >= 600) {
                        score += 5;
                        contentPassed++;
                        ruleWordsIcon.textContent = "🟢";
                        ruleWordsText.innerHTML = `<span style='color:#a5d6a7;'>Đạt chuẩn Pillar Content! (${wordCount} từ)</span>`;
                    } else if (wordCount >= 300) {
                        score += 2;
                        ruleWordsIcon.textContent = "🟡";
                        ruleWordsText.innerHTML = `<span style='color:#ffe082;'>Độ dài trung bình (${wordCount} từ). Viết thêm để tăng thứ hạng.</span>`;
                    } else {
                        ruleWordsIcon.textContent = "🔴";
                        ruleWordsText.innerHTML = `<span style='color:#ff8a80;'>Nội dung quá mỏng (${wordCount} từ). Cần tối thiểu 300-600 từ.</span>`;
                    }
                }

                // 2.4 Keyword Density (Ideal: 0.8% - 2.5%)
                let density = 0;
                if (wordCount > 0 && cleanKw !== "") {
                    const escapedKw = cleanKw.replace(/[-\/\^$*+?.()|[\]{}]/g, '\\$&');
                    const regex = new RegExp(escapedKw, 'gi');
                    const matches = textOnly.match(regex);
                    const kwCount = matches ? matches.length : 0;
                    density = (kwCount / wordCount) * 100;

                    if (density >= 0.8 && density <= 2.5) {
                        score += 5;
                        contentPassed++;
                        ruleDensityIcon.textContent = "🟢";
                        ruleDensityText.innerHTML = `<span style='color:#a5d6a7;'>Mật độ lý tưởng: ${density.toFixed(1)}% (Xuất hiện ${kwCount} lần).</span>`;
                    } else if (density > 2.5) {
                        score += 1;
                        ruleDensityIcon.textContent = "🔴";
                        ruleDensityText.innerHTML = `<span style='color:#ff8a80;'>Spam từ khóa! (${density.toFixed(1)}% - ${kwCount} lần). Google sẽ phạt.</span>`;
                    } else {
                        score += 2;
                        ruleDensityIcon.textContent = "🟡";
                        ruleDensityText.innerHTML = `<span style='color:#ffe082;'>Mật độ hơi thấp: ${density.toFixed(1)}% (${kwCount} lần). Hãy thêm từ khóa tự nhiên.</span>`;
                    }
                } else {
                    ruleDensityIcon.textContent = "🔴";
                    ruleDensityText.textContent = "Mật độ từ khóa chính khuyên dùng (0.8% - 2.5%).";
                }

                // 2.5 Keyword in Introduction (First 100 words)
                if (wordCount > 0 && cleanKw !== "") {
                    const first100Words = words.slice(0, 100).join(" ").toLowerCase();
                    if (first100Words.includes(cleanKw)) {
                        score += 5;
                        contentPassed++;
                        ruleIntroKwIcon.textContent = "🟢";
                        ruleIntroKwText.innerHTML = `<span style='color:#a5d6a7;'>Tuyệt vời! Từ khóa xuất hiện ngay trong 100 từ mở bài.</span>`;
                    } else {
                        ruleIntroKwIcon.textContent = "🔴";
                        ruleIntroKwText.innerHTML = `<span style='color:#ff8a80;'>Từ khóa chưa xuất hiện trong 100 từ mở bài.</span>`;
                    }
                } else {
                    ruleIntroKwIcon.textContent = "🔴";
                    ruleIntroKwText.textContent = "Từ khóa xuất hiện trong 100 từ đầu mở bài.";
                }

                // Update Pillar 2 Score
                if (scorePillarContent) {
                    scorePillarContent.textContent = contentPassed + "/5 Đạt";
                    scorePillarContent.style.color = (contentPassed === 5) ? "#a5d6a7" : "var(--color-text-muted)";
                }


                // ===================================================
                // PILLAR 3: CẤU TRÚC & ĐỘ DỄ ĐỌC (Max 5 Rules)
                // ===================================================
                
                // 3.1 Keyword in Conclusion (Last 150 words)
                if (wordCount > 150 && cleanKw !== "") {
                    const last150Words = words.slice(-150).join(" ").toLowerCase();
                    if (last150Words.includes(cleanKw)) {
                        score += 5;
                        structurePassed++;
                        ruleConclusionKwIcon.textContent = "🟢";
                        ruleConclusionKwText.innerHTML = `<span style='color:#a5d6a7;'>Xuất sắc! Từ khóa đã xuất hiện trong 150 từ kết bài.</span>`;
                    } else {
                        ruleConclusionKwIcon.textContent = "🔴";
                        ruleConclusionKwText.innerHTML = `<span style='color:#ff8a80;'>Hãy chèn lại từ khóa chính ở đoạn kết luận của bài.</span>`;
                    }
                } else {
                    ruleConclusionKwIcon.textContent = "🔴";
                    ruleConclusionKwText.textContent = "Từ khóa xuất hiện trong đoạn kết bài (150 từ cuối).";
                }

                // 3.2 Heading Tags (H2/H3/H4 presence)
                const headingTags = tempDiv.querySelectorAll("h2, h3, h4");
                if (headingTags.length > 0) {
                    score += 5;
                    structurePassed++;
                    ruleHeadingsIcon.textContent = "🟢";
                    ruleHeadingsText.innerHTML = `<span style='color:#a5d6a7;'>Bài viết phân bổ rất tốt, phát hiện ${headingTags.length} tiêu đề phụ.</span>`;
                } else {
                    ruleHeadingsIcon.textContent = "🔴";
                    ruleHeadingsText.innerHTML = `<span style='color:#ff8a80;'>Thiếu thẻ H2/H3. Phải chia nhỏ ý bài viết để tăng trải nghiệm.</span>`;
                }

                // 3.3 Keyword in Heading Tags
                if (headingTags.length > 0 && cleanKw !== "") {
                    let kwInHeading = false;
                    for (let h of headingTags) {
                        if (h.textContent.toLowerCase().includes(cleanKw)) {
                            kwInHeading = true;
                            break;
                        }
                    }
                    if (kwInHeading) {
                        score += 5;
                        structurePassed++;
                        ruleHeadingKwIcon.textContent = "🟢";
                        ruleHeadingKwText.innerHTML = `<span style='color:#a5d6a7;'>Tuyệt vời! Tiêu đề phụ H2/H3 đã chứa từ khóa chính.</span>`;
                    } else {
                        ruleHeadingKwIcon.textContent = "🔴";
                        ruleHeadingKwText.innerHTML = `<span style='color:#ff8a80;'>Từ khóa "${cleanKw}" chưa có trong tiêu đề phụ H2/H3 nào.</span>`;
                    }
                } else {
                    ruleHeadingKwIcon.textContent = "🔴";
                    ruleHeadingKwText.textContent = "Có từ khóa trong tiêu đề phụ H2/H3.";
                }

                // 3.4 Focus Keyword Bolding (strong / b tags)
                const boldTags = tempDiv.querySelectorAll("strong, b");
                if (boldTags.length > 0 && cleanKw !== "") {
                    let kwBolded = false;
                    for (let b of boldTags) {
                        if (b.textContent.toLowerCase().includes(cleanKw)) {
                            kwBolded = true;
                            break;
                        }
                    }
                    if (kwBolded) {
                        score += 5;
                        structurePassed++;
                        ruleBoldingIcon.textContent = "🟢";
                        ruleBoldingText.innerHTML = `<span style='color:#a5d6a7;'>Đã bôi đậm từ khóa chính nhằm tăng sức nặng.</span>`;
                    } else {
                        score += 2;
                        ruleBoldingIcon.textContent = "🟡";
                        ruleBoldingText.innerHTML = `<span style='color:#ffe082;'>Nên bôi đậm (in đậm) từ khóa chính 1-2 lần trong bài viết.</span>`;
                    }
                } else {
                    ruleBoldingIcon.textContent = "🔴";
                    ruleBoldingText.textContent = "Bôi đậm từ khóa chính để tạo điểm nhấn.";
                }

                // 3.5 Paragraph Length Readability (Paragraphs under 150 words)
                const paragraphs = tempDiv.querySelectorAll("p");
                let longParagraphsCount = 0;
                paragraphs.forEach(p => {
                    const pWords = p.textContent.trim().split(/\s+/).filter(w => w.length > 0).length;
                    if (pWords > 120) {
                        longParagraphsCount++;
                    }
                });

                if (paragraphs.length > 0) {
                    if (longParagraphsCount === 0) {
                        score += 5;
                        structurePassed++;
                        ruleReadabilityIcon.textContent = "🟢";
                        ruleReadabilityText.innerHTML = `<span style='color:#a5d6a7;'>Rất tốt! Tất cả đoạn văn đều ngắn gọn, dễ đọc trên di động.</span>`;
                    } else {
                        score += 2;
                        ruleReadabilityIcon.textContent = "🟡";
                        ruleReadabilityText.innerHTML = `<span style='color:#ffe082;'>Phát hiện ${longParagraphsCount} đoạn văn quá dài (>120 từ). Hãy ngắt dòng.</span>`;
                    }
                } else {
                    ruleReadabilityIcon.textContent = "🟢";
                    ruleReadabilityText.textContent = "Các đoạn văn ngắn gọn, dễ đọc (dưới 150 từ).";
                }

                // Update Pillar 3 Score
                if (scorePillarStructure) {
                    scorePillarStructure.textContent = structurePassed + "/5 Đạt";
                    scorePillarStructure.style.color = (structurePassed === 5) ? "#a5d6a7" : "var(--color-text-muted)";
                }


                // ===================================================
                // PILLAR 4: LIÊN KẾT & HÌNH ẢNH (Max 5 Rules)
                // ===================================================
                
                // 4.1 Image Presence
                const images = tempDiv.querySelectorAll("img");
                if (images.length > 0) {
                    score += 5;
                    linksPassed++;
                    ruleImgPresenceIcon.textContent = "🟢";
                    ruleImgPresenceText.innerHTML = `<span style='color:#a5d6a7;'>Đã chèn ${images.length} hình ảnh minh họa bài viết.</span>`;
                } else {
                    ruleImgPresenceIcon.textContent = "🔴";
                    ruleImgPresenceText.innerHTML = `<span style='color:#ff8a80;'>Bài viết chưa có ảnh. Cần ít nhất 1 ảnh để tăng sức hút.</span>`;
                }

                // 4.2 Image Alt text attribute
                if (images.length > 0) {
                    let missingAltCount = 0;
                    images.forEach(img => {
                        const alt = img.getAttribute("alt");
                        if (!alt || alt.trim() === "" || alt === "Image") {
                            missingAltCount++;
                        }
                    });

                    if (missingAltCount === 0) {
                        score += 5;
                        linksPassed++;
                        ruleImgAltIcon.textContent = "🟢";
                        ruleImgAltText.innerHTML = `<span style='color:#a5d6a7;'>100% hình ảnh đều chứa thẻ ALT mô tả đầy đủ.</span>`;
                    } else {
                        ruleImgAltIcon.textContent = "🔴";
                        ruleImgAltText.innerHTML = `<span style='color:#ff8a80;'>Phát hiện ${missingAltCount} ảnh thiếu mô tả ALT (Lỗi nghiêm trọng).</span>`;
                    }
                } else {
                    ruleImgAltIcon.textContent = "🔴";
                    ruleImgAltText.textContent = "Tất cả hình ảnh chèn vào bài phải có thẻ ALT.";
                }

                // 4.3 Focus Keyword in Image Alt
                if (images.length > 0 && cleanKw !== "") {
                    let kwInAlt = false;
                    images.forEach(img => {
                        const alt = img.getAttribute("alt");
                        if (alt && alt.toLowerCase().includes(cleanKw)) {
                            kwInAlt = true;
                        }
                    });

                    if (kwInAlt) {
                        score += 5;
                        linksPassed++;
                        ruleImgAltKwIcon.textContent = "🟢";
                        ruleImgAltKwText.innerHTML = `<span style='color:#a5d6a7;'>Đã chèn từ khóa chính vào thẻ ALT của ảnh thành công.</span>`;
                    } else {
                        score += 2;
                        ruleImgAltKwIcon.textContent = "🟡";
                        ruleImgAltKwText.innerHTML = `<span style='color:#ffe082;'>Từ khóa "${cleanKw}" chưa nằm trong mô tả thẻ ALT của ảnh nào.</span>`;
                    }
                } else {
                    ruleImgAltKwIcon.textContent = "🔴";
                    ruleImgAltKwText.textContent = "Có chứa từ khóa chính trong thẻ ALT của ảnh.";
                }

                // 4.4 Hyperlink Presence
                const links = tempDiv.querySelectorAll("a");
                if (links.length > 0) {
                    score += 5;
                    linksPassed++;
                    ruleLinkPresenceIcon.textContent = "🟢";
                    ruleLinkPresenceText.innerHTML = `<span style='color:#a5d6a7;'>Đạt chuẩn! Phát hiện ${links.length} liên kết chèn trong bài.</span>`;
                } else {
                    score += 2;
                    ruleLinkPresenceIcon.textContent = "🟡";
                    ruleLinkPresenceText.innerHTML = `<span style='color:#ffe082;'>Chưa có link. Hãy trỏ liên kết về các bài viết dịch vụ khác.</span>`;
                }

                // 4.5 Anchor Text Quality (Lazy words check)
                if (links.length > 0) {
                    const lazyAnchors = ["tại đây", "bấm vào", "click here", "xem thêm", "đọc thêm", "link", "đây", "tại link này"];
                    let lazyCount = 0;
                    links.forEach(a => {
                        const txt = a.textContent.toLowerCase().trim();
                        for (let lazy of lazyAnchors) {
                            if (txt === lazy || txt.includes(lazy)) {
                                lazyCount++;
                                break;
                            }
                        }
                    });

                    if (lazyCount === 0) {
                        score += 5;
                        linksPassed++;
                        ruleLinkAnchorIcon.textContent = "🟢";
                        ruleLinkAnchorText.innerHTML = `<span style='color:#a5d6a7;'>Tuyệt vời! Anchor text tự nhiên, ngữ cảnh hóa tốt.</span>`;
                    } else {
                        score += 1;
                        ruleLinkAnchorIcon.textContent = "🔴";
                        ruleLinkAnchorText.innerHTML = `<span style='color:#ff8a80;'>Phát hiện ${lazyCount} liên kết có neo chữ lười biếng ("tại đây", "xem thêm").</span>`;
                    }
                } else {
                    ruleLinkAnchorIcon.textContent = "🔴";
                    ruleLinkAnchorText.textContent = "Chất lượng Anchor text (Tránh từ khóa chung chung).";
                }

                // Update Pillar 4 Score
                if (scorePillarLinks) {
                    scorePillarLinks.textContent = linksPassed + "/5 Đạt";
                    scorePillarLinks.style.color = (linksPassed === 5) ? "#a5d6a7" : "var(--color-text-muted)";
                }

                // ===================================================
                // FINAL CALCULATIONS & BADGE RENDERING
                // ===================================================
                scoreBadge.textContent = "ĐIỂM: " + score + "/100";
                if (score >= 80) {
                    scoreBadge.style.background = "rgba(76, 175, 80, 0.15)";
                    scoreBadge.style.borderColor = "#4caf50";
                    scoreBadge.style.color = "#a5d6a7";
                } else if (score >= 50) {
                    scoreBadge.style.background = "rgba(255, 193, 7, 0.15)";
                    scoreBadge.style.borderColor = "#ffc107";
                    scoreBadge.style.color = "#ffe082";
                } else {
                    scoreBadge.style.background = "rgba(239, 83, 80, 0.15)";
                    scoreBadge.style.borderColor = "#ef5350";
                    scoreBadge.style.color = "#ff8a80";
                }

                // Update Smart Suggestions based on Category
                const suggested = categoryKeywords[categoryVal] || [];
                smartTagsContainer.innerHTML = "";
                const textToSearch = (titleVal + " " + summaryVal + " " + textOnly).toLowerCase();
                
                if (suggested.length > 0) {
                    suggested.forEach(tag => {
                        const isFound = textToSearch.includes(tag);
                        const tagEl = document.createElement("span");
                        tagEl.textContent = "#" + tag;
                        tagEl.style.fontSize = "10.5px";
                        tagEl.style.padding = "3px 8px";
                        tagEl.style.borderRadius = "4px";
                        tagEl.style.display = "inline-block";
                        tagEl.style.fontWeight = "bold";
                        tagEl.style.cursor = "pointer";
                        if (isFound) {
                            tagEl.style.background = "rgba(76, 175, 80, 0.2)";
                            tagEl.style.color = "#a5d6a7";
                            tagEl.style.border = "1px solid #4caf50";
                        } else {
                            tagEl.style.background = "rgba(255,255,255,0.05)";
                            tagEl.style.color = "rgba(255,255,255,0.5)";
                            tagEl.style.border = "1px solid rgba(255,255,255,0.1)";
                        }
                        
                        tagEl.addEventListener("click", () => {
                            const focusInput = document.getElementById("seo_focus_keyword");
                            if (focusInput) {
                                focusInput.value = tag;
                                updateSeoAnalysis();
                            }
                        });
                        
                        smartTagsContainer.appendChild(tagEl);
                    });
                } else {
                    smartTagsContainer.textContent = "Chọn chuyên mục để xem từ khóa gợi ý.";
                }
            };

            window.updateSeoAnalysis = updateSeoAnalysis;

            // Bind listeners
            titleInput.addEventListener("input", updateSeoAnalysis);
            summaryInput.addEventListener("input", updateSeoAnalysis);
            categorySelect.addEventListener("change", updateSeoAnalysis);

            // Initial trigger
            updateSeoAnalysis();
        });
      </script>
    </div>

    <!-- ==================================================== -->
    <!-- VIEW: 7. CONFIGURATIONS & PERMISSIONS -->





