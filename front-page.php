<?php
  // --- USTAWIENIA ---
  $bgUrl      = '/wp-content/themes/kancelaria/assets/hero-bg.jpg';
  $personUrl  = '/wp-content/themes/kancelaria/assets/person.webp';
  $logoSvg    = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19V7l8-4 8 4v12M4 19h16M8 21h8"/></svg>';

  $mapApiKey  = get_theme_mod('law_firm_map_api_key', '');
  $mapLat     = get_theme_mod('law_firm_map_lat', '50.064650');
  $mapLng     = get_theme_mod('law_firm_map_lng', '19.944980');
  $mapZoom    = get_theme_mod('law_firm_map_zoom', 16);
  $mapLabel   = get_theme_mod('law_firm_map_label', __('Kancelaria Adwokacka Paweł Noworolnik', 'your-textdomain'));
  $mapAddress = get_theme_mod('law_firm_map_address', __('ul. Pawia 5, 31-154 Kraków', 'your-textdomain'));
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kancelaria</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['ui-sans-serif', 'system-ui', 'Inter', 'Arial', 'sans-serif'] },
        }
      }
    }
  </script>
  <script>
    document.documentElement.classList.add('js');
  </script>
  <?php wp_head(); ?>
</head>
<body class="bg-black text-white antialiased">
  <?php    the_content() ?>
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var sections = document.querySelectorAll('.section-rise');
      if (!sections.length) return;

      var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      var supportsObserver = 'IntersectionObserver' in window;

      if (prefersReducedMotion || !supportsObserver) {
        sections.forEach(function (section) {
          section.classList.add('is-visible');
        });
        return;
      }

      var observer = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target);
          }
        });
      }, { threshold: 0.2 });

      sections.forEach(function (section) {
        observer.observe(section);
      });
    });
  </script>

  <?php get_footer(); ?>
