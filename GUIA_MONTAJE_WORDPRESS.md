# Guía de Montaje de Sitio Web — Rama Caida (WordPress Local + Elementor)

Esta guía detalla el paso a paso para tener el sitio web de **Rama Caida Product Sampling & Brand Awareness** 100% montado en local con el tema y los textos del cliente.

---

## 1. Archivos del Proyecto en tu Carpeta
Ubicación: `C:\Type_b\Clientes\RAMA CAIDA`
* **Template Kit:** `runda-creative-agency-elementor-template-kit-2025-01-15-11-55-26-utc.zip`
* **Plugin Pro:** `elementor-pro.zip` (comprimido listo para instalar) y carpeta descomprimida `elementor-pro`
* **Estructura y Textos:** `c:\Users\JMATA\Downloads\Rama-Caida-Estructura-Textos-Web.md`
* **Recursos Gráficos:**
  * [Material Gráfico de Marca en Google Drive](https://drive.google.com/drive/folders/1TilgTQUR2yXXUdu2lLPbYQsriWUU4sWM?usp=sharing)
  * [Material Fotográfico en Google Drive](https://drive.google.com/drive/folders/11dL46tr98KFCVyUa8CAB8KKhLPZzTsdb?usp=sharing)

---

## 2. Crear el Sitio en LocalWP (1 minuto)

1. Abre **Local** desde el menú Inicio de Windows (busca **Local** o ábrelo desde tus programas).
2. Haz clic en el botón verde **`+ Create a new site`**.
3. Selecciona **`Create a new site`** y pulsa **Continue**.
4. **Site name:** Escribe `Rama Caida` (el dominio local será `ramacaida.local`). Pulsa **Continue**.
5. **Environment:** Deja marcada la opción **`Preferred`** (PHP 8.2, Nginx, MySQL 8). Pulsa **Continue**.
6. **WordPress Username & Password:**
   * **Username:** `admin` (o tu usuario preferido)
   * **Password:** `admin` (o tu contraseña preferida)
   * **Email:** `danicp.ramacaidasampling@gmail.com`
7. Haz clic en **`Add Site`**. En unos segundos tendrás WordPress listo.
8. En la interfaz de LocalWP verás el botón **`WP Admin`** (acceso directo al panel) y **`Open Site`** (ver la web).

---

## 3. Instalación de Tema y Plugins Requeridos

### A. Tema Base (Hello Elementor)
1. En el panel de WordPress ve a: **Apariencia > Temas > Añadir nuevo**.
2. Busca: **Hello Elementor**.
3. Haz clic en **Instalar** y luego en **Activar**.

### B. Plugins Gratuitos desde el Repositorio
Ve a **Plugins > Añadir nuevo** e instala y activa uno por uno:
1. **Elementor** (creador de páginas principal)
2. **Envato Elements - Photos & System Kits** (para importar el kit Runda)
3. **ElementsKit Lite**
4. **Elementor Header & Footer Builder**
5. **Jeg Elementor Kit**
6. **WPForms Lite** (formularios de contacto y aplicación)

### C. Plugin Elementor Pro
1. Ve a **Plugins > Añadir nuevo > Subir plugin**.
2. Selecciona el archivo: `C:\Type_b\Clientes\RAMA CAIDA\elementor-pro.zip`.
3. Haz clic en **Instalar ahora** y luego en **Activar plugin**.

---

## 4. Importación del Template Kit "Runda"

1. En el menú lateral de WordPress ve a **Elements > Installed Kits** (o **Herramientas > Template Kits**).
2. Haz clic en **Upload Template Kit ZIP** y sube el archivo:  
   `C:\Type_b\Clientes\RAMA CAIDA\runda-creative-agency-elementor-template-kit-2025-01-15-11-55-26-utc.zip`
3. Si aparece una advertencia en naranja arriba con requerimientos, haz clic en **"Install Requirements"**.
4. Haz clic en **"Import Global Kit Styles"** (esto carga la paleta de colores, tipografías y fuentes corporativas).
5. En la lista de plantillas disponibles, haz clic en **Import Template** en las que usaremos:
   * `Header`
   * `Footer`
   * `Home 1`
   * `Service 1` y `Service 2`
   * `About Us`
   * `Our Team` / `Single Member`
   * `Contact Us`
   * `Blog`

---

## 5. Estructura y Mapeo de Contenidos (Páginas a Crear)

Crea cada página en **Páginas > Añadir nueva**, asígnale la plantilla **Elementor Canvas** o **Elementor Ancho Completo**, pulsa **Editar con Elementor**, y añade la plantilla correspondiente:

### 1. Header & Footer Globales
* Configúralos con **Elementor Header & Footer Builder** (o en Theme Builder de Elementor Pro).
* **Menú Superior:**
  * **Services** (Desplegable: *Merchandising & Sales*, *Street Marketing*, *Events*)
  * **Get to Know Us** (`/about`)
  * **Join Us** (`/join-us`)
  * **Blog** (`/blog`)
  * **Contact Us** (`/contact`)
* **Footer:**
  * Eslogan: *Product Sampling and Brand Awareness*
  * Ubicación: *137 1/2 Washington Ave., Suite 306, Belleville NJ 07109*
  * Correo: *danicp.ramacaidasampling@gmail.com*
  * Toll Free: *(888) 973-3122*

---

### 2. Home (`/`)
* **Plantilla base:** `Home 1`
* **Hero:**
  * Imagen: Equipo en campo (descargar de la carpeta de Drive)
  * Título: *Unleash Your Field Marketing Superpowers!*
  * Bajada: *Libera tus superpoderes de marketing en el campo!*
* **Sección 2 — Our Services (3 bloques destacados):**
  1. *Merchandising & Sales* (Merchandising + Neuro Sales)
  2. *Street Marketing* (Street Marketing + Interactive Marketing, 360 Booths)
  3. *Events* (Pop Up Events + Retail Activations Demos)
* **Sección 3 — Get to Know Us:**
  * Texto de trayectoria desde 2017 (Virginia a Massachusetts). Botón *Learn more* -> `/about`.
* **Sección 4 — Call to Action:**
  * *Grab your spot!* Botón *Contact Us* -> `/contact`.
* **Sección 5 — Portfolio:**
  * Galería de fotos de activaciones, eventos y equipo en campo.
* **Sección 6 — Join the Team:**
  * Botón 1: *I would like to join the Field Team in the North East!*
  * Botón 2: *¡Deseo aplicar para una posición en LATAM!*

---

### 3. Merchandising & Sales (`/merchandising-sales`)
* **Plantilla base:** `Service 1`
* **Intro:** *Retail Specialists* (El valor del equipo en campo con category managers, store managers y buyers).
* **Bloque Merchandisers:** Colocación estratégica, rotación de producto, visibilidad de marca y disponibilidad (*Part time, Full Time, Weekends*).
* **Bloque Neuro Sales:** Principios de neurociencia aplicados al retail, storytelling y embajadores bilingües.
* **Strategy Sales (3 pilares):**
  * *Value:* Paquetes flexibles por tamaño y duración.
  * *Length of Service:* 1 mes (energizers), 3 meses (growth), 6 meses (brand partnership).
  * *Why It’s Unique:* Personal bilingüe, fluidez cultural y reportes de desempeño en tiempo real.

---

### 4. Street Marketing (`/street-marketing`)
* **Plantilla base:** `Service 2`
* **Hero:** *Street Marketing — Surprise them. Delight them. Make them remember you.* (*Sorpréndelos. Encántalos. Haz que te recuerden.*)
* **Intro:** *Unexpected by design* (Llevar la marca a calles, plazas y ferias sin necesidad de megapresupuestos).
* **Servicios:**
  * *Street Marketing:* Muestreos y dinámicas en vía pública.
  * *Interactive Marketing:* Cabinas 360, Pop up game booths en ferias.
* **Metodología (How we make it happen):**
  * *Plan:* Diagnóstico y diseño según audiencia y locación.
  * *Activate:* Equipo bilingüe capacitado y presentación pulcra.
  * *Learn:* Retroalimentación y reportes de campo.
* **Por qué Rama Caida:** Profesionalismo y diversión, equipos bilingües inglés/español, cobertura VA hasta MA, experiencia desde 2017.
* **CTA:** *Whatever it is, the way you tell your story can make all the difference.* -> Botón *Let’s plan your activation*.

---

### 5. Events (`/events`)
* **Plantilla base:** `Service 1` o `Service 2`
* **Hero:** *Events — Where your brand meets its fans.* (*Donde tu marca conoce a sus fans.*)
* **Intro:** *Experiences worth sharing* (Feria, supermercado o lanzamiento de marca).
* **Servicios:**
  * *Pop Up Events:* Descubrimiento y degustación en ferias masivas.
  * *Retail Activations (Demos):* Activación en tienda, conexión sensorial con el cliente.
* **Meet our activators:** Perfil del personal de demo (bilingües, higiene/seguridad alimentaria, carismáticos).
* **Proceso (From first idea to final high-five):** *Before*, *During*, *After*.
* **CTA:** *Whatever it is, the way you tell your story in the field can make all the difference.* -> Botón *Let’s plan your event*.

---

### 6. Get to Know Us (`/about`)
* **Plantilla base:** `About Us`
* **Our Origins:** Historia de Francia Franco (2022) y el motivo de fundar la empresa al no encontrar personal de demostración a la altura en supermercados.
* **Our Mission:** Revolucionar el muestreo de productos con transparencia, confianza y responsabilidad social.
* **Our Core Values:** Transparencia, Confianza, Responsabilidad Social, Excelencia, Trabajo en Equipo, Innovación y Compromiso Comunitario.
* **Our Vision:** Liderazgo en marketing de campo e impacto en comunidades.
* **Formulario de Contacto:** Integrado con WPForms.

---

### 7. Join Us (`/join-us`)
* **Plantilla base:** `Our Team` / `Contact Us`
* **Hero & Empleos:**
  * Vacantes: *Merchandisers, Sales staff, Activators (Demo Personnel), Drivers*.
  * Cobertura: *NJ, NY, CT, PA, MA, RI, MD, DE, VA y LATAM (remoto)*.
* **Pasos de Postulación (How do I apply?):**
  1. *Step 1:* Descargar solicitud (PDF en Google Drive).
  2. *Step 2:* Rellenar la solicitud.
  3. *Step 3:* Subir la solicitud mediante el formulario.
  4. Entrevista agendada vía Zoom.
* **Testimonios Reales del Equipo:**
  * Andrea Cuervo G (Elizabeth, NJ - 2024)
  * Angelica Rivera (Brooklyn, NY - 2024)
  * Maitte Ribadeneira (LATAM - 2024)
  * Maria Lopez (Bridgeport, CT - 2025)
  * Jessica Camacho (LATAM - 2024)
  * Alex Garcia (LATAM - 2022)

---

### 8. Contact Us / Appointments (`/contact`)
* **Plantilla base:** `Contact Us`
* **Hero:** *Grab your spot! Ready to take your brand on a marketing joyride?*
* **Formulario / Calendario de Agendamiento:**
  * Formulario de contacto con WPForms o incrustación de calendario (ej. Calendly) para reuniones.
