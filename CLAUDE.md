# CLAUDE.md — Maciej Małecki · Drawing Archive

Working memory for Claude Code. Read this before touching any file.

---

## Project overview

Portfolio for hand-draughtsman **Maciej Małecki** — dense pen-and-ink
megastructures drawn on millimetre graph paper.
Design direction: **Tactical-Telemetry / Industrial-Brutalism**.
Framing: a *declassified drawing archive*, not a gallery website.

- **Repository**: `lenorq/Maly` (private)
- **Default branch**: `main`

Two deliverables share one asset base:

| Folder | What it is | Use it when |
|---|---|---|
| `static-site/` | **Static one-page site** — hand-coded HTML/CSS/JS, zero build step | Quick deploy, a one-pager, or a design reference |
| `wordpress-theme/maciej-malecki/` | **WordPress theme** — same design, fully editable, with an *Artwork* post type | The client needs to add/reorder works and edit copy |

> **All biography, exhibition and contact copy is placeholder.** Replace before launch.

---

## Repository structure

```
.
├── CLAUDE.md
├── static-site/
│   ├── index.html                     ← static one-page site (deploy as-is)
│   ├── README.md                      ← full project documentation
│   ├── assets/
│   │   ├── css/style.css              ← full design system (CSS custom properties)
│   │   ├── js/main.js                 ← reveals · HUD clock · lightbox
│   │   └── img/                       ← 46 files: WebP + JPG × 3 sizes per plate
│   └── CLAUDE.md
└── wordpress-theme/
    └── maciej-malecki/                ← zip this folder to install as WP theme
        ├── style.css                  ← WP theme header only
        ├── functions.php              ← enqueue · supports · includes
        ├── theme.json                 ← block editor palette + typography
        ├── front-page.php · header.php · footer.php
        ├── archive-artwork.php · single-artwork.php · page.php · 404.php · index.php
        ├── inc/
        │   ├── cpt.php                ← Artwork CPT + catalogue meta box
        │   ├── customizer.php         ← all editable copy (mm_ prefixed keys)
        │   └── template-helpers.php   ← mm_get_plates() · mm_render_plate_inner() · seed
        ├── template-parts/
        │   ├── hero.php · ticker.php · statement.php
        │   ├── plates.php             ← layout logic (full/split/duo)
        │   ├── density.php · exhibitions.php · contact.php
        ├── assets/                    ← same CSS/JS/img (copied from static-site)
        └── CLAUDE.md
```

---

## Tech stack

- **Static site**: Vanilla HTML / CSS / JS. No build step, no dependencies.
- **WordPress theme**: PHP 7.4+, WordPress 6.4+. Block-aware, dependency-free, translation-ready (`maciej-malecki` text domain).
- **Fonts**: Archivo (display, weight 900, uppercase lockups) + Space Mono (telemetry/labels/metadata) — loaded from Google Fonts.
- **Images**: WebP primary with JPG fallback, three sizes per plate (full/grid/thumb).

---

## Design tokens

All in `assets/css/style.css` as CSS custom properties. **Do not hardcode any of these values.**

```css
--bg:        #0a0a0a   /* page background                    */
--surface:   #141414   /* elevated cards / plate frames      */
--fg:        #ececec   /* primary text  (~17:1 on --bg)      */
--fg-dim:    #b4afa4   /* captions      (~9:1)               */
--fg-faint:  #6c6c6c   /* large text only                    */
--hair:      #2a2a2a   /* hairline borders                   */
--red:       #e61919   /* single accent — use very sparingly  */

--display: 'Archivo', sans-serif        /* weight 900, uppercase, tight */
--mono:    'Space Mono', monospace      /* telemetry / labels / metadata */

--ease-out: cubic-bezier(.4,0,.2,1)
--dur-1: .42s   --dur-2: .62s   --dur-3: .9s
```

The same palette is mirrored in `wordpress-theme/maciej-malecki/theme.json` for the block editor.

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
1. Produce the three WebP+JPG pairs at those sizes.
2. Add a `<picture>` block to `index.html` (static) **and/or** create an
   `Artwork` post with a featured image (WordPress).

---

## Catalogue plate data shape

Both the static seed (`mm_seed_plates()`) and WordPress `mm_plate_from_post()` produce the same array:

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
1. Above-the-fold prime — adds `.is-in` to anything already in the viewport on load.
2. `IntersectionObserver` — watches the rest, fires `.is-in` on entry.
3. Throttled `scroll`/`resize` fallback — sweep that catches anything IO misses.

`@media (prefers-reduced-motion)` → CSS disables clip/transition animations;
JS skips to showing everything immediately.

---

## JavaScript modules (`main.js`)

No dependencies. Progressive enhancement — everything works without JS.

1. **Scroll reveals** — IntersectionObserver + fallback sweep (see above)
2. **HUD live clock** — UTC time updated every second (`[data-clock]`)
3. **Mobile nav** — burger toggle at ≤860 px (`.nav__burger` / `.nav__links`)
4. **Lightbox** — `role="dialog" aria-modal="true"`, focus trap (Esc/←/→ keys), triggers via `[data-plate]` buttons
5. **Footer year** — auto-updates `[data-year]`

