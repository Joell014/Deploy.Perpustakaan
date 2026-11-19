<?php

// Pastikan folder cache/views di /tmp tersedia saat serverless cold-start
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// Perbaiki SCRIPT_NAME agar Laravel tidak memotong prefix /api/* di Vercel
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

require __DIR__ . '/../public/index.php';
