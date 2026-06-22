=== Astrology Suite for FreeAstroAPI ===
Contributors: omegab
Tags: astrology, natal chart, horoscope, gutenberg, blocks, shortcodes
Requires at least: 6.6
Tested up to: 6.9
Requires PHP: 8.1
Stable tag: 0.3.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add interactive astrology blocks with natal charts, reports, simple sign widgets, monthly ephemeris tables, daily horoscope widgets, personalized horoscope widgets, and an astrology bot.

== Description ==

Astrology Suite for FreeAstroAPI helps you publish astrology experiences that feel fast, clean, and easy to use:

* Add interactive blocks directly in Gutenberg.
* Add the same widgets with shortcodes in classic content, shortcode blocks, or shortcode-ready template areas.
* Capture birth details with a built-in form (city autocomplete included).
* Render natal chart, natal report, or both.
* Offer simple sign widgets for Sun, Moon, Rising, and Midheaven.
* Publish monthly ephemeris tables with selectable bodies, tropical/sidereal mode, optional local points, and CSV download.
* Add a daily horoscope widget using sign, date, and timezone controls.
* Add a personalized horoscope widget using birth details, city autocomplete, target date, and personal transit context.
* Add a Western/Vedic astrology bot widget using birth details, city autocomplete, FreeAstroAPI MCP tool calls, and Gemini-generated chat answers.
* Use explicit 24-hour birth-time controls (`00`-`23`) instead of browser-local AM/PM labels.
* Let visitors mark birth time as unknown on natal chart/report forms, sending `time_known: false` to FreeAstroAPI.
* Localize frontend UI labels and validation text, and choose the natal interpretation response language from settings.
* Choose chart SVG/PNG themes from settings, customize each theme's chart request body, or paste a custom chart_config JSON object.
* Allow public visitor calculations, or restrict calculations to logged-in editors from the API settings tab.
* Customize styling, ephemeris table colors, bot chat colors, plugin background transparency, Past inputs visibility, and typography from plugin settings.
* Add optional birth context, thematic interpretation groups, and clickable planet aspect links that open matching FreeAstroAPI interpretation blocks without using the psychological report flow.
* Reuse recent requests with a "Past inputs" dropdown (stored in browser local storage).

Included blocks:

* `astrology-suite/chart-only`
* `astrology-suite/report-only`
* `astrology-suite/chart-report`
* `astrology-suite/simple-sign-sun`
* `astrology-suite/simple-sign-moon`
* `astrology-suite/simple-sign-rising`
* `astrology-suite/simple-sign-midheaven`
* `astrology-suite/ephemeris`
* `astrology-suite/daily-horoscope`
* `astrology-suite/personalized-horoscope`
* `astrology-suite/astrology-bot`

Included shortcodes:

* `[astrology_suite mode="chart-report"]`
* `[astrology_suite mode="chart-report" language="vi"]`
* `[astrology_suite_chart_only]`
* `[astrology_suite_report_only]`
* `[astrology_suite_chart_report]`
* `[astrology_suite_simple_sign_sun include_interpretation="true" interpretation_style="improved"]`
* `[astrology_suite_simple_sign_moon include_interpretation="false"]`
* `[astrology_suite_simple_sign_rising include_interpretation="true" interpretation_style="poetic"]`
* `[astrology_suite_simple_sign_midheaven]`
* `[astrology_suite_ephemeris]`
* `[astrology_suite_daily_horoscope]`
* `[astrology_suite_personalized_horoscope]`
* `[astrology_suite_astrology_bot]`

== External services ==

Astrology Suite for FreeAstroAPI connects to FreeAstroAPI (`https://www.freeastroapi.com/`) to autocomplete cities and generate astrology calculations used by the included blocks. The Astrology Bot also connects to Google Gemini to generate chat answers.

What is sent and when:

* When someone types at least two characters into the city field, the plugin sends the typed city query and optional country filter to FreeAstroAPI over HTTPS so matching cities and timezones can be returned.
* When a visitor submits a natal chart, report, simple-sign, ephemeris, daily horoscope, personalized horoscope, or astrology bot form while public calculations are enabled, or when an authenticated editor submits while public calculations are disabled, the plugin sends the submitted astrology data and calculation options to FreeAstroAPI over HTTPS. This may include the optional name field, birth date, birth time, city name, latitude, longitude, timezone, interpretation settings, enabled extra bodies, selected ephemeris month/year, selected ephemeris bodies, zodiac type, horoscope sign/date/timezone, horoscope target date, chat message/history/profile, the requested calculation mode, and whether minor aspects were requested.
* Astrology bot requests may send the chat message, recent chat history, selected Western/Vedic system, and submitted birth profile to FreeAstroAPI MCP and Google Gemini over HTTPS.
* Calculation requests also include the site's configured FreeAstroAPI key in the server-to-server request header so FreeAstroAPI can authenticate the request. The API key is not sent to the visitor's browser.
* Astrology bot answer requests include the site's configured Gemini API key in the server-to-server request header. The Gemini API key is not sent to the visitor's browser.
* The plugin does not store visitor birth data in WordPress by default. The optional “Past inputs” feature stores recent successful requests only in the visitor's local browser storage.

