# Maciej Małecki — Drawing Archive

A dark, industrial-brutalist portfolio for the hand-draughtsman **Maciej Małecki**. The work — extraordinarily dense pen-and-ink megastructures, much of it drawn on millimetre graph paper — is framed here as a *declassified drawing archive*: a HUD/telemetry instrument frame, a graph-paper substrate that echoes the artist's own paper, catalogued "plates", and restrained scroll choreography.

Two deliverables ship in this folder:

| Folder | What it is | Use it when |
|---|---|---|
| `/` (root) | **Static landing page** — hand-coded HTML/CSS/JS, zero build step | Quick deploy, a one-pager, or a design reference for developers |
| `/wordpress/maciej-malecki/` | **WordPress theme** — same design, fully editable, with an *Artwork* post type | The client needs to add/reorder works and edit copy themselves |

> **All biography, exhibition and contact copy is placeholder.** Names, dates, venues, the email `studio@maciejmalecki.art` and the HUD coordinates are invented stand-ins. Replace them before launch (static: edit the HTML; WordPress: Customizer + Plates editor). They're written so the layout reads as finished, not so the facts are true.

---

## 1 · Static landing page

```
index.html
assets/
  css/style.css      design system + all section styles
  js/main.js          reveals, HUD clock, accessible lightbox
  img/                optimised WebP + JPG (full / grid / thumb per plate)
```

**Run it:** open `index.html` in a browser, or drop the whole root folder on any static host (Netlify, Vercel, GitHub Pages, S3, plain Apache/Nginx). No build, no dependencies. Fonts (Archivo + Space Mono) load from Google Fonts; everything else is local.

**Edit content:** all text lives directly in `index.html`, clearly sectioned by comments (`HERO`, `STATEMENT`, `PLATES`, `DENSITY`, `EXHIBITIONS`, `CONTACT`). Image swaps go in `assets/img/` — keep the `-full` / `-grid` / `-thumb` naming and the `<picture>` WebP+JPG pairs.

---

## 2 · WordPress theme

A real, functional theme — not an export. It recreates the landing page as the front page and adds a content model so the studio can manage the archive without touching code.

### What it gives you

- **`Artwork` custom post type ("Plates")** with a native *Catalogue record* meta box: catalogue no., year, medium, dimensions, density index, an extra labelled row, status, and layout (`full` / `split` / `duo`). No plugin required for this.
- **`Plate Series` taxonomy** for grouping.
- **Customizer panel "Archive — Studio & copy"** for every editable string: HUD coordinates, hero/statement/bio/contact text, email, studio location, social links, and a slot for a contact-form shortcode.
- **Front page** that renders real Plates if any exist, otherwise falls back to the seven bundled demo plates — so the site is never empty.
- **Accessible lightbox, scroll reveals, HUD clock** — the same `main.js`, enqueued the WordPress way.
- **Templates:** `front-page`, `archive-artwork` (grid), `single-artwork` (full scan + record), `page`, `index`, `404`.
- **`theme.json`** mapping the palette and Archivo/Space Mono to the block editor, plus `editor-styles`.
- **Translation-ready** (`maciej-malecki` text domain) and **Polylang-aware** (the footer language switcher uses Polylang if active).

### Install

1. Zip the **inner** folder so the archive contains `maciej-malecki/style.css` at its top level:
   ```
   cd wordpress
   zip -r maciej-malecki.zip maciej-malecki
   ```
2. WordPress admin → **Appearance → Themes → Add New → Upload Theme** → choose the zip → **Activate**.
3. **Settings → Reading → Your homepage displays → A static page**, or simply leave it on "Your latest posts" — the theme's `front-page.php` takes over the homepage either way. (Assigning a blank "Home" page is cleanest.)
4. **Settings → Permalinks → Save** once (registers the `/plates/` URLs).

### Set it up

1. **Appearance → Customize → Archive — Studio & copy** — replace all placeholder text, set the real email, social URLs, and HUD coordinates. Set the site **Title** (Settings → General) to `Maciej Małecki` — the hero splits it across two lines on the first space.
2. **Plates → Add plate** for each real work:
   - **Title** = work title (e.g. *Great Works*)
   - **Featured image** = the full-resolution scan (the theme generates `mm-full` / `mm-grid` / `mm-thumb` sizes automatically)
   - **Catalogue record** = fill the fields; set **Layout** to `full`, `split`, or `duo`
   - **Excerpt** = the short descriptive line shown on `split` plates
   - **Order** = use *Page Attributes → Order* to sequence the gallery
   Once one real Plate exists, the demo seed disappears.
3. **Appearance → Menus** (optional) — assign a menu to *Primary navigation*; otherwise the built-in anchor nav (Plates / Process / Exhibitions / Inquire) is used.
4. **Regenerate thumbnails** after import if scans look soft (see *Regenerate Thumbnails* plugin below).

### How the static page maps to WordPress

| Static (`index.html`) | WordPress |
|---|---|
| Hero panorama + name lockup | `template-parts/hero.php`; site Title + front-page featured image |
| Plate `<article>`s (hard-coded) | `Artwork` posts looped in `template-parts/plates.php` |
| Catalogue metadata in markup | *Catalogue record* meta box (`inc/cpt.php`) |
| Statement / bio / contact copy | Customizer fields (`inc/customizer.php`) |
| `<form action="#">` demo | Customizer *contact form shortcode* → CF7/WPForms, else built-in `mailto` form |
| `assets/` files | Same files, enqueued in `functions.php` |

---

## 3 · WordPress plugins

The theme is deliberately **dependency-free** — it works with zero plugins. The list below is what I recommend for a production launch, grouped by need. *Essential* = install these; the rest are situational.

### Essential

