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
    'rewrite'      => ['slug' => 'zespol'],
    'show_in_rest' => true, // edycja w Gutenbergu
    'supports' => ['title','editor','excerpt','thumbnail','page-attributes'],
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
});

// Rozmiar zdjęcia do kart
add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails');
  add_image_size('team-card', 768, 960, true); // przycięcie do portretu
});

/**
 * ===== Enqueue Tailwind (jeśli kompilujesz sam — pomiń) + Splide =====
 * Jeśli Tailwind już masz w motywie, zostaw tylko Splide.
 */
add_action('wp_enqueue_scripts', function () {
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
  wp_add_inline_script('splide', "
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('[data-team-splide]').forEach(function(el){
        var slides = el.querySelectorAll('.splide__slide').length;
        var enableSlider = parseInt(el.getAttribute('data-min')) || 2; // włącz gdy >4
        if (slides >= enableSlider) {
          new Splide(el, {
            type      : 'slide',
            perPage   : 4,
            gap       : '2rem',
            arrows    : true,
            pagination: false,
            breakpoints: {
              1280: { perPage: 3, gap: '1.5rem' },
              1024: { perPage: 2, gap: '1.25rem' },
              640 : { perPage: 1, gap: '1rem' }
            }
          }).mount();
        } else {
          // jeśli brak slidera – usuń wrappery Splide, zostaw responsywną siatkę
          el.classList.add('not-splide');
          var track = el.querySelector('.splide__track');
          var list  = el.querySelector('.splide__list');
          if (track && list) { track.replaceWith(list); list.classList.remove('splide__list'); }
        }
      });
    });
  ");
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

  if (!$q->have_posts()) return '';

  ob_start();
  $total = $q->found_posts;
  ?>

  <section class="bg-neutral-50">
    <div class="mx-auto max-w-7xl px-6 py-16">
      <div class="mb-10">
        <div class="text-sm tracking-widest text-red-800 font-semibold"><?php echo esc_html($atts['subtitle']); ?></div>
        <h2 class="mt-2 text-4xl md:text-5xl font-semibold leading-tight text-neutral-900">
          <?php echo esc_html($atts['title']); ?>
        </h2>
        <div class="mt-6 border-t border-neutral-300"></div>
      </div>

      <div class="splide" data-team-splide data-min="2">
        <div class="splide__track">
          <ul class="splide__list">
            <?php
            while ($q->have_posts()) { $q->the_post();
              $id   = get_the_ID();
              $img  = get_the_post_thumbnail($id, 'team-card', ['class' => 'w-full h-auto object-cover']);
              $name = get_the_title();
              $spec = '';
              $terms = get_the_terms($id, 'practice_area');
              if ($terms && !is_wp_error($terms)) $spec = $terms[0]->name;

              // opis na hover: excerpt lub fragment treści
              $desc = get_the_excerpt();
              if (!$desc) $desc = wp_trim_words( wp_strip_all_tags(get_the_content()), 35);
              ?>
              <li class="splide__slide">
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
            }
            wp_reset_postdata();
            ?>
          </ul>
        </div>

        <!-- Strzałki (Splide tworzy domyślne, ale daj własne – pokazywane tylko gdy slider aktywny) -->
        <div class="splide__arrows md:mt-0 mt-6 flex gap-4 justify-end">
          <button class="splide__arrow splide__arrow--prev !static !translate-x-0 inline-flex h-10 w-10 items-center justify-center rounded-full border border-neutral-300 hover:border-neutral-500">
            <span class="sr-only">Poprzedni</span>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="m10 12 5-5-1.41-1.41L7.17 12l6.42 6.41L15 17z"/></svg>
          </button>
          <button class="splide__arrow splide__arrow--next !static !translate-x-0 inline-flex h-10 w-10 items-center justify-center rounded-full border border-neutral-300 hover:border-neutral-500">
            <span class="sr-only">Następny</span>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="m14 12-5 5 1.41 1.41L16.83 12l-6.42-6.41L9 7z"/></svg>
          </button>
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
