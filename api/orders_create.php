<?php
declare(strict_types=1);
require_once __DIR__ . '/_bootstrap.php';

require_login(); // must be logged in

$data = read_json_body();
$itemsIn = $data['items'] ?? null;
if (!is_array($itemsIn) || count($itemsIn) === 0) {
    json_response(['ok'=>false,'error'=>'No items'], 400);
}

$items = [];
foreach ($itemsIn as $it) {
    $pid = (int)($it['productId'] ?? 0);
    $qty = (int)($it['qty'] ?? 0);
    if ($pid <= 0 || $qty <= 0) continue;
    $p = product_find($pid);
    if (!$p || (int)$p['isActive'] !== 1) continue;
    $items[] = ['productId'=>$pid,'qty'=>$qty,'unitPrice'=>(float)$p['price']];
}

if (count($items) === 0) {
    json_response(['ok'=>false,'error'=>'No valid items'], 400);
}

$orderId = order_create((int)current_user()['id'], $items);
json_response(['ok'=>true,'orderId'=>$orderId]);
?>