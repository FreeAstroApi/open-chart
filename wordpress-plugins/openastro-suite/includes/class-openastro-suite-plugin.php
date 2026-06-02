<?php

namespace AstrologySuiteFreeAstroAPI;

if (!defined('ABSPATH')) {
    exit;
}

class Plugin
{
    private const RATE_LIMIT_MAX_REQUESTS = 30;
    private const RATE_LIMIT_WINDOW_SECONDS = 60;
    private const UPSTREAM_BASE_URL = 'https://api.freeastroapi.com/api/v1';
    private const UPSTREAM_SERVICE_URL = 'https://www.freeastroapi.com/';
    private const UPSTREAM_TERMS_URL = 'https://www.freeastroapi.com/terms';
    private const UPSTREAM_PRIVACY_URL = 'https://www.freeastroapi.com/privacy';
    private const UPSTREAM_SUPPORT_URL = 'https://www.freeastroapi.com/contact';
    private const UPSTREAM_CHART_DESIGNER_URL = 'https://www.freeastroapi.com/dashboard/chart-designer';
    private const UPSTREAM_CHART_DOCS_URL = 'https://www.freeastroapi.com/docs/western/chart-svg';
    private const UPSTREAM_EPHEMERIS_DOCS_URL = 'https://www.freeastroapi.com/docs/western/ephemeris';
    private const CALCULATION_CAPABILITY = 'edit_posts';
    private const BLOCK_NAMESPACE = 'astrology-suite';
    private const LEGACY_BLOCK_NAMESPACE = 'openastro';
    private const REST_NAMESPACE = 'astrology-suite/v1';
    private const LEGACY_REST_NAMESPACE = 'openastro/v1';
    private const SETTINGS_PAGE_SLUG = 'astrology-suite-settings';
    private const LEGACY_SETTINGS_PAGE_SLUG = 'openastro-settings';
    private const SETTINGS_API_PAGE = 'openastro-settings';
    private const WIDGET_MODES = [
        'chart-only',
        'report-only',
        'chart-report',
        'simple-sign-sun',
        'simple-sign-moon',
        'simple-sign-rising',
        'simple-sign-midheaven',
        'ephemeris',
    ];

    public const OPTION_API_KEY = 'openastro_api_key';
    public const OPTION_PUBLIC_CALCULATIONS = 'openastro_public_calculations';
    public const OPTION_REPORT_DETAIL = 'openastro_report_detail';
    public const OPTION_REPORT_MAX_PLANETS = 'openastro_report_max_planets';
    public const OPTION_REPORT_MAX_ASPECTS = 'openastro_report_max_aspects';
    public const OPTION_REPORT_SHOW_TABLES = 'openastro_report_show_tables';
    public const OPTION_REPORT_SHOW_ANGLES = 'openastro_report_show_angles';
    public const OPTION_CHART_SHOW_PRINT_BUTTON = 'openastro_chart_show_print_button';
    public const OPTION_CHART_THEME = 'openastro_chart_theme';
    public const OPTION_CHART_CUSTOM_CONFIG = 'openastro_chart_custom_config';
    public const OPTION_CHART_BODY_CURRENT = 'openastro_chart_body_current';
    public const OPTION_CHART_BODY_CLASSIC_MONO = 'openastro_chart_body_classic_mono';
    public const OPTION_CHART_BODY_TRANSPARENT_FRENCH = 'openastro_chart_body_transparent_french';
    public const OPTION_CHART_BODY_MIDNIGHT = 'openastro_chart_body_midnight';
    public const OPTION_CHART_BODY_PARCHMENT = 'openastro_chart_body_parchment';
    public const OPTION_CHART_BODY_CUSTOM = 'openastro_chart_body_custom';
    public const OPTION_OBJ_ASC = 'openastro_obj_asc';
    public const OPTION_OBJ_MC = 'openastro_obj_mc';
    public const OPTION_OBJ_CHIRON = 'openastro_obj_chiron';
    public const OPTION_OBJ_LILITH = 'openastro_obj_lilith';
    public const OPTION_OBJ_TRUE_NODE = 'openastro_obj_true_node';
    public const OPTION_OBJ_MEAN_NODE = 'openastro_obj_mean_node';
    public const OPTION_OBJ_PART_OF_FORTUNE = 'openastro_obj_part_of_fortune';
    public const OPTION_STYLE_SHOW_BORDER = 'openastro_style_show_border';
    public const OPTION_STYLE_BG_COLOR = 'openastro_style_bg_color';
    public const OPTION_STYLE_TRANSPARENT_BG = 'openastro_style_transparent_bg';
    public const OPTION_STYLE_TEXT_COLOR = 'openastro_style_text_color';
    public const OPTION_STYLE_SHOW_HISTORY = 'openastro_style_show_history';
    public const OPTION_STYLE_HISTORY_BG_COLOR = 'openastro_style_history_bg_color';
    public const OPTION_STYLE_HISTORY_BORDER_COLOR = 'openastro_style_history_border_color';
    public const OPTION_STYLE_HISTORY_TEXT_COLOR = 'openastro_style_history_text_color';
    public const OPTION_STYLE_INPUT_BORDER_RADIUS = 'openastro_style_input_border_radius';
    public const OPTION_STYLE_INPUT_BORDER_COLOR = 'openastro_style_input_border_color';
    public const OPTION_STYLE_INPUT_BG_COLOR = 'openastro_style_input_bg_color';
    public const OPTION_STYLE_INPUT_TEXT_COLOR = 'openastro_style_input_text_color';
    public const OPTION_STYLE_INPUT_PLACEHOLDER_COLOR = 'openastro_style_input_placeholder_color';
    public const OPTION_STYLE_BUTTON_BORDER_RADIUS = 'openastro_style_button_border_radius';
    public const OPTION_STYLE_BUTTON_BG_COLOR = 'openastro_style_button_bg_color';
    public const OPTION_STYLE_BUTTON_TEXT_COLOR = 'openastro_style_button_text_color';
    public const OPTION_STYLE_BUTTON_BORDER_COLOR = 'openastro_style_button_border_color';
    public const OPTION_STYLE_LABEL_COLOR = 'openastro_style_label_color';
    public const OPTION_STYLE_LABEL_WEIGHT = 'openastro_style_label_weight';
    public const OPTION_STYLE_FOCUS_RING_COLOR = 'openastro_style_focus_ring_color';
    public const OPTION_STYLE_ASTRO_FONT_SIZE = 'openastro_style_astro_font_size';
    public const OPTION_STYLE_ASTRO_FONT_COLOR = 'openastro_style_astro_font_color';
    public const OPTION_EPHEMERIS_TABLE_BG_COLOR = 'openastro_ephemeris_table_bg_color';
    public const OPTION_EPHEMERIS_TABLE_TEXT_COLOR = 'openastro_ephemeris_table_text_color';
    public const OPTION_EPHEMERIS_TABLE_BORDER_COLOR = 'openastro_ephemeris_table_border_color';
    public const OPTION_EPHEMERIS_TABLE_HEADER_BG_COLOR = 'openastro_ephemeris_table_header_bg_color';
    public const OPTION_EPHEMERIS_TABLE_HEADER_TEXT_COLOR = 'openastro_ephemeris_table_header_text_color';
    public const OPTION_EPHEMERIS_TABLE_BADGE_BG_COLOR = 'openastro_ephemeris_table_badge_bg_color';
    public const OPTION_EPHEMERIS_TABLE_BADGE_TEXT_COLOR = 'openastro_ephemeris_table_badge_text_color';
    public const OPTION_EPHEMERIS_TABLE_TODAY_BG_COLOR = 'openastro_ephemeris_table_today_bg_color';
    public const OPTION_EPHEMERIS_TABLE_TODAY_ACCENT_COLOR = 'openastro_ephemeris_table_today_accent_color';
    public const OPTION_EPHEMERIS_RETROGRADE_COLOR = 'openastro_ephemeris_retrograde_color';
    public const OPTION_EPHEMERIS_INGRESS_COLOR = 'openastro_ephemeris_ingress_color';
    public const OPTION_EPHEMERIS_STATION_COLOR = 'openastro_ephemeris_station_color';
    public const OPTION_TYPO_H2 = 'openastro_typo_h2';
    public const OPTION_TYPO_H3 = 'openastro_typo_h3';
    public const OPTION_TYPO_H4 = 'openastro_typo_h4';
    public const OPTION_TYPO_BODY = 'openastro_typo_body';
    public const OPTION_TYPO_TABLE = 'openastro_typo_table';
    public const OPTION_TYPO_INPUT = 'openastro_typo_input';
    public const OPTION_TYPO_BUTTON = 'openastro_typo_button';
    public const OPTION_TYPO_META = 'openastro_typo_meta';

    public static function boot(): void
    {
        add_action('init', [__CLASS__, 'migrate_legacy_options'], 5);
        add_action('admin_init', [__CLASS__, 'redirect_legacy_settings_request'], 1);
        add_action('admin_init', [__CLASS__, 'register_settings']);
        add_action('admin_init', [__CLASS__, 'add_privacy_policy_content']);
        add_action('admin_menu', [__CLASS__, 'register_menu']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets']);
        add_action('admin_notices', [__CLASS__, 'maybe_render_block_migration_notice']);
        add_action('admin_post_openastro_migrate_blocks', [__CLASS__, 'handle_block_migration']);
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
        add_action('init', [__CLASS__, 'register_blocks']);
        add_action('init', [__CLASS__, 'register_shortcodes']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'maybe_enqueue_shortcode_assets']);
        add_action('wp_footer', [__CLASS__, 'maybe_print_late_shortcode_styles'], 1);
        add_action('wp_ajax_astrology_suite_chart_preview', [__CLASS__, 'render_chart_preview_image']);
        add_action('wp_ajax_astrology_suite_style_chart_preview_svg', [__CLASS__, 'render_style_chart_preview_svg']);
        add_filter('plugin_action_links_' . plugin_basename(OPENASTRO_SUITE_FILE), [__CLASS__, 'add_plugin_action_links']);
    }

    public static function add_plugin_action_links(array $links): array
    {
        $settings_url = admin_url('admin.php?page=' . self::SETTINGS_PAGE_SLUG);
        $settings_link = '<a href="' . esc_url($settings_url) . '">' . esc_html__('Settings', 'astrology-suite-freeastroapi') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    private static function legacy_option_name(string $name): string
    {
        return str_replace('openastro_', 'freeastro_', $name);
    }

    private static function get_option_value(string $name, $default)
    {
        $sentinel = '__openastro_option_missing__';
        $value = get_option($name, $sentinel);
        if ($value !== $sentinel) {
            return $value;
        }
        return get_option(self::legacy_option_name($name), $default);
    }

    private static function current_user_can_calculate(): bool
    {
        return current_user_can(self::CALCULATION_CAPABILITY);
    }

    private static function public_calculations_enabled(): bool
    {
        return (bool) self::get_option_value(self::OPTION_PUBLIC_CALCULATIONS, true);
    }

    private static function current_request_can_calculate(): bool
    {
        return self::public_calculations_enabled() || self::current_user_can_calculate();
    }

    private static function chart_theme_presets(): array
    {
        static $presets = null;
        if ($presets !== null) {
            return $presets;
        }

        $raw = [
            'current' => [
                'label' => __('Current Default', 'astrology-suite-freeastroapi'),
                'description' => __('The existing light chart styling used by the plugin.', 'astrology-suite-freeastroapi'),
                'json' => <<<'JSON'
{
  "show_color_background": false,
  "custom_planet_color": "#000000"
}
JSON
            ],
            'classic_mono' => [
                'label' => __('Classic Monochrome', 'astrology-suite-freeastroapi'),
                'description' => __('Clean white chart with dark glyphs, soft grey rings, and emphasized angle lines.', 'astrology-suite-freeastroapi'),
                'json' => <<<'JSON'
{
  "chart_background": "#FFFFFF",
  "custom_planet_color": "#000000",
  "custom_sign_color": "#000000",
  "custom_house_color": "#232323",
  "degree_label_color": "#444444",
  "custom_sign_bg_color": "#00000000",
  "custom_house_bg_color": "#FFFFFF",
  "custom_sign_colors": [
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000"
  ],
  "custom_planet_colors": {
    "asc": "#791a3e",
    "dsc": "#61177c",
    "mc": "#791a3e",
    "ic": "#5c0700"
  },
  "sign_line_color": "#C0C0C0",
  "house_line_color": "#C0C0C0",
  "sign_ring_inner_color": "#444444",
  "sign_ring_outer_color": "#444444",
  "house_ring_inner_color": "#C0C0C0",
  "house_ring_outer_color": "#C0C0C0",
  "asc_line_color": "#000000",
  "dsc_line_color": "#000000",
  "mc_line_color": "#000000",
  "ic_line_color": "#000000",
  "angle_label_color": "#444444",
  "asc_label_color": "#606060",
  "dsc_label_color": "#606060",
  "mc_label_color": "#606060",
  "ic_label_color": "#606060",
  "sign_tick_color": "#929292",
  "long_tick_color": "#C0C0C0",
  "short_tick_color": "#C0C0C0",
  "planet_connector_color": "#232323",
  "sign_ring_thickness_fraction": 0.17,
  "house_ring_thickness_fraction": 0.08,
  "center_disk_fraction": 0.42,
  "planet_symbol_scale": 0.41,
  "planet_spacing_scale": 1.25,
  "planet_radius_offset": -10,
  "round_planet_glyphs": false,
  "sign_symbol_scale": 0.8,
  "round_sign_wheel_glyphs": false,
  "house_number_scale": 0.3,
  "degree_label_scale": 0.6,
  "degree_label_minute_scale": 1.13,
  "degree_label_sign_scale": 1.31,
  "degree_label_row_gap": 1.95,
  "angle_label_scale": 0.67,
  "asc_label_scale": 0.67,
  "sign_line_width": 0.75,
  "house_line_width": 1.4,
  "sign_ring_inner_width": 1.4,
  "asc_line_width": 3,
  "dsc_line_width": 3,
  "mc_line_width": 3,
  "ic_line_width": 3,
  "sign_tick_width": 0.6,
  "long_sign_tick_width": 1,
  "sign_background_opacity": 1,
  "house_background_opacity": 0.71,
  "show_planet_connectors": true,
  "planet_connector_opacity": 0.24,
  "show_aspect_symbols": true,
  "show_aspect_lines": true,
  "show_house_ring": true,
  "show_house_numbers": true,
  "show_house_separators": true,
  "show_house_ring_circles": true,
  "show_sign_ticks": true,
  "show_retrograde_markers": true,
  "show_degree_labels": true,
  "show_angle_labels": true,
  "show_horoscope_shape": false,
  "horoscope_shape_style": "subtle",
  "horoscope_shape_label": false,
  "embed_horoscope_shape_metadata": false,
  "angle_marker_style": "french_arrow",
  "retrograde_marker_style": "rx",
  "degree_label_format": "minutes",
  "degree_label_precision": 1,
  "houses_inside_planets": true,
  "french_style": false,
  "show_color_background": true
}
JSON
            ],
            'transparent_french' => [
                'label' => __('Transparent French', 'astrology-suite-freeastroapi'),
                'description' => __('Transparent wheel with restrained technical lines and French-style labels.', 'astrology-suite-freeastroapi'),
                'json' => <<<'JSON'
{
  "chart_background": "#00000000",
  "custom_planet_color": "#262626",
  "custom_sign_color": "#111111",
  "custom_house_color": "#333333",
  "degree_label_color": "#262626",
  "custom_sign_bg_color": "#00000000",
  "custom_house_bg_color": "#00000000",
  "custom_sign_colors": [
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000"
  ],
  "custom_sign_glyph_colors": {},
  "custom_planet_colors": {},
  "custom_house_colors": [
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000"
  ],
  "sign_line_color": "#2F2F2F",
  "house_line_color": "#6B7280",
  "sign_ring_inner_color": "#111111",
  "sign_ring_outer_color": "#111111",
  "house_ring_inner_color": "#9CA3AF",
  "house_ring_outer_color": "#6B7280",
  "asc_line_color": "#111111",
  "dsc_line_color": "#111111",
  "mc_line_color": "#111111",
  "ic_line_color": "#111111",
  "sign_tick_color": "#111111",
  "long_tick_color": "#111111",
  "short_tick_color": "#111111",
  "planet_connector_color": "#EDE8F8",
  "aspect_conjunction_color": "#C08430",
  "aspect_opposition_color": "#B91C1C",
  "aspect_trine_color": "#2563EB",
  "aspect_square_color": "#DC2626",
  "aspect_sextile_color": "#15803D",
  "aspect_quincunx_color": "#7C3AED",
  "sign_ring_thickness_fraction": 0.2,
  "house_ring_thickness_fraction": 0.1,
  "center_disk_fraction": 0.38,
  "planet_symbol_scale": 0.62,
  "planet_radius_offset": 0,
  "round_planet_glyphs": false,
  "sign_symbol_scale": 0.72,
  "round_sign_wheel_glyphs": false,
  "house_number_scale": 0.38,
  "degree_label_scale": 0.58,
  "degree_label_degree_scale": 1,
  "degree_label_minute_scale": 1,
  "degree_label_sign_scale": 1.25,
  "degree_label_row_gap": 1.55,
  "french_planet_radius_offset": 0,
  "long_sign_tick_length": 8,
  "short_sign_tick_length": 3,
  "sign_line_width": 1,
  "house_line_width": 0.75,
  "sign_ring_inner_width": 1,
  "sign_ring_outer_width": 1,
  "house_ring_inner_width": 0.75,
  "house_ring_outer_width": 0.75,
  "asc_line_width": 1.5,
  "dsc_line_width": 1.5,
  "mc_line_width": 1.5,
  "ic_line_width": 1.5,
  "sign_tick_width": 0.35,
  "long_sign_tick_width": 1,
  "short_sign_tick_width": 0.35,
  "planet_connector_width": 1,
  "aspect_conjunction_width": 1.5,
  "aspect_opposition_width": 1.5,
  "aspect_trine_width": 1.25,
  "aspect_square_width": 1.35,
  "aspect_sextile_width": 1.15,
  "aspect_quincunx_width": 1,
  "sign_background_opacity": 0.18,
  "house_background_opacity": 0.1,
  "show_planet_connectors": true,
  "planet_connector_opacity": 0.6,
  "show_aspect_symbols": false,
  "show_aspect_lines": true,
  "show_house_ring": true,
  "show_house_numbers": true,
  "show_house_separators": true,
  "show_house_ring_circles": true,
  "show_sign_ticks": false,
  "show_retrograde_markers": true,
  "show_degree_labels": true,
  "show_angle_labels": true,
  "show_horoscope_shape": false,
  "horoscope_shape_style": "subtle",
  "horoscope_shape_color": "#D97706",
  "horoscope_shape_label": true,
  "embed_horoscope_shape_metadata": true,
  "show_pattern_overlays": false,
  "pattern_overlay_style": "subtle",
  "pattern_overlay_labels": false,
  "pattern_overlay_max_items": 4,
  "embed_pattern_metadata": false,
  "retrograde_marker_style": "R",
  "degree_label_format": "minutes",
  "degree_label_precision": 0,
  "houses_inside_planets": true,
  "french_style": true,
  "show_color_background": false
}
JSON
            ],
            'midnight' => [
                'label' => __('Midnight Zodiac', 'astrology-suite-freeastroapi'),
                'description' => __('Dark celestial chart with colored signs, violet rings, and bright glyphs.', 'astrology-suite-freeastroapi'),
                'json' => <<<'JSON'
{
  "chart_background": "#0B0710",
  "custom_planet_color": "#EDE8F8",
  "custom_sign_color": "#D8B96A",
  "custom_house_color": "#E5E7EB",
  "degree_label_color": "#EDE8F8",
  "custom_sign_bg_color": "#16111D",
  "custom_house_bg_color": "#00000000",
  "custom_sign_colors": [
    "#EF4444",
    "#D9A441",
    "#FACC15",
    "#38BDF8",
    "#F97316",
    "#34D399",
    "#FBBF24",
    "#A855F7",
    "#F43F5E",
    "#C08430",
    "#8B5CF6",
    "#60A5FA"
  ],
  "custom_sign_glyph_colors": {},
  "custom_planet_colors": {},
  "custom_house_colors": [
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000"
  ],
  "sign_line_color": "#8B6FB3",
  "house_line_color": "#8B6FB3",
  "sign_ring_inner_color": "#8B6FB3",
  "sign_ring_outer_color": "#8B6FB3",
  "house_ring_inner_color": "#8B6FB3",
  "house_ring_outer_color": "#8B6FB3",
  "asc_line_color": "#A78BFA",
  "dsc_line_color": "#A78BFA",
  "mc_line_color": "#A78BFA",
  "ic_line_color": "#A78BFA",
  "sign_tick_color": "#8B6FB3",
  "long_tick_color": "#8B6FB3",
  "short_tick_color": "#8B6FB3",
  "planet_connector_color": "#EDE8F8",
  "aspect_conjunction_color": "#FBBF24",
  "aspect_opposition_color": "#F472B6",
  "aspect_trine_color": "#3B82F6",
  "aspect_square_color": "#EF4444",
  "aspect_sextile_color": "#34D399",
  "aspect_quincunx_color": "#A78BFA",
  "sign_ring_thickness_fraction": 0.16,
  "house_ring_thickness_fraction": 0.05,
  "center_disk_fraction": 0.45,
  "planet_symbol_scale": 0.35,
  "planet_radius_offset": 0,
  "round_planet_glyphs": false,
  "sign_symbol_scale": 0.6,
  "round_sign_wheel_glyphs": false,
  "house_number_scale": 0.25,
  "degree_label_scale": 0.6,
  "degree_label_degree_scale": 1,
  "degree_label_minute_scale": 1,
  "degree_label_sign_scale": 1.25,
  "degree_label_row_gap": 1.55,
  "french_planet_radius_offset": 0,
  "long_sign_tick_length": 8,
  "short_sign_tick_length": 3,
  "sign_line_width": 1,
  "house_line_width": 0.75,
  "sign_ring_inner_width": 1,
  "sign_ring_outer_width": 1,
  "house_ring_inner_width": 0.75,
  "house_ring_outer_width": 0.75,
  "asc_line_width": 1.5,
  "dsc_line_width": 1.5,
  "mc_line_width": 1.5,
  "ic_line_width": 1.5,
  "sign_tick_width": 0.35,
  "long_sign_tick_width": 0.5,
  "short_sign_tick_width": 0.35,
  "planet_connector_width": 1,
  "aspect_conjunction_width": 1.5,
  "aspect_opposition_width": 1.5,
  "aspect_trine_width": 1.25,
  "aspect_square_width": 1.35,
  "aspect_sextile_width": 1.15,
  "aspect_quincunx_width": 1,
  "sign_background_opacity": 0.18,
  "house_background_opacity": 0.1,
  "show_planet_connectors": true,
  "planet_connector_opacity": 0.6,
  "show_aspect_symbols": false,
  "show_aspect_lines": true,
  "show_house_ring": true,
  "show_house_numbers": true,
  "show_house_separators": true,
  "show_house_ring_circles": true,
  "show_sign_ticks": true,
  "show_retrograde_markers": false,
  "show_degree_labels": true,
  "show_angle_labels": true,
  "show_horoscope_shape": false,
  "horoscope_shape_style": "subtle",
  "horoscope_shape_color": "#D97706",
  "horoscope_shape_label": true,
  "embed_horoscope_shape_metadata": true,
  "show_pattern_overlays": false,
  "pattern_overlay_style": "subtle",
  "pattern_overlay_labels": false,
  "pattern_overlay_max_items": 4,
  "embed_pattern_metadata": false,
  "retrograde_marker_style": "R",
  "degree_label_format": "degree",
  "degree_label_precision": 0,
  "houses_inside_planets": true,
  "french_style": false,
  "show_color_background": false
}
JSON
            ],
            'parchment' => [
                'label' => __('Parchment Gold', 'astrology-suite-freeastroapi'),
                'description' => __('Warm parchment palette with gold rings and earthy labels.', 'astrology-suite-freeastroapi'),
                'json' => <<<'JSON'
{
  "chart_background": "#F8F3EA",
  "custom_planet_color": "#211A16",
  "custom_sign_color": "#9A6B2F",
  "custom_house_color": "#3A332E",
  "degree_label_color": "#211A16",
  "custom_sign_bg_color": "#EFE3D1",
  "custom_house_bg_color": "#00000000",
  "custom_sign_colors": [
    "#EF4444",
    "#D9A441",
    "#FACC15",
    "#38BDF8",
    "#F97316",
    "#34D399",
    "#FBBF24",
    "#A855F7",
    "#F43F5E",
    "#C08430",
    "#8B5CF6",
    "#60A5FA"
  ],
  "custom_sign_glyph_colors": {},
  "custom_planet_colors": {},
  "custom_house_colors": [
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000",
    "#00000000"
  ],
  "sign_line_color": "#B98E54",
  "house_line_color": "#C8A66C",
  "sign_ring_inner_color": "#B98E54",
  "sign_ring_outer_color": "#7C5A2C",
  "house_ring_inner_color": "#D6BA85",
  "house_ring_outer_color": "#B98E54",
  "asc_line_color": "#6F4E21",
  "dsc_line_color": "#6F4E21",
  "mc_line_color": "#6F4E21",
  "ic_line_color": "#6F4E21",
  "sign_tick_color": "#7C5A2C",
  "long_tick_color": "#8B6FB3",
  "short_tick_color": "#8B6FB3",
  "planet_connector_color": "#EDE8F8",
  "aspect_conjunction_color": "#A16207",
  "aspect_opposition_color": "#B91C1C",
  "aspect_trine_color": "#1D4ED8",
  "aspect_square_color": "#DC2626",
  "aspect_sextile_color": "#15803D",
  "aspect_quincunx_color": "#7C3AED",
  "sign_ring_thickness_fraction": 0.16,
  "house_ring_thickness_fraction": 0.05,
  "center_disk_fraction": 0.45,
  "planet_symbol_scale": 0.35,
  "planet_radius_offset": 0,
  "round_planet_glyphs": false,
  "sign_symbol_scale": 0.6,
  "round_sign_wheel_glyphs": false,
  "house_number_scale": 0.25,
  "degree_label_scale": 0.6,
  "degree_label_degree_scale": 1,
  "degree_label_minute_scale": 1,
  "degree_label_sign_scale": 1.25,
  "degree_label_row_gap": 1.55,
  "french_planet_radius_offset": 0,
  "long_sign_tick_length": 8,
  "short_sign_tick_length": 3,
  "sign_line_width": 1,
  "house_line_width": 0.75,
  "sign_ring_inner_width": 1,
  "sign_ring_outer_width": 1,
  "house_ring_inner_width": 0.75,
  "house_ring_outer_width": 0.75,
  "asc_line_width": 1.5,
  "dsc_line_width": 1.5,
  "mc_line_width": 1.5,
  "ic_line_width": 1.5,
  "sign_tick_width": 0.35,
  "long_sign_tick_width": 0.5,
  "short_sign_tick_width": 0.35,
  "planet_connector_width": 1,
  "aspect_conjunction_width": 1.5,
  "aspect_opposition_width": 1.5,
  "aspect_trine_width": 1.25,
  "aspect_square_width": 1.35,
  "aspect_sextile_width": 1.15,
  "aspect_quincunx_width": 1,
  "sign_background_opacity": 0.2,
  "house_background_opacity": 0.12,
  "show_planet_connectors": true,
  "planet_connector_opacity": 0.6,
  "show_aspect_symbols": false,
  "show_aspect_lines": true,
  "show_house_ring": true,
  "show_house_numbers": true,
  "show_house_separators": true,
  "show_house_ring_circles": true,
  "show_sign_ticks": true,
  "show_retrograde_markers": false,
  "show_degree_labels": true,
  "show_angle_labels": true,
  "show_horoscope_shape": false,
  "horoscope_shape_style": "subtle",
  "horoscope_shape_color": "#D97706",
  "horoscope_shape_label": true,
  "embed_horoscope_shape_metadata": true,
  "show_pattern_overlays": false,
  "pattern_overlay_style": "subtle",
  "pattern_overlay_labels": false,
  "pattern_overlay_max_items": 4,
  "embed_pattern_metadata": false,
  "retrograde_marker_style": "R",
  "degree_label_format": "degree",
  "degree_label_precision": 0,
  "houses_inside_planets": true,
  "french_style": false,
  "show_color_background": false
}
JSON
            ],
        ];

        $presets = [];
        foreach ($raw as $slug => $preset) {
            $config = json_decode($preset['json'], true);
            $presets[$slug] = [
                'label' => $preset['label'],
                'description' => $preset['description'],
                'config' => is_array($config) ? self::normalize_chart_config_for_api($config) : [],
            ];
        }

        return $presets;
    }

    private static function custom_chart_config(): array
    {
        $raw = (string) self::get_option_value(self::OPTION_CHART_CUSTOM_CONFIG, '');
        if (trim($raw) === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) && !array_is_list($decoded) ? self::normalize_chart_config_for_api($decoded) : [];
    }

    private static function selected_chart_config(): array
    {
        $theme = (string) self::get_option_value(self::OPTION_CHART_THEME, 'current');
        $presets = self::chart_theme_presets();

        if ($theme === 'custom') {
            $custom = self::custom_chart_config();
            return $custom ?: $presets['current']['config'];
        }

        return isset($presets[$theme]) ? $presets[$theme]['config'] : $presets['current']['config'];
    }

    private static function chart_theme_body_option_names(): array
    {
        return [
            'current' => self::OPTION_CHART_BODY_CURRENT,
            'classic_mono' => self::OPTION_CHART_BODY_CLASSIC_MONO,
            'transparent_french' => self::OPTION_CHART_BODY_TRANSPARENT_FRENCH,
            'midnight' => self::OPTION_CHART_BODY_MIDNIGHT,
            'parchment' => self::OPTION_CHART_BODY_PARCHMENT,
            'custom' => self::OPTION_CHART_BODY_CUSTOM,
        ];
    }

    private static function selected_chart_body(): array
    {
        $theme = (string) self::get_option_value(self::OPTION_CHART_THEME, 'current');
        return self::chart_body_for_theme($theme);
    }

    private static function chart_body_for_theme(string $theme): array
    {
        $theme = self::sanitize_chart_theme($theme);
        $option_names = self::chart_theme_body_option_names();
        $option = $option_names[$theme] ?? self::OPTION_CHART_BODY_CURRENT;
        $raw = (string) self::get_option_value($option, '');
        if (trim($raw) !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && !array_is_list($decoded)) {
                return self::normalize_chart_body_for_api($decoded);
            }
        }

        return self::default_chart_body_for_theme($theme);
    }