FreeAstroAPI Terms of Service: https://www.freeastroapi.com/terms
FreeAstroAPI Privacy Policy: https://www.freeastroapi.com/privacy
FreeAstroAPI Chart Designer: https://www.freeastroapi.com/dashboard/chart-designer
FreeAstroAPI Ephemeris Docs: https://www.freeastroapi.com/docs/western/ephemeris
FreeAstroAPI Daily Sign Horoscope Docs: https://www.freeastroapi.com/docs/western/daily-sign
FreeAstroAPI Daily Personal Horoscope Docs: https://www.freeastroapi.com/docs/western/daily-personal
FreeAstroAPI Western Natal Docs: https://www.freeastroapi.com/docs/western/natal
FreeAstroAPI Astrology Bot: https://www.freeastroapi.com/astrology-bot
Google Gemini API Key Docs: https://ai.google.dev/gemini-api/docs/api-key

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`, or install via WordPress plugin upload.
2. Activate **Astrology Suite for FreeAstroAPI** in the Plugins screen.
3. Get a FreeAstroAPI key and add it in **Settings > Astrology Suite**.
4. Add Astrology Suite blocks in the block editor.
5. Or add Astrology Suite shortcodes in shortcode-ready content.

== Frequently Asked Questions ==

= Do I need an API key? =

Yes. Add your key in **Settings > Astrology Suite**.

= Who can submit calculation requests? =

By default, public visitors can submit astrology calculation forms. Site admins can disable public calculations in **Settings > Astrology Suite > API** to restrict natal chart, report, simple-sign, ephemeris, daily horoscope, personalized horoscope, and astrology bot calculations to logged-in users who can edit posts. City autocomplete remains public.

= Is user birth data stored by default? =

No server-side storage is performed by default. The “Past inputs” list is kept in the visitor's local browser storage.

= Can I style the widgets? =

Yes. Use plugin settings for typography/colors and target documented CSS classes for theme-level customization.

== Screenshots ==

1. Frontend chart and report widget with saved birth input, generated natal wheel, and styled form controls.
2. Frontend natal report sections with Ascendant, Midheaven, and planet interpretation cards.
3. Frontend aspect dynamics table rendered below the report.
4. API settings screen with the FreeAstroAPI key field and service disclosure.
5. Report settings screen for report length, tables, angles, and chart print controls.
6. Style settings screen for colors, background transparency, border radius, typography, labels, and form controls.
7. Frontend ephemeris table with month navigation, body filters, and a styled monthly grid.
8. Frontend daily horoscope widget with sign selector, scores, lucky attributes, and guidance.
9. Frontend personalized horoscope widget with birth details, target date, and personal transit context.
10. Frontend astrology bot widget with Western/Vedic contacts, birth profile form, chat messages, and quick prompts.

== Changelog ==

= 0.3.2 =
* Added `astrology-suite/astrology-bot` block and `[astrology_suite_astrology_bot]` shortcode for the FreeAstroAPI Western/Vedic astrology bot experience.
* Added `/wp-json/astrology-suite/v1/astrology-bot/chat` REST proxy using the saved FreeAstroAPI key for MCP tool calls and the saved Gemini key for chat answers.
* Added API settings for Gemini API key/model and natal interpretation response language.
* Added Astrology Bot style controls for shell, header, screen, accent, and chat bubble colors.
* Added multilingual natal/simple-sign interpretation request support using FreeAstroAPI's supported language values.

= 0.3.1 =
* Added `astrology-suite/daily-horoscope` block and `[astrology_suite_daily_horoscope]` shortcode using the FreeAstroAPI Daily Sign Horoscope endpoint.
* Added `astrology-suite/personalized-horoscope` block and `[astrology_suite_personalized_horoscope]` shortcode using the FreeAstroAPI Daily Personal Horoscope endpoint.
* Added configurable planet aspect links that open FreeAstroAPI aspect interpretation blocks in a modal.
* Added optional aspect glyph display and thematic interpretation settings.
* Improved astrology glyph mappings for ASC, MC, Lilith, and aspect table rows.
* Improved report headings so missing house data no longer displays as "House -".

= 0.3.0 =
* Added `astrology-suite/ephemeris` block and `[astrology_suite_ephemeris]` shortcode.
* Added `/wp-json/astrology-suite/v1/western/ephemeris` REST proxy for FreeAstroAPI monthly table grids.
* Added ephemeris frontend with month navigation, body selectors, optional city-based local points, tropical/sidereal mode, CSV download, and plugin-matched table styling.
* Added Ephemeris Style settings for table grid, header, badge, today row, retrograde, ingress, and station colors.

= 0.2.9 =
* Added an API setting to allow public visitor calculations while keeping the FreeAstroAPI key server-side.
* Changed the API key field to "leave blank to keep current key" so the saved key is not echoed into admin page HTML.
* Split settings saves by tab to avoid hidden-field key exposure and accidental cross-tab option persistence.
* Optimized frontend requests so chart-only calls only chart SVG, report-only calls only natal calculation, and chart-report calls both.
* Sanitized upstream SVG chart responses before returning them to the frontend.
* Added explicit "Customize this body" and "Reset to preset" controls for per-theme chart API bodies.

= 0.2.8 =
* Added per-theme FreeAstroAPI chart request body editors for chart themes.
* Chart preview PNGs and frontend SVG chart requests now use the selected theme body.
* Updated Custom Chart help text for SVG/PNG chart body fields such as display_settings, fixed_stars, and chart_config.

= 0.2.7 =
* Added a Custom Chart settings tab with chart theme presets and FreeAstroAPI-generated PNG preview cards.
* Added an advanced custom chart_config JSON textarea for configs generated in FreeAstroAPI Chart Designer.
* Chart SVG requests now use the selected preset or custom chart_config.

= 0.2.6 =
* Added shortcode support for all Astrology Suite widgets.
* Added generic `[astrology_suite mode="..."]` shortcode plus named `[astrology_suite_*]` shortcodes.
* Added legacy `[openastro]`, `[openastro_*]`, `[freeastro]`, and `[freeastro_*]` shortcode aliases.

= 0.2.5 =
* Added `astrology-suite/*` block names and `/wp-json/astrology-suite/v1/*` REST routes.
* Kept `openastro/*` blocks and `/wp-json/openastro/v1/*` routes as legacy compatibility aliases.
* Updated Help and CSS docs to use Astrology Suite naming.

= 0.2.4 =
* Improved the city autocomplete dropdown with richer rows, country filters, and keyboard selection.

= 0.2.3 =
* Updated natal chart SVG generation to use FreeAstroAPI's current `/api/v1/natal/chart/` endpoint.
* Improved default widget form styling for cleaner inputs, buttons, and past-input controls.

= 0.2.2 =
* Renamed the plugin to Astrology Suite for FreeAstroAPI for WordPress.org review.
* Updated the text domain and approval-ready plugin slug to astrology-suite-freeastroapi.

= 0.2.1 =
* Documented the required FreeAstroAPI external service usage, data sent, and terms/privacy links.
* Moved upstream requests to the documented FreeAstroAPI API domain.
* Added authenticated-user protection for API-key-backed calculation routes.
* Added privacy-policy helper text for site owners.

= 0.2.0 =
* Added Astrology Suite for FreeAstroAPI unified widget blocks and settings improvements.
* Improved input and display customization options.
* Added and refined simple sign widgets.

== Upgrade Notice ==

= 0.3.2 =
Adds the Astrology Bot block/shortcode, Gemini key setting, bot style controls, and multilingual natal response language support.

= 0.3.1 =
Adds aspect interpretation modals, optional aspect glyphs, thematic interpretation groups, and cleaner report headings.

= 0.3.0 =
Adds the ephemeris block/shortcode, monthly table REST proxy, and Ephemeris Style controls.

= 0.2.9 =
Adds public calculation controls, safer API key handling, sanitized chart SVG responses, and mode-specific API calls.

= 0.2.8 =
Adds per-theme SVG/PNG chart request body editors and applies those bodies to preview PNGs and frontend chart SVGs.

= 0.2.7 =
Adds Custom Chart settings for chart SVG presets, previews, and custom chart_config JSON.

= 0.2.6 =
Adds shortcode support for all widget modes while keeping block behavior unchanged.

= 0.2.5 =
Adds Astrology Suite block and REST namespaces while keeping existing OpenAstro aliases compatible.

= 0.2.3 =
Fixes natal chart SVG rendering by using the current FreeAstroAPI chart endpoint.

= 0.2.2 =
Naming and text-domain update for WordPress.org review.

= 0.2.1 =
Security and documentation update for FreeAstroAPI service disclosure and API-key-backed calculation routes.
