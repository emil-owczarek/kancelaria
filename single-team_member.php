<?php
/**
 * Single Team Member template.
 *
 * Displays individual team members in a layout consistent with the front page.
 *
 * @package Kancelaria
 */

if (!defined('ABSPATH')) {
    exit;
}

// Prepare data once; loop rendered inline below.
$team_id = get_the_ID();
$portrait_field = get_field('team_portrait_vertical', $team_id);
$portrait_id = 0;

if (is_array($portrait_field)) {
    $portrait_id = isset($portrait_field['ID']) ? (int) $portrait_field['ID'] : (int) ($portrait_field['id'] ?? 0);
} elseif (!empty($portrait_field)) {
    $portrait_id = (int) $portrait_field;
}

if (!$portrait_id) {
    $portrait_id = get_post_thumbnail_id($team_id);
}

$portrait_html = $portrait_id
    ? wp_get_attachment_image(
        $portrait_id,
        'full',
        false,
        [
            'class'          => 'person-img mx-auto md:ml-auto select-none pointer-events-none object-contain max-h-[550px]',
            'loading'        => 'eager',
            'fetchpriority'  => 'high',
            'decoding'       => 'async',
            'aria-hidden'    => 'false',
        ]
    )
    : '';

$office_field = get_field('team_office_image', $team_id);
$office_id = 0;

if (is_array($office_field)) {
    $office_id = isset($office_field['ID']) ? (int) $office_field['ID'] : (int) ($office_field['id'] ?? 0);
} elseif (!empty($office_field)) {
    $office_id = (int) $office_field;
}

// Logo kancelarii
$logo_svg = '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="23.7288" height="25" fill="url(#pattern0_50_85)"/>
<defs>
<pattern id="pattern0_50_85" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_50_85" transform="scale(0.0178571 0.0169492)"/>
</pattern>
<image id="image0_50_85" width="56" height="59" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAA7CAYAAAAuEkmwAAACqklEQVR4AexaS1IbMRCVzMwExzlBUsk9WJBFqnIHcoSw5AQsOANs2cGaI8CGc0AVJ6AwjAeLlsCDGLVE61MzY5eoEsit7tfv9TPgKs2EbfhXkEDx8CT6XqE+BAkMbTZEXRY4xNRT9swOUqfJv37hqRa1JyUvO0iZ0phzsoNjdofCrXVQLMQudWHAohb/qfXOPMCJxdfrW4FsUV+Sl46w2jf1Mbne1UvirDD1nzLuqtPPtLp3gVpwk7ZZ4Lq76XZQTO7YcuvcWJhqsXVt5GG1n8UkDhVf8sNytZhbYFXs8W/Fv+7S6tstnxU73byg14DTgmobDJ8BPy0F3boFdkvW8HUWuIamfaCcHfwwjsAX4r45665AKO+yfhycPO+x7vKmGlbQj8AwbkmqssAkYxwQJDs44PCTtM4OJhnjgCDZwQGHn6R1djDJGAcEyQ5GDH8UpdnBUdgQQSI7GDG8UZRmB0dhQwSJXhzEHk6I4OxV2otAL0aJk70Fwu3s38QcSHChfb0Fsro5NRnxRzMWEcFujRaLixBEL4EwxV3Gl9+NRkV5YMRiAmVxZJaLbdXfPHBGyAKFENvqDh6B4xU/QcLBISse3MMrHh7IJIEA+pPN6zmKKy800YPIoA0XeCg+RHi3wGb5R94pgLgbG5685LSdxcSduPP6RvF6et7/rIdboGgO1Z2CDWVa/bIdJYlPq6kVZ3XXYU14PXALfM3BvxfVPuf8Fj9MEwX8RwZ9YtDCBJbVb+sfghg2SK3qE/FO8RMI/5/Ux66SXyFc4kKOanDyVvZl0N+Rhh7RBMpHO+D3gc/KHyhKT0HVH3gwyYfY810gvO1YdwGYnByfFTswxbSfVogEu2mSh+Lz9oSxwVlq0IpagRzedsbiiT+CaY1TbQ3OoEPHbgXqwU3avwAAAP//5YElqgAAAAZJREFUAwAxdCqVQgOfxQAAAABJRU5ErkJggg=="/>
</defs>
</svg>';


$office_url = $office_id ? wp_get_attachment_image_url($office_id, 'full') : get_theme_file_uri('assets/hero-bg.jpg');
$office_alt = $office_id ? get_post_meta($office_id, '_wp_attachment_image_alt', true) : '';

