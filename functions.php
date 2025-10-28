<?php
/**
 * ===== TEAM (CPT + TAX) =====
 */
add_action('init', function () {
  // CPT: Pracownik
  register_post_type('team_member', [
    'labels' => [
      'name'          => __('Pracownicy', 'your-textdomain'),
      'singular_name' => __('Pracownik', 'your-textdomain'),
      'add_new_item'  => __('Dodaj pracownika', 'your-textdomain'),
      'edit_item'     => __('Edytuj pracownika', 'your-textdomain'),
    ],
    'public'       => true,
    'menu_icon'    => 'dashicons-id',
    'supports'     => ['title', 'editor', 'excerpt', 'thumbnail'],
    'has_archive'  => false,
    'rewrite'      => ['slug' => 'zespol', 'with_front' => false],
    'supports'     => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
  ]);

  // Taksonomia: Specjalizacja / dziedzina prawa
  register_taxonomy('practice_area', ['team_member'], [
    'labels' => [
      'name'          => __('Specjalizacje', 'your-textdomain'),
      'singular_name' => __('Specjalizacja', 'your-textdomain'),
    ],
    'public'       => true,
    'hierarchical' => false,
    'rewrite'      => ['slug' => 'specjalizacja'],
    'show_in_rest' => true,
  ]);

  // CPT: Specjalizacje (obszary kompetencji)
  register_post_type('specialization', [
    'labels' => [
      'name'          => __('Specjalizacje', 'your-textdomain'),
      'singular_name' => __('Specjalizacja', 'your-textdomain'),
      'add_new_item'  => __('Dodaj specjalizację', 'your-textdomain'),
      'edit_item'     => __('Edytuj specjalizację', 'your-textdomain'),
    ],
    'public'       => true,
    'menu_icon'    => 'dashicons-lightbulb',
    'supports'     => ['title', 'editor', 'excerpt', 'page-attributes'],
    'has_archive'  => false,
    'rewrite'      => ['slug' => 'specjalizacje'],
    'show_in_rest' => true,
  ]);
});

// Rozmiar zdjęcia do kart
add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails');
  add_image_size('team-card', 768, 960, true); // przycięcie do portretu
});

// Rejestracja menu nawigacyjnych
add_action('after_setup_theme', function() {
  register_nav_menus([
    'primary'   => __('Główne menu', 'your-textdomain'),
    'footer'    => __('Menu w stopce', 'your-textdomain'),
  ]);
});

/**
 * ===== Enqueue Tailwind (jeśli kompilujesz sam — pomiń) + Splide =====
 * Jeśli Tailwind już masz w motywie, zostaw tylko Splide.
 */
