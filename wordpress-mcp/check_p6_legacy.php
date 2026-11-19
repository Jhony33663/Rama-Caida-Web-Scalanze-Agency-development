<?php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';

$raw = get_post_meta(6, '_elementor_data', true);
preg_match_all('/https?:\/\/[^"\'\s]+\.(?:jpg|jpeg|png)/i', $raw, $matches);
echo "Unique legacy URLs in Page 6:\n";
print_r(array_unique($matches[0]));