    private static function default_chart_body_for_theme(string $theme): array
    {
        $theme = self::sanitize_chart_theme($theme);
        $theme_type = 'light';
        if ($theme === 'midnight') {
            $theme_type = 'dark';
        } elseif ($theme === 'classic_mono') {
            $theme_type = 'mono';
        }

        return [
            'size' => 760,
            'theme_type' => $theme_type,
            'show_metadata' => false,
            'display_settings' => self::chart_display_settings(),
            'chart_config' => self::chart_preview_config($theme),
        ];
    }

    private static function normalize_chart_body_for_api(array $body): array
    {
        foreach (['name', 'year', 'month', 'day', 'hour', 'minute', 'time_known', 'city', 'lat', 'lng', 'tz_str'] as $birth_key) {
            unset($body[$birth_key]);
        }

        if (isset($body['chart_config']) && is_array($body['chart_config'])) {
            $body['chart_config'] = self::normalize_chart_config_for_api($body['chart_config']);
        }

        if (isset($body['display_settings']) && is_array($body['display_settings']) && $body['display_settings'] === []) {
            $body['display_settings'] = (object) [];
        }

        return $body;
    }

    private static function apply_chart_body(array $payload, array $body, string $format, ?int $forced_size = null, ?array $fallback_config = null): array
    {
        $format = $format === 'png' ? 'png' : 'svg';
        $body = self::normalize_chart_body_for_api($body);
        $payload = array_replace_recursive($payload, $body);
        $payload['format'] = $format;
        if ($forced_size !== null) {
            $payload['size'] = $forced_size;
        } else {
            $payload['size'] = max(240, min(1600, (int) ($payload['size'] ?? 760)));
        }
        if ($format === 'png') {
            $payload['png_quality_scale'] = max(1.0, min(5.0, (float) ($payload['png_quality_scale'] ?? 1.25)));
        }
        $payload['theme_type'] = in_array((string) ($payload['theme_type'] ?? 'light'), ['light', 'dark', 'mono'], true) ? (string) $payload['theme_type'] : 'light';
        $payload['show_metadata'] = !empty($payload['show_metadata']);
        if (!isset($payload['display_settings']) || (!is_array($payload['display_settings']) && !is_object($payload['display_settings']))) {
            $payload['display_settings'] = self::chart_display_settings();
        }
        if (is_array($payload['display_settings']) && $payload['display_settings'] === []) {
            $payload['display_settings'] = (object) [];
        }
        if (empty($payload['chart_config']) || !is_array($payload['chart_config'])) {
            $payload['chart_config'] = $fallback_config ?? self::selected_chart_config();
        }
        $payload['chart_config'] = self::normalize_chart_config_for_api($payload['chart_config']);

        return $payload;
    }

    private static function chart_display_settings(): array
    {
        $enabled_features = self::get_enabled_features();
        return [
            'sun' => true,
            'moon' => true,
            'mercury' => true,
            'venus' => true,
            'mars' => true,
            'jupiter' => true,
            'saturn' => true,
            'uranus' => true,
            'neptune' => true,
            'pluto' => true,
            'asc' => in_array('asc', $enabled_features, true),
            'chiron' => in_array('chiron', $enabled_features, true),
            'lilith' => in_array('lilith', $enabled_features, true),
            'north_node' => in_array('true_node', $enabled_features, true) || in_array('mean_node', $enabled_features, true),
            'part_of_fortune' => in_array('part_of_fortune', $enabled_features, true),
        ];
    }

    private static function normalize_chart_config_for_api(array $config): array
    {
        foreach (['custom_planet_colors', 'custom_sign_glyph_colors'] as $object_key) {
            if (array_key_exists($object_key, $config) && is_array($config[$object_key]) && $config[$object_key] === []) {
                $config[$object_key] = (object) [];
            }
        }

        return $config;
    }

    private static function frontend_access_message(): string
    {
        return __('This astrology form is disabled for public visitors. Enable public calculations in Astrology Suite API settings, or log in with permission to edit posts.', 'astrology-suite-freeastroapi');
    }

    public static function migrate_legacy_options(): void
    {
        if ((bool) get_option('openastro_migration_done', false)) {
            return;
        }

        $keys = [
            self::OPTION_API_KEY,
            self::OPTION_PUBLIC_CALCULATIONS,
            self::OPTION_REPORT_DETAIL,
            self::OPTION_REPORT_MAX_PLANETS,
            self::OPTION_REPORT_MAX_ASPECTS,
            self::OPTION_REPORT_SHOW_TABLES,
            self::OPTION_REPORT_SHOW_ANGLES,
            self::OPTION_CHART_SHOW_PRINT_BUTTON,
            self::OPTION_CHART_THEME,
            self::OPTION_CHART_CUSTOM_CONFIG,
            self::OPTION_CHART_BODY_CURRENT,
            self::OPTION_CHART_BODY_CLASSIC_MONO,
            self::OPTION_CHART_BODY_TRANSPARENT_FRENCH,
            self::OPTION_CHART_BODY_MIDNIGHT,
            self::OPTION_CHART_BODY_PARCHMENT,
            self::OPTION_CHART_BODY_CUSTOM,
            self::OPTION_OBJ_ASC,
            self::OPTION_OBJ_MC,
            self::OPTION_OBJ_CHIRON,
            self::OPTION_OBJ_LILITH,
            self::OPTION_OBJ_TRUE_NODE,
            self::OPTION_OBJ_MEAN_NODE,
            self::OPTION_OBJ_PART_OF_FORTUNE,
            self::OPTION_STYLE_SHOW_BORDER,
            self::OPTION_STYLE_BG_COLOR,
            self::OPTION_STYLE_TEXT_COLOR,
            self::OPTION_STYLE_INPUT_BORDER_RADIUS,
            self::OPTION_STYLE_INPUT_BORDER_COLOR,
            self::OPTION_STYLE_INPUT_BG_COLOR,
            self::OPTION_STYLE_INPUT_TEXT_COLOR,
            self::OPTION_STYLE_INPUT_PLACEHOLDER_COLOR,
            self::OPTION_STYLE_BUTTON_BORDER_RADIUS,
            self::OPTION_STYLE_BUTTON_BG_COLOR,
            self::OPTION_STYLE_BUTTON_TEXT_COLOR,
            self::OPTION_STYLE_BUTTON_BORDER_COLOR,
            self::OPTION_STYLE_LABEL_COLOR,
            self::OPTION_STYLE_LABEL_WEIGHT,
            self::OPTION_STYLE_FOCUS_RING_COLOR,
            self::OPTION_STYLE_ASTRO_FONT_SIZE,
            self::OPTION_STYLE_ASTRO_FONT_COLOR,
        ];

        foreach ($keys as $key) {
            $value = get_option($key, '__openastro_option_missing__');
            if ($value !== '__openastro_option_missing__') {
                continue;
            }
            $legacy = self::legacy_option_name($key);
            $legacyValue = get_option($legacy, '__openastro_option_missing__');
            if ($legacyValue !== '__openastro_option_missing__') {
                update_option($key, $legacyValue);
            }
        }

        update_option('openastro_migration_done', 1, false);
    }

    public static function sanitize_typography_size($value): int
    {
        return max(10, min(48, (int) $value));
    }

    public static function sanitize_radius_size($value): int
    {
        return max(0, min(40, (int) $value));
    }

    public static function sanitize_hex_color_value($value): string
    {
        $candidate = trim((string) $value);
        return preg_match('/^#[0-9a-fA-F]{6}$/', $candidate) ? strtolower($candidate) : '#000000';
    }

    public static function sanitize_label_weight($value): string
    {
        $candidate = trim((string) $value);
        return in_array($candidate, ['normal', '500', '600', '700'], true) ? $candidate : 'normal';
    }

    public static function sanitize_api_key($value): string
    {
        $raw = trim((string) wp_unslash($value));
        if ($raw === '') {
            return (string) get_option(self::OPTION_API_KEY, '');
        }

        return sanitize_text_field($raw);
    }

    public static function sanitize_public_calculations($value): bool
    {
        return (bool) $value;
    }

    public static function sanitize_chart_theme($value): string
    {
        $candidate = sanitize_key((string) $value);
        $allowed = array_merge(array_keys(self::chart_theme_presets()), ['custom']);
        return in_array($candidate, $allowed, true) ? $candidate : 'current';
    }

    public static function sanitize_chart_custom_config($value): string
    {
        $raw = trim((string) wp_unslash($value));
        if ($raw === '') {
            return '';
        }

        if (strlen($raw) > 75000) {
            add_settings_error(
                self::OPTION_CHART_CUSTOM_CONFIG,
                'chart_custom_config_too_large',
                __('Custom chart JSON is too large. Paste only the chart_config object from the chart designer.', 'astrology-suite-freeastroapi')
            );
            return (string) get_option(self::OPTION_CHART_CUSTOM_CONFIG, '');
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded) || array_is_list($decoded)) {
            add_settings_error(
                self::OPTION_CHART_CUSTOM_CONFIG,
                'chart_custom_config_invalid_json',
                __('Custom chart JSON must be a valid JSON object.', 'astrology-suite-freeastroapi')
            );
            return (string) get_option(self::OPTION_CHART_CUSTOM_CONFIG, '');
        }

        $clean = self::sanitize_chart_config_value($decoded);
        if (!is_array($clean) || array_is_list($clean)) {
            add_settings_error(
                self::OPTION_CHART_CUSTOM_CONFIG,
                'chart_custom_config_invalid_object',
                __('Custom chart JSON must decode to an object.', 'astrology-suite-freeastroapi')
            );
            return (string) get_option(self::OPTION_CHART_CUSTOM_CONFIG, '');
        }

        $clean = self::normalize_chart_config_for_api($clean);