$position = trim((string) get_field('team_position', $team_id));
$practice_terms = get_the_terms($team_id, 'practice_area');
$practice_names = [];

if (!empty($practice_terms) && !is_wp_error($practice_terms)) {
    $practice_names = wp_list_pluck($practice_terms, 'name');
}

if (!$position && !empty($practice_names)) {
    $position = $practice_names[0];
}

$excerpt = get_the_excerpt();
if (!$excerpt) {
    $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 32, '…');
}

$contact_url = home_url('/kontakt');
$team_url = home_url('/#team');

get_header(); ?>

<?php if (have_posts()) : the_post(); ?>
  <section class="relative isolate overflow-hidden min-h-[80vh]">
    <?php if ($office_url): ?>
      <img
        src="<?php echo esc_url($office_url); ?>"
        alt="<?php echo esc_attr($office_alt ?: sprintf(__('Zdjęcie kancelarii – %s', 'kancelaria'), get_bloginfo('name'))); ?>"
        class="absolute inset-0 -z-20 h-full w-full object-cover"
        loading="lazy"
      />
      <div class="absolute inset-0 -z-10 bg-gradient-to-br from-black/80 via-black/70 to-black/40"></div>
    <?php endif; ?>

    <header class="relative z-20">
      <div class="mx-auto max-w-7xl px-6 pt-6">
        <div class="flex items-center justify-between gap-4">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 text-white/90 hover:text-white">
          <span class="inline-block"><?php echo $logo_svg; ?></span>
          <span class="sr-only"><?php esc_html_e('Kancelaria', 'kancelaria'); ?></span>
        </a>

          <nav class="hidden md:flex items-center gap-8 text-sm">
            <?php
            wp_nav_menu([
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'primary-menu flex items-center gap-8',
              'link_before'    => '',
              'link_after'     => '',
              'fallback_cb'    => '__return_empty_string',
            ]);
            ?>
          </nav>

          <div class="flex items-center gap-3">
            <a href="<?php echo esc_url($contact_url); ?>"
               class="group inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/15 hover:border-white/30">
              <span><?php esc_html_e('Kontakt', 'kancelaria'); ?></span>
              <span aria-hidden="true" class="transition-transform group-hover:translate-x-0.5">↗</span>
            </a>

            <?php if (function_exists('pll_the_languages')) : ?>
              <?php $languages = pll_the_languages(['raw' => 1]); ?>
              <?php $current_lang = function_exists('pll_current_language') ? pll_current_language() : ''; ?>
              <?php if (!empty($languages)) : ?>
                <div class="relative inline-block text-left">
                  <button type="button"
                          class="group inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/15 hover:border-white/30"
                          onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <?php echo esc_html(strtoupper($current_lang ?: array_key_first($languages))); ?>
                    <span aria-hidden="true">▾</span>
                  </button>

                  <div class="absolute right-0 mt-2 w-36 origin-top-right rounded-md bg-white/10 backdrop-blur border border-white/20 shadow-lg hidden z-10">
                    <ul class="py-1 text-sm text-white">
                      <?php foreach ($languages as $lang) : ?>
                        <li>
                          <a href="<?php echo esc_url($lang['url']); ?>"
                             class="block px-4 py-2 hover:bg-white/15 transition <?php echo $lang['current_lang'] ? 'opacity-60 cursor-default pointer-events-none' : ''; ?>">
                            <?php echo esc_html($lang['name']); ?>
                          </a>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </header>

    <div class="relative z-10 mx-auto flex max-w-7xl flex-col-reverse items-center gap-12 px-6 pb-16 pt-10 md:flex-row md:pb-24 md:pt-16">
      <div class="flex-1">
      <?php if ($position) : ?>
          <p class="mt-3 text-lg uppercase tracking-[0.4em] text-red-200/80"><?php echo esc_html($position); ?></p>
        <?php endif; ?>
        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-[#F5F5F5] sm:text-5xl md:text-6xl">
          <?php the_title(); ?>
        </h1>

        <?php if ($excerpt) : ?>
          <p class="mt-6 max-w-2xl text-base leading-relaxed text-white/85">
            <?php echo esc_html($excerpt); ?>
          </p>
        <?php endif; ?>

        <div class="mt-8 flex flex-wrap gap-3">
          <a href="<?php echo esc_url($contact_url); ?>"
             class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-medium text-black hover:bg-white/90">
            <?php esc_html_e('Umów konsultację', 'kancelaria'); ?>
            <span aria-hidden="true">→</span>
          </a>
          <a href="<?php echo esc_url($team_url); ?>"
             class="inline-flex items-center gap-2 rounded-md border border-white/20 px-5 py-3 text-sm text-white/90 hover:bg-white/10">
            <?php esc_html_e('Powrót do zespołu', 'kancelaria'); ?>
          </a>
        </div>
      </div>

      <div class="flex-1">
        <!-- <?php if ($portrait_html) : ?>
          <?php echo $portrait_html; ?>
        <?php endif; ?> -->
      </div>
    </div>
  </section>

  <main class="bg-stone-100 text-neutral-900">
    <section class="section-rise">
      <div class="mx-auto max-w-5xl px-6 py-20 grid gap-12 lg:grid-cols-[2fr,1fr] lg:items-start">
        <article class="prose prose-neutral prose-lg max-w-none text-neutral-800 rise-child prose-p:my-[15px]">
          <?php
          $content = get_the_content();
          if ($content) {
              echo apply_filters('the_content', $content);
          }
          ?>
        </article>

        <aside class="rise-child lg:sticky lg:top-24">
          <div class="rounded-3xl border border-neutral-200 bg-white p-8 shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
            <h2 class="text-sm font-semibold tracking-[0.4em] text-red-900/80 uppercase"><?php esc_html_e('Specjalizacje', 'kancelaria'); ?></h2>
            <ul class="mt-6 space-y-3 text-sm font-medium leading-relaxed text-neutral-600">
              <?php if (!empty($practice_names)) : ?>
                <?php foreach ($practice_names as $name) : ?>
                  <li class="flex items-start gap-3 items-center">
                    <span aria-hidden="true" class="mt-1 inline-block h-2 w-2 rounded-full bg-red-900/70"></span>
                    <span><?php echo esc_html($name); ?></span>
                  </li>
                <?php endforeach; ?>
              <?php else : ?>
                <li class="text-neutral-400"><?php esc_html_e('Specjalizacje zostaną wkrótce uzupełnione.', 'kancelaria'); ?></li>
              <?php endif; ?>
            </ul>

            <?php if ($position) : ?>
              <div class="mt-8 border-t border-neutral-200 pt-6 text-sm uppercase tracking-[0.4em] text-neutral-500">
                <?php echo esc_html($position); ?>
              </div>
            <?php endif; ?>
          </div>
        </aside>
      </div>
    </section>

    <?php if ($office_url) : ?>
      <section class="relative overflow-hidden bg-neutral-900 text-white">
        <div class="absolute inset-0 bg-neutral-900/40"></div>
        <figure class="relative mx-auto max-w-6xl px-6 py-16">
          <img
            src="<?php echo esc_url($office_url); ?>"
            alt="<?php echo esc_attr($office_alt ?: __('Siedziba kancelarii', 'kancelaria')); ?>"
            class="w-full rounded-3xl border border-white/10 object-cover shadow-[0_35px_120px_rgba(0,0,0,0.45)]"
            loading="lazy"
          />
          <figcaption class="mt-6 text-sm text-white/70">
            <?php esc_html_e('Kancelaria – zaufane miejsce spotkań z Klientami.', 'kancelaria'); ?>
          </figcaption>
        </figure>
      </section>
    <?php endif; ?>

    <section class="section-rise">
      <div class="mx-auto max-w-5xl px-6 py-16 text-center rise-child">
        <h2 class="text-3xl font-semibold text-neutral-900 md:text-4xl"><?php esc_html_e('Porozmawiajmy o Twojej sprawie', 'kancelaria'); ?></h2>
        <p class="mt-4 text-base text-neutral-600"><?php esc_html_e('Skontaktuj się z nami, aby umówić spotkanie lub konsultację z prawnikiem.', 'kancelaria'); ?></p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
          <a href="tel:+48612213022" class="inline-flex items-center gap-2 rounded-full bg-neutral-900 px-6 py-3 text-sm font-medium tracking-wide text-white transition hover:bg-neutral-800">
            <?php esc_html_e('Zadzwoń', 'kancelaria'); ?>
            <span aria-hidden="true">→</span>
          </a>
          <a href="mailto:biuro@noworolnik.com" class="inline-flex items-center gap-2 rounded-full border border-neutral-300 px-6 py-3 text-sm font-medium tracking-wide text-neutral-900 transition hover:border-neutral-400 hover:bg-white">
            <?php esc_html_e('Napisz', 'kancelaria'); ?>
          </a>
        </div>
      </div>
    </section>
  </main>

<?php endif; ?>

<?php get_footer(); ?>