add_action('wp_enqueue_scripts', function () {
  // Główny CSS motywu
  wp_enqueue_style(
    'kancelaria-style',
    get_stylesheet_uri(),
    [],
    '1.0.0'
  );

  // Splide (slider)
  wp_enqueue_style(
    'splide',
    'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css',
    [],
    '4.1.4'
  );
  wp_enqueue_script(
    'splide',
    'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js',
    [],
    '4.1.4',
    true
  );

  // Nasz init JS
  wp_add_inline_script('splide', <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-team-splide]').forEach(function (el) {
    var slides = el.querySelectorAll('.splide__slide').length;
    var enableSlider = parseInt(el.getAttribute('data-min')) || 2; // włącz gdy >4
    if (slides >= enableSlider) {
      new Splide(el, {
        type: 'slide',
        perPage: 4,
        gap: '2rem',
        arrows: true,
        pagination: false,
        
        breakpoints: {
          1280: { perPage: 3, gap: '1.5rem' },
          1024: { perPage: 2, gap: '1.25rem' },
          640: { perPage: 1, gap: '1rem' }
        }
      }).mount();
    } else {
      // jeśli brak slidera – usuń wrappery Splide, zostaw responsywną siatkę
      el.classList.add('not-splide');
      var track = el.querySelector('.splide__track');
      var list = el.querySelector('.splide__list');
      if (track && list) {
        track.replaceWith(list);
        list.classList.remove('splide__list');
      }
    }
  });

  

  document.querySelectorAll('[data-accordion]').forEach(function (wrapper) {
    var openFirstAttr = wrapper.getAttribute('data-open-first');
    var singleAttr = wrapper.getAttribute('data-accordion-single');
    var shouldOpenFirst = openFirstAttr !== 'false';
    var allowMultiple = singleAttr === 'false';
    var items = wrapper.querySelectorAll('[data-accordion-item]');

    items.forEach(function (item, index) {
      var button = item.querySelector('[data-accordion-trigger]');
      var content = item.querySelector('[data-accordion-content]');
      if (!button || !content) {
        return;
      }

      var startOpen = shouldOpenFirst && index === 0;
      button.setAttribute('aria-expanded', startOpen ? 'true' : 'false');
      item.classList.toggle('is-open', startOpen);
      // content.classList.toggle('hidden', !startOpen);

      button.addEventListener('click', function () {
        var isExpanded = button.getAttribute('aria-expanded') === 'true';
        var willOpen = !isExpanded;

        if (!allowMultiple && willOpen) {
          items.forEach(function (otherItem) {
            if (otherItem === item) {
              return;
            }
            var otherButton = otherItem.querySelector('[data-accordion-trigger]');
            var otherContent = otherItem.querySelector('[data-accordion-content]');
            if (!otherButton || !otherContent) {
              return;
            }
            otherButton.setAttribute('aria-expanded', 'false');
            otherItem.classList.remove('is-open');
            // otherContent.classList.add('hidden');
          });
        }

        button.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        item.classList.toggle('is-open', willOpen);
        // content.classList.toggle('hidden', !willOpen);
      });
    });
  });

  // Efekt rise tylko raz na sesj
  var sections = document.querySelectorAll('.section-rise');
  if (sections.length) {
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var supportsObserver = 'IntersectionObserver' in window;
    var hasSeenAnimations = sessionStorage.getItem('rise-animations-seen');

    if (prefersReducedMotion || !supportsObserver) {
      // Jeśli już widział animacje w tej sesji, pokaż od razu
      sections.forEach(function (section) {
        section.classList.add('is-visible');
      });
    } else {
      // Pierwszy raz w sesji - pokaż animacje
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

      // Oznacz że już widział animacje w tej sesji
      sessionStorage.setItem('rise-animations-seen', 'true');
    }
  }
});
JS
  );
});

/**
 * ===== Customizer: mapa kancelarii =====
 */
function law_firm_sanitize_float($value)
{
  return is_numeric($value) ? $value : '';
}

function law_firm_sanitize_zoom($value)
{
  $value = intval($value);
  if ($value < 1 || $value > 20) {
    $value = 16;
  }

  return $value;
}

