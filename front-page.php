<?php
/**
 * Front page template
 *
 * @package Kancelaria
 */

if (!defined('ABSPATH')) {
    exit;
}

// --- USTAWIENIA ---
$bgUrl      = '/wp-content/themes/kancelaria/assets/hero-bg.jpg';
$personUrl  = '/wp-content/themes/kancelaria/assets/person.webp';
$logoSvg    = '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="23.7288" height="25" fill="url(#pattern0_50_85)"/>
<defs>
<pattern id="pattern0_50_85" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_50_85" transform="scale(0.0178571 0.0169492)"/>
</pattern>
<image id="image0_50_85" width="56" height="59" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAA7CAYAAAAuEkmwAAACqklEQVR4AexaS1IbMRCVzMwExzlBUsk9WJBFqnIHcoSw5AQsOANs2cGaI8CGc0AVJ6AwjAeLlsCDGLVE61MzY5eoEsit7tfv9TPgKs2EbfhXkEDx8CT6XqE+BAkMbTZEXRY4xNRT9swOUqfJv37hqRa1JyUvO0iZ0phzsoNjdofCrXVQLMQudWHAohb/qfXOPMCJxdfrW4FsUV+Sl46w2jf1Mbne1UvirDD1nzLuqtPPtLp3gVpwk7ZZ4Lq76XZQTO7YcuvcWJhqsXVt5GG1n8UkDhVf8sNytZhbYFXs8W/Fv+7S6tstnxU73byg14DTgmobDJ8BPy0F3boFdkvW8HUWuIamfaCcHfwwjsAX4r45665AKO+yfhycPO+x7vKmGlbQj8AwbkmqssAkYxwQJDs44PCTtM4OJhnjgCDZwQGHn6R1djDJGAcEyQ5GDH8UpdnBUdgQQSI7GDG8UZRmB0dhQwSJXhzEHk6I4OxV2otAL0aJk70Fwu3s38QcSHChfb0Fsro5NRnxRzMWEcFujRaLixBEL4EwxV3Gl9+NRkV5YMRiAmVxZJaLbdXfPHBGyAKFENvqDh6B4xU/QcLBISse3MMrHh7IJIEA+pPN6zmKKy800YPIoA0XeCg+RHi3wGb5R94pgLgbG5685LSdxcSduPP6RvF6et7/rIdboGgO1Z2CDWVa/bIdJYlPq6kVZ3XXYU14PXALfM3BvxfVPuf8Fj9MEwX8RwZ9YtDCBJbVb+sfghg2SK3qE/FO8RMI/5/Ux66SXyFc4kKOanDyVvZl0N+Rhh7RBMpHO+D3gc/KHyhKT0HVH3gwyYfY810gvO1YdwGYnByfFTswxbSfVogEu2mSh+Lz9oSxwVlq0IpagRzedsbiiT+CaY1TbQ3OoEPHbgXqwU3avwAAAP//5YElqgAAAAZJREFUAwAxdCqVQgOfxQAAAABJRU5ErkJggg=="/>
</defs>
</svg>';

$mapApiKey  = get_theme_mod('law_firm_map_api_key', '');
$mapLat     = get_theme_mod('law_firm_map_lat', '50.064650');
$mapLng     = get_theme_mod('law_firm_map_lng', '19.944980');
$mapZoom    = get_theme_mod('law_firm_map_zoom', 16);
$mapLabel   = get_theme_mod('law_firm_map_label', __('Kancelaria Adwokacka Paweł Noworolnik', 'your-textdomain'));
$mapAddress = get_theme_mod('law_firm_map_address', __('ul. Pawia 5, 31-154 Kraków', 'your-textdomain'));

get_header(); ?>

<?php the_content(); ?>

<?php
get_template_part(
  'template-parts/hero',
  null,
  [
    'bg_url'     => $bgUrl,
    'person_url' => $personUrl,
    'logo_svg'   => $logoSvg,
  ]
);

get_template_part('template-parts/about');
get_template_part('template-parts/experience');
echo do_shortcode('[team_section subtitle="NASZ ZESPÓŁ" title="Specjaliści w różnych dziedzinach prawa"]');
echo do_shortcode('[specializations_section subtitle="USŁUGI" title="Obszary naszych kompetencji" open_first="true"]');

get_template_part(
  'template-parts/location',
  null,
  [
    'map' => [
      'api_key' => $mapApiKey,
      'lat'     => $mapLat,
      'lng'     => $mapLng,
      'zoom'    => $mapZoom,
      'label'   => $mapLabel,
      'address' => $mapAddress,
    ],
  ]
);
?>

<?php get_footer(); ?>
