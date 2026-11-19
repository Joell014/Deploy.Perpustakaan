<?php

// Pastikan folder cache/views di /tmp tersedia saat serverless cold-start
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

require __DIR__ . '/../public/index.php';