add_action('customize_register', function ($wp_customize) {
  $wp_customize->add_section('law_firm_map_section', [
    'title'       => __('Mapa kancelarii', 'your-textdomain'),
    'description' => __('Skonfiguruj wyświetlanie mapy z lokalizacją biura.', 'your-textdomain'),
    'priority'    => 160,
  ]);

  $wp_customize->add_setting('law_firm_map_api_key', [
    'type'              => 'theme_mod',
    'sanitize_callback' => 'sanitize_text_field',
  ]);

  $wp_customize->add_control('law_firm_map_api_key', [
    'label'       => __('Klucz API Google Maps', 'your-textdomain'),
    'section'     => 'law_firm_map_section',
    'settings'    => 'law_firm_map_api_key',
    'type'        => 'text',
    'description' => __('Wprowadź klucz API z Google Cloud Console (Maps JavaScript API).', 'your-textdomain'),
  ]);

  $wp_customize->add_setting('law_firm_map_lat', [
    'type'              => 'theme_mod',
    'default'           => '50.064650',
    'sanitize_callback' => 'law_firm_sanitize_float',
  ]);

  $wp_customize->add_control('law_firm_map_lat', [
    'label'    => __('Szerokość geograficzna', 'your-textdomain'),
    'section'  => 'law_firm_map_section',
    'settings' => 'law_firm_map_lat',
    'type'     => 'number',
    'input_attrs' => [
      'step' => '0.000001',
    ],
  ]);

  $wp_customize->add_setting('law_firm_map_lng', [
    'type'              => 'theme_mod',
    'default'           => '19.944980',
    'sanitize_callback' => 'law_firm_sanitize_float',
  ]);

  $wp_customize->add_control('law_firm_map_lng', [
    'label'    => __('Długość geograficzna', 'your-textdomain'),
    'section'  => 'law_firm_map_section',
    'settings' => 'law_firm_map_lng',
    'type'     => 'number',
    'input_attrs' => [
      'step' => '0.000001',
    ],
  ]);

  $wp_customize->add_setting('law_firm_map_zoom', [
    'type'              => 'theme_mod',
    'default'           => 16,
    'sanitize_callback' => 'law_firm_sanitize_zoom',
  ]);

  $wp_customize->add_control('law_firm_map_zoom', [
    'label'       => __('Powiększenie mapy (1–20)', 'your-textdomain'),
    'section'     => 'law_firm_map_section',
    'settings'    => 'law_firm_map_zoom',
    'type'        => 'number',
    'input_attrs' => [
      'min'  => 1,
      'max'  => 20,
      'step' => 1,
    ],
  ]);

  $wp_customize->add_setting('law_firm_map_label', [
    'type'              => 'theme_mod',
    'default'           => __('Kancelaria Adwokacka Paweł Noworolnik', 'your-textdomain'),
    'sanitize_callback' => 'sanitize_text_field',
  ]);

  $wp_customize->add_control('law_firm_map_label', [
    'label'    => __('Podpis pinezki', 'your-textdomain'),
    'section'  => 'law_firm_map_section',
    'settings' => 'law_firm_map_label',
    'type'     => 'text',
  ]);

  $wp_customize->add_setting('law_firm_map_address', [
    'type'              => 'theme_mod',
    'default'           => __('ul. Pawia 5, 31-154 Kraków', 'your-textdomain'),
    'sanitize_callback' => 'sanitize_text_field',
  ]);

  $wp_customize->add_control('law_firm_map_address', [
    'label'    => __('Adres wyświetlany obok mapy', 'your-textdomain'),
    'section'  => 'law_firm_map_section',
    'settings' => 'law_firm_map_address',
    'type'     => 'text',
  ]);
});

