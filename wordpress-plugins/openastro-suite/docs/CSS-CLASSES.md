# Astrology Suite for FreeAstroAPI CSS Class Reference

Use these classes in your theme CSS (`Appearance > Customize > Additional CSS`) to restyle blocks.

## Container / Layout

- `.wp-block-astrology-suite-widget`
  - Purpose: Main block wrapper.
  - Rendered in: all `astrology-suite/*` blocks.
- `.astrology-suite-no-border`
  - Purpose: Removes wrapper border when border setting is disabled.
  - Rendered in: all blocks.
- `.astrology-suite-output`
  - Purpose: Results/output container.
  - Rendered in: all blocks.

Legacy `.wp-block-openastro-widget` and `.openastro-*` classes remain supported for existing pages and custom CSS.

Example:

```css
.wp-block-astrology-suite-widget {
  max-width: 900px;
  margin: 0 auto;
}
```

## Form / Input Controls

- `.astrology-suite-form-header`
  - Purpose: Top row containing quick actions like history dropdown.
  - Rendered in: all blocks.
- `.astrology-suite-history-label`
  - Purpose: Label for saved-input selector.
  - Rendered in: all blocks.
- `.astrology-suite-history-select`
  - Purpose: Dropdown to load past inputs.
  - Rendered in: all blocks.
- `.astrology-suite-load-recent-wrap`
  - Purpose: Saved-input selector wrapper.
  - Rendered in: all blocks.
- `.astrology-suite-load-recent-label`
  - Purpose: Saved-input selector label.
  - Rendered in: all blocks.
- `.astrology-suite-load-recent-select`
  - Purpose: Saved-input select control.
  - Rendered in: all blocks.
- `.astrology-suite-load-recent-panel`
  - Purpose: Saved-input selector panel.
  - Rendered in: all blocks.
- `.astrology-suite-form`
  - Purpose: Input form grid.
  - Rendered in: all blocks.
- `.astrology-suite-input`
  - Purpose: Text/date/time/city fields.
  - Rendered in: all blocks.
- `.astrology-suite-city-field`
  - Purpose: City autocomplete field wrapper and suggestion popover anchor.
  - Rendered in: all blocks.
- `.astrology-suite-city-input`
  - Purpose: City autocomplete text field.
  - Rendered in: all blocks.
- `.astrology-suite-city-loading`
  - Purpose: City autocomplete loading, empty, error, and selected-state message.
  - Rendered in: all blocks.
- `.astrology-suite-inline`
  - Purpose: Inline checkbox row (minor aspects).
  - Rendered in: natal blocks.
- `.astrology-suite-btn`
  - Purpose: Primary submit button.
  - Rendered in: all blocks.
- `.astrology-suite-status`
  - Purpose: Helper/status text.
  - Rendered in: all blocks.
- `.astrology-suite-results`
  - Purpose: City autocomplete list wrapper.
  - Rendered in: all blocks.
- `.astrology-suite-result-btn`
  - Purpose: City suggestion item.
  - Rendered in: all blocks.
- `.astrology-suite-result-main`, `.astrology-suite-result-primary`, `.astrology-suite-result-name`, `.astrology-suite-result-country`, `.astrology-suite-result-meta`, `.astrology-suite-result-meta-item`
  - Purpose: City suggestion row text, country badge, metadata row, and metadata items.
  - Rendered in: all blocks.

Example:

```css
.astrology-suite-input {
  border-radius: 8px;
  border-color: #d6d6d6;
}
```

## Report / Cards

- `.astrology-suite-report-title`
  - Purpose: Main report title (`h2`).
  - Rendered in: `astrology-suite/report-only`, `astrology-suite/chart-report`.
- `.astrology-suite-card`
  - Purpose: Shared report/sign/chart card panel.
  - Rendered in: report, chart, and simple-sign outputs.
- `.astrology-suite-access-note`
  - Purpose: Access-state message shown when the current visitor cannot use protected calculation routes.
  - Rendered in: all blocks when the viewer is not logged in with content-editing permission.
- `.astrology-suite-planet-item`
  - Purpose: Per-planet interpretation item.
  - Rendered in: report modes.

Example:

```css
.astrology-suite-card {
  border-radius: 12px;
  border-color: #e8e8e8;
}
```

## Simple Signs

- `.astrology-suite-simple-sign-card`
  - Purpose: Simple-sign result card.
  - Rendered in: all simple-sign blocks.
- `.astrology-suite-simple-sign-value`
  - Purpose: Sign + degree line.
  - Rendered in: all simple-sign blocks.
- `.astrology-suite-simple-sign-interpretation`
  - Purpose: Interpretation text section.
  - Rendered when interpretation is enabled.

Example:

```css
.astrology-suite-simple-sign-value {
  color: #1f4a8a;
}
```

## Chart / Print / Glyphs

- `.astrology-suite-chart-card`
  - Purpose: Natal wheel card wrapper.
  - Rendered in: `astrology-suite/chart-only`, `astrology-suite/chart-report`.
- `.astrology-suite-chart`
  - Purpose: SVG chart container.
  - Rendered in: chart modes.
- `.astrology-suite-print-btn`
  - Purpose: Chart print button.
  - Rendered when print option is enabled.
- `.astrology-suite-astro-glyph`
  - Purpose: Astrological glyph span using AstrologySuiteStarFont.
  - Rendered in report/simple-sign output.

Example:

```css
.astrology-suite-print-btn {
  border-radius: 999px;
}
```

## Typography Variables

Astrology Suite for FreeAstroAPI exposes CSS variables on `.wp-block-astrology-suite-widget`:

- `--astrology-suite-font-h2`
- `--astrology-suite-font-h3`
- `--astrology-suite-font-h4`
- `--astrology-suite-font-body`
- `--astrology-suite-font-table`
- `--astrology-suite-font-input`
- `--astrology-suite-font-button`
- `--astrology-suite-font-meta`
- `--astrology-suite-input-radius`
- `--astrology-suite-input-border-color`
- `--astrology-suite-input-bg`
- `--astrology-suite-input-text`
- `--astrology-suite-input-placeholder`
- `--astrology-suite-button-radius`
- `--astrology-suite-button-bg`
- `--astrology-suite-button-text`
- `--astrology-suite-button-border`
- `--astrology-suite-label-color`
- `--astrology-suite-label-weight`
- `--astrology-suite-focus-ring`

Legacy `--openastro-*` variables remain supported as fallbacks.

Example:

```css
.wp-block-astrology-suite-widget {
  --astrology-suite-font-h2: 34px;
  --astrology-suite-font-body: 17px;
}
```