        return (string) wp_json_encode($clean, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public static function sanitize_chart_body_json($value): string
    {
        return self::sanitize_chart_body_json_for_option($value);
    }

    private static function sanitize_chart_body_json_for_option($value, ?string $option = null): string
    {
        if ($option !== null) {
            if (self::chart_body_reset_requested($option) || !self::chart_body_customize_requested($option)) {
                return '';
            }
        }

        $raw = trim((string) wp_unslash($value));
        if ($raw === '') {
            return '';
        }

        if (strlen($raw) > 120000) {
            add_settings_error(
                'openastro_chart_body',
                'chart_body_too_large',
                __('Chart body JSON is too large. Paste only the chart API body fields needed for this theme.', 'astrology-suite-freeastroapi')
            );
            return $option ? (string) get_option($option, '') : '';
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded) || array_is_list($decoded)) {
            add_settings_error(
                'openastro_chart_body',
                'chart_body_invalid_json',
                __('Chart body JSON must be a valid JSON object.', 'astrology-suite-freeastroapi')
            );
            return $option ? (string) get_option($option, '') : '';
        }

        $clean = self::sanitize_chart_config_value($decoded);
        if (!is_array($clean) || array_is_list($clean)) {
            add_settings_error(
                'openastro_chart_body',
                'chart_body_invalid_object',
                __('Chart body JSON must decode to an object.', 'astrology-suite-freeastroapi')
            );
            return $option ? (string) get_option($option, '') : '';
        }

        $clean = self::normalize_chart_body_for_api($clean);

        return (string) wp_json_encode($clean, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    private static function chart_body_customize_requested(string $option): bool
    {
        return self::posted_checkbox_is_checked($option . '_enabled');
    }

    private static function chart_body_reset_requested(string $option): bool
    {
        return self::posted_checkbox_is_checked($option . '_reset');
    }

    private static function posted_checkbox_is_checked(string $key): bool
    {
        if (!isset($_POST[$key])) {
            return false;
        }

        $value = wp_unslash($_POST[$key]);
        if (is_array($value)) {
            return false;
        }

        return in_array(strtolower((string) $value), ['1', 'true', 'on', 'yes'], true);
    }

    private static function sanitize_chart_config_value($value, int $depth = 0)
    {
        if ($depth > 8) {
            return null;
        }

        if (is_bool($value) || is_null($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value)) {
            return is_finite((float) $value) ? $value : 0;
        }

        if (is_string($value)) {
            return sanitize_text_field($value);
        }

        if (!is_array($value)) {
            return null;
        }

        $clean = [];
        if (array_is_list($value)) {
            foreach (array_slice($value, 0, 48) as $item) {
                $clean[] = self::sanitize_chart_config_value($item, $depth + 1);
            }
            return $clean;
        }

        foreach (array_slice($value, 0, 160, true) as $key => $item) {
            $clean_key = sanitize_key((string) $key);
            if ($clean_key === '') {
                continue;
            }
            $clean[$clean_key] = self::sanitize_chart_config_value($item, $depth + 1);
        }

        return $clean;
    }

    public static function register_settings(): void
    {
        $api_group = self::settings_group_for_tab('api');
        $report_group = self::settings_group_for_tab('report');
        $chart_group = self::settings_group_for_tab('chart');
        $objects_group = self::settings_group_for_tab('objects');
        $style_group = self::settings_group_for_tab('style');
        $ephemeris_group = self::settings_group_for_tab('ephemeris');
        $typography_group = self::settings_group_for_tab('typography');

        register_setting($api_group, self::OPTION_API_KEY, [
            'type' => 'string',
            'sanitize_callback' => [__CLASS__, 'sanitize_api_key'],
            'default' => '',
        ]);

        register_setting($api_group, self::OPTION_PUBLIC_CALCULATIONS, [
            'type' => 'boolean',
            'sanitize_callback' => [__CLASS__, 'sanitize_public_calculations'],
            'default' => true,
        ]);

        register_setting($report_group, self::OPTION_REPORT_DETAIL, [
            'type' => 'string',
            'sanitize_callback' => static function ($value): string {
                $val = sanitize_key((string) $value);
                return in_array($val, ['full', 'concise'], true) ? $val : 'full';
            },
            'default' => 'full',
        ]);

        register_setting($report_group, self::OPTION_REPORT_MAX_PLANETS, [
            'type' => 'integer',
            'sanitize_callback' => static fn($v): int => max(1, min(20, (int) $v)),
            'default' => 13,
        ]);

        register_setting($report_group, self::OPTION_REPORT_MAX_ASPECTS, [
            'type' => 'integer',
            'sanitize_callback' => static fn($v): int => max(1, min(100, (int) $v)),
            'default' => 40,
        ]);

        register_setting($report_group, self::OPTION_REPORT_SHOW_TABLES, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);

        register_setting($report_group, self::OPTION_REPORT_SHOW_ANGLES, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);

        register_setting($report_group, self::OPTION_CHART_SHOW_PRINT_BUTTON, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);

        register_setting($chart_group, self::OPTION_CHART_THEME, [
            'type' => 'string',
            'sanitize_callback' => [__CLASS__, 'sanitize_chart_theme'],
            'default' => 'current',
        ]);

        register_setting($chart_group, self::OPTION_CHART_CUSTOM_CONFIG, [
            'type' => 'string',
            'sanitize_callback' => [__CLASS__, 'sanitize_chart_custom_config'],
            'default' => '',
        ]);

        foreach (self::chart_theme_body_option_names() as $body_option) {
            register_setting($chart_group, $body_option, [
                'type' => 'string',
                'sanitize_callback' => static fn($value): string => self::sanitize_chart_body_json_for_option($value, $body_option),
                'default' => '',
            ]);
        }

        register_setting($objects_group, self::OPTION_OBJ_ASC, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);
        register_setting($objects_group, self::OPTION_OBJ_MC, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);
        register_setting($objects_group, self::OPTION_OBJ_CHIRON, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);
        register_setting($objects_group, self::OPTION_OBJ_LILITH, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);
        register_setting($objects_group, self::OPTION_OBJ_TRUE_NODE, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);
        register_setting($objects_group, self::OPTION_OBJ_MEAN_NODE, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);
        register_setting($objects_group, self::OPTION_OBJ_PART_OF_FORTUNE, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);

        register_setting($style_group, self::OPTION_STYLE_SHOW_BORDER, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);
        register_setting($style_group, self::OPTION_STYLE_BG_COLOR, [
            'type' => 'string',
            'sanitize_callback' => static function ($v): string {
                $value = trim((string) $v);
                return preg_match('/^#[0-9a-fA-F]{6}$/', $value) ? strtolower($value) : '#ffffff';
            },
            'default' => '#ffffff',
        ]);
        register_setting($style_group, self::OPTION_STYLE_TRANSPARENT_BG, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => false,
        ]);
        register_setting($style_group, self::OPTION_STYLE_TEXT_COLOR, [
            'type' => 'string',
            'sanitize_callback' => static function ($v): string {
                $value = trim((string) $v);
                return preg_match('/^#[0-9a-fA-F]{6}$/', $value) ? strtolower($value) : '#111111';
            },
            'default' => '#111111',
        ]);
        register_setting($style_group, self::OPTION_STYLE_SHOW_HISTORY, [
            'type' => 'boolean',
            'sanitize_callback' => static fn($v): bool => (bool) $v,
            'default' => true,
        ]);
        register_setting($style_group, self::OPTION_STYLE_HISTORY_BG_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#f9fafb']);
        register_setting($style_group, self::OPTION_STYLE_HISTORY_BORDER_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#e5e7eb']);
        register_setting($style_group, self::OPTION_STYLE_HISTORY_TEXT_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#111111']);
        register_setting($style_group, self::OPTION_STYLE_INPUT_BORDER_RADIUS, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_radius_size'], 'default' => 6]);
        register_setting($style_group, self::OPTION_STYLE_INPUT_BORDER_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#d1d5db']);
        register_setting($style_group, self::OPTION_STYLE_INPUT_BG_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#ffffff']);
        register_setting($style_group, self::OPTION_STYLE_INPUT_TEXT_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#111111']);
        register_setting($style_group, self::OPTION_STYLE_INPUT_PLACEHOLDER_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#6b7280']);
        register_setting($style_group, self::OPTION_STYLE_BUTTON_BORDER_RADIUS, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_radius_size'], 'default' => 6]);
        register_setting($style_group, self::OPTION_STYLE_BUTTON_BG_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#111827']);
        register_setting($style_group, self::OPTION_STYLE_BUTTON_TEXT_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#ffffff']);
        register_setting($style_group, self::OPTION_STYLE_BUTTON_BORDER_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#111827']);
        register_setting($style_group, self::OPTION_STYLE_LABEL_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#111111']);
        register_setting($style_group, self::OPTION_STYLE_LABEL_WEIGHT, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_label_weight'], 'default' => '600']);
        register_setting($style_group, self::OPTION_STYLE_FOCUS_RING_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#2563eb']);
        register_setting($style_group, self::OPTION_STYLE_ASTRO_FONT_SIZE, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 20]);
        register_setting($style_group, self::OPTION_STYLE_ASTRO_FONT_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#111111']);

        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_BG_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#ffffff']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_TEXT_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#111111']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_BORDER_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#e5e7eb']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_HEADER_BG_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#f8fafc']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_HEADER_TEXT_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#111111']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_BADGE_BG_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#f8fafc']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_BADGE_TEXT_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#475569']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_TODAY_BG_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#f8fafc']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_TABLE_TODAY_ACCENT_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#2563eb']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_RETROGRADE_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#b91c1c']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_INGRESS_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#1d4ed8']);
        register_setting($ephemeris_group, self::OPTION_EPHEMERIS_STATION_COLOR, ['type' => 'string', 'sanitize_callback' => [__CLASS__, 'sanitize_hex_color_value'], 'default' => '#a16207']);

        register_setting($typography_group, self::OPTION_TYPO_H2, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 28]);
        register_setting($typography_group, self::OPTION_TYPO_H3, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 22]);
        register_setting($typography_group, self::OPTION_TYPO_H4, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 18]);
        register_setting($typography_group, self::OPTION_TYPO_BODY, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 16]);
        register_setting($typography_group, self::OPTION_TYPO_TABLE, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 14]);
        register_setting($typography_group, self::OPTION_TYPO_INPUT, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 16]);
        register_setting($typography_group, self::OPTION_TYPO_BUTTON, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 16]);
        register_setting($typography_group, self::OPTION_TYPO_META, ['type' => 'integer', 'sanitize_callback' => [__CLASS__, 'sanitize_typography_size'], 'default' => 13]);

        add_settings_section('openastro_settings_main', __('Astrology Suite', 'astrology-suite-freeastroapi'), '__return_false', 'openastro-settings');
        add_settings_section('openastro_report_settings', __('Report Customization', 'astrology-suite-freeastroapi'), '__return_false', 'openastro-settings');
        add_settings_section('openastro_chart_settings', __('Custom Chart Themes', 'astrology-suite-freeastroapi'), '__return_false', 'openastro-settings');
        add_settings_section('openastro_objects_settings', __('Objects & Points', 'astrology-suite-freeastroapi'), '__return_false', 'openastro-settings');
        add_settings_section('openastro_style_settings', __('Style Customization', 'astrology-suite-freeastroapi'), '__return_false', 'openastro-settings');
        add_settings_section('openastro_ephemeris_style_settings', __('Ephemeris Table Styling', 'astrology-suite-freeastroapi'), '__return_false', 'openastro-settings');
        add_settings_section('openastro_typography_settings', __('Typography Customization', 'astrology-suite-freeastroapi'), '__return_false', 'openastro-settings');

        add_settings_field(
            self::OPTION_API_KEY,
            __('API key', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_api_key_field'],
            'openastro-settings',
            'openastro_settings_main'
        );

        add_settings_field(
            self::OPTION_PUBLIC_CALCULATIONS,
            __('Public calculations', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_public_calculations_field'],
            'openastro-settings',
            'openastro_settings_main'
        );

        add_settings_field(
            self::OPTION_REPORT_DETAIL,
            __('Report detail level', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_report_detail_field'],
            'openastro-settings',
            'openastro_report_settings'
        );

        add_settings_field(
            self::OPTION_REPORT_MAX_PLANETS,
            __('Max planets in report', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_report_max_planets_field'],
            'openastro-settings',
            'openastro_report_settings'
        );

        add_settings_field(
            self::OPTION_REPORT_MAX_ASPECTS,
            __('Max aspects in report', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_report_max_aspects_field'],
            'openastro-settings',
            'openastro_report_settings'
        );

        add_settings_field(
            self::OPTION_REPORT_SHOW_ANGLES,
            __('Show ASC/MC sections', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_report_show_angles_field'],
            'openastro-settings',
            'openastro_report_settings'
        );

        add_settings_field(
            self::OPTION_CHART_SHOW_PRINT_BUTTON,
            __('Show chart print button', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_chart_show_print_button_field'],
            'openastro-settings',
            'openastro_report_settings'
        );

        add_settings_field(
            self::OPTION_REPORT_SHOW_TABLES,
            __('Show tables', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_report_show_tables_field'],
            'openastro-settings',
            'openastro_report_settings'
        );

        add_settings_field(
            self::OPTION_CHART_THEME,
            __('Chart theme', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_chart_theme_field'],
            'openastro-settings',
            'openastro_chart_settings'
        );

        add_settings_field(
            self::OPTION_CHART_CUSTOM_CONFIG,
            __('Advanced custom config', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_chart_custom_config_field'],
            'openastro-settings',
            'openastro_chart_settings'
        );

        add_settings_field(
            'openastro_chart_theme_bodies',
            __('Chart API bodies', 'astrology-suite-freeastroapi'),
            [__CLASS__, 'render_chart_theme_bodies_field'],
            'openastro-settings',
            'openastro_chart_settings'
        );

        add_settings_field(self::OPTION_OBJ_ASC, __('Include ASC', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_obj_asc_field'], 'openastro-settings', 'openastro_objects_settings');
        add_settings_field(self::OPTION_OBJ_MC, __('Include MC', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_obj_mc_field'], 'openastro-settings', 'openastro_objects_settings');
        add_settings_field(self::OPTION_OBJ_CHIRON, __('Include Chiron', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_obj_chiron_field'], 'openastro-settings', 'openastro_objects_settings');
        add_settings_field(self::OPTION_OBJ_LILITH, __('Include Lilith', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_obj_lilith_field'], 'openastro-settings', 'openastro_objects_settings');
        add_settings_field(self::OPTION_OBJ_TRUE_NODE, __('Include True Node', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_obj_true_node_field'], 'openastro-settings', 'openastro_objects_settings');
        add_settings_field(self::OPTION_OBJ_MEAN_NODE, __('Include Mean Node', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_obj_mean_node_field'], 'openastro-settings', 'openastro_objects_settings');
        add_settings_field(self::OPTION_OBJ_PART_OF_FORTUNE, __('Include Part of Fortune', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_obj_part_of_fortune_field'], 'openastro-settings', 'openastro_objects_settings');

        add_settings_field('openastro_style_preview', __('Preview', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_preview_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_SHOW_BORDER, __('Show container border', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_show_border_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_BG_COLOR, __('Plugin background color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_bg_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_TRANSPARENT_BG, __('No plugin background', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_transparent_bg_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_TEXT_COLOR, __('Plugin text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_text_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field('openastro_style_group_history', __('Past inputs', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_group_history'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_SHOW_HISTORY, __('Show Past inputs', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_show_history_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_HISTORY_BG_COLOR, __('Past inputs background', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_history_bg_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_HISTORY_BORDER_COLOR, __('Past inputs border color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_history_border_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_HISTORY_TEXT_COLOR, __('Past inputs text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_history_text_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field('openastro_style_group_input', __('Input', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_group_input'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_INPUT_BORDER_RADIUS, __('Input border radius (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_input_border_radius_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_INPUT_BORDER_COLOR, __('Input border color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_input_border_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_INPUT_BG_COLOR, __('Input background color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_input_bg_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_INPUT_TEXT_COLOR, __('Input text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_input_text_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_INPUT_PLACEHOLDER_COLOR, __('Input placeholder color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_input_placeholder_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field('openastro_style_group_button', __('Button', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_group_button'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_BUTTON_BORDER_RADIUS, __('Button border radius (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_button_border_radius_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_BUTTON_BG_COLOR, __('Button background color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_button_bg_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_BUTTON_TEXT_COLOR, __('Button text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_button_text_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_BUTTON_BORDER_COLOR, __('Button border color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_button_border_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field('openastro_style_group_labels', __('Labels & Focus', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_group_labels'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_LABEL_COLOR, __('Label color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_label_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_LABEL_WEIGHT, __('Label weight', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_label_weight_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_FOCUS_RING_COLOR, __('Focus ring color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_focus_ring_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_ASTRO_FONT_SIZE, __('Glyph font size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_astro_font_size_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field(self::OPTION_STYLE_ASTRO_FONT_COLOR, __('Glyph font color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_style_astro_font_color_field'], 'openastro-settings', 'openastro_style_settings');
        add_settings_field('openastro_ephemeris_preview', __('Preview', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_style_preview_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_BG_COLOR, __('Table background', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_bg_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_TEXT_COLOR, __('Table text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_text_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_BORDER_COLOR, __('Grid/border color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_border_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_HEADER_BG_COLOR, __('Header background', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_header_bg_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_HEADER_TEXT_COLOR, __('Header text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_header_text_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_BADGE_BG_COLOR, __('Rows badge background', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_badge_bg_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_BADGE_TEXT_COLOR, __('Rows badge text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_badge_text_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_TODAY_BG_COLOR, __('Current day row background', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_today_bg_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_TABLE_TODAY_ACCENT_COLOR, __('Current day accent color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_table_today_accent_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_RETROGRADE_COLOR, __('Retrograde text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_retrograde_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_INGRESS_COLOR, __('Ingress text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_ingress_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_EPHEMERIS_STATION_COLOR, __('Station text color', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_ephemeris_station_color_field'], 'openastro-settings', 'openastro_ephemeris_style_settings');
        add_settings_field(self::OPTION_TYPO_H2, __('Title H2 size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_typography_h2_field'], 'openastro-settings', 'openastro_typography_settings');
        add_settings_field(self::OPTION_TYPO_H3, __('Section H3 size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_typography_h3_field'], 'openastro-settings', 'openastro_typography_settings');
        add_settings_field(self::OPTION_TYPO_H4, __('Subsection H4 size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_typography_h4_field'], 'openastro-settings', 'openastro_typography_settings');
        add_settings_field(self::OPTION_TYPO_BODY, __('Paragraph/body size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_typography_body_field'], 'openastro-settings', 'openastro_typography_settings');
        add_settings_field(self::OPTION_TYPO_TABLE, __('Table text size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_typography_table_field'], 'openastro-settings', 'openastro_typography_settings');
        add_settings_field(self::OPTION_TYPO_INPUT, __('Input text size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_typography_input_field'], 'openastro-settings', 'openastro_typography_settings');
        add_settings_field(self::OPTION_TYPO_BUTTON, __('Button text size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_typography_button_field'], 'openastro-settings', 'openastro_typography_settings');
        add_settings_field(self::OPTION_TYPO_META, __('Helper/meta text size (px)', 'astrology-suite-freeastroapi'), [__CLASS__, 'render_typography_meta_field'], 'openastro-settings', 'openastro_typography_settings');
    }

    public static function register_menu(): void
    {
        add_options_page(
            __('Astrology Suite', 'astrology-suite-freeastroapi'),
            __('Astrology Suite', 'astrology-suite-freeastroapi'),
            'manage_options',
            self::SETTINGS_PAGE_SLUG,
            [__CLASS__, 'render_settings_page']
        );

        add_options_page(
            __('Astrology Suite', 'astrology-suite-freeastroapi'),
            __('Astrology Suite', 'astrology-suite-freeastroapi'),
            'manage_options',
            self::LEGACY_SETTINGS_PAGE_SLUG,
            [__CLASS__, 'redirect_legacy_settings_page']
        );

        $page_param = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $current_page = is_string($page_param) ? sanitize_key(wp_unslash($page_param)) : '';
        if ($current_page !== self::LEGACY_SETTINGS_PAGE_SLUG) {
            remove_submenu_page('options-general.php', self::LEGACY_SETTINGS_PAGE_SLUG);
        }
    }

    public static function redirect_legacy_settings_page(): void
    {
        self::redirect_legacy_settings_request();
    }

    public static function enqueue_admin_assets(string $hook): void
    {
        if ($hook !== 'settings_page_' . self::SETTINGS_PAGE_SLUG) {
            return;
        }

        self::register_widget_assets();
        wp_enqueue_style('openastro-suite-widgets-style');
    }

    public static function redirect_legacy_settings_request(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $page_param = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!is_string($page_param) || sanitize_key(wp_unslash($page_param)) !== self::LEGACY_SETTINGS_PAGE_SLUG) {
            return;
        }

        $args = ['page' => self::SETTINGS_PAGE_SLUG];
        $tab_param = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (is_string($tab_param) && $tab_param !== '') {
            $args['tab'] = sanitize_key(wp_unslash($tab_param));
        }

        $migrated_param = filter_input(INPUT_GET, 'openastro_migrated', FILTER_SANITIZE_NUMBER_INT);
        if ($migrated_param !== null && $migrated_param !== false && $migrated_param !== '') {
            $args['astrology_suite_migrated'] = max(0, (int) $migrated_param);
        }

        wp_safe_redirect(add_query_arg($args, admin_url('admin.php')));
        exit;
    }

    public static function render_api_key_field(): void
    {
        $has_key = (string) self::get_option_value(self::OPTION_API_KEY, '') !== '';
        echo '<input type="password" class="regular-text" name="' . esc_attr(self::OPTION_API_KEY) . '" value="" autocomplete="new-password" placeholder="' . esc_attr__('Leave blank to keep current key', 'astrology-suite-freeastroapi') . '" />';
        echo '<p class="description">' . esc_html($has_key ? __('A FreeAstroAPI key is currently saved. Leave this field blank to keep it, or enter a new key to replace it.', 'astrology-suite-freeastroapi') : __('No FreeAstroAPI key is currently saved. Enter one to enable chart/report calculations.', 'astrology-suite-freeastroapi')) . '</p>';
        echo '<p class="description">' . esc_html__('Get a free API key from freeastroapi.com.', 'astrology-suite-freeastroapi') . '</p>';
        echo '<p class="description">' . esc_html__('The key is used only in server-to-server requests to FreeAstroAPI. It is not exposed to frontend visitors.', 'astrology-suite-freeastroapi') . '</p>';
    }

    public static function render_public_calculations_field(): void
    {
        $value = self::public_calculations_enabled();
        echo '<input type="hidden" name="' . esc_attr(self::OPTION_PUBLIC_CALCULATIONS) . '" value="0" />';
        echo '<label><input type="checkbox" name="' . esc_attr(self::OPTION_PUBLIC_CALCULATIONS) . '" value="1" ' . checked($value, true, false) . ' /> ' . esc_html__('Allow visitors who are not logged in to use astrology forms.', 'astrology-suite-freeastroapi') . '</label>';
        echo '<p class="description">' . esc_html__('Public requests still go through this WordPress site, use the saved API key server-side, and are rate-limited per visitor. Turn this off to restrict calculations to logged-in users who can edit posts.', 'astrology-suite-freeastroapi') . '</p>';
    }

    public static function add_privacy_policy_content(): void
    {
        if (!function_exists('wp_add_privacy_policy_content')) {
            return;
        }

        $policy = '<p>' . esc_html__('Astrology Suite for FreeAstroAPI connects to FreeAstroAPI to autocomplete cities and generate astrology calculations.', 'astrology-suite-freeastroapi') . '</p>';
        $policy .= '<p>' . esc_html__('When someone types into the city field, the plugin sends the typed city query and optional country filter to FreeAstroAPI over HTTPS so matching cities and timezones can be returned.', 'astrology-suite-freeastroapi') . '</p>';
        $policy .= '<p>' . esc_html__('When a visitor submits a natal chart, report, simple-sign, or ephemeris form while public calculations are enabled, or when an authenticated editor submits while public calculations are disabled, the plugin sends the submitted astrology data and calculation options to FreeAstroAPI over HTTPS. This may include the optional name field, birth date, birth time, city name, latitude, longitude, timezone, interpretation settings, selected ephemeris month/year, selected bodies, zodiac type, and the requested calculation mode. The site’s configured FreeAstroAPI key is also sent in the server-to-server request header and is not exposed to visitors.', 'astrology-suite-freeastroapi') . '</p>';
        $policy .= '<p>' . esc_html__('The plugin does not store visitor birth data in WordPress by default. The optional “Past inputs” feature stores the most recent successful requests in the visitor’s own browser local storage only.', 'astrology-suite-freeastroapi') . '</p>';
        $policy .= '<p>' . sprintf(
            wp_kses(
                /* translators: 1: FreeAstroAPI terms URL, 2: FreeAstroAPI privacy URL. */
                __('FreeAstroAPI terms of service: <a href="%1$s">Terms of Service</a>. FreeAstroAPI privacy policy: <a href="%2$s">Privacy Policy</a>.', 'astrology-suite-freeastroapi'),
                ['a' => ['href' => []]]
            ),
            esc_url(self::UPSTREAM_TERMS_URL),
            esc_url(self::UPSTREAM_PRIVACY_URL)
        ) . '</p>';

        wp_add_privacy_policy_content(
            __('Astrology Suite for FreeAstroAPI', 'astrology-suite-freeastroapi'),
            wp_kses_post($policy)
        );
    }

    public static function render_report_detail_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_REPORT_DETAIL, 'full');
        ?>
        <select name="<?php echo esc_attr(self::OPTION_REPORT_DETAIL); ?>">
            <option value="full" <?php selected($value, 'full'); ?>><?php esc_html_e('Full', 'astrology-suite-freeastroapi'); ?></option>
            <option value="concise" <?php selected($value, 'concise'); ?>><?php esc_html_e('Concise', 'astrology-suite-freeastroapi'); ?></option>
        </select>
        <?php
    }

    public static function render_report_max_planets_field(): void
    {
        $value = (int) self::get_option_value(self::OPTION_REPORT_MAX_PLANETS, 13);
        echo '<input type="number" min="1" max="20" name="' . esc_attr(self::OPTION_REPORT_MAX_PLANETS) . '" value="' . esc_attr((string) $value) . '" />';
    }

    public static function render_report_max_aspects_field(): void
    {
        $value = (int) self::get_option_value(self::OPTION_REPORT_MAX_ASPECTS, 40);
        echo '<input type="number" min="1" max="100" name="' . esc_attr(self::OPTION_REPORT_MAX_ASPECTS) . '" value="' . esc_attr((string) $value) . '" />';
    }

    public static function render_report_show_angles_field(): void
    {
        $value = (bool) self::get_option_value(self::OPTION_REPORT_SHOW_ANGLES, true);
        echo '<label><input type="checkbox" name="' . esc_attr(self::OPTION_REPORT_SHOW_ANGLES) . '" value="1" ' . checked($value, true, false) . ' /> ' . esc_html__('Include Ascendant and Midheaven sections.', 'astrology-suite-freeastroapi') . '</label>';
    }

    public static function render_report_show_tables_field(): void
    {
        $value = (bool) self::get_option_value(self::OPTION_REPORT_SHOW_TABLES, true);
        echo '<label><input type="checkbox" name="' . esc_attr(self::OPTION_REPORT_SHOW_TABLES) . '" value="1" ' . checked($value, true, false) . ' /> ' . esc_html__('Include planets/aspects tables.', 'astrology-suite-freeastroapi') . '</label>';
    }

    public static function render_chart_show_print_button_field(): void
    {
        $value = (bool) self::get_option_value(self::OPTION_CHART_SHOW_PRINT_BUTTON, true);
        echo '<label><input type="checkbox" name="' . esc_attr(self::OPTION_CHART_SHOW_PRINT_BUTTON) . '" value="1" ' . checked($value, true, false) . ' /> ' . esc_html__('Show small print button at top-right of natal wheel.', 'astrology-suite-freeastroapi') . '</label>';
    }

    public static function render_chart_theme_field(): void
    {
        $selected = (string) self::get_option_value(self::OPTION_CHART_THEME, 'current');
        $presets = self::chart_theme_presets();
        self::render_chart_theme_admin_styles();

        echo '<p class="description">' . esc_html__('Choose the chart request body sent to the FreeAstroAPI SVG/PNG chart endpoint.', 'astrology-suite-freeastroapi') . '</p>';
        echo '<p class="description">' . esc_html__('Preview images are PNG charts generated by FreeAstroAPI from sample birth data and each theme body.', 'astrology-suite-freeastroapi') . '</p>';
        echo '<div class="astrology-suite-chart-theme-grid">';

        foreach ($presets as $slug => $preset) {
            self::render_chart_theme_card($slug, $preset['label'], $preset['description'], $selected === $slug);
        }

        self::render_chart_theme_card(
            'custom',
            __('Custom JSON', 'astrology-suite-freeastroapi'),
            __('Use the custom theme body below, or the custom chart_config field when no body is saved.', 'astrology-suite-freeastroapi'),
            $selected === 'custom'
        );

        echo '</div>';
    }

    public static function render_chart_custom_config_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_CHART_CUSTOM_CONFIG, '');
        ?>
        <details class="astrology-suite-chart-advanced">
            <summary><?php esc_html_e('Advanced: paste a custom chart_config JSON object', 'astrology-suite-freeastroapi'); ?></summary>
            <p class="description">
                <?php
                echo wp_kses(
                    sprintf(
                        /* translators: %s: FreeAstroAPI chart designer URL. */
                        __('Generate a custom chart config in the <a href="%s" target="_blank" rel="noopener">FreeAstroAPI Chart Designer</a>, then paste only the JSON object here. Select “Custom JSON” above to use it.', 'astrology-suite-freeastroapi'),
                        esc_url(self::UPSTREAM_CHART_DESIGNER_URL)
                    ),
                    ['a' => ['href' => [], 'target' => [], 'rel' => []]]
                );
                ?>
            </p>
            <textarea
                name="<?php echo esc_attr(self::OPTION_CHART_CUSTOM_CONFIG); ?>"
                rows="18"
                class="large-text code"
                spellcheck="false"
                placeholder="<?php echo esc_attr__('Paste chart_config JSON here.', 'astrology-suite-freeastroapi'); ?>"
            ><?php echo esc_textarea($value); ?></textarea>
        </details>
        <?php
    }

    public static function render_chart_theme_bodies_field(): void
    {
        $presets = self::chart_theme_presets();
        $option_names = self::chart_theme_body_option_names();
        $labels = array_map(static fn($preset) => (string) $preset['label'], $presets);
        $labels['custom'] = __('Custom JSON', 'astrology-suite-freeastroapi');
        ?>
        <details class="astrology-suite-chart-advanced">
            <summary><?php esc_html_e('Advanced: customize the chart API body for each theme', 'astrology-suite-freeastroapi'); ?></summary>
            <p class="description">
                <?php
                echo wp_kses(
                    sprintf(
                        /* translators: %s: FreeAstroAPI chart docs URL. */
                        __('These are partial request bodies for <a href="%s" target="_blank" rel="noopener">FreeAstroAPI’s SVG/PNG chart endpoint</a>. The plugin still supplies the visitor’s birth data, forces SVG for frontend charts, and forces PNG for preview cards.', 'astrology-suite-freeastroapi'),
                        esc_url(self::UPSTREAM_CHART_DOCS_URL)
                    ),
                    ['a' => ['href' => [], 'target' => [], 'rel' => []]]
                );
                ?>
            </p>
            <p class="description">
                <?php esc_html_e('Supported useful body fields include size, theme_type, png_quality_scale, show_metadata, display_settings, fixed_stars, and chart_config. Birth fields such as name, year, time_known, city, lat, and lng are ignored here.', 'astrology-suite-freeastroapi'); ?>
            </p>
            <div class="astrology-suite-chart-body-list">
                <?php foreach ($option_names as $theme => $option) : ?>
                    <?php
                    $saved = (string) self::get_option_value($option, '');
                    $is_custom = trim($saved) !== '';
                    $body = $is_custom ? $saved : (string) wp_json_encode(self::default_chart_body_for_theme($theme), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                    $label = $labels[$theme] ?? $theme;
                    ?>
                    <details class="astrology-suite-chart-body-item">
                        <summary><?php echo esc_html(sprintf(__('%s chart body', 'astrology-suite-freeastroapi'), $label)); ?></summary>
                        <p class="description">
                            <?php esc_html_e('Preset body shown below is not saved unless "Customize this body" is checked. Leave it unchecked to keep the theme preset and dynamic object/display fallbacks.', 'astrology-suite-freeastroapi'); ?>
                        </p>
                        <p>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr($option . '_enabled'); ?>" value="1" <?php checked($is_custom, true); ?> />
                                <?php esc_html_e('Customize this body', 'astrology-suite-freeastroapi'); ?>
                            </label>
                            &nbsp;
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr($option . '_reset'); ?>" value="1" />
                                <?php esc_html_e('Reset to preset on save', 'astrology-suite-freeastroapi'); ?>
                            </label>
                        </p>
                        <textarea
                            name="<?php echo esc_attr($option); ?>"
                            rows="14"
                            class="large-text code"
                            spellcheck="false"
                        ><?php echo esc_textarea($body); ?></textarea>
                    </details>
                <?php endforeach; ?>
            </div>
        </details>
        <?php
    }

    private static function render_chart_theme_admin_styles(): void
    {
        static $printed = false;
        if ($printed) {
            return;
        }
        $printed = true;
        ?>
        <style>
            .astrology-suite-chart-theme-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
                gap: 12px;
                max-width: 1120px;
            }
            .astrology-suite-chart-theme-card {
                display: grid;
                gap: 8px;
                min-height: 100%;
                border: 1px solid #dcdcde;
                border-radius: 8px;
                padding: 12px;
                background: #fff;
                cursor: pointer;
                box-sizing: border-box;
            }
            .astrology-suite-chart-theme-card.is-selected {
                border-color: #2271b1;
                box-shadow: 0 0 0 2px rgba(34, 113, 177, 0.16);
            }
            .astrology-suite-chart-theme-card input {
                margin: 0;
            }
            .astrology-suite-chart-theme-card strong {
                font-size: 14px;
            }
            .astrology-suite-chart-theme-card span.description {
                color: #50575e;
                font-size: 12px;
                line-height: 1.4;
            }
            .astrology-suite-chart-preview {
                width: 100%;
                max-width: 180px;
                aspect-ratio: 1;
                border: 1px solid #dcdcde;
                border-radius: 8px;
                overflow: hidden;
                background-color: #f6f7f7;
                background-image: linear-gradient(45deg, #e5e7eb 25%, transparent 25%), linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #e5e7eb 75%), linear-gradient(-45deg, transparent 75%, #e5e7eb 75%);
                background-size: 16px 16px;
                background-position: 0 0, 0 8px, 8px -8px, -8px 0;
            }
            .astrology-suite-chart-preview img {
                display: block;
                width: 100%;
                height: auto;
            }
            .astrology-suite-chart-advanced {
                max-width: 980px;
                border: 1px solid #dcdcde;
                border-radius: 8px;
                padding: 12px;
                background: #fff;
            }
            .astrology-suite-chart-advanced summary {
                cursor: pointer;
                font-weight: 600;
            }
            .astrology-suite-chart-advanced textarea {
                margin-top: 10px;
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            }
            .astrology-suite-chart-body-list {
                display: grid;
                gap: 10px;
                margin-top: 12px;
            }
            .astrology-suite-chart-body-item {
                border-top: 1px solid #dcdcde;
                padding-top: 10px;
            }
            .astrology-suite-chart-body-item summary {
                font-weight: 600;
            }
        </style>
        <?php
    }

    private static function render_chart_theme_card(string $slug, string $label, string $description, bool $selected): void
    {
        $id = self::OPTION_CHART_THEME . '_' . sanitize_key($slug);
        echo '<label class="astrology-suite-chart-theme-card' . ($selected ? ' is-selected' : '') . '" for="' . esc_attr($id) . '">';
        echo '<input id="' . esc_attr($id) . '" type="radio" name="' . esc_attr(self::OPTION_CHART_THEME) . '" value="' . esc_attr($slug) . '" ' . checked($selected, true, false) . ' />';
        echo '<span class="astrology-suite-chart-preview"><img src="' . esc_url(self::chart_preview_url($slug)) . '" alt="' . esc_attr(sprintf(__('%s chart preview', 'astrology-suite-freeastroapi'), $label)) . '" loading="lazy" /></span>';
        echo '<strong>' . esc_html($label) . '</strong>';
        echo '<span class="description">' . esc_html($description) . '</span>';
        echo '</label>';
    }

    private static function chart_preview_url(string $theme): string
    {
        $theme = self::sanitize_chart_theme($theme);
        return add_query_arg(
            [
                'action' => 'astrology_suite_chart_preview',
                'theme' => $theme,
                'nonce' => wp_create_nonce('astrology_suite_chart_preview_' . $theme),
            ],
            admin_url('admin-ajax.php')
        );
    }

    private static function style_chart_preview_svg_url(): string
    {
        $theme = self::sanitize_chart_theme((string) self::get_option_value(self::OPTION_CHART_THEME, 'current'));
        $body = self::selected_chart_body();
        $hash = md5($theme . '|' . wp_json_encode($body));

        return add_query_arg(
            [
                'action' => 'astrology_suite_style_chart_preview_svg',
                'nonce' => wp_create_nonce('astrology_suite_style_chart_preview_svg_' . $hash),
            ],
            admin_url('admin-ajax.php')
        );
    }

    public static function render_chart_preview_image(): void
    {
        $theme = self::sanitize_chart_theme((string) filter_input(INPUT_GET, 'theme', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (!current_user_can('manage_options')) {
            status_header(403);
            exit;
        }

        if (!check_ajax_referer('astrology_suite_chart_preview_' . $theme, 'nonce', false)) {
            status_header(403);
            exit;
        }

        $body = self::chart_body_for_theme($theme);
        $cache_key = 'astrology_suite_chart_preview_' . md5($theme . '|' . wp_json_encode($body));
        $cached = get_transient($cache_key);
        if (is_string($cached) && $cached !== '') {
            self::output_chart_preview_png((string) base64_decode($cached, true));
        }

        $png = self::request_chart_preview_png($body, $theme);
        if (is_wp_error($png)) {
            self::output_chart_preview_error($png->get_error_message());
        }

        set_transient($cache_key, base64_encode($png), HOUR_IN_SECONDS);
        self::output_chart_preview_png($png);
    }

    public static function render_style_chart_preview_svg(): void
    {
        if (!current_user_can('manage_options')) {
            status_header(403);
            exit;
        }

        $theme = self::sanitize_chart_theme((string) self::get_option_value(self::OPTION_CHART_THEME, 'current'));
        $body = self::selected_chart_body();
        $hash = md5($theme . '|' . wp_json_encode($body));

        if (!check_ajax_referer('astrology_suite_style_chart_preview_svg_' . $hash, 'nonce', false)) {
            status_header(403);
            exit;
        }

        $cache_key = 'astrology_suite_style_chart_preview_svg_' . $hash;
        $cached = get_transient($cache_key);
        if (is_string($cached) && $cached !== '') {
            self::output_chart_preview_svg($cached);
        }

        $payload = self::chart_preview_payload($body, $theme, 'svg', 520);
        $svg = self::request('POST', '/natal/chart/', $payload, true);
        if (is_wp_error($svg)) {
            self::output_chart_preview_error($svg->get_error_message());
        }

        set_transient($cache_key, $svg, HOUR_IN_SECONDS);
        self::output_chart_preview_svg($svg);
    }

    private static function chart_preview_config(string $theme): array
    {
        $theme = self::sanitize_chart_theme($theme);
        $presets = self::chart_theme_presets();

        if ($theme === 'custom') {
            return self::custom_chart_config() ?: $presets['current']['config'];
        }

        return $presets[$theme]['config'] ?? $presets['current']['config'];
    }

    private static function request_chart_preview_png(array $body, string $theme)
    {
        $api_key = (string) self::get_option_value(self::OPTION_API_KEY, '');
        if ($api_key === '') {
            return new \WP_Error('missing_api_key', __('Set a FreeAstroAPI key to load chart previews.', 'astrology-suite-freeastroapi'));
        }

        $payload = self::chart_preview_payload($body, $theme);
        $response = wp_remote_post(self::UPSTREAM_BASE_URL . '/natal/chart/', [
            'timeout' => 25,
            'headers' => [
                'Content-Type' => 'application/json',
                'x-api-key' => $api_key,
            ],
            'body' => wp_json_encode($payload),
        ]);

        if (is_wp_error($response)) {
            return $response;
        }

        $status = (int) wp_remote_retrieve_response_code($response);
        $body = (string) wp_remote_retrieve_body($response);
        if ($status < 200 || $status >= 300) {
            return new \WP_Error('preview_upstream_error', self::upstream_status_message($status) . ' HTTP ' . $status);
        }

        $png = self::extract_png_response($body);
        if ($png === '') {
            return new \WP_Error('preview_invalid_response', __('FreeAstroAPI did not return a PNG preview.', 'astrology-suite-freeastroapi'));
        }

        return $png;
    }

    private static function chart_preview_payload(array $body, string $theme, string $format = 'png', ?int $forced_size = 520): array
    {
        $theme = self::sanitize_chart_theme($theme);
        $payload = [
            'name' => 'Astrology Suite Preview',
            'year' => 1990,
            'month' => 1,
            'day' => 1,
            'hour' => 12,
            'minute' => 0,
            'city' => 'Paris, France',
            'lat' => 48.8566,
            'lng' => 2.3522,
            'tz_str' => 'Europe/Paris',
            'house_system' => 'placidus',
            'zodiac_type' => 'tropical',
            'include_speed' => true,
            'include_dominants' => true,
            'include_features' => self::get_enabled_features(),
            'interpretation' => ['enable' => false],
        ];

        return self::apply_chart_body($payload, $body, $format, $forced_size, self::chart_preview_config($theme));
    }

    private static function extract_png_response(string $body): string
    {
        if (str_starts_with($body, "\x89PNG\r\n\x1a\n")) {
            return $body;
        }

        $decoded = json_decode($body, true);
        if (!is_array($decoded)) {
            return '';
        }

        foreach (['png', 'image', 'data', 'base64'] as $key) {
            if (empty($decoded[$key]) || !is_string($decoded[$key])) {
                continue;
            }

            $candidate = $decoded[$key];
            if (str_starts_with($candidate, 'data:image/png;base64,')) {
                $candidate = substr($candidate, strlen('data:image/png;base64,'));
            }

            $binary = base64_decode($candidate, true);
            if (is_string($binary) && str_starts_with($binary, "\x89PNG\r\n\x1a\n")) {
                return $binary;
            }
        }

        return '';
    }

    private static function output_chart_preview_png(string $png): void
    {
        if ($png === '') {
            self::output_chart_preview_error(__('Chart preview unavailable.', 'astrology-suite-freeastroapi'));
        }

        nocache_headers();
        header('Content-Type: image/png');
        header('Content-Length: ' . strlen($png));
        echo $png;
        exit;
    }

    private static function output_chart_preview_svg(string $svg): void
    {
        if ($svg === '') {
            self::output_chart_preview_error(__('Chart preview unavailable.', 'astrology-suite-freeastroapi'));
        }

        nocache_headers();
        header('Content-Type: image/svg+xml; charset=utf-8');
        echo $svg;
        exit;
    }

    private static function output_chart_preview_error(string $message): void
    {
        $safe_message = esc_html($message);
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 520 520" role="img"><rect width="520" height="520" fill="#f6f7f7"/><text x="260" y="246" text-anchor="middle" font-family="system-ui, sans-serif" font-size="24" fill="#1d2327">Preview unavailable</text><text x="260" y="284" text-anchor="middle" font-family="system-ui, sans-serif" font-size="16" fill="#50575e">' . $safe_message . '</text></svg>';
        nocache_headers();
        header('Content-Type: image/svg+xml; charset=utf-8');
        echo $svg;
        exit;
    }

    private static function render_checkbox_field(string $option, string $label, bool $default = true): void
    {
        $value = (bool) self::get_option_value($option, $default);
        echo '<input type="hidden" name="' . esc_attr($option) . '" value="0" />';
        echo '<label><input type="checkbox" name="' . esc_attr($option) . '" value="1" ' . checked($value, true, false) . ' /> ' . esc_html($label) . '</label>';
    }

    public static function render_obj_asc_field(): void { self::render_checkbox_field(self::OPTION_OBJ_ASC, __('Enable Ascendant (ASC).', 'astrology-suite-freeastroapi')); }
    public static function render_obj_mc_field(): void { self::render_checkbox_field(self::OPTION_OBJ_MC, __('Enable Midheaven (MC).', 'astrology-suite-freeastroapi')); }
    public static function render_obj_chiron_field(): void { self::render_checkbox_field(self::OPTION_OBJ_CHIRON, __('Include Chiron in calculation, chart, and report.', 'astrology-suite-freeastroapi')); }
    public static function render_obj_lilith_field(): void { self::render_checkbox_field(self::OPTION_OBJ_LILITH, __('Include Lilith in calculation, chart, and report.', 'astrology-suite-freeastroapi')); }
    public static function render_obj_true_node_field(): void { self::render_checkbox_field(self::OPTION_OBJ_TRUE_NODE, __('Include True Node in calculation, chart, and report.', 'astrology-suite-freeastroapi')); }
    public static function render_obj_mean_node_field(): void { self::render_checkbox_field(self::OPTION_OBJ_MEAN_NODE, __('Include Mean Node in calculation, chart, and report.', 'astrology-suite-freeastroapi')); }
    public static function render_obj_part_of_fortune_field(): void { self::render_checkbox_field(self::OPTION_OBJ_PART_OF_FORTUNE, __('Include Part of Fortune in calculation, chart, and report.', 'astrology-suite-freeastroapi')); }

    public static function render_style_show_border_field(): void { self::render_checkbox_field(self::OPTION_STYLE_SHOW_BORDER, __('Show border around plugin container.', 'astrology-suite-freeastroapi')); }

    public static function render_style_preview_field(): void
    {
        self::render_style_preview_admin_styles();
        $classes = 'wp-block-astrology-suite-widget astrology-suite-style-preview-widget';
        if (!(bool) self::get_option_value(self::OPTION_STYLE_SHOW_BORDER, true)) {
            $classes .= ' astrology-suite-no-border openastro-no-border';
        }
        if (!(bool) self::get_option_value(self::OPTION_STYLE_SHOW_HISTORY, true)) {
            $classes .= ' astrology-suite-history-hidden';
        }
        ?>
        <div class="astrology-suite-style-preview-shell">
            <p class="description"><?php esc_html_e('Preview starts with the saved settings and updates as you edit the controls below. Save changes to keep the new style.', 'astrology-suite-freeastroapi'); ?></p>
            <div class="<?php echo esc_attr($classes); ?>" style="<?php echo esc_attr(self::style_preview_inline_vars()); ?>">
                <div class="astrology-suite-style-preview-grid">
                    <section class="astrology-suite-style-preview-panel" aria-label="<?php echo esc_attr__('Input form preview', 'astrology-suite-freeastroapi'); ?>">
                        <h3><?php esc_html_e('Input form', 'astrology-suite-freeastroapi'); ?></h3>
                        <div class="openastro-form">
                            <div class="openastro-form-header">
                                <div class="openastro-load-recent-wrap">
                                    <div class="openastro-load-recent-panel">
                                        <label class="openastro-history-label openastro-load-recent-label" for="astrology-suite-style-preview-history"><?php esc_html_e('Past inputs', 'astrology-suite-freeastroapi'); ?></label>
                                        <select id="astrology-suite-style-preview-history" class="openastro-history-select openastro-load-recent-select" aria-label="<?php echo esc_attr__('Load recent past inputs', 'astrology-suite-freeastroapi'); ?>">
                                            <option><?php esc_html_e('Past inputs...', 'astrology-suite-freeastroapi'); ?></option>
                                            <option><?php esc_html_e('Ada · Paris, FR · 1990-01-01', 'astrology-suite-freeastroapi'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <label>
                                <?php esc_html_e('Name', 'astrology-suite-freeastroapi'); ?>
                                <input class="openastro-input" type="text" value="<?php echo esc_attr__('Ada Lovelace', 'astrology-suite-freeastroapi'); ?>" readonly />
                            </label>

                            <div class="astrology-suite-style-preview-row">
                                <label>
                                    <?php esc_html_e('Birth date', 'astrology-suite-freeastroapi'); ?>
                                    <input class="openastro-input" type="text" value="1990-01-01" readonly />
                                </label>
                                <label>
                                    <?php esc_html_e('Birth time', 'astrology-suite-freeastroapi'); ?>
                                    <input class="openastro-input" type="text" value="12:00" readonly />
                                </label>
                            </div>

                            <label class="openastro-city-field is-open">
                                <?php esc_html_e('City', 'astrology-suite-freeastroapi'); ?>
                                <input class="openastro-input openastro-city-input" type="text" value="<?php echo esc_attr__('Paris', 'astrology-suite-freeastroapi'); ?>" readonly />
                                <span class="openastro-city-loading"><?php esc_html_e('2 suggestions', 'astrology-suite-freeastroapi'); ?></span>
                                <div class="openastro-results">
                                    <?php self::render_style_preview_city_result(__('Paris', 'astrology-suite-freeastroapi'), 'FR', 'Europe/Paris', '48.8566, 2.3522', true); ?>
                                    <?php self::render_style_preview_city_result(__('Paris', 'astrology-suite-freeastroapi'), 'US', 'America/Chicago', '33.6609, -95.5555', false); ?>
                                </div>
                            </label>

                            <label class="openastro-inline">
                                <input type="checkbox" checked disabled />
                                <?php esc_html_e('Include minor aspects', 'astrology-suite-freeastroapi'); ?>
                            </label>

                            <button class="openastro-btn" type="button"><?php esc_html_e('Generate', 'astrology-suite-freeastroapi'); ?></button>
                            <p class="openastro-status"><?php esc_html_e('Ready to generate.', 'astrology-suite-freeastroapi'); ?></p>
                        </div>
                    </section>

                    <section class="astrology-suite-style-preview-panel" aria-label="<?php echo esc_attr__('Result preview', 'astrology-suite-freeastroapi'); ?>">
                        <h3><?php esc_html_e('Results', 'astrology-suite-freeastroapi'); ?></h3>
                        <div class="openastro-output">
                            <h2 class="openastro-report-title"><?php esc_html_e('Natal Report', 'astrology-suite-freeastroapi'); ?></h2>
                            <section class="openastro-card openastro-chart-card">
                                <h3><?php esc_html_e('Natal Wheel', 'astrology-suite-freeastroapi'); ?></h3>
                                <button class="openastro-print-btn" type="button"><?php esc_html_e('Print', 'astrology-suite-freeastroapi'); ?></button>
                                <div class="openastro-chart" aria-hidden="true">
                                    <img class="astrology-suite-style-preview-chart-img" src="<?php echo esc_url(self::style_chart_preview_svg_url()); ?>" alt="<?php echo esc_attr__('Sample natal wheel using the selected chart theme', 'astrology-suite-freeastroapi'); ?>" loading="lazy" />
                                </div>
                            </section>
                            <section class="openastro-card">
                                <h3><?php esc_html_e('Planet highlights', 'astrology-suite-freeastroapi'); ?></h3>
                                <div class="openastro-planet-item">
                                    <h4><span class="openastro-astro-glyph">s</span><?php esc_html_e('Sun in Capricorn', 'astrology-suite-freeastroapi'); ?></h4>
                                    <p><?php esc_html_e('A concise interpretation paragraph previews body text, labels, spacing, and card contrast.', 'astrology-suite-freeastroapi'); ?></p>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th><?php esc_html_e('Body', 'astrology-suite-freeastroapi'); ?></th>
                                            <th><?php esc_html_e('Sign', 'astrology-suite-freeastroapi'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php esc_html_e('Moon', 'astrology-suite-freeastroapi'); ?></td>
                                            <td><?php esc_html_e('Libra', 'astrology-suite-freeastroapi'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </section>
                            <section class="openastro-card openastro-simple-sign-card">
                                <h3><?php esc_html_e('Moon Sign', 'astrology-suite-freeastroapi'); ?></h3>
                                <p class="openastro-simple-sign-value"><span class="openastro-astro-glyph">X</span><?php esc_html_e('Libra', 'astrology-suite-freeastroapi'); ?></p>
                                <div class="openastro-simple-sign-interpretation">
                                    <h4><?php esc_html_e('Interpretation', 'astrology-suite-freeastroapi'); ?></h4>
                                    <p><?php esc_html_e('This card previews simple-sign result spacing and typography.', 'astrology-suite-freeastroapi'); ?></p>
                                </div>
                            </section>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <?php
    }

    private static function render_style_preview_city_result(string $name, string $country, string $timezone, string $coords, bool $active): void
    {
        ?>
        <button class="openastro-result-btn<?php echo $active ? ' is-active' : ''; ?>" type="button">
            <span class="openastro-result-main">
                <span class="openastro-result-primary">
                    <span class="openastro-result-name"><?php echo esc_html($name); ?></span>
                    <span class="openastro-result-country"><?php echo esc_html($country); ?></span>
                </span>
            </span>
            <span class="openastro-result-meta">
                <span class="openastro-result-meta-item"><?php echo esc_html($timezone); ?></span>
                <span class="openastro-result-meta-item"><?php echo esc_html($coords); ?></span>
            </span>
        </button>
        <?php
    }

    private static function style_preview_inline_vars(): string
    {
        $background = (bool) self::get_option_value(self::OPTION_STYLE_TRANSPARENT_BG, false)
            ? 'transparent'
            : (string) self::get_option_value(self::OPTION_STYLE_BG_COLOR, '#ffffff');

        $vars = [
            '--openastro-bg' => $background,
            '--openastro-text' => (string) self::get_option_value(self::OPTION_STYLE_TEXT_COLOR, '#111111'),
            '--openastro-history-bg' => (string) self::get_option_value(self::OPTION_STYLE_HISTORY_BG_COLOR, '#f9fafb'),
            '--openastro-history-border' => (string) self::get_option_value(self::OPTION_STYLE_HISTORY_BORDER_COLOR, '#e5e7eb'),
            '--openastro-history-text' => (string) self::get_option_value(self::OPTION_STYLE_HISTORY_TEXT_COLOR, '#111111'),
            '--openastro-input-radius' => (int) self::get_option_value(self::OPTION_STYLE_INPUT_BORDER_RADIUS, 6) . 'px',
            '--openastro-input-border-color' => (string) self::get_option_value(self::OPTION_STYLE_INPUT_BORDER_COLOR, '#d1d5db'),
            '--openastro-input-bg' => (string) self::get_option_value(self::OPTION_STYLE_INPUT_BG_COLOR, '#ffffff'),
            '--openastro-input-text' => (string) self::get_option_value(self::OPTION_STYLE_INPUT_TEXT_COLOR, '#111111'),
            '--openastro-input-placeholder' => (string) self::get_option_value(self::OPTION_STYLE_INPUT_PLACEHOLDER_COLOR, '#6b7280'),
            '--openastro-button-radius' => (int) self::get_option_value(self::OPTION_STYLE_BUTTON_BORDER_RADIUS, 6) . 'px',
            '--openastro-button-bg' => (string) self::get_option_value(self::OPTION_STYLE_BUTTON_BG_COLOR, '#111827'),
            '--openastro-button-text' => (string) self::get_option_value(self::OPTION_STYLE_BUTTON_TEXT_COLOR, '#ffffff'),
            '--openastro-button-border' => (string) self::get_option_value(self::OPTION_STYLE_BUTTON_BORDER_COLOR, '#111827'),
            '--openastro-label-color' => (string) self::get_option_value(self::OPTION_STYLE_LABEL_COLOR, '#111111'),
            '--openastro-label-weight' => (string) self::get_option_value(self::OPTION_STYLE_LABEL_WEIGHT, '600'),
            '--openastro-focus-ring' => (string) self::get_option_value(self::OPTION_STYLE_FOCUS_RING_COLOR, '#2563eb'),
            '--openastro-astro-font-size' => (int) self::get_option_value(self::OPTION_STYLE_ASTRO_FONT_SIZE, 20) . 'px',
            '--openastro-astro-font-color' => (string) self::get_option_value(self::OPTION_STYLE_ASTRO_FONT_COLOR, '#111111'),
            '--openastro-font-h2' => (int) self::get_option_value(self::OPTION_TYPO_H2, 28) . 'px',
            '--openastro-font-h3' => (int) self::get_option_value(self::OPTION_TYPO_H3, 22) . 'px',
            '--openastro-font-h4' => (int) self::get_option_value(self::OPTION_TYPO_H4, 18) . 'px',
            '--openastro-font-body' => (int) self::get_option_value(self::OPTION_TYPO_BODY, 16) . 'px',
            '--openastro-font-table' => (int) self::get_option_value(self::OPTION_TYPO_TABLE, 14) . 'px',
            '--openastro-font-input' => (int) self::get_option_value(self::OPTION_TYPO_INPUT, 16) . 'px',
            '--openastro-font-button' => (int) self::get_option_value(self::OPTION_TYPO_BUTTON, 16) . 'px',
            '--openastro-font-meta' => (int) self::get_option_value(self::OPTION_TYPO_META, 13) . 'px',
        ];

        $style = [];
        foreach ($vars as $key => $value) {
            $style[] = $key . ': ' . $value;
        }

        return implode('; ', $style);
    }

    private static function render_style_preview_admin_styles(): void
    {
        static $printed = false;
        if ($printed) {
            return;
        }
        $printed = true;
        ?>
        <style>
            .astrology-suite-style-preview-shell {
                max-width: 1120px;
            }
            .astrology-suite-style-preview-shell > .description {
                margin: 0 0 10px;
            }
            .astrology-suite-style-preview-widget {
                max-width: 1120px;
            }
            .astrology-suite-style-preview-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 18px;
                align-items: start;
            }
            .astrology-suite-style-preview-panel {
                min-width: 0;
            }
            .astrology-suite-style-preview-panel > h3 {
                margin: 0 0 12px;
                font-size: 14px;
                line-height: 1.35;
                text-transform: uppercase;
                letter-spacing: 0.02em;
                color: #50575e;
            }
            .astrology-suite-style-preview-widget .openastro-form {
                max-width: none;
                margin: 0;
            }
            .astrology-suite-style-preview-widget.astrology-suite-history-hidden .openastro-form-header {
                display: none;
            }
            .astrology-suite-style-preview-widget .openastro-output {
                gap: 14px;
            }
            .astrology-suite-style-preview-row {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }
            .astrology-suite-style-preview-widget .openastro-chart svg,
            .astrology-suite-style-preview-chart-img {
                display: block;
                width: 100%;
                height: auto;
                max-width: 280px;
                margin: 0 auto;
            }
            .astrology-suite-style-preview-widget table {
                margin-top: 10px;
            }
            @media (max-width: 680px) {
                .astrology-suite-style-preview-row {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <script>
            (function () {
                function initAstrologySuiteStylePreview() {
                    var preview = document.querySelector('.astrology-suite-style-preview-widget');
                    if (!preview) {
                        return;
                    }

                    var fields = {
                        <?php echo wp_json_encode(self::OPTION_STYLE_TEXT_COLOR); ?>: ['--openastro-text', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_HISTORY_BG_COLOR); ?>: ['--openastro-history-bg', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_HISTORY_BORDER_COLOR); ?>: ['--openastro-history-border', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_HISTORY_TEXT_COLOR); ?>: ['--openastro-history-text', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_INPUT_BORDER_RADIUS); ?>: ['--openastro-input-radius', 'px'],
                        <?php echo wp_json_encode(self::OPTION_STYLE_INPUT_BORDER_COLOR); ?>: ['--openastro-input-border-color', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_INPUT_BG_COLOR); ?>: ['--openastro-input-bg', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_INPUT_TEXT_COLOR); ?>: ['--openastro-input-text', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_INPUT_PLACEHOLDER_COLOR); ?>: ['--openastro-input-placeholder', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_BUTTON_BORDER_RADIUS); ?>: ['--openastro-button-radius', 'px'],
                        <?php echo wp_json_encode(self::OPTION_STYLE_BUTTON_BG_COLOR); ?>: ['--openastro-button-bg', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_BUTTON_TEXT_COLOR); ?>: ['--openastro-button-text', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_BUTTON_BORDER_COLOR); ?>: ['--openastro-button-border', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_LABEL_COLOR); ?>: ['--openastro-label-color', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_LABEL_WEIGHT); ?>: ['--openastro-label-weight', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_FOCUS_RING_COLOR); ?>: ['--openastro-focus-ring', ''],
                        <?php echo wp_json_encode(self::OPTION_STYLE_ASTRO_FONT_SIZE); ?>: ['--openastro-astro-font-size', 'px'],
                        <?php echo wp_json_encode(self::OPTION_STYLE_ASTRO_FONT_COLOR); ?>: ['--openastro-astro-font-color', '']
                    };

                    function setPreviewVariable(name, value) {
                        preview.style.setProperty(name, value);
                        if (name.indexOf('--openastro-') === 0) {
                            preview.style.setProperty(name.replace('--openastro-', '--astrology-suite-'), value);
                        }
                    }

                    function updateField(name) {
                        var field = document.querySelector('[name="' + name + '"]');
                        var target = fields[name];
                        if (!field || !target) {
                            return;
                        }
                        var value = field.value;
                        if (value === '') {
                            return;
                        }
                        setPreviewVariable(target[0], value + target[1]);
                    }

                    Object.keys(fields).forEach(function (name) {
                        var field = document.querySelector('[name="' + name + '"]');
                        if (!field) {
                            return;
                        }
                        field.addEventListener('input', function () { updateField(name); });
                        field.addEventListener('change', function () { updateField(name); });
                    });

                    var backgroundColor = document.querySelector('[name="<?php echo esc_js(self::OPTION_STYLE_BG_COLOR); ?>"]');
                    var transparentBackground = document.querySelector('[name="<?php echo esc_js(self::OPTION_STYLE_TRANSPARENT_BG); ?>"][type="checkbox"]');
                    function syncBackground() {
                        var value = backgroundColor && backgroundColor.value ? backgroundColor.value : '#ffffff';
                        setPreviewVariable('--openastro-bg', transparentBackground && transparentBackground.checked ? 'transparent' : value);
                    }
                    if (backgroundColor) {
                        backgroundColor.addEventListener('input', syncBackground);
                        backgroundColor.addEventListener('change', syncBackground);
                    }
                    if (transparentBackground) {
                        transparentBackground.addEventListener('change', syncBackground);
                    }
                    syncBackground();

                    var border = document.querySelector('[name="<?php echo esc_js(self::OPTION_STYLE_SHOW_BORDER); ?>"][type="checkbox"]');
                    if (border) {
                        border.addEventListener('change', function () {
                            preview.classList.toggle('astrology-suite-no-border', !border.checked);
                            preview.classList.toggle('openastro-no-border', !border.checked);
                        });
                    }

                    var history = document.querySelector('[name="<?php echo esc_js(self::OPTION_STYLE_SHOW_HISTORY); ?>"][type="checkbox"]');
                    if (history) {
                        history.addEventListener('change', function () {
                            preview.classList.toggle('astrology-suite-history-hidden', !history.checked);
                        });
                    }
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initAstrologySuiteStylePreview);
                } else {
                    initAstrologySuiteStylePreview();
                }
            })();
        </script>
        <?php
    }

    public static function render_style_bg_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_BG_COLOR, '#ffffff');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_BG_COLOR) . '" value="' . esc_attr($value) . '" />';
        echo '<p class="description">' . esc_html__('Used when the plugin background is enabled.', 'astrology-suite-freeastroapi') . '</p>';
    }

    public static function render_style_transparent_bg_field(): void
    {
        self::render_checkbox_field(self::OPTION_STYLE_TRANSPARENT_BG, __('Use a transparent plugin background.', 'astrology-suite-freeastroapi'), false);
        echo '<p class="description">' . esc_html__('Keeps the saved background color available for when this option is turned off.', 'astrology-suite-freeastroapi') . '</p>';
    }

    public static function render_style_text_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_TEXT_COLOR, '#111111');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_TEXT_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_group_history(): void
    {
        echo '<p><strong>' . esc_html__('Past inputs dropdown', 'astrology-suite-freeastroapi') . '</strong></p>';
        echo '<p class="description">' . esc_html__('Controls the saved local-browser input selector shown above each widget form.', 'astrology-suite-freeastroapi') . '</p>';
    }

    public static function render_style_show_history_field(): void
    {
        self::render_checkbox_field(self::OPTION_STYLE_SHOW_HISTORY, __('Show the Past inputs dropdown above widget forms.', 'astrology-suite-freeastroapi'));
        echo '<p class="description">' . esc_html__('When hidden, new widget submissions are not added to the Past inputs list.', 'astrology-suite-freeastroapi') . '</p>';
    }

    public static function render_style_history_bg_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_HISTORY_BG_COLOR, '#f9fafb');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_HISTORY_BG_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_history_border_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_HISTORY_BORDER_COLOR, '#e5e7eb');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_HISTORY_BORDER_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_history_text_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_HISTORY_TEXT_COLOR, '#111111');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_HISTORY_TEXT_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_group_input(): void
    {
        echo '<p><strong>' . esc_html__('Input controls', 'astrology-suite-freeastroapi') . '</strong></p>';
    }

    public static function render_style_group_button(): void
    {
        echo '<p><strong>' . esc_html__('Button controls', 'astrology-suite-freeastroapi') . '</strong></p>';
    }

    public static function render_style_group_labels(): void
    {
        echo '<p><strong>' . esc_html__('Labels and focus states', 'astrology-suite-freeastroapi') . '</strong></p>';
    }

    public static function render_style_input_border_radius_field(): void
    {
        $value = (int) self::get_option_value(self::OPTION_STYLE_INPUT_BORDER_RADIUS, 6);
        echo '<input type="number" min="0" max="40" step="1" name="' . esc_attr(self::OPTION_STYLE_INPUT_BORDER_RADIUS) . '" value="' . esc_attr((string) $value) . '" /> px';
    }

    public static function render_style_input_border_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_INPUT_BORDER_COLOR, '#d1d5db');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_INPUT_BORDER_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_input_bg_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_INPUT_BG_COLOR, '#ffffff');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_INPUT_BG_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_input_text_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_INPUT_TEXT_COLOR, '#111111');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_INPUT_TEXT_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_input_placeholder_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_INPUT_PLACEHOLDER_COLOR, '#6b7280');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_INPUT_PLACEHOLDER_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_button_border_radius_field(): void
    {
        $value = (int) self::get_option_value(self::OPTION_STYLE_BUTTON_BORDER_RADIUS, 6);
        echo '<input type="number" min="0" max="40" step="1" name="' . esc_attr(self::OPTION_STYLE_BUTTON_BORDER_RADIUS) . '" value="' . esc_attr((string) $value) . '" /> px';
    }

    public static function render_style_button_bg_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_BUTTON_BG_COLOR, '#111827');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_BUTTON_BG_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_button_text_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_BUTTON_TEXT_COLOR, '#ffffff');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_BUTTON_TEXT_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_button_border_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_BUTTON_BORDER_COLOR, '#111827');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_BUTTON_BORDER_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_label_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_LABEL_COLOR, '#111111');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_LABEL_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_label_weight_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_LABEL_WEIGHT, '600');
        ?>
        <select name="<?php echo esc_attr(self::OPTION_STYLE_LABEL_WEIGHT); ?>">
            <option value="normal" <?php selected($value, 'normal'); ?>><?php esc_html_e('Normal', 'astrology-suite-freeastroapi'); ?></option>
            <option value="500" <?php selected($value, '500'); ?>>500</option>
            <option value="600" <?php selected($value, '600'); ?>>600</option>
            <option value="700" <?php selected($value, '700'); ?>>700</option>
        </select>
        <?php
    }

    public static function render_style_focus_ring_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_FOCUS_RING_COLOR, '#2563eb');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_FOCUS_RING_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_style_astro_font_size_field(): void
    {
        $value = (int) self::get_option_value(self::OPTION_STYLE_ASTRO_FONT_SIZE, 20);
        echo '<input type="number" min="10" max="48" step="1" name="' . esc_attr(self::OPTION_STYLE_ASTRO_FONT_SIZE) . '" value="' . esc_attr((string) $value) . '" /> px';
    }

    public static function render_style_astro_font_color_field(): void
    {
        $value = (string) self::get_option_value(self::OPTION_STYLE_ASTRO_FONT_COLOR, '#111111');
        echo '<input type="color" name="' . esc_attr(self::OPTION_STYLE_ASTRO_FONT_COLOR) . '" value="' . esc_attr($value) . '" />';
    }

    private static function ephemeris_style_defaults(): array
    {
        return [
            self::OPTION_EPHEMERIS_TABLE_BG_COLOR => '#ffffff',
            self::OPTION_EPHEMERIS_TABLE_TEXT_COLOR => '#111111',
            self::OPTION_EPHEMERIS_TABLE_BORDER_COLOR => '#e5e7eb',
            self::OPTION_EPHEMERIS_TABLE_HEADER_BG_COLOR => '#f8fafc',
            self::OPTION_EPHEMERIS_TABLE_HEADER_TEXT_COLOR => '#111111',
            self::OPTION_EPHEMERIS_TABLE_BADGE_BG_COLOR => '#f8fafc',
            self::OPTION_EPHEMERIS_TABLE_BADGE_TEXT_COLOR => '#475569',
            self::OPTION_EPHEMERIS_TABLE_TODAY_BG_COLOR => '#f8fafc',
            self::OPTION_EPHEMERIS_TABLE_TODAY_ACCENT_COLOR => '#2563eb',
            self::OPTION_EPHEMERIS_RETROGRADE_COLOR => '#b91c1c',
            self::OPTION_EPHEMERIS_INGRESS_COLOR => '#1d4ed8',
            self::OPTION_EPHEMERIS_STATION_COLOR => '#a16207',
        ];
    }

    private static function ephemeris_style_variable_map(): array
    {
        return [
            self::OPTION_EPHEMERIS_TABLE_BG_COLOR => '--openastro-ephemeris-table-bg',
            self::OPTION_EPHEMERIS_TABLE_TEXT_COLOR => '--openastro-ephemeris-table-text',
            self::OPTION_EPHEMERIS_TABLE_BORDER_COLOR => '--openastro-ephemeris-table-border',
            self::OPTION_EPHEMERIS_TABLE_HEADER_BG_COLOR => '--openastro-ephemeris-header-bg',
            self::OPTION_EPHEMERIS_TABLE_HEADER_TEXT_COLOR => '--openastro-ephemeris-header-text',
            self::OPTION_EPHEMERIS_TABLE_BADGE_BG_COLOR => '--openastro-ephemeris-badge-bg',
            self::OPTION_EPHEMERIS_TABLE_BADGE_TEXT_COLOR => '--openastro-ephemeris-badge-text',
            self::OPTION_EPHEMERIS_TABLE_TODAY_BG_COLOR => '--openastro-ephemeris-today-bg',
            self::OPTION_EPHEMERIS_TABLE_TODAY_ACCENT_COLOR => '--openastro-ephemeris-today-accent',
            self::OPTION_EPHEMERIS_RETROGRADE_COLOR => '--openastro-ephemeris-retrograde',
            self::OPTION_EPHEMERIS_INGRESS_COLOR => '--openastro-ephemeris-ingress',
            self::OPTION_EPHEMERIS_STATION_COLOR => '--openastro-ephemeris-station',
        ];
    }

    private static function ephemeris_style_inline_vars(): string
    {
        $defaults = self::ephemeris_style_defaults();
        $vars = [];
        foreach (self::ephemeris_style_variable_map() as $option => $var_name) {
            $value = (string) self::get_option_value($option, $defaults[$option]);
            $vars[$var_name] = $value;
            $vars[str_replace('--openastro-', '--astrology-suite-', $var_name)] = $value;
        }

        $style = [];
        foreach ($vars as $key => $value) {
            $style[] = $key . ': ' . $value;
        }

        return implode('; ', $style);
    }

    private static function render_color_field(string $option, string $default): void
    {
        $value = (string) self::get_option_value($option, $default);
        echo '<input type="color" name="' . esc_attr($option) . '" value="' . esc_attr($value) . '" />';
    }

    public static function render_ephemeris_style_preview_field(): void
    {
        self::render_ephemeris_style_preview_admin_assets();
        ?>
        <div class="wp-block-astrology-suite-widget astrology-suite-ephemeris-style-preview" style="<?php echo esc_attr(self::ephemeris_style_inline_vars()); ?>">
            <section class="openastro-ephemeris-table-card">
                <div class="openastro-ephemeris-table-top">
                    <span class="openastro-ephemeris-table-meta"><?php esc_html_e('GMT 00:00', 'astrology-suite-freeastroapi'); ?></span>
                    <h3><?php esc_html_e('June 2026', 'astrology-suite-freeastroapi'); ?></h3>
                    <span class="openastro-ephemeris-row-badge"><?php esc_html_e('30 rows', 'astrology-suite-freeastroapi'); ?></span>
                </div>
                <div class="openastro-ephemeris-table-viewport">
                    <table class="openastro-ephemeris-table">
                        <thead>
                            <tr>
                                <th class="openastro-ephemeris-col-date"><?php esc_html_e('Date', 'astrology-suite-freeastroapi'); ?></th>
                                <th><?php esc_html_e('Day', 'astrology-suite-freeastroapi'); ?></th>
                                <th><?php esc_html_e('GST', 'astrology-suite-freeastroapi'); ?></th>
                                <th><span class="openastro-ephemeris-head-body"><span class="openastro-ephemeris-glyph">☉</span><span class="openastro-ephemeris-head-label">SUN</span></span></th>
                                <th><span class="openastro-ephemeris-head-body"><span class="openastro-ephemeris-glyph">☽</span><span class="openastro-ephemeris-head-label">MOON</span></span></th>
                                <th><span class="openastro-ephemeris-head-body"><span class="openastro-ephemeris-glyph">☿</span><span class="openastro-ephemeris-head-label">MERCURY</span></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="openastro-ephemeris-date-cell">1</td>
                                <td class="openastro-ephemeris-day-cell">Mon</td>
                                <td class="openastro-ephemeris-gst-cell">16:37:59</td>
                                <td>10°32' Gem</td>
                                <td>17°29' Sag</td>
                                <td class="openastro-ephemeris-cell is-ingress">29°09' Gem</td>
                            </tr>
                            <tr class="openastro-ephemeris-row is-today">
                                <td class="openastro-ephemeris-date-cell">2</td>
                                <td class="openastro-ephemeris-day-cell">Tue</td>
                                <td class="openastro-ephemeris-gst-cell">16:41:55</td>
                                <td>11°30' Gem</td>
                                <td>29°21' Sag</td>
                                <td>00°51' Can</td>
                            </tr>
                            <tr>
                                <td class="openastro-ephemeris-date-cell">3</td>
                                <td class="openastro-ephemeris-day-cell">Wed</td>
                                <td class="openastro-ephemeris-gst-cell">16:45:52</td>
                                <td>12°27' Gem</td>
                                <td>11°13' Cap</td>
                                <td class="openastro-ephemeris-cell is-retrograde">02°30' Can Rx</td>
                            </tr>
                            <tr>
                                <td class="openastro-ephemeris-date-cell">4</td>
                                <td class="openastro-ephemeris-day-cell">Thu</td>
                                <td class="openastro-ephemeris-gst-cell">16:49:49</td>
                                <td>13°25' Gem</td>
                                <td>23°08' Cap</td>
                                <td class="openastro-ephemeris-cell is-station">04°06' Can S</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <p class="description"><?php esc_html_e('Preview starts with the saved ephemeris table colors and updates as you edit the controls below. Save changes to apply them on the frontend.', 'astrology-suite-freeastroapi'); ?></p>
        <?php
    }

    private static function render_ephemeris_style_preview_admin_assets(): void
    {
        static $printed = false;
        if ($printed) {
            return;
        }
        $printed = true;
        ?>
        <style>
            .astrology-suite-ephemeris-style-preview {
                max-width: 1120px;
                padding: 16px;
                overflow: hidden;
            }
            .astrology-suite-ephemeris-style-preview .openastro-ephemeris-table {
                min-width: 680px;
            }
        </style>
        <script>
            (function () {
                function initAstrologySuiteEphemerisStylePreview() {
                    var preview = document.querySelector('.astrology-suite-ephemeris-style-preview');
                    if (!preview) {
                        return;
                    }
                    var fields = <?php echo wp_json_encode(self::ephemeris_style_variable_map()); ?>;
                    function setPreviewVariable(name, value) {
                        preview.style.setProperty(name, value);
                        if (name.indexOf('--openastro-') === 0) {
                            preview.style.setProperty(name.replace('--openastro-', '--astrology-suite-'), value);
                        }
                    }
                    Object.keys(fields).forEach(function (name) {
                        var field = document.querySelector('[name="' + name + '"]');
                        if (!field) {
                            return;
                        }
                        var update = function () {
                            if (field.value) {
                                setPreviewVariable(fields[name], field.value);
                            }
                        };
                        field.addEventListener('input', update);
                        field.addEventListener('change', update);
                    });
                }
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initAstrologySuiteEphemerisStylePreview);
                } else {
                    initAstrologySuiteEphemerisStylePreview();
                }
            })();
        </script>
        <?php
    }

    public static function render_ephemeris_table_bg_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_BG_COLOR, '#ffffff'); }
    public static function render_ephemeris_table_text_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_TEXT_COLOR, '#111111'); }
    public static function render_ephemeris_table_border_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_BORDER_COLOR, '#e5e7eb'); }
    public static function render_ephemeris_table_header_bg_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_HEADER_BG_COLOR, '#f8fafc'); }
    public static function render_ephemeris_table_header_text_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_HEADER_TEXT_COLOR, '#111111'); }
    public static function render_ephemeris_table_badge_bg_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_BADGE_BG_COLOR, '#f8fafc'); }
    public static function render_ephemeris_table_badge_text_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_BADGE_TEXT_COLOR, '#475569'); }
    public static function render_ephemeris_table_today_bg_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_TODAY_BG_COLOR, '#f8fafc'); }
    public static function render_ephemeris_table_today_accent_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_TABLE_TODAY_ACCENT_COLOR, '#2563eb'); }
    public static function render_ephemeris_retrograde_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_RETROGRADE_COLOR, '#b91c1c'); }
    public static function render_ephemeris_ingress_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_INGRESS_COLOR, '#1d4ed8'); }
    public static function render_ephemeris_station_color_field(): void { self::render_color_field(self::OPTION_EPHEMERIS_STATION_COLOR, '#a16207'); }

    private static function render_font_size_field(string $option, int $default): void
    {
        $value = (int) self::get_option_value($option, $default);
        echo '<input type="number" min="10" max="48" step="1" name="' . esc_attr($option) . '" value="' . esc_attr((string) $value) . '" /> px';
    }

    public static function render_typography_h2_field(): void { self::render_font_size_field(self::OPTION_TYPO_H2, 28); }
    public static function render_typography_h3_field(): void { self::render_font_size_field(self::OPTION_TYPO_H3, 22); }
    public static function render_typography_h4_field(): void { self::render_font_size_field(self::OPTION_TYPO_H4, 18); }
    public static function render_typography_body_field(): void { self::render_font_size_field(self::OPTION_TYPO_BODY, 16); }
    public static function render_typography_table_field(): void { self::render_font_size_field(self::OPTION_TYPO_TABLE, 14); }
    public static function render_typography_input_field(): void { self::render_font_size_field(self::OPTION_TYPO_INPUT, 16); }
    public static function render_typography_button_field(): void { self::render_font_size_field(self::OPTION_TYPO_BUTTON, 16); }
    public static function render_typography_meta_field(): void { self::render_font_size_field(self::OPTION_TYPO_META, 13); }

    private static function settings_tabs(): array
    {
        return [
            'api' => __('API', 'astrology-suite-freeastroapi'),
            'report' => __('Report', 'astrology-suite-freeastroapi'),
            'chart' => __('Custom Chart', 'astrology-suite-freeastroapi'),
            'objects' => __('Objects', 'astrology-suite-freeastroapi'),
            'style' => __('Style', 'astrology-suite-freeastroapi'),
            'ephemeris' => __('Ephemeris Style', 'astrology-suite-freeastroapi'),
            'typography' => __('Typography', 'astrology-suite-freeastroapi'),
            'help' => __('Help', 'astrology-suite-freeastroapi'),
        ];
    }

    private static function active_settings_tab(): string
    {
        $tab_param = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tab = is_string($tab_param) ? sanitize_key(wp_unslash($tab_param)) : 'api';
        $tabs = self::settings_tabs();
        return isset($tabs[$tab]) ? $tab : 'api';
    }

    private static function settings_group_for_tab(string $tab): string
    {
        $groups = [
            'api' => 'astrology_suite_api_settings_group',
            'report' => 'astrology_suite_report_settings_group',
            'chart' => 'astrology_suite_chart_settings_group',
            'objects' => 'astrology_suite_objects_settings_group',
            'style' => 'astrology_suite_style_settings_group',
            'ephemeris' => 'astrology_suite_ephemeris_settings_group',
            'typography' => 'astrology_suite_typography_settings_group',
        ];

        return $groups[$tab] ?? $groups['api'];
    }

    private static function render_section_fields(string $section_id): void
    {
        global $wp_settings_fields;

        if (empty($wp_settings_fields[self::SETTINGS_API_PAGE][$section_id])) {
            return;
        }

        echo '<table class="form-table" role="presentation">';
        do_settings_fields(self::SETTINGS_API_PAGE, $section_id);
        echo '</table>';
    }

    private static function render_tabbed_settings_fields(string $tab): void
    {
        if ($tab === 'api') {
            self::render_section_fields('openastro_settings_main');
            return;
        }
        if ($tab === 'report') {
            self::render_section_fields('openastro_report_settings');
            return;
        }
        if ($tab === 'chart') {
            self::render_section_fields('openastro_chart_settings');
            return;
        }
        if ($tab === 'objects') {
            self::render_section_fields('openastro_objects_settings');
            return;
        }
        if ($tab === 'style') {
            self::render_section_fields('openastro_style_settings');
            return;
        }
        if ($tab === 'ephemeris') {
            self::render_section_fields('openastro_ephemeris_style_settings');
            return;
        }
        if ($tab === 'typography') {
            self::render_section_fields('openastro_typography_settings');
        }
    }

    public static function render_settings_page(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $tabs = self::settings_tabs();
        $active_tab = self::active_settings_tab();
        $migrate_url = wp_nonce_url(
            admin_url('admin-post.php?action=openastro_migrate_blocks'),
            'openastro_migrate_blocks'
        );
        $css_doc_url = OPENASTRO_SUITE_URL . 'docs/CSS-CLASSES.md';
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Astrology Suite for FreeAstroAPI Settings', 'astrology-suite-freeastroapi'); ?></h1>
            <h2 class="nav-tab-wrapper">
                <?php foreach ($tabs as $slug => $label) : ?>
                    <?php $tab_url = add_query_arg(['page' => self::SETTINGS_PAGE_SLUG, 'tab' => $slug], admin_url('admin.php')); ?>
                    <a href="<?php echo esc_url($tab_url); ?>" class="nav-tab <?php echo $active_tab === $slug ? 'nav-tab-active' : ''; ?>">
                        <?php echo esc_html($label); ?>
                    </a>
                <?php endforeach; ?>
            </h2>

            <?php if ($active_tab !== 'help') : ?>
                <form method="post" action="options.php">
                    <?php
                    settings_fields(self::settings_group_for_tab($active_tab));
                    self::render_tabbed_settings_fields($active_tab);
                    submit_button();
                    ?>
                </form>
            <?php else : ?>
                <h2><?php esc_html_e('How To Add Blocks Or Shortcodes To A Page', 'astrology-suite-freeastroapi'); ?></h2>
                <ol>
                    <li><?php esc_html_e('Open a page in the WordPress block editor.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Search for "Astrology Suite" in the block inserter.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Choose a block, configure any sidebar options, and publish the page.', 'astrology-suite-freeastroapi'); ?></li>
                </ol>
                <p><?php esc_html_e('Natal and simple-sign blocks render birth-data forms with city autocomplete, a local "Past inputs..." selector, and a Generate button. The ephemeris block renders month controls, body filters, optional city autocomplete for local points, and a monthly table.', 'astrology-suite-freeastroapi'); ?></p>

                <h3><?php esc_html_e('Available Blocks', 'astrology-suite-freeastroapi'); ?></h3>
                <table class="widefat striped" style="max-width: 920px;">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Block', 'astrology-suite-freeastroapi'); ?></th>
                            <th><?php esc_html_e('Front-end output', 'astrology-suite-freeastroapi'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>astrology-suite/chart-only</code></td>
                            <td><?php esc_html_e('Input form plus natal wheel chart. Report text is not shown.', 'astrology-suite-freeastroapi'); ?></td>
                        </tr>
                        <tr>
                            <td><code>astrology-suite/report-only</code></td>
                            <td><?php esc_html_e('Input form plus interpretation report. Natal wheel chart is not shown.', 'astrology-suite-freeastroapi'); ?></td>
                        </tr>
                        <tr>
                            <td><code>astrology-suite/chart-report</code></td>
                            <td><?php esc_html_e('Input form plus natal wheel chart and interpretation report.', 'astrology-suite-freeastroapi'); ?></td>
                        </tr>
                        <tr>
                            <td><code>astrology-suite/simple-sign-sun</code></td>
                            <td><?php esc_html_e('Input form plus Sun sign result.', 'astrology-suite-freeastroapi'); ?></td>
                        </tr>
                        <tr>
                            <td><code>astrology-suite/simple-sign-moon</code></td>
                            <td><?php esc_html_e('Input form plus Moon sign result.', 'astrology-suite-freeastroapi'); ?></td>
                        </tr>
                        <tr>
                            <td><code>astrology-suite/simple-sign-rising</code></td>
                            <td><?php esc_html_e('Input form plus Rising sign result.', 'astrology-suite-freeastroapi'); ?></td>
                        </tr>
                        <tr>
                            <td><code>astrology-suite/simple-sign-midheaven</code></td>
                            <td><?php esc_html_e('Input form plus Midheaven sign result.', 'astrology-suite-freeastroapi'); ?></td>
                        </tr>
                        <tr>
                            <td><code>astrology-suite/ephemeris</code></td>
                            <td><?php esc_html_e('Monthly ephemeris table with selectable bodies, tropical/sidereal mode, optional city, and CSV download.', 'astrology-suite-freeastroapi'); ?></td>
                        </tr>
                    </tbody>
                </table>
                <p><?php esc_html_e('Simple-sign blocks include sidebar controls for interpretation text and interpretation style. The supported style values are "improved" and "poetic".', 'astrology-suite-freeastroapi'); ?></p>

                <h3><?php esc_html_e('Code Block Example (Page Code Editor)', 'astrology-suite-freeastroapi'); ?></h3>
                <pre><code><?php echo esc_html("<!-- wp:astrology-suite/chart-only /-->\n<!-- wp:astrology-suite/report-only /-->\n<!-- wp:astrology-suite/chart-report /-->\n<!-- wp:astrology-suite/simple-sign-sun {\"includeInterpretation\":true,\"interpretationStyle\":\"improved\"} /-->\n<!-- wp:astrology-suite/simple-sign-moon {\"includeInterpretation\":false,\"interpretationStyle\":\"improved\"} /-->\n<!-- wp:astrology-suite/simple-sign-rising {\"includeInterpretation\":true,\"interpretationStyle\":\"poetic\"} /-->\n<!-- wp:astrology-suite/simple-sign-midheaven {\"includeInterpretation\":true,\"interpretationStyle\":\"improved\"} /-->\n<!-- wp:astrology-suite/ephemeris /-->"); ?></code></pre>

                <h3><?php esc_html_e('Shortcode Examples', 'astrology-suite-freeastroapi'); ?></h3>
                <p><?php esc_html_e('Use shortcodes in classic editor content, shortcode blocks, widgets, or template areas that run WordPress shortcodes.', 'astrology-suite-freeastroapi'); ?></p>
                <pre><code><?php echo esc_html("[astrology_suite mode=\"chart-report\"]\n[astrology_suite_chart_only]\n[astrology_suite_report_only]\n[astrology_suite_chart_report]\n[astrology_suite_simple_sign_sun include_interpretation=\"true\" interpretation_style=\"improved\"]\n[astrology_suite_simple_sign_moon include_interpretation=\"false\"]\n[astrology_suite_simple_sign_rising include_interpretation=\"true\" interpretation_style=\"poetic\"]\n[astrology_suite_simple_sign_midheaven]\n[astrology_suite_ephemeris]"); ?></code></pre>
                <p><?php esc_html_e('Supported shortcode modes are chart-only, report-only, chart-report, simple-sign-sun, simple-sign-moon, simple-sign-rising, simple-sign-midheaven, and ephemeris.', 'astrology-suite-freeastroapi'); ?></p>
                <p><?php esc_html_e('Shortcode attributes: mode, include_interpretation, interpretation_style, and class. Legacy openastro, openastro_*, freeastro, and freeastro_* shortcode aliases are also registered.', 'astrology-suite-freeastroapi'); ?></p>

                <hr />
                <h2><?php esc_html_e('Settings Tabs', 'astrology-suite-freeastroapi'); ?></h2>
                <ul>
                    <li><?php esc_html_e('API stores the FreeAstroAPI key used for server-to-server requests and controls whether public visitors can use calculation forms.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Report controls interpretation length, report limits, angle sections, chart print button, and tables.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Custom Chart controls SVG/PNG chart theme bodies, FreeAstroAPI-generated preview cards, and optional advanced chart_config JSON.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Objects controls which extra points are requested and rendered in chart/report modes.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Style controls container border/background transparency, Past inputs visibility/colors, input, button, label, focus, and glyph colors/radii.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Ephemeris Style controls the monthly table preview, grid, header, badge, today row, retrograde, ingress, and station colors.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Typography controls heading, body, table, input, button, and helper text sizes.', 'astrology-suite-freeastroapi'); ?></li>
                </ul>
                <p>
                    <?php
                    echo wp_kses(
                        sprintf(
                            /* translators: %s: FreeAstroAPI chart designer URL. */
                            __('Custom chart JSON can be generated in the <a href="%s" target="_blank" rel="noopener">FreeAstroAPI Chart Designer</a>. Paste chart_config only into the custom-config field, or paste a partial SVG/PNG chart request body into an individual theme body.', 'astrology-suite-freeastroapi'),
                            esc_url(self::UPSTREAM_CHART_DESIGNER_URL)
                        ),
                        ['a' => ['href' => [], 'target' => [], 'rel' => []]]
                    );
                    ?>
                </p>
                <p>
                    <?php
                    echo wp_kses(
                        sprintf(
                            /* translators: %s: FreeAstroAPI ephemeris docs URL. */
                            __('The ephemeris block uses the <a href="%s" target="_blank" rel="noopener">FreeAstroAPI Western Ephemeris endpoint</a> with table grid output for monthly planetary tables.', 'astrology-suite-freeastroapi'),
                            esc_url(self::UPSTREAM_EPHEMERIS_DOCS_URL)
                        ),
                        ['a' => ['href' => [], 'target' => [], 'rel' => []]]
                    );
                    ?>
                </p>
                <p>
                    <?php
                    echo wp_kses(
                        sprintf(
                            /* translators: %s: FreeAstroAPI chart docs URL. */
                            __('The per-theme body editor follows the <a href="%s" target="_blank" rel="noopener">FreeAstroAPI SVG/PNG chart endpoint</a>: useful fields include size, theme_type, png_quality_scale, show_metadata, display_settings, fixed_stars, and chart_config.', 'astrology-suite-freeastroapi'),
                            esc_url(self::UPSTREAM_CHART_DOCS_URL)
                        ),
                        ['a' => ['href' => [], 'target' => [], 'rel' => []]]
                    );
                    ?>
                </p>

                <hr />
                <h2><?php esc_html_e('Legacy Block Migration', 'astrology-suite-freeastroapi'); ?></h2>
                <p><?php esc_html_e('If your pages still use old freeastro/* or openastro/* blocks, run the migrator once to convert them to astrology-suite/*.', 'astrology-suite-freeastroapi'); ?></p>
                <p><?php esc_html_e('The old openastro/* block names and REST routes remain registered for compatibility, but new pages should use astrology-suite/*.', 'astrology-suite-freeastroapi'); ?></p>
                <p><a class="button button-secondary" href="<?php echo esc_url($migrate_url); ?>"><?php esc_html_e('Run Block Migrator', 'astrology-suite-freeastroapi'); ?></a></p>

                <hr />
                <h2><?php esc_html_e('City Autocomplete', 'astrology-suite-freeastroapi'); ?></h2>
                <p><?php esc_html_e('The city field searches after at least two characters. Visitors can type a city name, or add a two-letter country filter such as "Paris, FR" or "Paris FR". Suggestions show city name, country, timezone, and coordinates when available.', 'astrology-suite-freeastroapi'); ?></p>
                <p><?php esc_html_e('Suggestions can be selected by clicking, or with Arrow Up, Arrow Down, Enter, and Escape from the keyboard.', 'astrology-suite-freeastroapi'); ?></p>

                <hr />
                <h2><?php esc_html_e('CSS Class Reference', 'astrology-suite-freeastroapi'); ?></h2>
                <p><?php esc_html_e('Use these classes in your theme/customizer CSS to style Astrology Suite for FreeAstroAPI blocks.', 'astrology-suite-freeastroapi'); ?></p>
                <pre><code><?php echo esc_html(
"Container/Layout:
.wp-block-astrology-suite-widget
.astrology-suite-no-border
.astrology-suite-output

Form/Input Controls:
.astrology-suite-form-header
.astrology-suite-history-label
.astrology-suite-history-select
.astrology-suite-load-recent-wrap
.astrology-suite-load-recent-label
.astrology-suite-load-recent-select
.astrology-suite-load-recent-panel
.astrology-suite-form
.astrology-suite-input
.astrology-suite-city-field
.astrology-suite-city-input
.astrology-suite-city-loading
.astrology-suite-inline
.astrology-suite-btn
.astrology-suite-status
.astrology-suite-results
.astrology-suite-result-btn
.astrology-suite-result-main
.astrology-suite-result-primary
.astrology-suite-result-name
.astrology-suite-result-country
.astrology-suite-result-meta
.astrology-suite-result-meta-item

Report/Card Elements:
.astrology-suite-report-title
.astrology-suite-card
.astrology-suite-access-note
.astrology-suite-planet-item

Simple Sign Elements:
.astrology-suite-simple-sign-card
.astrology-suite-simple-sign-value
.astrology-suite-simple-sign-interpretation

Chart/Print Elements:
.astrology-suite-chart-card
.astrology-suite-chart
.astrology-suite-print-btn
.astrology-suite-astro-glyph

Ephemeris Elements:
.astrology-suite-ephemeris
.astrology-suite-ephemeris-toolbar
.astrology-suite-ephemeris-filter
.astrology-suite-ephemeris-chip
.astrology-suite-ephemeris-table-card
.astrology-suite-ephemeris-table-meta
.astrology-suite-ephemeris-row-badge
.astrology-suite-ephemeris-table
.astrology-suite-ephemeris-row
.astrology-suite-ephemeris-cell
.astrology-suite-ephemeris-glyph"
                ); ?></code></pre>
                <p><?php esc_html_e('Legacy .openastro-* classes and --openastro-* variables remain supported for existing custom CSS.', 'astrology-suite-freeastroapi'); ?></p>
                <p><a href="<?php echo esc_url($css_doc_url); ?>" target="_blank" rel="noopener"><?php esc_html_e('Open full CSS class docs (Markdown)', 'astrology-suite-freeastroapi'); ?></a></p>

                <hr />
                <h2><?php esc_html_e('REST Endpoints Used By The Blocks', 'astrology-suite-freeastroapi'); ?></h2>
                <ul>
                    <li><code>GET /wp-json/astrology-suite/v1/geo/search</code> - <?php esc_html_e('public city autocomplete proxy.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><code>POST /wp-json/astrology-suite/v1/natal/calculate</code> - <?php esc_html_e('natal data and report calculation. Used by report-only and chart-report modes.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><code>POST /wp-json/astrology-suite/v1/natal/chart-svg</code> - <?php esc_html_e('natal wheel SVG generation using the selected Custom Chart request body. Used by chart-only and chart-report modes.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><code>POST /wp-json/astrology-suite/v1/western/simple-signs</code> - <?php esc_html_e('simple sign calculation for Sun, Moon, Rising, or Midheaven modes.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><code>POST /wp-json/astrology-suite/v1/western/ephemeris</code> - <?php esc_html_e('monthly ephemeris grid calculation. Used by the ephemeris mode.', 'astrology-suite-freeastroapi'); ?></li>
                </ul>
                <p><?php esc_html_e('Calculation routes are available to public visitors when public calculations are enabled in the API tab. If disabled, they require a logged-in user who can edit posts. The matching /wp-json/openastro/v1/* routes remain available as legacy aliases.', 'astrology-suite-freeastroapi'); ?></p>

                <hr />
                <h2><?php esc_html_e('External Service Disclosure', 'astrology-suite-freeastroapi'); ?></h2>
                <p><?php esc_html_e('Astrology Suite connects to FreeAstroAPI to search cities and generate astrology calculations.', 'astrology-suite-freeastroapi'); ?></p>
                <ul>
                    <li><?php esc_html_e('City autocomplete sends the typed city query and optional country filter to FreeAstroAPI over HTTPS when a visitor types at least two characters into the city field.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('Natal chart, report, chart SVG, simple-sign, and ephemeris requests send submitted astrology data and calculation options to FreeAstroAPI over HTTPS when a visitor submits the form while public calculations are enabled, or when an editor submits while public calculations are disabled.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('These calculation requests include the site’s configured FreeAstroAPI key in a server-to-server request header. The API key is not sent to the browser.', 'astrology-suite-freeastroapi'); ?></li>
                    <li><?php esc_html_e('The plugin does not store visitor birth data in WordPress by default. The optional “Past inputs” list is stored only in the visitor’s local browser storage.', 'astrology-suite-freeastroapi'); ?></li>
                </ul>
                <p><?php esc_html_e('Public calculations can be turned off in the API tab. When disabled, visitors without editor permissions see an access note instead of the calculation form.', 'astrology-suite-freeastroapi'); ?></p>
                <p>
                    <a href="<?php echo esc_url(self::UPSTREAM_SERVICE_URL); ?>" target="_blank" rel="noopener"><?php esc_html_e('FreeAstroAPI website', 'astrology-suite-freeastroapi'); ?></a>
                    |
                    <a href="<?php echo esc_url(self::UPSTREAM_TERMS_URL); ?>" target="_blank" rel="noopener"><?php esc_html_e('Terms of Service', 'astrology-suite-freeastroapi'); ?></a>
                    |
                    <a href="<?php echo esc_url(self::UPSTREAM_PRIVACY_URL); ?>" target="_blank" rel="noopener"><?php esc_html_e('Privacy Policy', 'astrology-suite-freeastroapi'); ?></a>
                </p>

                <hr />
                <h2><?php esc_html_e('Support', 'astrology-suite-freeastroapi'); ?></h2>
                <p>
                    <a class="button button-primary" href="<?php echo esc_url(self::UPSTREAM_SUPPORT_URL); ?>" target="_blank" rel="noopener">
                        <?php esc_html_e('Contact FreeAstroAPI Support', 'astrology-suite-freeastroapi'); ?>
                    </a>
                </p>
                <hr />
                <h2><?php esc_html_e('Saved Inputs (Local Browser)', 'astrology-suite-freeastroapi'); ?></h2>
                <p><?php esc_html_e('Astrology Suite for FreeAstroAPI saves the last 20 successful calculation inputs in the current browser only. Saved inputs are not written to WordPress.', 'astrology-suite-freeastroapi'); ?></p>
                <p><?php esc_html_e('Use the "Past inputs..." dropdown at the top of each widget form to reload a previous chart, report, or simple-sign request.', 'astrology-suite-freeastroapi'); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    private static function count_legacy_block_posts(): int
    {
        $post_ids = [];
        foreach (['wp:freeastro/', 'wp:openastro/'] as $needle) {
            $query = new \WP_Query([
                'post_type' => 'any',
                'post_status' => 'any',
                's' => $needle,
                'posts_per_page' => -1,
                'no_found_rows' => true,
                'fields' => 'ids',
                'cache_results' => false,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
            ]);

            foreach ((array) $query->posts as $post_id) {
                $post_ids[(int) $post_id] = true;
            }
        }

        return count($post_ids);
    }

    public static function maybe_render_block_migration_notice(): void
    {
        if (!is_admin() || !current_user_can('edit_posts')) {
            return;
        }

        $migrated_param = filter_input(INPUT_GET, 'astrology_suite_migrated', FILTER_SANITIZE_NUMBER_INT);
        if ($migrated_param === null || $migrated_param === false || $migrated_param === '') {
            $migrated_param = filter_input(INPUT_GET, 'openastro_migrated', FILTER_SANITIZE_NUMBER_INT);
        }
        if ($migrated_param !== null && $migrated_param !== false && $migrated_param !== '') {
            $count = max(0, (int) $migrated_param);
            /* translators: %d: Number of posts migrated to astrology-suite blocks. */
            $migrated_message_format = __('Astrology Suite for FreeAstroAPI migrated %d post(s) to astrology-suite/* blocks.', 'astrology-suite-freeastroapi');
            $migrated_message = sprintf($migrated_message_format, $count);
            echo '<div class="notice notice-success is-dismissible"><p>' .
                esc_html($migrated_message) .
                '</p></div>';
            return;
        }

        if (self::count_legacy_block_posts() < 1) {
            return;
        }

        $url = wp_nonce_url(admin_url('admin-post.php?action=openastro_migrate_blocks'), 'openastro_migrate_blocks');
        echo '<div class="notice notice-warning"><p>' .
            esc_html__('Legacy freeastro/* or openastro/* blocks were found. Migrate them to astrology-suite/*.', 'astrology-suite-freeastroapi') .
            ' <a class="button button-secondary" href="' . esc_url($url) . '">' . esc_html__('Run migrator', 'astrology-suite-freeastroapi') . '</a></p></div>';
    }

    public static function handle_block_migration(): void
    {
        if (!current_user_can('edit_posts')) {
            wp_die(esc_html__('You are not allowed to run this migration.', 'astrology-suite-freeastroapi'));
        }

        check_admin_referer('openastro_migrate_blocks');

        $query = new \WP_Query([
            'post_type' => 'any',
            'post_status' => 'any',
            's' => 'wp:',
            'posts_per_page' => -1,
            'no_found_rows' => true,
            'fields' => 'ids',
            'cache_results' => false,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);
        $posts = is_array($query->posts) ? $query->posts : [];

        $updated = 0;
        foreach ($posts as $post_id) {
            $content = (string) get_post_field('post_content', (int) $post_id);
            if (
                strpos($content, 'wp:freeastro/') === false &&
                strpos($content, 'wp:openastro/') === false &&
                strpos($content, '/freeastro/') === false &&
                strpos($content, '/openastro/') === false &&
                strpos($content, 'wp-block-openastro-widget') === false &&
                strpos($content, 'data-openastro-widget') === false
            ) {
                continue;
            }

            $new_content = str_replace(
                [
                    'wp:freeastro/',
                    'wp:openastro/',
                    '/wp-json/freeastro/',
                    '/wp-json/openastro/',
                    '"/freeastro/',
                    '"/openastro/',
                    '\\/freeastro/',
                    '\\/openastro/',
                    'wp-block-openastro-widget',
                    'data-openastro-widget',
                ],
                [
                    'wp:astrology-suite/',
                    'wp:astrology-suite/',
                    '/wp-json/astrology-suite/',
                    '/wp-json/astrology-suite/',
                    '"/astrology-suite/',
                    '"/astrology-suite/',
                    '\\/astrology-suite/',
                    '\\/astrology-suite/',
                    'wp-block-astrology-suite-widget',
                    'data-astrology-suite-widget',
                ],
                $content
            );

            if ($new_content === $content) {
                continue;
            }

            wp_update_post([
                'ID' => (int) $post_id,
                'post_content' => $new_content,
            ]);
            $updated++;
        }

        $redirect = add_query_arg(
            ['page' => self::SETTINGS_PAGE_SLUG, 'astrology_suite_migrated' => (string) $updated],
            admin_url('admin.php')
        );
        wp_safe_redirect($redirect);
        exit;
    }

    public static function register_routes(): void
    {
        foreach ([self::REST_NAMESPACE, self::LEGACY_REST_NAMESPACE] as $namespace) {
            register_rest_route($namespace, '/geo/search', [
                'methods' => \WP_REST_Server::READABLE,
                'callback' => [__CLASS__, 'geo_search'],
                'permission_callback' => '__return_true',
            ]);

            register_rest_route($namespace, '/natal/calculate', [
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => [__CLASS__, 'natal_calculate'],
                'permission_callback' => [__CLASS__, 'calculation_permission'],
            ]);

            register_rest_route($namespace, '/natal/chart-svg', [
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => [__CLASS__, 'natal_chart_svg'],
                'permission_callback' => [__CLASS__, 'calculation_permission'],
            ]);

            register_rest_route($namespace, '/western/simple-signs', [
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => [__CLASS__, 'simple_signs_calculate'],
                'permission_callback' => [__CLASS__, 'calculation_permission'],
            ]);

            register_rest_route($namespace, '/western/ephemeris', [
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => [__CLASS__, 'ephemeris_calculate'],
                'permission_callback' => [__CLASS__, 'calculation_permission'],
            ]);
        }
    }

    public static function calculation_permission()
    {
        if (!self::current_request_can_calculate()) {
            return new \WP_Error(
                'rest_forbidden',
                __('Astrology Suite public calculations are disabled. Log in with permission to edit posts, or enable public calculations in the API settings.', 'astrology-suite-freeastroapi'),
                ['status' => rest_authorization_required_code()]
            );
        }

        return true;
    }

    private static function ratelimit(string $bucket): bool
    {
        $key = 'openastro_rl_' . md5($bucket . '|' . self::client_fingerprint());
        $count = (int) get_transient($key);
        if ($count >= self::RATE_LIMIT_MAX_REQUESTS) {
            return false;
        }
        set_transient($key, $count + 1, self::RATE_LIMIT_WINDOW_SECONDS);
        return true;
    }

    private static function client_fingerprint(): string
    {
        $remoteAddr = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : 'unknown';
        $forwardedFor = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_X_FORWARDED_FOR'])) : '';
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';

        $xffIp = '';
        if ($forwardedFor !== '') {
            $parts = explode(',', $forwardedFor);
            if (isset($parts[0])) {
                $xffIp = trim($parts[0]);
            }
        }

        $ip = $xffIp !== '' ? $xffIp : $remoteAddr;
        return $ip . '|' . substr($userAgent, 0, 120);
    }

    public static function geo_search(\WP_REST_Request $request)
    {
        if (!self::ratelimit('geo_search')) {
            return new \WP_Error('rate_limited', 'Too many requests.', ['status' => 429]);
        }

        $q = trim((string) $request->get_param('q'));
        $limit = (int) ($request->get_param('limit') ?: 10);
        $country = trim((string) $request->get_param('country'));

        if (strlen($q) < 2 || strlen($q) > 100) {
            return new \WP_Error('invalid_q', 'Query must be 2-100 chars.', ['status' => 400]);
        }
        if ($limit < 1 || $limit > 50) {
            return new \WP_Error('invalid_limit', 'Limit must be between 1 and 50.', ['status' => 400]);
        }

        $params = ['q' => $q, 'limit' => (string) $limit];
        if ($country !== '' && preg_match('/^[A-Za-z]{2}$/', $country)) {
            $params['country'] = strtoupper($country);
        }

        return self::request('GET', '/geo/search?' . http_build_query($params), null, false, false);
    }

    public static function natal_calculate(\WP_REST_Request $request)
    {
        if (!self::ratelimit('natal_calculate')) {
            return new \WP_Error('rate_limited', 'Too many requests.', ['status' => 429]);
        }

        $payload = self::sanitize_payload($request->get_json_params());
        if (is_wp_error($payload)) {
            return $payload;
        }

        $include_minor = !empty($payload['include_minor_aspects']) ? 'true' : 'false';
        return self::request('POST', '/natal/calculate?include_minor=' . $include_minor, $payload);
    }

    public static function natal_chart_svg(\WP_REST_Request $request)
    {
        if (!self::ratelimit('natal_chart_svg')) {
            return new \WP_Error('rate_limited', 'Too many requests.', ['status' => 429]);
        }

        $payload = self::sanitize_payload($request->get_json_params());
        if (is_wp_error($payload)) {
            return $payload;
        }

        $chart_payload = self::apply_chart_body($payload, self::selected_chart_body(), 'svg', null, self::selected_chart_config());

        $result = self::request('POST', '/natal/chart/', $chart_payload, true);

        if (is_wp_error($result)) {
            return $result;
        }

        return ['svg' => $result];
    }

    public static function simple_signs_calculate(\WP_REST_Request $request)
    {
        if (!self::ratelimit('simple_signs_calculate')) {
            return new \WP_Error('rate_limited', 'Too many requests.', ['status' => 429]);
        }

        $payload = self::sanitize_simple_signs_payload($request->get_json_params());
        if (is_wp_error($payload)) {
            return $payload;
        }

        $point = $payload['include_points'][0];
        $endpoint_point = $point === 'mc' ? 'midheaven' : $point;
        unset($payload['include_points']);

        $result = self::request('POST', '/western/signs/' . rawurlencode($endpoint_point), $payload);
        if (is_wp_error($result)) {
            return $result;
        }

        return self::normalize_simple_signs_response($result, $point);
    }

    public static function ephemeris_calculate(\WP_REST_Request $request)
    {
        if (!self::ratelimit('ephemeris_calculate')) {
            return new \WP_Error('rate_limited', 'Too many requests.', ['status' => 429]);
        }

        $payload = self::sanitize_ephemeris_payload($request->get_json_params());
        if (is_wp_error($payload)) {
            return $payload;
        }

        return self::request('POST', '/ephemeris/calculate', $payload);
    }

    private static function ephemeris_body_map(): array
    {
        return [
            'sun' => 'Sun',
            'moon' => 'Moon',
            'mercury' => 'Mercury',
            'venus' => 'Venus',
            'mars' => 'Mars',
            'jupiter' => 'Jupiter',
            'saturn' => 'Saturn',
            'uranus' => 'Uranus',
            'neptune' => 'Neptune',
            'pluto' => 'Pluto',
            'mean-node' => 'Mean Node',
            'mean_node' => 'Mean Node',
            'true-node' => 'True Node',
            'true_node' => 'True Node',
            'north-node' => 'True Node',
            'north_node' => 'True Node',
            'lilith' => 'Lilith',
            'true-lilith' => 'True Lilith',
            'true_lilith' => 'True Lilith',
            'chiron' => 'Chiron',
            'pholus' => 'Pholus',
            'ceres' => 'Ceres',
            'pallas' => 'Pallas',
            'juno' => 'Juno',
            'vesta' => 'Vesta',
            'ascendant' => 'Ascendant',
            'asc' => 'Ascendant',
            'mc' => 'MC',
            'midheaven' => 'MC',
            'vertex' => 'Vertex',
            'vx' => 'Vertex',
            'part-of-fortune' => 'Part of Fortune',
            'part_of_fortune' => 'Part of Fortune',
            'pof' => 'Part of Fortune',
        ];
    }

    private static function sanitize_ephemeris_payload($payload)
    {
        if (!is_array($payload)) {
            return new \WP_Error('invalid_payload', 'Payload must be an object.', ['status' => 400]);
        }

        $year = isset($payload['year']) ? (int) $payload['year'] : 0;
        $month = isset($payload['month']) ? (int) $payload['month'] : 0;
        if ($year < 1800 || $year > 2100) {
            return new \WP_Error('invalid_payload', 'Year out of range.', ['status' => 400]);
        }
        if ($month < 1 || $month > 12) {
            return new \WP_Error('invalid_payload', 'Month out of range.', ['status' => 400]);
        }

        $body_map = self::ephemeris_body_map();
        $requested_bodies = isset($payload['bodies']) && is_array($payload['bodies']) ? $payload['bodies'] : [];
        if ($requested_bodies === []) {
            $requested_bodies = ['Sun', 'Moon', 'Mercury', 'Venus', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune', 'Pluto', 'True Node', 'Chiron'];
        }

        $bodies = [];
        foreach ($requested_bodies as $body) {
            $key = sanitize_key(str_replace(' ', '-', (string) $body));
            if (!isset($body_map[$key])) {
                return new \WP_Error('invalid_payload', 'Unsupported ephemeris body requested.', ['status' => 400]);
            }
            $bodies[] = $body_map[$key];
        }
        $bodies = array_values(array_unique($bodies));
        if (count($bodies) < 1 || count($bodies) > 24) {
            return new \WP_Error('invalid_payload', 'Select between 1 and 24 ephemeris bodies.', ['status' => 400]);
        }

        $has_lat = isset($payload['lat']) && $payload['lat'] !== '';
        $has_lng = isset($payload['lng']) && $payload['lng'] !== '';
        $has_location = $has_lat || $has_lng;
        if ($has_location && !($has_lat && $has_lng)) {
            return new \WP_Error('invalid_payload', 'lat and lng must both be provided when selecting a location.', ['status' => 400]);
        }

        $lat = null;
        $lng = null;
        if ($has_location) {
            $lat = (float) $payload['lat'];
            $lng = (float) $payload['lng'];
            if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
                return new \WP_Error('invalid_payload', 'Invalid lat/lng.', ['status' => 400]);
            }
        }

        $local_bodies = ['Ascendant', 'MC', 'Vertex', 'Part of Fortune'];
        if (!$has_location && array_intersect($local_bodies, $bodies) !== []) {
            return new \WP_Error('invalid_payload', 'Coordinate-based points require a selected city.', ['status' => 400]);
        }

        try {
            $start = new \DateTimeImmutable(sprintf('%04d-%02d-01 00:00:00', $year, $month), new \DateTimeZone('UTC'));
            $end = $start->modify('last day of this month');
        } catch (\Exception $e) {
            return new \WP_Error('invalid_payload', 'Invalid month.', ['status' => 400]);
        }

        $zodiac_type = isset($payload['zodiac_type']) ? sanitize_key((string) $payload['zodiac_type']) : 'tropical';
        if (!in_array($zodiac_type, ['tropical', 'sidereal'], true)) {
            $zodiac_type = 'tropical';
        }

        $api_payload = [
            'start' => $start->format('Y-m-d\T00:00:00\Z'),
            'end' => $end->format('Y-m-d\T00:00:00\Z'),
            'step' => '1d',
            'format' => 'table',
            'response_mode' => 'table',
            'table_style' => 'grid',
            'zodiac_type' => $zodiac_type,
            'bodies' => $bodies,
        ];

        if ($has_location) {
            $api_payload['lat'] = $lat;
            $api_payload['lng'] = $lng;
            $api_payload['city'] = isset($payload['city']) ? sanitize_text_field((string) $payload['city']) : '';
            $api_payload['tz_str'] = isset($payload['tz_str']) && (string) $payload['tz_str'] !== ''
                ? sanitize_text_field((string) $payload['tz_str'])
                : 'AUTO';
            $api_payload['include_angles'] = true;
            $api_payload['include_houses'] = true;
        }

        return $api_payload;
    }

    private static function normalize_simple_signs_response(array $result, string $point): array
    {
        if (!isset($result['sign']) && !isset($result['point'])) {
            $keys = ['sun', 'moon', 'rising', 'midheaven', 'mc'];
            foreach ($keys as $k) {
                if (isset($result[$k]) && is_array($result[$k])) {
                    $result = $result[$k];
                    break;
                }
            }
        }

        $interpretation = null;
        if (isset($result['interpretation']) && is_array($result['interpretation'])) {
            $interpretation = [
                'title' => isset($result['interpretation']['title']) ? (string) $result['interpretation']['title'] : '',
                'body' => isset($result['interpretation']['body']) ? (string) $result['interpretation']['body'] : '',
                'tone' => isset($result['interpretation']['tone']) ? (string) $result['interpretation']['tone'] : '',
            ];
        }

        return [
            'point' => isset($result['point']) ? (string) $result['point'] : ucfirst($point),
            'sign' => isset($result['sign']) ? (string) $result['sign'] : '',
            'sign_id' => isset($result['sign_id']) ? (string) $result['sign_id'] : '',
            'degree' => isset($result['degree']) ? (float) $result['degree'] : null,
            'abs_pos' => isset($result['abs_pos']) ? (float) $result['abs_pos'] : null,
            'house' => isset($result['house']) ? (int) $result['house'] : null,
            'interpretation' => $interpretation,
            'raw' => $result,
        ];
    }

    private static function sanitize_simple_signs_payload($payload)
    {
        if (!is_array($payload)) {
            return new \WP_Error('invalid_payload', 'Payload must be an object.', ['status' => 400]);
        }

        $required = ['year', 'month', 'day', 'hour', 'minute', 'city', 'include_points'];
        foreach ($required as $field) {
            if (!isset($payload[$field])) {
                return new \WP_Error('invalid_payload', "Missing {$field}.", ['status' => 400]);
            }
        }

        if (!is_array($payload['include_points']) || count($payload['include_points']) !== 1) {
            return new \WP_Error('invalid_payload', 'include_points must contain exactly one point.', ['status' => 400]);
        }

        $point = strtolower(trim((string) $payload['include_points'][0]));
        if ($point === 'midheaven') {
            $point = 'mc';
        }
        if (!in_array($point, ['sun', 'moon', 'rising', 'mc'], true)) {
            return new \WP_Error('invalid_payload', 'Point must be one of sun, moon, rising, mc/midheaven.', ['status' => 400]);
        }

        $payload['year'] = (int) $payload['year'];
        $payload['month'] = (int) $payload['month'];
        $payload['day'] = (int) $payload['day'];
        $payload['hour'] = (int) $payload['hour'];
        $payload['minute'] = (int) $payload['minute'];

        if ($payload['year'] < 1800 || $payload['year'] > 2100) return new \WP_Error('invalid_payload', 'Year out of range.', ['status' => 400]);
        if ($payload['month'] < 1 || $payload['month'] > 12) return new \WP_Error('invalid_payload', 'Month out of range.', ['status' => 400]);
        if ($payload['day'] < 1 || $payload['day'] > 31) return new \WP_Error('invalid_payload', 'Day out of range.', ['status' => 400]);
        if ($payload['hour'] < 0 || $payload['hour'] > 23) return new \WP_Error('invalid_payload', 'Hour out of range.', ['status' => 400]);
        if ($payload['minute'] < 0 || $payload['minute'] > 59) return new \WP_Error('invalid_payload', 'Minute out of range.', ['status' => 400]);

        $payload['city'] = sanitize_text_field((string) $payload['city']);
        if ($payload['city'] === '') {
            return new \WP_Error('invalid_payload', 'City is required.', ['status' => 400]);
        }

        if (isset($payload['lat']) || isset($payload['lng'])) {
            if (!isset($payload['lat'], $payload['lng'])) {
                return new \WP_Error('invalid_payload', 'lat and lng must both be provided when overriding coordinates.', ['status' => 400]);
            }
            $payload['lat'] = (float) $payload['lat'];
            $payload['lng'] = (float) $payload['lng'];
            if ($payload['lat'] < -90 || $payload['lat'] > 90 || $payload['lng'] < -180 || $payload['lng'] > 180) {
                return new \WP_Error('invalid_payload', 'Invalid lat/lng.', ['status' => 400]);
            }
        }

        $payload['name'] = isset($payload['name']) ? sanitize_text_field((string) $payload['name']) : '';
        $payload['tz_str'] = isset($payload['tz_str']) ? sanitize_text_field((string) $payload['tz_str']) : 'AUTO';
        $payload['house_system'] = isset($payload['house_system']) ? sanitize_key((string) $payload['house_system']) : 'placidus';
        $payload['zodiac_type'] = isset($payload['zodiac_type']) ? sanitize_key((string) $payload['zodiac_type']) : 'tropical';
        $payload['include_points'] = [$point];

        $include_interpretation = !isset($payload['include_interpretation']) || (bool) $payload['include_interpretation'];
        $style = isset($payload['interpretation_style']) ? sanitize_key((string) $payload['interpretation_style']) : 'improved';
        if (!in_array($style, ['improved', 'poetic'], true)) {
            return new \WP_Error('invalid_payload', 'interpretation_style must be improved or poetic.', ['status' => 400]);
        }

        $payload['interpretation'] = ['enable' => $include_interpretation];
        if ($include_interpretation) {
            $payload['interpretation']['style'] = $style;
        }

        unset($payload['include_interpretation'], $payload['interpretation_style']);

        return $payload;
    }

    private static function sanitize_payload($payload)
    {
        if (!is_array($payload)) {
            return new \WP_Error('invalid_payload', 'Payload must be an object.', ['status' => 400]);
        }

        $required = ['year', 'month', 'day', 'hour', 'minute', 'city', 'lat', 'lng', 'tz_str'];
        foreach ($required as $field) {
            if (!isset($payload[$field])) {
                return new \WP_Error('invalid_payload', "Missing {$field}.", ['status' => 400]);
            }
        }

        $payload['year'] = (int) $payload['year'];
        $payload['month'] = (int) $payload['month'];
        $payload['day'] = (int) $payload['day'];
        $payload['hour'] = (int) $payload['hour'];
        $payload['minute'] = (int) $payload['minute'];
        $payload['lat'] = (float) $payload['lat'];
        $payload['lng'] = (float) $payload['lng'];

        if ($payload['year'] < 1800 || $payload['year'] > 2100) return new \WP_Error('invalid_payload', 'Year out of range.', ['status' => 400]);
        if ($payload['month'] < 1 || $payload['month'] > 12) return new \WP_Error('invalid_payload', 'Month out of range.', ['status' => 400]);
        if ($payload['day'] < 1 || $payload['day'] > 31) return new \WP_Error('invalid_payload', 'Day out of range.', ['status' => 400]);
        if ($payload['hour'] < 0 || $payload['hour'] > 23) return new \WP_Error('invalid_payload', 'Hour out of range.', ['status' => 400]);
        if ($payload['minute'] < 0 || $payload['minute'] > 59) return new \WP_Error('invalid_payload', 'Minute out of range.', ['status' => 400]);
        if ($payload['lat'] < -90 || $payload['lat'] > 90 || $payload['lng'] < -180 || $payload['lng'] > 180) {
            return new \WP_Error('invalid_payload', 'Invalid lat/lng.', ['status' => 400]);
        }

        $payload['name'] = isset($payload['name']) ? sanitize_text_field((string) $payload['name']) : '';
        $payload['city'] = sanitize_text_field((string) $payload['city']);
        $payload['tz_str'] = sanitize_text_field((string) $payload['tz_str']);
        $payload['house_system'] = 'placidus';
        $payload['zodiac_type'] = 'tropical';
        $payload['include_speed'] = true;
        $payload['include_dominants'] = true;
        $payload['include_features'] = self::get_enabled_features();
        $payload['interpretation'] = ['enable' => true, 'style' => 'improved'];
        $payload['include_minor_aspects'] = !isset($payload['include_minor_aspects']) || (bool) $payload['include_minor_aspects'];

        return $payload;
    }

    private static function request(string $method, string $path, ?array $body = null, bool $expect_svg = false, bool $include_api_key = true)
    {
        $args = [
            'method' => $method,
            'timeout' => 15,
            'headers' => [],
        ];

        if ($include_api_key) {
            $api_key = (string) self::get_option_value(self::OPTION_API_KEY, '');
            if ($api_key === '') {
                return new \WP_Error('missing_api_key', 'FreeAstroAPI key is not configured.', ['status' => 500]);
            }
            $args['headers']['x-api-key'] = $api_key;
        }

        if ($body !== null) {
            $args['headers']['Content-Type'] = 'application/json';
            $args['body'] = wp_json_encode($body);
        }

        $response = wp_remote_request(self::UPSTREAM_BASE_URL . $path, $args);
        if (is_wp_error($response)) {
            return new \WP_Error('upstream_network_error', 'Could not reach upstream API.', ['status' => 502]);
        }

        $status = (int) wp_remote_retrieve_response_code($response);
        $raw = (string) wp_remote_retrieve_body($response);

        if ($status < 200 || $status >= 300) {
            return new \WP_Error('upstream_error', self::upstream_status_message($status), ['status' => $status]);
        }

        if ($expect_svg) {
            $svg = self::sanitize_svg_response($raw);
            if ($svg === '') {
                return new \WP_Error('invalid_svg', 'Invalid SVG response from upstream.', ['status' => 502]);
            }
            return $svg;
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            return new \WP_Error('invalid_response', 'Invalid JSON response from upstream.', ['status' => 502]);
        }

        return $decoded;
    }

    private static function sanitize_svg_response(string $raw): string
    {
        $raw = trim($raw);
        if ($raw === '' || stripos($raw, '<svg') === false) {
            return '';
        }

        if (!class_exists('\DOMDocument')) {
            return self::sanitize_svg_response_with_kses($raw);
        }

        $previous = libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $loaded = $dom->loadXML($raw, LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if (!$loaded || !$dom->documentElement || strtolower($dom->documentElement->localName) !== 'svg') {
            return '';
        }

        self::sanitize_svg_node($dom->documentElement);
        $svg = $dom->saveXML($dom->documentElement);

        return is_string($svg) ? trim($svg) : '';
    }

    private static function sanitize_svg_node(\DOMNode $node): void
    {
        if ($node->nodeType === XML_COMMENT_NODE || $node->nodeType === XML_PI_NODE) {
            if ($node->parentNode) {
                $node->parentNode->removeChild($node);
            }
            return;
        }

        if ($node->nodeType === XML_ELEMENT_NODE) {
            $blocked_elements = [
                'script',
                'foreignobject',
                'iframe',
                'object',
                'embed',
                'audio',
                'video',
                'canvas',
                'link',
                'meta',
                'style',
            ];
            if (in_array(strtolower($node->localName), $blocked_elements, true)) {
                if ($node->parentNode) {
                    $node->parentNode->removeChild($node);
                }
                return;
            }

            if ($node->hasAttributes()) {
                $remove_attributes = [];
                foreach ($node->attributes as $attribute) {
                    $name = strtolower($attribute->nodeName);
                    $value = trim(html_entity_decode((string) $attribute->nodeValue, ENT_QUOTES | ENT_HTML5, 'UTF-8'));

                    if (strpos($name, 'on') === 0) {
                        $remove_attributes[] = $attribute->nodeName;
                        continue;
                    }

                    if (in_array($name, ['href', 'xlink:href', 'src'], true) && strpos($value, '#') !== 0) {
                        $remove_attributes[] = $attribute->nodeName;
                        continue;
                    }

                    if (preg_match('/^\s*(?:javascript|vbscript|data):/i', $value)) {
                        $remove_attributes[] = $attribute->nodeName;
                        continue;
                    }

                    if ($name === 'style' && preg_match('/(?:url\s*\(|expression\s*\(|@import)/i', $value)) {
                        $remove_attributes[] = $attribute->nodeName;
                    }
                }

                foreach ($remove_attributes as $attribute_name) {
                    $node->removeAttribute($attribute_name);
                }
            }
        }

        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            self::sanitize_svg_node($child);
        }
    }

    private static function sanitize_svg_response_with_kses(string $raw): string
    {
        $allowed_svg = [
            'svg' => ['xmlns' => true, 'viewbox' => true, 'viewBox' => true, 'width' => true, 'height' => true, 'role' => true, 'aria-label' => true],
            'g' => ['id' => true, 'class' => true, 'transform' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true],
            'path' => ['d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'opacity' => true, 'transform' => true],
            'circle' => ['cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true],
            'ellipse' => ['cx' => true, 'cy' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true],
            'line' => ['x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true],
            'polyline' => ['points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true],
            'polygon' => ['points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true],
            'rect' => ['x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true],
            'text' => ['x' => true, 'y' => true, 'fill' => true, 'font-size' => true, 'font-family' => true, 'font-weight' => true, 'text-anchor' => true, 'dominant-baseline' => true, 'transform' => true, 'opacity' => true],
            'tspan' => ['x' => true, 'y' => true, 'dx' => true, 'dy' => true, 'fill' => true, 'font-size' => true, 'font-family' => true, 'font-weight' => true, 'text-anchor' => true],
            'defs' => [],
            'clipPath' => ['id' => true],
            'mask' => ['id' => true],
            'linearGradient' => ['id' => true, 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true],
            'radialGradient' => ['id' => true, 'cx' => true, 'cy' => true, 'r' => true],
            'stop' => ['offset' => true, 'stop-color' => true, 'stop-opacity' => true],
            'title' => [],
            'desc' => [],
        ];

        $svg = trim(wp_kses($raw, $allowed_svg));
        return stripos($svg, '<svg') !== false ? $svg : '';
    }

    private static function upstream_status_message(int $status): string
    {
        if ($status === 400) return 'Upstream rejected the request payload.';
        if ($status === 401 || $status === 403) return 'Upstream authentication failed.';
        if ($status === 404) return 'Upstream endpoint not found.';
        if ($status === 408 || $status === 504) return 'Upstream request timed out.';
        if ($status === 429) return 'Upstream rate limit reached.';
        if ($status >= 500) return 'Upstream service is temporarily unavailable.';
        return 'Upstream API returned an error.';
    }

    public static function register_blocks(): void
    {
        self::register_widget_blocks();
    }

    public static function register_shortcodes(): void
    {
        foreach (self::shortcode_names() as $shortcode) {
            add_shortcode($shortcode, [__CLASS__, 'render_shortcode']);
        }
    }

    public static function render_shortcode($atts = [], $content = null, string $tag = ''): string
    {
        $raw_atts = is_array($atts) ? array_change_key_case($atts, CASE_LOWER) : [];
        $defaults = [
            'mode' => '',
            'type' => '',
            'include_interpretation' => '',
            'includeinterpretation' => '',
            'interpretation_style' => '',
            'interpretationstyle' => '',
            'class' => '',
        ];
        $parsed = shortcode_atts($defaults, $raw_atts, $tag);
        $mode = self::shortcode_mode_from_tag($tag, (string) ($parsed['mode'] ?: $parsed['type']));
        $include_interpretation = $parsed['include_interpretation'] !== ''
            ? $parsed['include_interpretation']
            : $parsed['includeinterpretation'];
        $interpretation_style = $parsed['interpretation_style'] !== ''
            ? $parsed['interpretation_style']
            : $parsed['interpretationstyle'];

        self::enqueue_widget_assets();

        return self::render_widget_container($mode, [
            'include_interpretation' => self::shortcode_bool($include_interpretation, true),
            'interpretation_style' => self::normalize_interpretation_style((string) $interpretation_style),
            'class' => (string) $parsed['class'],
        ]);
    }

    public static function maybe_enqueue_shortcode_assets(): void
    {
        if (is_admin()) {
            return;
        }

        if (self::current_request_has_shortcode()) {
            self::enqueue_widget_assets();
        }
    }

    public static function maybe_print_late_shortcode_styles(): void
    {
        if (wp_style_is('openastro-suite-widgets-style', 'enqueued') && !wp_style_is('openastro-suite-widgets-style', 'done')) {
            wp_print_styles('openastro-suite-widgets-style');
        }
    }

    private static function frontend_config(): array
    {
        return [
            'root' => esc_url_raw(rest_url(self::REST_NAMESPACE . '/')),
            'nonce' => wp_create_nonce('wp_rest'),
            'permissions' => [
                'canCalculate' => self::current_request_can_calculate(),
                'calculationMessage' => self::frontend_access_message(),
            ],
            'report' => [
                'detailLevel' => (string) self::get_option_value(self::OPTION_REPORT_DETAIL, 'full'),
                'maxPlanets' => (int) self::get_option_value(self::OPTION_REPORT_MAX_PLANETS, 13),
                'maxAspects' => (int) self::get_option_value(self::OPTION_REPORT_MAX_ASPECTS, 40),
                'showTables' => (bool) self::get_option_value(self::OPTION_REPORT_SHOW_TABLES, true),
                'showAngles' => (bool) self::get_option_value(self::OPTION_REPORT_SHOW_ANGLES, true),
                'showPrintButton' => (bool) self::get_option_value(self::OPTION_CHART_SHOW_PRINT_BUTTON, true),
            ],
            'objects' => [
                'asc' => (bool) self::get_option_value(self::OPTION_OBJ_ASC, true),
                'mc' => (bool) self::get_option_value(self::OPTION_OBJ_MC, true),
                'chiron' => (bool) self::get_option_value(self::OPTION_OBJ_CHIRON, true),
                'lilith' => (bool) self::get_option_value(self::OPTION_OBJ_LILITH, true),
                'true_node' => (bool) self::get_option_value(self::OPTION_OBJ_TRUE_NODE, true),
                'mean_node' => (bool) self::get_option_value(self::OPTION_OBJ_MEAN_NODE, true),
                'part_of_fortune' => (bool) self::get_option_value(self::OPTION_OBJ_PART_OF_FORTUNE, true),
            ],
            'style' => [
                'showBorder' => (bool) self::get_option_value(self::OPTION_STYLE_SHOW_BORDER, true),
                'backgroundColor' => (string) self::get_option_value(self::OPTION_STYLE_BG_COLOR, '#ffffff'),
                'transparentBackground' => (bool) self::get_option_value(self::OPTION_STYLE_TRANSPARENT_BG, false),
                'textColor' => (string) self::get_option_value(self::OPTION_STYLE_TEXT_COLOR, '#111111'),
                'showHistory' => (bool) self::get_option_value(self::OPTION_STYLE_SHOW_HISTORY, true),
                'historyBgColor' => (string) self::get_option_value(self::OPTION_STYLE_HISTORY_BG_COLOR, '#f9fafb'),
                'historyBorderColor' => (string) self::get_option_value(self::OPTION_STYLE_HISTORY_BORDER_COLOR, '#e5e7eb'),
                'historyTextColor' => (string) self::get_option_value(self::OPTION_STYLE_HISTORY_TEXT_COLOR, '#111111'),
                'inputBorderRadius' => (int) self::get_option_value(self::OPTION_STYLE_INPUT_BORDER_RADIUS, 6),
                'inputBorderColor' => (string) self::get_option_value(self::OPTION_STYLE_INPUT_BORDER_COLOR, '#d1d5db'),
                'inputBgColor' => (string) self::get_option_value(self::OPTION_STYLE_INPUT_BG_COLOR, '#ffffff'),
                'inputTextColor' => (string) self::get_option_value(self::OPTION_STYLE_INPUT_TEXT_COLOR, '#111111'),
                'inputPlaceholderColor' => (string) self::get_option_value(self::OPTION_STYLE_INPUT_PLACEHOLDER_COLOR, '#6b7280'),
                'buttonBorderRadius' => (int) self::get_option_value(self::OPTION_STYLE_BUTTON_BORDER_RADIUS, 6),
                'buttonBgColor' => (string) self::get_option_value(self::OPTION_STYLE_BUTTON_BG_COLOR, '#111827'),
                'buttonTextColor' => (string) self::get_option_value(self::OPTION_STYLE_BUTTON_TEXT_COLOR, '#ffffff'),
                'buttonBorderColor' => (string) self::get_option_value(self::OPTION_STYLE_BUTTON_BORDER_COLOR, '#111827'),
                'labelColor' => (string) self::get_option_value(self::OPTION_STYLE_LABEL_COLOR, '#111111'),
                'labelWeight' => (string) self::get_option_value(self::OPTION_STYLE_LABEL_WEIGHT, '600'),
                'focusRingColor' => (string) self::get_option_value(self::OPTION_STYLE_FOCUS_RING_COLOR, '#2563eb'),
                'astroFontSize' => (int) self::get_option_value(self::OPTION_STYLE_ASTRO_FONT_SIZE, 20),
                'astroFontColor' => (string) self::get_option_value(self::OPTION_STYLE_ASTRO_FONT_COLOR, '#111111'),
            ],
            'ephemerisStyle' => [
                'tableBgColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_BG_COLOR, '#ffffff'),
                'tableTextColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_TEXT_COLOR, '#111111'),
                'tableBorderColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_BORDER_COLOR, '#e5e7eb'),
                'headerBgColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_HEADER_BG_COLOR, '#f8fafc'),
                'headerTextColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_HEADER_TEXT_COLOR, '#111111'),
                'badgeBgColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_BADGE_BG_COLOR, '#f8fafc'),
                'badgeTextColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_BADGE_TEXT_COLOR, '#475569'),
                'todayBgColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_TODAY_BG_COLOR, '#f8fafc'),
                'todayAccentColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_TABLE_TODAY_ACCENT_COLOR, '#2563eb'),
                'retrogradeColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_RETROGRADE_COLOR, '#b91c1c'),
                'ingressColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_INGRESS_COLOR, '#1d4ed8'),
                'stationColor' => (string) self::get_option_value(self::OPTION_EPHEMERIS_STATION_COLOR, '#a16207'),
            ],
            'typography' => [
                'h2' => (int) self::get_option_value(self::OPTION_TYPO_H2, 28),
                'h3' => (int) self::get_option_value(self::OPTION_TYPO_H3, 22),
                'h4' => (int) self::get_option_value(self::OPTION_TYPO_H4, 18),
                'body' => (int) self::get_option_value(self::OPTION_TYPO_BODY, 16),
                'table' => (int) self::get_option_value(self::OPTION_TYPO_TABLE, 14),
                'input' => (int) self::get_option_value(self::OPTION_TYPO_INPUT, 16),
                'button' => (int) self::get_option_value(self::OPTION_TYPO_BUTTON, 16),
                'meta' => (int) self::get_option_value(self::OPTION_TYPO_META, 13),
            ],
        ];
    }

    private static function get_enabled_features(): array
    {
        $features = [];

        if ((bool) self::get_option_value(self::OPTION_OBJ_ASC, true)) { $features[] = 'asc'; }
        if ((bool) self::get_option_value(self::OPTION_OBJ_MC, true)) { $features[] = 'mc'; }
        if ((bool) self::get_option_value(self::OPTION_OBJ_CHIRON, true)) { $features[] = 'chiron'; }
        if ((bool) self::get_option_value(self::OPTION_OBJ_LILITH, true)) { $features[] = 'lilith'; }
        if ((bool) self::get_option_value(self::OPTION_OBJ_TRUE_NODE, true)) { $features[] = 'true_node'; }
        if ((bool) self::get_option_value(self::OPTION_OBJ_MEAN_NODE, true)) { $features[] = 'mean_node'; }
        if ((bool) self::get_option_value(self::OPTION_OBJ_PART_OF_FORTUNE, true)) { $features[] = 'part_of_fortune'; }

        if (count($features) < 2) {
            return ['asc', 'mc'];
        }

        return $features;
    }

    private static function add_config(string $handle): void
    {
        $config = wp_json_encode(self::frontend_config());
        wp_add_inline_script($handle, 'window.AstrologySuiteBlocks = Object.assign({}, window.AstrologySuiteBlocks || {}, ' . $config . '); window.OpenAstroBlocks = Object.assign({}, window.OpenAstroBlocks || {}, window.AstrologySuiteBlocks);', 'before');
    }

    private static function shortcode_names(): array
    {
        $shortcodes = ['astrology_suite', 'openastro', 'freeastro'];

        foreach (self::WIDGET_MODES as $mode) {
            $suffix = str_replace('-', '_', $mode);
            $shortcodes[] = 'astrology_suite_' . $suffix;
            $shortcodes[] = 'openastro_' . $suffix;
            $shortcodes[] = 'freeastro_' . $suffix;
        }

        return $shortcodes;
    }

    private static function current_request_has_shortcode(): bool
    {
        $posts = [];
        $post = get_post();
        if ($post instanceof \WP_Post) {
            $posts[] = $post;
        }

        global $wp_query;
        if ($wp_query instanceof \WP_Query && is_array($wp_query->posts)) {
            foreach ($wp_query->posts as $query_post) {
                if ($query_post instanceof \WP_Post) {
                    $posts[] = $query_post;
                }
            }
        }

        foreach ($posts as $candidate) {
            if (self::content_has_widget_shortcode((string) $candidate->post_content)) {
                return true;
            }
        }

        return false;
    }

    private static function content_has_widget_shortcode(string $content): bool
    {
        if ($content === '') {
            return false;
        }

        foreach (self::shortcode_names() as $shortcode) {
            if (has_shortcode($content, $shortcode)) {
                return true;
            }
        }

        return false;
    }

    private static function register_widget_assets(): void
    {
        if (!wp_script_is('openastro-suite-widgets-editor', 'registered')) {
            wp_register_script('openastro-suite-widgets-editor', OPENASTRO_SUITE_URL . 'assets/widgets-blocks.js', ['wp-blocks', 'wp-element', 'wp-i18n', 'wp-block-editor', 'wp-components'], OPENASTRO_SUITE_VERSION, true);
        }

        if (!wp_script_is('openastro-suite-widgets-frontend', 'registered')) {
            wp_register_script('openastro-suite-widgets-frontend', OPENASTRO_SUITE_URL . 'assets/widgets-frontend.js', [], OPENASTRO_SUITE_VERSION, true);
            self::add_config('openastro-suite-widgets-frontend');
        }

        if (!wp_style_is('openastro-suite-widgets-style', 'registered')) {
            wp_register_style('openastro-suite-widgets-style', OPENASTRO_SUITE_URL . 'assets/widgets-style.css', [], OPENASTRO_SUITE_VERSION);
        }
    }

    private static function enqueue_widget_assets(): void
    {
        self::register_widget_assets();
        wp_enqueue_script('openastro-suite-widgets-frontend');
        wp_enqueue_style('openastro-suite-widgets-style');
    }

    private static function register_widget_blocks(): void
    {
        self::register_widget_assets();

        foreach (self::WIDGET_MODES as $slug) {
            foreach ([self::BLOCK_NAMESPACE, self::LEGACY_BLOCK_NAMESPACE] as $namespace) {
                register_block_type($namespace . '/' . $slug, [
                    'editor_script' => 'openastro-suite-widgets-editor',
                    'script' => 'openastro-suite-widgets-frontend',
                    'style' => 'openastro-suite-widgets-style',
                ]);
            }
        }
    }

    private static function shortcode_mode_from_tag(string $tag, string $fallback): string
    {
        $tag = sanitize_key($tag);
        foreach (['astrology_suite_', 'openastro_', 'freeastro_'] as $prefix) {
            if (str_starts_with($tag, $prefix)) {
                return self::normalize_widget_mode(substr($tag, strlen($prefix)));
            }
        }

        return self::normalize_widget_mode($fallback !== '' ? $fallback : 'chart-report');
    }

    private static function normalize_widget_mode(string $mode): string
    {
        $mode = sanitize_key(str_replace('_', '-', $mode));
        return in_array($mode, self::WIDGET_MODES, true) ? $mode : 'chart-report';
    }

    private static function normalize_interpretation_style(string $style): string
    {
        return sanitize_key($style) === 'poetic' ? 'poetic' : 'improved';
    }

    private static function shortcode_bool($value, bool $default): bool
    {
        $value = trim(strtolower((string) $value));
        if ($value === '') {
            return $default;
        }
        if (in_array($value, ['1', 'true', 'yes', 'on'], true)) {
            return true;
        }
        if (in_array($value, ['0', 'false', 'no', 'off'], true)) {
            return false;
        }
        return $default;
    }

    private static function sanitize_class_list(string $class): string
    {
        $classes = preg_split('/\s+/', trim($class));
        if (!is_array($classes)) {
            return '';
        }

        $clean = [];
        foreach ($classes as $item) {
            $sanitized = sanitize_html_class($item);
            if ($sanitized !== '') {
                $clean[] = $sanitized;
            }
        }

        return implode(' ', array_unique($clean));
    }

    private static function render_widget_container(string $mode, array $attrs = []): string
    {
        $mode = self::normalize_widget_mode($mode);
        $include_interpretation = !isset($attrs['include_interpretation']) || (bool) $attrs['include_interpretation'];
        $interpretation_style = self::normalize_interpretation_style((string) ($attrs['interpretation_style'] ?? 'improved'));
        $extra_class = self::sanitize_class_list((string) ($attrs['class'] ?? ''));
        $classes = trim('wp-block-astrology-suite-widget' . ($extra_class !== '' ? ' ' . $extra_class : ''));

        return sprintf(
            '<div class="%1$s" data-astrology-suite-widget="1" data-mode="%2$s" data-include-interpretation="%3$s" data-interpretation-style="%4$s"></div>',
            esc_attr($classes),
            esc_attr($mode),
            $include_interpretation ? '1' : '0',
            esc_attr($interpretation_style)
        );
    }
}