add_action('wp_footer', function () {
  if (!is_front_page() && !is_home()) {
    return;
  }

  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var mapContainer = document.querySelector('[data-law-map]');
      if (!mapContainer) {
        return;
      }

      var apiKey = mapContainer.dataset.apiKey;
      if (!apiKey) {
        return;
      }

      var lat = parseFloat(mapContainer.dataset.lat);
      var lng = parseFloat(mapContainer.dataset.lng);
      var zoom = parseInt(mapContainer.dataset.zoom || '16', 10);
      var markerTitle = mapContainer.dataset.markerTitle || '';

      function initLawFirmMap() {
        if (typeof google === 'undefined' || !google.maps) {
          return;
        }

        var position = { lat: lat, lng: lng };
        var defaultMapStyle = [
          { elementType: 'geometry', stylers: [{ color: '#cacaca' }] },
          { elementType: 'labels.icon', stylers: [{ visibility: 'off' }] },
          { elementType: 'labels.text.fill', stylers: [{ color: '#333333' }] },
          { elementType: 'labels.text.stroke', stylers: [{ color: '#f1f1f1' }] },
          {
            featureType: 'administrative',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#4b4b4b' }]
          },
          {
            featureType: 'administrative.land_parcel',
            elementType: 'labels',
            stylers: [{ visibility: 'off' }]
          },
          {
            featureType: 'poi',
            elementType: 'geometry.fill',
            stylers: [{ color: '#b2b2b2' }]
          },
          {
            featureType: 'poi',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#4d4d4d' }]
          },
          {
            featureType: 'poi.park',
            elementType: 'geometry',
            stylers: [{ color: '#aaaaaa' }]
          },
          {
            featureType: 'poi.park',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#3f3f3f' }]
          },
          {
            featureType: 'road',
            elementType: 'geometry.fill',
            stylers: [{ color: '#ffffff' }]
          },
          {
            featureType: 'road.arterial',
            elementType: 'geometry',
            stylers: [{ color: '#f7f7f7' }]
          },
          {
            featureType: 'road.arterial',
            elementType: 'geometry.stroke',
            stylers: [{ color: '#bfbfbf' }]
          },
          {
            featureType: 'road.highway',
            elementType: 'geometry',
            stylers: [{ color: '#ffffff' }]
          },
          {
            featureType: 'road.highway',
            elementType: 'geometry.stroke',
            stylers: [{ color: '#b1b1b1' }]
          },
          {
            featureType: 'road',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#404040' }]
          },
          {
            featureType: 'transit',
            stylers: [{ visibility: 'off' }]
          },
          {
            featureType: 'water',
            elementType: 'geometry',
            stylers: [{ color: '#a8afb5' }]
          },
          {
            featureType: 'water',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#424242' }]
          }
        ];

        var mapStyle = defaultMapStyle;
        if (mapContainer.dataset.mapStyle) {
          try {
            mapStyle = JSON.parse(mapContainer.dataset.mapStyle);
          } catch (error) {
            mapStyle = defaultMapStyle;
          }
        }

        var map = new google.maps.Map(mapContainer, {
          center: position,
          zoom: zoom,
          styles: mapStyle,
          disableDefaultUI: true,
          zoomControl: true,
        });

        new google.maps.Marker({
          position: position,
          map: map,
          title: markerTitle,
        });
      }

      window.lawFirmInitMap = initLawFirmMap;

      if (typeof google !== 'undefined' && google.maps) {
        initLawFirmMap();
        return;
      }

      var script = document.createElement('script');
      script.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(apiKey) + '&callback=lawFirmInitMap';
      script.async = true;
      script.defer = true;
      document.head.appendChild(script);
    });
  </script>
  <?php
});

/**
 * ===== Shortcode [team_section] =====
 * Atrybuty: title, subtitle
 */
