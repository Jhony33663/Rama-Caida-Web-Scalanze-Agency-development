<?php
$realTestimonials = [
    [
        'client_name' => 'Andrea Cuervo G',
        'designation' => 'Brand Ambassador — Elizabeth, NJ (2024)',
        'review' => '“Hice parte de Rama Caída y tuve la oportunidad de aprender y disfrutar de un ambiente de trabajo motivador enfocado en la disciplina y comprometido, donde pude desarrollar mis habilidades creciendo de manera laboral y profesional.”',
        'rating' => 5
    ],
    [
        'client_name' => 'Angelica Rivera',
        'designation' => 'Field Marketing Lead — Brooklyn, NY (2024)',
        'review' => '“Rama Caída es una compañía sólida que resalta por su compromiso y profesionalismo. Proveen un excelente ambiente laboral basado en el respeto y una comunicación constante en todo el ámbito laboral.”',
        'rating' => 5
    ],
    [
        'client_name' => 'Maitte Ribadeneira',
        'designation' => 'Operations Coordinator — LATAM (2024)',
        'review' => '“Trabajar en RAMA CAIDA ha sido una experiencia sumamente enriquecedora. Desde el primer día me sentí parte de un equipo dinámico y colaborativo, donde la comunicación abierta y el respeto mutuo son esenciales.”',
        'rating' => 5
    ],
    [
        'client_name' => 'Maria Lopez',
        'designation' => 'Events Specialist — Bridgeport, CT (2025)',
        'review' => '“Uno de los aspectos más positivos ha sido la oportunidad de dar a conocer grandes marcas y conectar con la gente. Rama Caída ofrece capacitación continua para fortalecer nuestras habilidades con un gran equilibrio personal y profesional.”',
        'rating' => 5
    ],
    [
        'client_name' => 'Jessica Camacho',
        'designation' => 'Sampling Coordinator — LATAM (2024)',
        'review' => '“Me permitió cumplir con mis responsabilidades de manera eficiente, disfrutando de flexibilidad. Me siento afortunada de formar parte de un equipo tan dedicado, donde fortalecí mis habilidades contribuyendo al desarrollo de la empresa.”',
        'rating' => 5
    ]
];

function updateTestimonialNodes(&$node, $testimonials) {
    if (is_array($node)) {
        if (isset($node['widgetType']) && $node['widgetType'] === 'elementskit-testimonial') {
            if (!empty($node['settings']['ekit_testimonial_data'])) {
                $items = &$node['settings']['ekit_testimonial_data'];
                $count = count($items);
                for ($i = 0; $i < $count; $i++) {
                    $t = $testimonials[$i % count($testimonials)];
                    $items[$i]['client_name'] = $t['client_name'];
                    $items[$i]['designation'] = $t['designation'];
                    $items[$i]['review'] = $t['review'];
                }
                echo "  -> Successfully updated {$count} items in ekit_testimonial_data!\n";
            }
        }
        foreach ($node as $k => &$v) {
            updateTestimonialNodes($v, $testimonials);
        }
    }
}

$targetPosts = [6, 10];
foreach ($targetPosts as $pid) {
    echo "Updating Post $pid (" . get_the_title($pid) . ")...\n";
    $raw = get_post_meta($pid, '_elementor_data', true);
    if (!empty($raw)) {
        $data = json_decode($raw, true);
        if (is_array($data)) {
            updateTestimonialNodes($data, $realTestimonials);
            update_post_meta($pid, '_elementor_data', wp_slash(json_encode($data)));
            echo "Saved Post $pid.\n";
        }
    }
}
