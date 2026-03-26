<?php
declare(strict_types=1);
require_once __DIR__ . '/_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    json_response(['ok'=>true,'products'=>products_all_active()]);
}

json_response(['ok'=>false,'error'=>'Method not allowed'], 405);
?>