add_shortcode('team_section', function ($atts) {
  $atts = shortcode_atts([
    'title'    => 'Specjaliści w różnych dziedzinach prawa',
    'subtitle' => 'Nasz zespół',
    'count'    => -1,
  ], $atts);

  $q = new WP_Query([
    'post_type'      => 'team_member',
    'posts_per_page' => intval($atts['count']),
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
  ]);

  if (!$q->have_posts()) {
    // Debug: sprawdź czy są posty
    return '<!-- Team section: Brak postów team_member -->';
  }

  ob_start();
  $total = $q->found_posts;
  ?>

  

  <section id='team' class="bg-stone-100 section-rise splide" data-team-splide data-min="2">
    <div class="mx-auto max-w-7xl px-6 py-16">
      <div class="mb-10 rise-child">
        <div class="text-sm tracking-widest text-red-800 font-semibold"><?php echo esc_html($atts['subtitle']); ?></div>
        <div class='flex items-center justify-between'>
        <h2 class="mt-2 text-4xl md:text-5xl font-semibold leading-tight text-neutral-900">
          <?php echo esc_html($atts['title']); ?>
        </h2>
        <div class="splide__arrows md:mt-0 mt-6 flex gap-4 justify-end">
          <button class="splide__arrow splide__arrow--prev !static !translate-x-0 inline-flex h-10 w-10 items-center justify-center">
            <span class="sr-only">Poprzedni</span>
            <svg width="25" height="14" viewBox="0 0 25 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.2926 0.292893C17.6831 -0.0976311 18.3162 -0.0976311 18.7068 0.292893L24.7068 6.29289C25.0973 6.68342 25.0973 7.31658 24.7068 7.70711L18.7068 13.7071C18.3162 14.0976 17.6831 14.0976 17.2926 13.7071C16.902 13.3166 16.902 12.6834 17.2926 12.2929L21.5855 8H0C-0.000125676 7.5 0 7.55228 0 7C0 6.44772 -5.58562e-05 6.5 0 6H21.5855L17.2926 1.70711C16.902 1.31658 16.902 0.683417 17.2926 0.292893Z" fill="#700505"/>
</svg>
          </button>
          <button class="splide__arrow splide__arrow--next !static !translate-x-0 inline-flex h-10 w-10 items-center justify-center">
            <span class="sr-only">Następny</span>
            <svg width="25" height="14" viewBox="0 0 25 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.2926 0.292893C17.6831 -0.0976311 18.3162 -0.0976311 18.7068 0.292893L24.7068 6.29289C25.0973 6.68342 25.0973 7.31658 24.7068 7.70711L18.7068 13.7071C18.3162 14.0976 17.6831 14.0976 17.2926 13.7071C16.902 13.3166 16.902 12.6834 17.2926 12.2929L21.5855 8H0C-0.000125676 7.5 0 7.55228 0 7C0 6.44772 -5.58562e-05 6.5 0 6H21.5855L17.2926 1.70711C16.902 1.31658 16.902 0.683417 17.2926 0.292893Z" fill="#700505"/>
</svg>
          </button>
        </div>
</div>
        <div class="mt-6 border-t border-neutral-300"></div>
      </div>

      <div class="rise-child" style="--rise-delay: 0.35s;">
        <div class="splide__track">
          <ul class="splide__list">
            <?php
            $index = 0;
            while ($q->have_posts()) { $q->the_post();
              $id   = get_the_ID();
              $img  = get_the_post_thumbnail($id, 'team-card', ['class' => 'w-full h-auto object-cover']);
              $name = get_the_title();
              $spec = '';
              
              // Pobierz pozycję z pola team_position
              $position = trim((string) get_field('team_position', $id));
              if ($position) {
                $spec = $position;
              } else {
                // Fallback na taksonomię jeśli brak pola team_position
                $terms = get_the_terms($id, 'practice_area');
                if ($terms && !is_wp_error($terms)) $spec = $terms[0]->name;
              }

              // opis na hover: excerpt lub fragment treści
              $desc = get_the_excerpt();
              if (!$desc) $desc = wp_trim_words( wp_strip_all_tags(get_the_content()), 35);
              $delay = 0.45 + ($index * 0.05);
              ?>
              <li class="splide__slide rise-child" style="--rise-delay: <?php echo esc_attr(number_format($delay, 2)); ?>s;">
                <article class="group">
                  <div class="relative aspect-[4/4.7] overflow-hidden bg-neutral-200">
                    <?php if ($img) { echo $img; } ?>
                    <!-- Overlay gradient + opis (hover) -->
                    <a href="<?php the_permalink(); ?>"
                       class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 focus:opacity-100 outline-none">
                      <div class="absolute inset-0 bg-gradient-to-b from-[#7b0f14]/90 via-[#5b0b0e]/85 to-black/90"></div>
                      <div class="absolute inset-0 p-8 flex flex-col justify-end text-white">
                        <p class="text-sm md:text-base leading-relaxed max-w-[34ch]">
                          <?php echo esc_html($desc); ?>
                        </p>
                        <span class="mt-6 inline-flex items-center gap-2 text-sm">
                          Czytaj dalej
                          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.172 12 8.586 7.414 10 6l6 6-6 6-1.414-1.414L13.172 12z"/></svg>
                        </span>
                      </div>
                    </a>
                  </div>

                  <!-- Podpis pod zdjęciem -->
                  <div class="mt-4">
                    <h3 class="text-lg md:text-xl font-medium text-neutral-900">
                      <a href="<?php the_permalink(); ?>" class="hover:underline"><?php echo esc_html($name); ?></a>
                    </h3>
                    <?php if ($spec): ?>
                      <div class="text-neutral-500"> <?php echo esc_html($spec); ?> </div>
                    <?php endif; ?>
                  </div>
                </article>
              </li>
              <?php
              $index++;
            }
            wp_reset_postdata();
            ?>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <?php
  return ob_get_clean();
});

