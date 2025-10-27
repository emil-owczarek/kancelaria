<?php
/**
 * Hero and navigation section.
 *
 * @var array $args
 */

$bg_url     = $args['bg_url'] ?? '';
$person_url = $args['person_url'] ?? '';
$logo_svg   = $args['logo_svg'] ?? '';
$content    = wp_parse_args(
  $args['content'] ?? [],
  [
    'tagline'         => __('Prawo, które rozumie biznes.', 'your-textdomain'),
    'title_line1'     => __('Twoi prawnicy', 'your-textdomain'),
    'title_line2'     => __('w świecie biznesu', 'your-textdomain'),
    'description'     => __('Kancelaria Pawła Noworolnika oferuje kompleksową obsługę prawną firm i przedsiębiorców. Dzięki doświadczeniu i znajomości realiów rynkowych pomagamy naszym Klientom skutecznie poruszać się w złożonym świecie prawa gospodarczego.', 'your-textdomain'),
    'primary_label'   => __('Umów spotkanie', 'your-textdomain'),
    'primary_url'     => '#kontakt',
    'secondary_label' => __('Zobacz usługi', 'your-textdomain'),
    'secondary_url'   => '#services',
    'nav'             => [
      'about'    => __('O nas', 'your-textdomain'),
      'team'     => __('Nasz zespół', 'your-textdomain'),
      'services' => __('Usługi', 'your-textdomain'),
    ],
    'contact_label'  => __('Kontakt', 'your-textdomain'),
    'language_label' => __('PL', 'your-textdomain'),
  ]
);

$content['nav'] = wp_parse_args(
  $content['nav'],
  [
    'about'    => __('O nas', 'your-textdomain'),
    'team'     => __('Nasz zespół', 'your-textdomain'),
    'services' => __('Usługi', 'your-textdomain'),
  ]
);
?>
<?php
$hero = get_field('hero_section');
?>
<style>
.not-splide ul {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem
}

.mask-line {
  display: inline-block;
  white-space: nowrap;
  overflow: hidden;
  padding-left: 10px;
  mask-image: linear-gradient(to right, black 100%, transparent 100%);
  mask-size: 0% 100%;
  mask-repeat: no-repeat;
  -webkit-mask-image: linear-gradient(to right, black 100%, transparent 100%);
  -webkit-mask-size: 0% 100%;
  -webkit-mask-repeat: no-repeat;
  animation: revealMask 2s ease-in forwards;
  animation-delay: var(--delay, 0s);
}

.hero-subtext {
  font-family: 'Tangerine', cursive;
  font-size: clamp(2.25rem, 4vw, 3.25rem);
  font-weight: 700;
  letter-spacing: 0.04em;
}

.hero-subtext .mask-line {
  padding-left: 0;
}

@keyframes revealMask {
  from {
    mask-size: 0% 100%;
    -webkit-mask-size: 0% 100%;
  }
  to {
    mask-size: 100% 100%;
    -webkit-mask-size: 100% 100%;
  }
}

@media (prefers-reduced-motion: reduce) {
  .mask-line {
    animation: none;
    mask-size: 100% 100%;
    -webkit-mask-size: 100% 100%;
  }
}

/* Style dla primary menu */
.primary-menu a {
  @apply text-white/80 hover:text-white transition;
}
</style>

<script>
  window.addEventListener('load', function () {
    document.body.classList.add('loaded');
  });
</script>

<section class="relative isolate overflow-hidden min-h-screen">
  <img
    src="<?php echo esc_url($bg_url); ?>"
    alt=""
    class="absolute inset-0 -z-20 h-full w-full object-cover"
    loading="eager"
    fetchpriority="high"
  />

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
          ]);
          ?>
        </nav>

        <div class="flex items-center gap-3">
          <a href="#kontakt"
             class="group inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/15 hover:border-white/30">
            <span><?php echo esc_html($content['contact_label']); ?></span>
            <span aria-hidden="true" class="transition-transform group-hover:translate-x-0.5">↗</span>
          </a>

          <?php 
$languages = pll_the_languages( array( 'raw' => 1 ) ); 
$current = pll_current_language();
?>

<div class="relative inline-block text-left">
  <button type="button"
          class="group inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/15 hover:border-white/30"
          onclick="this.nextElementSibling.classList.toggle('hidden')">
    <?php echo esc_html( strtoupper($current) ); ?>
    <span aria-hidden="true">▾</span>
  </button>

  <div class="absolute right-0 mt-2 w-36 origin-top-right rounded-md bg-white/10 backdrop-blur border border-white/20 shadow-lg hidden z-10">
    <ul class="py-1 text-sm text-white">
      <?php foreach ( $languages as $lang ) : ?>
        <li>
          <a href="<?php echo esc_url( $lang['url'] ); ?>"
             class="block px-4 py-2 hover:bg-white/15 transition <?php echo $lang['current_lang'] ? 'opacity-60 cursor-default pointer-events-none' : ''; ?>">
            <?php echo esc_html( $lang['name'] ); ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

        </div>
      </div>
    </div>
  </header>

  <div class="relative z-10 mx-auto flex min-h-[60vh] max-w-7xl flex-col-reverse lg:flex-row items-center px-6 pt-10">
    <div class="flex-1 order-2 lg:order-1">
      <p class="hero-subtext mb-4 text-lg italic text-white">
        <span class="mask-line pt-5 text-[2.5rem]" style="--delay: 1s;"><?php echo esc_html($hero['hero_claim']); ?></span>
      </p>
      <h1 class="text-4xl leading-tight font-semibold tracking-tight sm:text-5xl md:text-6xl text-[#C8C8C8]">
  <?php echo nl2br( esc_html( $hero['hero_heading'] ) ); ?>
</h1>


      <p class="mt-6 max-w-2xl text-base leading-relaxed text-white text-[#C8C8C8]">
      <?php echo nl2br( esc_html( $hero['hero_description'] ) ); ?>
      </p>

      <div class="mt-8 flex flex-wrap gap-3">
        <a href="<?php echo esc_url($content['primary_url'] ?: '#kontakt'); ?>"
           class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-medium text-black hover:bg-white/90">
          <?php echo esc_html($content['primary_label']); ?>
          <span aria-hidden="true">→</span>
        </a>
        <a href="<?php echo esc_url($content['secondary_url'] ?: '#uslugi'); ?>" class="inline-flex items-center gap-2 rounded-md border border-white/20 px-5 py-3 text-sm text-white/90 hover:bg-white/10">
          <?php echo esc_html($content['secondary_label']); ?>
        </a>
      </div>
    </div>

    <div class="person-wrap flex-1 mt-10 lg:mt-0 order-1 lg:order-2">
      <img
        src="<?php echo esc_url($person_url); ?>"
        alt="<?php esc_attr_e('Radca prawny – portret', 'kancelaria'); ?>"
        class="person-img mx-auto lg:ml-auto select-none pointer-events-none object-contain drop-shadow-[0_40px_80px_rgba(0,0,0,0.6)] max-h-[650px]"
        loading="eager"
        fetchpriority="high"
      />
    </div>
  </div>
</section>
