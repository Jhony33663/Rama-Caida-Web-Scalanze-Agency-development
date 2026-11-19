<?php
require_once 'C:/Users/JMATA/Local Sites/rama-caida/app/public/wp-load.php';

$posts = get_posts([
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'post_status' => 'any'
]);

$deleted = 0;
foreach ($posts as $p) {
    $title = $p->post_title;
    $file = get_attached_file($p->ID);
    
    // Check if it's from old scraped site
    $is_old_web = (strpos($title, 'Web -') === 0) || 
                  (strpos(basename($file), 'WhatsApp_Image') === 0) || 
                  (strpos(basename($file), 'unsplash') === 0) ||
                  (strpos(basename($file), 'image-asset') === 0) ||
                  (strpos(basename($file), 'Imagen_de_WhatsApp') === 0) ||
                  (strpos(basename($file), 'AroHa') === 0) ||
                  (strpos(basename($file), 'Aro_Ha') === 0) ||
                  (strpos(basename($file), '20221015') === 0) ||
                  (strpos(basename($file), 'Merche_Stock') === 0) ||
                  (strpos(basename($file), 'RC-') === 0);

    if ($is_old_web) {
        wp_delete_attachment($p->ID, true);
        echo "Deleted old site attachment: {$p->ID} ({$title})\n";
        $deleted++;
    }
}

echo "Total old site attachments deleted: $deleted\n";
