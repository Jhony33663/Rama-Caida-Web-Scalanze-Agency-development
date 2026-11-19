<?php
$metas = get_post_meta(6);
foreach ($metas as $k => $v) {
    echo "$k: " . (strlen($v[0]) > 60 ? substr($v[0], 0, 60) . '...' : $v[0]) . "\n";
}
