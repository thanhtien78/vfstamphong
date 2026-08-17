<?php
/**
 * Master Layout Template
 * Wraps dynamic views inside a premium, unified HTML header and footer structure.
 */
global $db, $settings;

// Expose legacy variables into global and local scopes for include files
foreach ($GLOBALS as $key => $val) {
    if (!isset($$key)) {
        $$key = $val;
    }
}

// Load common header (html opening tag, head meta, navigation header)
require_once __DIR__ . '/../components/header/header.php';

// Include the page-specific view template
include $viewFile;

// Load common footer (footer columns, contact info, closing tags)
require_once __DIR__ . '/../components/footer/footer.php';



