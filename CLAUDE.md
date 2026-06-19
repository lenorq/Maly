# CLAUDE.md — Maciej Małecki · Drawing Archive

Working memory for Claude Code. Read this before touching any file.

---

## Project overview

Portfolio for hand-draughtsman **Maciej Małecki** — dense pen-and-ink
megastructures drawn on millimetre graph paper.
Design direction: **Tactical-Telemetry / Industrial-Brutalism**.
Framing: a *declassified drawing archive*, not a gallery website.

Two deliverables share one asset base:

```
maciej-malecki-site/
├── index.html                  ← static one-page site (deploy as-is)
├── assets/
│   ├── css/style.css           ← full design system
│   ├── js/main.js              ← reveals · HUD clock · lightbox
│   └── img/                   ← 46 files: WebP + JPG × 3 sizes per plate
├── wordpress/maciej-malecki/   ← WP theme (zip inner folder to install)
│   ├── style.css               ← WP theme header only
│   ├── functions.php           ← enqueue · supports · includes
│   ├── theme.json
│   ├── inc/
│   │   ├── cpt.php             ← Artwork CPT + catalogue meta box
│   │   ├── customizer.php      ← all editable copy
│   │   └── template-helpers.php ← mm_get_plates() · mm_render_plate_inner() · seed
│   ├── template-parts/
│   │   ├── hero.php
│   │   ├── ticker.php
│   │   ├── statement.php
│   │   ├── plates.php          ← layout logic (full/split/duo)
│   │   ├── density.php
│   │   ├── exhibitions.php
│   │   └── contact.php
│   ├── front-page.php · header.php · footer.php
│   ├── archive-artwork.php · single-artwork.php · page.php · 404.php
│   └── assets/ → same CSS/JS/img (copied from root assets/)
└── README.md
```

---

## Design tokens

All in `assets/css/style.css` as CSS custom properties. **Do not hardcode any of these values.**

```css
--bg:       #0a0a0a   /* page background                   */
--surface:  #141414   /* elevated cards / plate frames     */
--fg:       #ececec   /* primary text  (~17:1 on --bg)     */
--fg-dim:   #b4afa4   /* captions      (~9:1)              */
--fg-faint: #6c6c6c   /* large text only                   */
--hair:     #2a2a2a   /* hairline borders                  */
--red:      #e61919   /* single accent — use very sparingly */

--display:  'Archivo', sans-serif       /* weight 900, uppercase, tight */
--mono:     'Space Mono', monospace     /* telemetry / labels / metadata */

--ease-out: cubic-bezier(.4,0,.2,1)
--dur-1: .42s  --dur-2: .62s  --dur-3: .9s
```

---

## Image naming convention

Every plate has **three sizes**, each as **WebP + JPG**:

```
work-{slug}-full.webp / .jpg    ← 2000 px long edge  (lightbox / hero)
work-{slug}-grid.webp / .jpg    ← 1280 px long edge  (gallery tiles)
work-{slug}-thumb.webp / .jpg   ← 720 px long edge   (ticker / crops)
portrait-artist.webp / .jpg     ← 1400 px (main) + portrait-artist-thumb.*
```

Current slugs: `07-panorama` `01-ascension` `02-interior` `03-reliquary`
`04-basin` `05-transept` `06-colonnade`

When adding a new plate:
1. Run the PIL pipeline in `optimize_images.py` (see root) or produce the
   three WebP+JPG pairs manually at those sizes.
2. Add a `<picture>` block to `index.html` (static) **and** create an
   `Artwork` post with a featured image (WordPress).

---

## Catalogue plate data shape

Both the static seed and WordPress `mm_plate_from_post()` produce the same array:

```php
array(
  'no'            => 'MŁ-007',          // catalogue number
  'title'         => 'Great Works',
  'layout'        => 'full',            // full | split | duo
  'grid'          => '…/work-07-panorama-grid', // base path, no extension
  'grid_url'      => '…-grid.webp',     // set by mm_plate_from_post()
  'full'          => '…-full.webp',     // lightbox source
  'w'             => 1280, 'h' => 905,  // grid image dimensions
  'alt'           => '…',              // descriptive alt text
  'desc'          => '…',              // shown on split plates only
  'meta'          => array('Medium'=>'…','Dimensions'=>'…',…),
  'lightbox_meta' => 'Ink on paper · 70 × 50 cm',
)
```

---

## Reveal / animation system

**Do not change the three reveal attributes** — CSS and JS are coupled to them.

