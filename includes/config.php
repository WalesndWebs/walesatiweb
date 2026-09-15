<?php
// includes/config.php - Wales & Webs Configuration for Hostinger
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

define('SITE_NAME', 'Wales & Webs');
define('ADMIN_EMAIL', 'hello@walesndwebs.com');
define('DATA_DIR', __DIR__ . '/../data');

if (!is_dir(DATA_DIR)) {
    @mkdir(DATA_DIR, 0755, true);
}
