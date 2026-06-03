# Astrology Suite for FreeAstroAPI

Install this plugin to get Astrology Suite for FreeAstroAPI in one package.

## Includes

- Shared Astrology Suite settings page (`Settings > Astrology Suite`)
- REST proxy endpoints:
  - `GET /wp-json/astrology-suite/v1/geo/search`
  - `POST /wp-json/astrology-suite/v1/natal/calculate`
  - `POST /wp-json/astrology-suite/v1/natal/chart-svg`
  - `POST /wp-json/astrology-suite/v1/western/simple-signs`
  - `POST /wp-json/astrology-suite/v1/western/ephemeris`
- Gutenberg blocks (each includes the input form):
  - `astrology-suite/chart-only`
  - `astrology-suite/report-only`
  - `astrology-suite/chart-report`
  - `astrology-suite/simple-sign-sun`
  - `astrology-suite/simple-sign-moon`
  - `astrology-suite/simple-sign-rising`
  - `astrology-suite/simple-sign-midheaven`
  - `astrology-suite/ephemeris`
- Shortcodes:
  - `[astrology_suite mode="chart-report"]`
  - `[astrology_suite mode="chart-report" language="vi"]`
  - `[astrology_suite_chart_only]`
  - `[astrology_suite_report_only]`
  - `[astrology_suite_chart_report]`
  - `[astrology_suite_simple_sign_sun include_interpretation="true" interpretation_style="improved"]`
  - `[astrology_suite_simple_sign_moon include_interpretation="false"]`
  - `[astrology_suite_simple_sign_rising include_interpretation="true" interpretation_style="poetic"]`
  - `[astrology_suite_simple_sign_midheaven]`
  - `[astrology_suite_ephemeris]`

## Notes

- `Chart only` does not render a legend.
- `Ephemeris` renders a monthly FreeAstroAPI table grid with body filters, tropical/sidereal mode, optional city for local points, CSV download, and table-specific style controls.
- Report rendering can be customized in plugin settings.
- Report output can include birth context, optional themed interpretation groups, and clickable planet aspect links that open the matching FreeAstroAPI interpretation block in a modal; this does not use the psychological report flow.
- Chart SVG/PNG styling can be customized from the Custom Chart tab with presets, FreeAstroAPI-generated PNG previews, per-theme chart request bodies, or a custom chart_config JSON object from the FreeAstroAPI Chart Designer.
- Typography, colors, border, and ephemeris table styling can be customized in plugin settings.
- Forms use explicit 24-hour controls (`00`-`23`) for birth time.
- Natal chart/report forms include an "I don't know my birth time" option. When selected, chart and report requests send `time_known: false` and angle/house-dependent report sections are skipped if the API omits them.
- Frontend UI text can be localized from settings or with the shortcode `language` attribute. FreeAstroAPI interpretation text is displayed exactly as the API returns it; unsupported interpretation languages are not requested.
- Container background transparency, inputs, buttons, and Past inputs visuals are customizable (visibility, radius, border, colors, placeholder, labels, focus ring).
- Forms include a local “Past inputs…” dropdown (last 20 successful requests, browser-local only).
- Public visitors can submit natal chart, report, simple-sign, and ephemeris forms by default. Site admins can turn public calculations off in `Settings > Astrology Suite > API` to restrict calculations to logged-in users who can edit posts.
- CSS class reference:
  - [`docs/CSS-CLASSES.md`](docs/CSS-CLASSES.md)
- Visitor birth data is not persisted by default.

## External services

Astrology Suite connects to [FreeAstroAPI](https://www.freeastroapi.com/) to autocomplete cities and generate astrology calculations.

- City autocomplete sends the typed city query and optional country filter over HTTPS when someone types into the city field.
- Natal chart, report, simple-sign, and ephemeris requests send submitted astrology data and calculation options over HTTPS when a visitor submits the form while public calculations are enabled, or when an authenticated editor submits while public calculations are disabled.
- Calculation requests also include the site's configured FreeAstroAPI key in the server-to-server request header. The API key is not sent to the visitor's browser.
- The plugin does not store visitor birth data in WordPress by default. The optional “Past inputs” feature stores recent successful requests in the visitor's browser local storage only.
- Custom chart configs can be generated at [FreeAstroAPI Chart Designer](https://www.freeastroapi.com/dashboard/chart-designer), and per-theme request bodies follow the [FreeAstroAPI SVG/PNG chart endpoint](https://www.freeastroapi.com/docs/western/chart-svg).
- The ephemeris widget follows the [FreeAstroAPI Western Ephemeris endpoint](https://www.freeastroapi.com/docs/western/ephemeris).

Links:

- Terms of Service: [https://www.freeastroapi.com/terms](https://www.freeastroapi.com/terms)
- Privacy Policy: [https://www.freeastroapi.com/privacy](https://www.freeastroapi.com/privacy)

## Migration

- Old `freeastro/*` and `openastro/*` block names are legacy aliases.
- Use `Settings > Astrology Suite > Run Block Migrator` once to convert legacy content to `astrology-suite/*`.
- Existing `/wp-json/openastro/v1/*` routes remain available as compatibility aliases for `/wp-json/astrology-suite/v1/*`.
- Existing `[openastro]`, `[openastro_*]`, `[freeastro]`, and `[freeastro_*]` shortcodes are available as compatibility aliases.
- Existing `freeastro_*` options are auto-migrated internally on plugin init.