| Plugin | Why for this site | Notes |
|---|---|---|
| **ShortPixel** *or* **Imagify** *or* **Smush** | The source scans are enormous (up to 8000 px / ~12 MB). This compresses uploads and serves **WebP/AVIF** automatically — the single biggest perf win here. | Pick one. ShortPixel and Imagify both do WebP+AVIF + on-the-fly resizing. |
| **A caching plugin — WP Rocket** (paid) *or* **LiteSpeed Cache** (free, if on LiteSpeed hosting) *or* **W3 Total Cache** | Page cache, CSS/JS minification, lazy-load, font-display handling. The CSS/JS are tiny but caching still cuts TTFB and repeat visits. | One only. WP Rocket is the most "set-and-forget". |
| **Contact Form 7 + Flamingo** *or* **WPForms Lite** | Turns the contact section into a real, spam-safe inquiry form. Paste its shortcode into *Customize → contact form shortcode* and it replaces the demo form. | Flamingo stores submissions in the DB as a backup to email. |
| **Wordfence Security** *or* **Solid Security** | Login hardening, firewall, malware scanning. | Wordfence's free tier is plenty for a portfolio. |
| **UpdraftPlus** | Scheduled backups to Drive/Dropbox/S3 — irreplaceable original artwork lives here. | Configure off-site storage, not just local. |
| **An SEO plugin — Rank Math** *or* **Yoast SEO** | Titles/meta, Open Graph, sitemaps, schema (`VisualArtwork` / `Person`). | Rank Math's schema support suits an art catalogue well. |

### Recommended (situational)

| Plugin | Why | Notes |
|---|---|---|
| **Polylang** (free) *or* **WPML** (paid) | Artist is Polish — run the site **PL/EN**. The footer language switcher already detects Polylang. | Polylang is free and enough for two languages. |
| **Complianz** *or* **CookieYes** | GDPR/EU cookie + privacy consent (Google Fonts, analytics). Relevant for a PL/EU audience. | Complianz auto-generates the policy and consent banner. |
| **Advanced Custom Fields (ACF) — free or Pro** | *Optional upgrade.* The catalogue fields are already native; ACF only buys a nicer editor UI and repeaters (e.g. a managed Exhibitions list). The meta keys (`mm_catalog_no`, `mm_medium`, …) match ACF names, so you can switch with no template changes. | Skip unless the client wants the polished ACF panels. |
| **Regenerate Thumbnails** | Rebuild the `mm-full/grid/thumb` sizes after importing large scans or changing image sizes. | Run once after bulk upload, then deactivate. |
| **Safe SVG** | Only if you ever upload SVG (e.g. a logo). Sanitises SVGs WordPress otherwise blocks. | Not needed for the raster scans. |
| **Redirection** | Manage 301s if migrating from an existing URL structure. | Handy during launch only. |

### Deliberately *not* needed

- **Page builders (Elementor / Divi / WPBakery)** — the design is hand-built and far lighter without one; a builder would fight the layout and bloat the page.
- **A lightbox/gallery plugin (FooGallery, Lightbox, etc.)** — the theme ships its own accessible, keyboard-navigable lightbox. Adding another would double up.
- **A slider plugin** — there's no slider; the hero is a single still.

---

## 4 · Design system (shared by both builds)

Tokens live at the top of `assets/css/style.css` as CSS custom properties.

```
--bg        #0a0a0a   page          --hair  #2a2a2a   hairlines
--surface   #141414   plate frame   --red   #e61919   single accent (sparing)
--fg        #ececec   primary text (~17:1 on --bg)
--fg-dim    #b4afa4   captions     (~9:1)
--fg-faint  #6c6c6c   large text only
```

- **Type:** `Archivo` 900 for display (tight, uppercase lockups); `Space Mono` for all metadata, labels and the HUD — the "instrument readout" voice.
- **Motion:** "premium" easing `cubic-bezier(.4,0,.2,1)`, 0.42–0.9 s, no overshoot. Reveals = upward fade (`[data-reveal]`), image wipe (`[data-reveal-img]` clip-path), and staggered children (`[data-stagger]`). Implemented in `main.js` with `IntersectionObserver`, an above-the-fold prime pass, **and** a throttled scroll/resize fallback so nothing stays hidden if the observer misfires.
- **Signature elements:** corner crosshairs + top/bottom status bars (HUD), graph-paper body texture, bracket frames on figures, catalogue/telemetry metadata.

## 5 · Accessibility & performance notes

- **Reduced motion:** `@media (prefers-reduced-motion: reduce)` disables reveals/clip animations and shows everything immediately; the JS also short-circuits to "all visible".
- **Keyboard:** skip-link, `:focus-visible` rings throughout, and a focus-trapped lightbox (Esc to close, ←/→ to navigate, focus restored to the trigger on close).
- **Semantics:** one `<h1>`, landmark regions (`header`/`main`/`footer`/`section[aria-label]`), real `<figure>/<figcaption>`, descriptive `alt` on every plate, decorative crops marked `aria-hidden`.
- **Contrast:** body/caption colours meet WCAG AA on `--bg`; `--fg-faint` is reserved for large text only.
- **Performance:** hero image `fetchpriority="high"`, all others `loading="lazy"` with explicit `width`/`height` (no layout shift), WebP with JPG fallback, and three resolution tiers so the 8000 px scans never ship full-size to the grid.
- **Progressive enhancement:** with JS off, all content is present and readable — JS only adds reveals, the clock and the lightbox.

> One thing worth a quick manual user-test pass: the lightbox on touch devices (swipe vs. the ←/→ buttons) and the mobile nav toggle at ≤860 px. Both are keyboard- and pointer-tested, but a real-device check is always worth it before launch.