/**
 * ===== Meta box dla ikony specjalizacji =====
 */
add_action('add_meta_boxes', function () {
  add_meta_box(
    'specialization_icon',
    __('Ikona specjalizacji', 'your-textdomain'),
    function ($post) {
      wp_nonce_field('save_specialization_icon', 'specialization_icon_nonce');
      $value = get_post_meta($post->ID, '_specialization_icon', true);
      ?>
      <p><?php esc_html_e('Wklej SVG, emoji lub krótki HTML wyświetlany w nagłówku akordeonu.', 'your-textdomain'); ?></p>
      <textarea name="specialization_icon" class="widefat" rows="4"><?php echo esc_textarea($value); ?></textarea>
      <?php
    },
    'specialization',
    'side'
  );
});

add_action('save_post_specialization', function ($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!isset($_POST['specialization_icon_nonce']) || !wp_verify_nonce($_POST['specialization_icon_nonce'], 'save_specialization_icon')) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (isset($_POST['specialization_icon'])) {
    $icon = wp_kses_post(wp_unslash($_POST['specialization_icon']));
    if ($icon) {
      update_post_meta($post_id, '_specialization_icon', $icon);
    } else {
      delete_post_meta($post_id, '_specialization_icon');
    }
  }
});

/**
 * ===== Shortcode [specializations_section] =====
 */
