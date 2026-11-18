# Rama Caida - Product Sampling & Brand Awareness Web Development

Sitio web corporativo y de servicios para **Rama Caida Product Sampling & Brand Awareness**, desarrollado con WordPress, Elementor Pro y arquitectura optimizada para rendimiento web y Core Web Vitals.

---

## 🌟 Características del Proyecto

- **Maquetación 100% en Elementor Pro**: Construido sobre el theme `hello-elementor` y maquetado con kits de diseño adaptados al branding de la marca.
- **7 Páginas Principales Totalmente Ensambladas**:
  - `Home` (`/`)
  - `Merchandising & Sales` (`/merchandising-sales/`)
  - `Street Marketing` (`/street-marketing/`)
  - `Events` (`/events/`)
  - `Get to Know Us` (`/about/`)
  - `Join Us` (`/join-us/`)
  - `Contact Us` (`/contact/`)
- **Theme Builder Global**: Header y Footer globales con navegación responsive, llamada a la acción y datos de contacto de la sede en Belleville, NJ.
- **Activos de Marca y Fotos Auténticas**:
  - Vectorización y optimización del logotipo oficial de Rama Caida (PNG transparente de alta definición).
  - 29 fotografías de campañas reales de sampling y activaciones (Bon O Bon, Buen Día, Colcafé, Café Santo Domingo, Café Sello Rojo).
- **Google Chrome Modern Web Guidance**:
  - Plugin personalizado en `mu-plugins/rama-modern-web.php` para optimización de Core Web Vitals:
    - Priorización de Largest Contentful Paint (`fetchpriority="high"` en la imagen Hero LCP sin lazy loading diferido).
    - Carga diferida nativa (`loading="lazy"` y `decoding="async"`) para todas las imágenes secundarias.
    - Metadatos de esquema de color y viewport moderno.
- **MCP Server para WordPress & Elementor**: Servidor Node.js para interactuar programáticamente con el CMS y Elementor mediante el Model Context Protocol.

---

## 📂 Estructura del Repositorio

```text
├── .agents/                 # Reglas y skills de desarrollo (incluye modern-web-guidance)
├── assets/                  # Logos oficiales y fotos de campañas descargadas
├── database.sql             # Exportación completa de la base de datos MySQL
├── elementor-pro/           # Plugin Elementor Pro
├── mu-plugins/              # Must-Use Plugins de WordPress (optimizaciones de rendimiento)
├── runda-kit/               # Plantillas base en formato JSON de Elementor
├── wordpress-mcp/           # Servidor MCP y scripts de automatización / montaje
├── GUIA_MONTAJE_WORDPRESS.md# Documentación de montaje técnico
├── Rama-Caida-Estructura-Textos-Web.md # Documento de contenidos y textos originales
└── run-wp.ps1               # Wrapper para ejecutar WP-CLI en el entorno local
```

---

## 🚀 Puesta en Marcha en Local / Restauración

1. **Importar Base de Datos**:
   ```bash
   mysql -u <usuario> -p <base_de_datos> < database.sql
   ```
2. **Reemplazo de URL (si cambia de dominio local a producción)**:
   ```bash
   wp search-replace "http://rama-caida.local" "https://tu-dominio.com" --all-tables
   ```
3. **Regenerar CSS de Elementor**:
   ```bash
   wp elementor flush-css
   ```