| Attribute | Effect | What carries it |
|---|---|---|
| `data-reveal` | `opacity 0→1` + `translateY 1.2rem→0` | section heads, text blocks, captions |
| `data-reveal-img` | `clip-path inset(0 100%→0)` left-wipe | `<figure>` wrappers, crop strips |
| `data-stagger` | staggered children, each `nth-child × 70ms` | stat rows, lists |

**How it works** (`main.js`):
1. `prime()` — adds `.is-in` to anything already in the viewport on load.
2. `IntersectionObserver` — watches the rest, fires `.is-in` on entry.
3. Throttled `scroll`/`resize` fallback — sweep that catches anything IO misses.

`@media (prefers-reduced-motion)` → CSS sets `clip-path: none !important` and
`transition: none`; JS also skips to prime everything immediately.

---

## WordPress-specific rules

- **`mm_render_plate_inner()`** lives in `inc/template-helpers.php` (always
  loaded). Never define it inside a template-part — it's called from three
  templates (`plates.php`, `archive-artwork.php`, `single-artwork.php`).
- **Seed plates** in `mm_seed_plates()` render until one real `Artwork` post
  exists. They reference `MM_URI . '/assets/img/…'`.
- **Customizer keys** are prefixed `mm_`. Match the keys in `customizer.php`
  exactly when reading with `mm_opt()`.
- **Image sizes** registered in `functions.php`: `mm-full` (2000 px),
  `mm-grid` (1280 px), `mm-thumb` (720 px). Run *Regenerate Thumbnails*
  after bulk-uploading scans.
- The theme is **dependency-free** — no ACF, no page builder. Plugins are
  additive, not required.

---

## HTML/CSS conventions (static + WP templates)

- **One `<h1>`** per page (the artist name in the hero; `single-artwork.php`
  uses `<h1>` for the plate title).
- Section landmarks: `<section aria-label="…">` or `<main id="main">`.
- Every `<img>` needs explicit `width`/`height` (no layout shift) and a
  descriptive `alt`. Decorative crops: `alt=""` + `aria-hidden="true"`.
- The lightbox is a `role="dialog" aria-modal="true"` `<div>` with a focus
  trap. Trigger buttons use `data-plate` + `data-full/no/title/meta`.
- Forms: `<label>` paired to every `<input>` by `for`/`id`.

---

## Common tasks

### Add a new plate (static)
1. Add images to `assets/img/` at the three sizes (WebP + JPG).
2. In `index.html`, find the `#works` section and add an `<article>` block.
   Copy the nearest plate with the same layout (`full` / `split` / `duo`).
3. Update the ticker `<span>` list (duplicated twice for the loop).

### Add a new plate (WordPress)
1. **Plates → Add plate** in WP admin.
2. Upload full-res scan as Featured image.
3. Fill the *Catalogue record* meta box fields.
4. Set *Page Attributes → Order* for gallery sequence.

### Change copy (static)
Edit directly in `index.html`. Sections are clearly commented.

### Change copy (WordPress)
**Appearance → Customize → Archive — Studio & copy.**

### Change exhibitions list (WordPress)
Update `mm_exhibitions_json` theme-mod as a JSON array, or edit
`mm_get_exhibitions()` default in `inc/template-helpers.php`.

### Add a language (WordPress)
Install **Polylang**. The footer switcher auto-detects `pll_the_languages()`.

### Wire up a real contact form (WordPress)
Install **Contact Form 7** or **WPForms**, copy its shortcode, paste into
**Customize → contact form shortcode**. The template switches automatically.

### Deploy static site
Drop `index.html` + `assets/` on any static host. No build step.
Netlify: drag-and-drop the `maciej-malecki-website` folder.
Vercel: `vercel --prod` from the folder.
Apache/Nginx: upload as-is, no `.htaccess` required.

### Install WordPress theme
```bash
cd wordpress
zip -rq maciej-malecki-theme.zip maciej-malecki
# Upload via WP Admin → Appearance → Themes → Add New → Upload
```

---

## What NOT to do

- Don't hardcode hex colours — use the CSS vars.
- Don't add a page builder or Elementor — the layout is hand-built and will conflict.
- Don't add a gallery/lightbox plugin — one is already built in.
- Don't define `mm_render_plate_inner()` anywhere except `inc/template-helpers.php`.
- Don't put production copy in `CLAUDE.md` — it's working notes.
- Don't change `--red` usage without design sign-off; it must stay very sparse
  (catalogue numbers, nav CTA arrow, contact email arrow, stat units).
