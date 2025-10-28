<?php
/**
 * Location/map section.
 *
 * @var array $args
 */

$map = wp_parse_args(
  $args['map'] ?? [],
  [
    'api_key' => '',
    'lat'     => '50.064650',
    'lng'     => '19.944980',
    'zoom'    => 16,
    'label'   => __('Kancelaria Adwokacka Paweł Noworolnik', 'your-textdomain'),
    'address' => __('ul. Pawia 5, 31-154 Kraków', 'your-textdomain'),
  ]
);

$copy = wp_parse_args(
  $args['copy'] ?? [],
  [
    'eyebrow'     => __('Nasza siedziba', 'your-textdomain'),
    'heading'     => __('Spotkania w centrum miasta', 'your-textdomain'),
    'description' => __('Zapraszamy do biura w sercu Poznania. W Personalizacji motywu możesz wprowadzić dokładny adres, aby wyświetlić go poniżej.', 'your-textdomain'),
    'access_label'=> __('Dojazd', 'your-textdomain'),
  ]
);
?>

<section id="kontakt" class="bg-stone-100 text-neutral-900 section-rise">
  <div class="mx-auto flex w-full max-w-7xl flex-col gap-10 px-6 py-20 lg:flex-row lg:items-start">
    <div class="w-full lg:w-2/5 rise-child">
      <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-900"><?php echo esc_html($copy['eyebrow']); ?></p>
      <h2 class="mt-4 text-4xl font-semibold leading-tight text-neutral-900 md:text-5xl"><?php echo wp_kses_post($copy['heading']); ?></h2>
      <p class="mt-6 text-base leading-relaxed text-neutral-600">
        <?php echo wp_kses_post($copy['description']); ?>
      </p>
      <?php if (!empty($map['address'])) : ?>
        <div class="mt-8 rounded-2xl border border-neutral-200 bg-neutral-50 p-6 text-sm text-neutral-700 shadow-sm location-card">
          <div class="font-medium text-neutral-900"><?php echo esc_html($map['label']); ?></div>
          <div class="mt-2 leading-relaxed"><?php echo esc_html($map['address']); ?></div>
          <div class="mt-4 flex items-center gap-2 text-xs uppercase tracking-[0.2em] text-neutral-500">
            <span class="inline-block h-px w-6 bg-neutral-300"></span>
            <a href="https://maps.app.goo.gl/Ge9v22YxFKydCBWU6" target="_blank" rel="noopener noreferrer" class="text-red-700 hover:text-red-800 transition-colors">
              <?php echo esc_html($copy['access_label']); ?>
            </a>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="w-full lg:w-3/5 rise-child" style="--rise-delay: 0.45s;">
      <div class="relative aspect-[16/9] w-full overflow-hidden rounded-3xl border border-neutral-200 shadow-2xl shadow-neutral-900/10 location-map-wrapper">
        <div
          data-law-map
          class="h-full w-full bg-neutral-200 law-map-canvas"
          data-api-key="<?php echo esc_attr($map['api_key']); ?>"
          data-lat="<?php echo esc_attr($map['lat']); ?>"
          data-lng="<?php echo esc_attr($map['lng']); ?>"
          data-zoom="<?php echo esc_attr($map['zoom']); ?>"
          data-marker-title="<?php echo esc_attr($map['label']); ?>"
        ></div>

        <?php if (empty($map['api_key'])) : ?>
          <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 bg-neutral-900/80 p-6 text-center text-sm text-white">
            <span class="text-base font-semibold"><?php esc_html_e('Mapa będzie widoczna po dodaniu klucza API.', 'your-textdomain'); ?></span>
            <p class="max-w-md text-white/80">
              <?php esc_html_e('Dodaj klucz Google Maps w panelu Wygląd → Personalizacja → Mapa kancelarii, a następnie uzupełnij współrzędne lokalizacji.', 'your-textdomain'); ?>
            </p>
            <?php if (current_user_can('manage_options')) : ?>
              <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=law_firm_map_section')); ?>" class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-neutral-900">
                <?php esc_html_e('Otwórz personalizację', 'your-textdomain'); ?>
                <span aria-hidden="true">↗</span>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
