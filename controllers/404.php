<?php
header("HTTP/1.0 404 Not Found");
$siteTitle = "404 - Không tìm thấy trang | VinFast Việt Nam";
$siteDesc = "Đường dẫn không tồn tại trên hệ thống.";
$pageBodyClass = 'page-404';

return [
    'title' => $siteTitle,
    'desc' => $siteDesc,
    'body_class' => $pageBodyClass
];



