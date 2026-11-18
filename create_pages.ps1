$pages = @(
    @{ title = 'Home'; slug = 'home' },
    @{ title = 'Merchandising & Sales'; slug = 'merchandising-sales' },
    @{ title = 'Street Marketing'; slug = 'street-marketing' },
    @{ title = 'Events'; slug = 'events' },
    @{ title = 'Get to Know Us'; slug = 'about' },
    @{ title = 'Join Us'; slug = 'join-us' },
    @{ title = 'Contact Us'; slug = 'contact' }
)

foreach ($p in $pages) {
    $t = $p.title
    $s = $p.slug
    $out = & powershell -File "C:\Type_b\Clientes\RAMA CAIDA\run-wp.ps1" post create --post_type=page --post_title="$t" --post_name="$s" --post_status=publish --porcelain
    $lines = $out | Where-Object { $_ -match '^\d+$' }
    if ($lines) {
        $id = $lines[0].Trim()
        & powershell -File "C:\Type_b\Clientes\RAMA CAIDA\run-wp.ps1" post meta update $id _elementor_edit_mode "builder"
        & powershell -File "C:\Type_b\Clientes\RAMA CAIDA\run-wp.ps1" post meta update $id _wp_page_template "elementor_header_footer"
        Write-Host "Created $t (ID: $id)"
    }
}