add_shortcode('specializations_section', function ($atts) {
  $atts = shortcode_atts([
    'title'       => __('Obszary naszych kompetencji', 'your-textdomain'),
    'subtitle'    => __('Usługi', 'your-textdomain'),
    'description' => '',
    'open_first'  => 'true',
    'count'       => -1,
  ], $atts);

  $query = new WP_Query([
    'post_type'      => 'specialization',
    'posts_per_page' => intval($atts['count']),
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
  ]);

  if (!$query->have_posts()) {
    // Debug: sprawdź czy są posty
    return '<!-- Specializations section: Brak postów specialization -->';
  }

  $open_first = true;
  if (isset($atts['open_first'])) {
    $value = filter_var($atts['open_first'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    if ($value !== null) {
      $open_first = $value;
    }
  }

  ob_start();
  ?>
  <section id="services" class="bg-stone-100 py-20 md:py-24 section-rise">
    <div class="mx-auto max-w-7xl px-6">
      <div class="grid gap-12 md:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] md:items-start">
        <div class="max-w-xl rise-child">
          <div class="text-sm font-semibold uppercase tracking-[0.35em] text-red-800"><?php echo esc_html($atts['subtitle']); ?></div>
          <h2 class="mt-4 text-4xl font-semibold leading-tight text-neutral-900 md:text-5xl"><?php echo esc_html($atts['title']); ?></h2>
          <?php if (!empty($atts['description'])) : ?>
            <p class="mt-6 text-base leading-relaxed text-neutral-600"><?php echo wp_kses_post($atts['description']); ?></p>
          <?php endif; ?>
          
          <!-- Zdjęcie services.jpg pod tytułem -->
          <div class="mt-8">
            <img 
              src="<?php echo get_template_directory_uri(); ?>/assets/services.jpg" 
              alt="<?php esc_attr_e('Obszary naszych kompetencji', 'your-textdomain'); ?>"
              class="w-full h-auto rounded-lg shadow-lg object-cover"
              loading="lazy"
            />
          </div>
        </div>

        <div class="rise-child" data-accordion data-open-first="<?php echo $open_first ? 'true' : 'false'; ?>" data-accordion-single="true" style="--rise-delay: 0.35s;">
          <?php
          $item_index = 0;
          while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();
            $icon_meta = get_post_meta($id, '_specialization_icon', true);
            $icon_html = '';

            if (function_exists('get_field')) {
              $icon_field = get_field('svg_icon', $id);

              if (!empty($icon_field)) {
                $icon_url = '';
                $icon_alt = '';

                if (is_array($icon_field)) {
                  $icon_url = $icon_field['url'] ?? '';
                  $icon_alt = $icon_field['alt'] ?? ($icon_field['title'] ?? '');
                } elseif (is_numeric($icon_field)) {
                  $icon_id  = (int) $icon_field;
                  $icon_url = wp_get_attachment_url($icon_id);
                  $icon_alt = get_post_meta($icon_id, '_wp_attachment_image_alt', true);
                } elseif (is_string($icon_field)) {
                  $icon_url = $icon_field;
                }

                if (!empty($icon_url)) {
                  if (empty($icon_alt)) {
                    $icon_alt = get_the_title($id);
                  }

                  $icon_html = sprintf(
                    '<img src="%s" alt="%s" class="h-7 w-7 object-contain" loading="lazy" decoding="async" />',
                    esc_url($icon_url),
                    esc_attr($icon_alt)
                  );
                }
              }
            }

            if (empty($icon_html) && !empty($icon_meta)) {
              $icon_html = wp_kses_post($icon_meta);
            }

            $excerpt = has_excerpt() ? get_the_excerpt() : '';
            $content = apply_filters('the_content', get_the_content());
            $content = wp_kses_post($content);
            $content_id = 'spec-content-' . $id;
            $item_delay = 0.45 + ($item_index * 0.05);
            ?>
            <div class="border-b border-black/40 rise-child" data-accordion-item style="--rise-delay: <?php echo esc_attr(number_format($item_delay, 2)); ?>s;">
              <button type="button" class="flex w-full items-center justify-between gap-6 px-6 py-5 text-left" data-accordion-trigger aria-expanded="false" aria-controls="<?php echo esc_attr($content_id); ?>">
                <span class="flex flex-1 items-start gap-4 items-center">
                  <span class="flex h-12 w-12 shrink-0 items-center text-red-700">
                    <?php
                    if (!empty($icon_html)) {
                      echo $icon_html; // already escaped above
                    } else {
                      ?>
                      <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                      <?php
                    }
                    ?>
                  </span>
                  <span class="flex-1">
                    <span class="block text-lg font-medium text-neutral-900 md:text-xl"><?php the_title(); ?></span>
                    <?php if (!empty($excerpt)) : ?>
                      <span class="mt-1 block text-sm text-neutral-500"><?php echo esc_html($excerpt); ?></span>
                    <?php endif; ?>
                  </span>
                </span>
                <span class="relative flex h-10 w-10 shrink-0 items-center justify-center text-neutral-900" data-accordion-icon>
                  <span class="accordion-line accordion-line--horizontal"></span>
                  <span class="accordion-line accordion-line--vertical"></span>
                </span>
              </button>
              <div id="<?php echo esc_attr($content_id); ?>" class="" data-accordion-content>
                <div class="prose prose-neutral max-w-none text-neutral-600">
                  <?php echo $content; ?>
                </div>
              </div>
            </div>
            <?php
            $item_index++;
          }
          wp_reset_postdata();
          ?>
        </div>
      </div>
    </div>
  </section>
  <?php
  return ob_get_clean();
});

/**
 * ===== Ułatwienia w edycji: kolumna taksonomii w WP-Admin =====
 */
add_filter('manage_team_member_posts_columns', function($cols){
  $cols['practice_area'] = __('Specjalizacje','your-textdomain');
  return $cols;
});
add_action('manage_team_member_posts_custom_column', function($col, $post_id){
  if ($col === 'practice_area') {
    $terms = get_the_terms($post_id, 'practice_area');
    if ($terms && !is_wp_error($terms)) {
      echo esc_html(implode(', ', wp_list_pluck($terms, 'name')));
    } else {
      echo '—';
    }
  }
}, 10, 2);
