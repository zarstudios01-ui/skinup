# SkinUp product data schema (v1, approved)

Principle: products are data, not pages. All structured product
information lives in WordPress/WooCommerce and is reused by product
cards, product pages, filters, the Routine Finder and schema markup.

## Taxonomies (registered by the plugin, managed in the dashboard)

| Taxonomy | Terms (initial) |
|---|---|
| `skin_type` | oily, dry, combination, normal |
| `skin_concern` | acne, oiliness, dryness, dark spots, uneven texture, general skin health |
| `routine_step` | clean, treat, hydrate, protect, night |

Taxonomies are used instead of plain meta so the owner can edit terms
without code, WooCommerce can filter on them, and each term gets an
archive URL (concern and routine pages for SEO and internal linking).

## Core vs targeted

Stored as a flag on each `routine_step` term, not on the product.
- Core: clean, hydrate, protect
- Targeted: treat, night

## Per-product fields ("SkinUp" tab in the product editor)

- size
- benefits (list)
- key ingredients (list; empty until verified)
- how to use
- when to use (AM / PM / both)
- who it's for

Native WooCommerce fields stay native: price, stock, descriptions,
reviews, related products, images. Gallery order is fixed:
hero, lifestyle, texture, usage.

## Routine Finder rules

- Questions and options map to term slugs; no hard-coded products.
- Each concern maps to the targeted step(s) it triggers.
- For each step, pick the product whose skin types and concerns best
  match the answers; ties break on the manual product order.
- Rule configuration is data, separate from PHP, and owner-editable.
- The server validates every answer against existing term slugs.
  Prices and totals always come from WooCommerce.

## Decisions

- No separate "recommendation tags" field: skin types and concerns
  already do that job.
- Night Repair is assigned to `night` only, so it never competes with
  Hydra Moisturizer for the hydrate slot.
- Clear Serum and Bright Serum both sit in `treat`; dark-spot users get
  the better match score.