---

## WordPress-specific rules

- **`mm_render_plate_inner()`** lives in `inc/template-helpers.php` (always
  loaded). Never define it inside a template-part — it's called from three
  templates (`plates.php`, `archive-artwork.php`, `single-artwork.php`).
- **Seed plates** in `mm_seed_plates()` render until one real `Artwork` post
  exists. They reference `MM_URI . '/assets/img/…'`.
- **Customizer keys** are prefixed `mm_`. Match the keys in `customizer.php`
  exactly when reading with `mm_opt()`.
- **Meta fields** for `artwork` CPT: `mm_catalog_no`, `mm_year`, `mm_medium`,
  `mm_dimensions`, `mm_density`, `mm_attribute`, `mm_attr_value`, `mm_status`,
  `mm_layout`. Defined in `inc/cpt.php`, saved with nonce verification.
- **Image sizes** registered in `functions.php`: `mm-full` (2000 px),
  `mm-grid` (1280 px), `mm-thumb` (720 px). Run *Regenerate Thumbnails*
  after bulk-uploading scans.
- **Taxonomy**: `plate_series` (hierarchical) for grouping artworks.
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
- Skip link: `<a class="skip" href="#main">`.
- HUD frame is `aria-hidden="true"` (decorative).

---

## Accessibility & performance

- **Reduced motion**: `@media (prefers-reduced-motion: reduce)` disables reveals/clip animations; JS shows everything immediately.
- **Keyboard**: skip-link, `:focus-visible` rings throughout, focus-trapped lightbox (Esc to close, ←/→ to navigate).
- **Contrast**: body/caption colours meet WCAG AA on `--bg`; `--fg-faint` is for large text only.
- **Performance**: hero image `fetchpriority="high"`, all others `loading="lazy"`, WebP + JPG fallback, three resolution tiers.
- **Progressive enhancement**: with JS off, all content visible; JS only adds reveals, clock, and lightbox.

---

## Common tasks

### Deploy static site
Drop `static-site/index.html` + `static-site/assets/` on any static host.
No build step. Netlify: drag-and-drop. Vercel: `vercel --prod`. Apache/Nginx: upload as-is.

### Install WordPress theme
```bash
cd wordpress-theme
zip -rq maciej-malecki.zip maciej-malecki
# Upload via WP Admin → Appearance → Themes → Add New → Upload
```

### Add a new plate (static)
1. Add images to `static-site/assets/img/` at the three sizes (WebP + JPG).
2. In `index.html`, find the `#works` section and add an `<article>` block.
   Copy the nearest plate with the same layout (`full` / `split` / `duo`).
3. Update the ticker `<span>` list (duplicated twice for the loop).

### Add a new plate (WordPress)
1. **Plates → Add plate** in WP admin.
2. Upload full-res scan as Featured image.
3. Fill the *Catalogue record* meta box fields.
4. Set *Page Attributes → Order* for gallery sequence.

### Change copy (static)
Edit directly in `index.html`. Sections are clearly commented
(`HERO`, `STATEMENT`, `PLATES`, `DENSITY`, `EXHIBITIONS`, `CONTACT`).

### Change copy (WordPress)
**Appearance → Customize → Archive — Studio & copy.**

### Sync assets between deliverables
The `assets/` folder is duplicated between `static-site/assets/` and
`wordpress-theme/maciej-malecki/assets/`. When updating CSS, JS, or images,
update both locations to keep them in sync.

---

## What NOT to do

- Don't hardcode hex colours — use the CSS custom properties.
- Don't add a page builder or Elementor — the layout is hand-built and will conflict.
- Don't add a gallery/lightbox plugin — one is already built in.
- Don't define `mm_render_plate_inner()` anywhere except `inc/template-helpers.php`.
- Don't change `--red` usage without design sign-off; it must stay very sparse
  (catalogue numbers, nav CTA arrow, contact email arrow, stat units).
- Don't change the three reveal data attributes (`data-reveal`, `data-reveal-img`,
  `data-stagger`) — CSS and JS are tightly coupled to them.
- Don't put production copy in `CLAUDE.md` — it's working notes.

---

## AI assistant guidelines

1. **Read before writing** — understand existing patterns before introducing new ones.
2. **Preserve the design language** — Tactical-Telemetry / Industrial-Brutalism. Changes should feel like they belong in the same declassified-archive aesthetic.
3. **Keep both deliverables in sync** — changes to shared assets (CSS, JS, images) must be reflected in both `static-site/` and `wordpress-theme/`.
4. **Don't over-engineer** — no build tools, no bundlers, no frameworks. The zero-dependency approach is intentional.
5. **Respect accessibility** — maintain WCAG AA contrast, semantic HTML, keyboard navigation, and reduced-motion support.
6. **Update this file** when introducing new tooling, conventions, or architectural patterns.
7. **Ask when uncertain** — if a task is ambiguous, clarify before implementing.
