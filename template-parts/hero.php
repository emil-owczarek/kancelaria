<?php
/**
 * Hero and navigation section.
 *
 * @var array $args
 */

$bg_url     = $args['bg_url'] ?? '';
$person_url = $args['person_url'] ?? '';
$logo_svg   = $args['logo_svg'] ?? '';
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
    <div class="mx-auto max-w-7xl px-6 py-6">
      <div class="flex items-center justify-between gap-4">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 text-white/90 hover:text-white">
          <span class="inline-block"><?php echo $logo_svg; ?></span>
          <span class="sr-only"><?php esc_html_e('Kancelaria', 'kancelaria'); ?></span>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm">
          <a href="#onas" class="text-white/80 hover:text-white transition"><?php esc_html_e('O nas', 'kancelaria'); ?></a>
          <a href="#zespol" class="text-white/80 hover:text-white transition"><?php esc_html_e('Nasz zespół', 'kancelaria'); ?></a>
          <a href="#uslugi" class="text-white/80 hover:text-white transition"><?php esc_html_e('Usługi', 'kancelaria'); ?></a>
        </nav>

        <div class="flex items-center gap-3">
          <a href="#kontakt"
             class="group inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/15 hover:border-white/30">
            <span><?php esc_html_e('Kontakt', 'kancelaria'); ?></span>
            <span aria-hidden="true" class="transition-transform group-hover:translate-x-0.5">↗</span>
          </a>

          <button type="button"
                  class="group inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/15 hover:border-white/30">
            <?php esc_html_e('PL', 'kancelaria'); ?>
            <span aria-hidden="true">▾</span>
          </button>
        </div>
      </div>
    </div>
  </header>

  <div class="relative z-10 mx-auto grid min-h-[60vh] max-w-7xl grid-cols-12 items-center px-6 pt-4 md:pb-24 md:pt-10">
    <div class="col-span-12 md:col-span-7 lg:col-span-6">
      <p class="hero-subtext mb-4 text-lg italic text-white/70">
        <span class="mask-line pt-5" style="--delay: 1s;"><?php esc_html_e('Prawo, które rozumie biznes.', 'kancelaria'); ?></span>
      </p>
      <h1 class="text-4xl leading-tight font-semibold tracking-tight sm:text-5xl md:text-6xl">
        <?php esc_html_e('Twoi prawnicy', 'kancelaria'); ?><br />
        <span class="text-white/90"><?php echo wp_kses_post(__('w&nbsp;świecie biznesu', 'kancelaria')); ?></span>
      </h1>

      <p class="mt-6 max-w-2xl text-base leading-relaxed text-white/80">
        <?php esc_html_e('Kancelaria Pawła Noworolnika oferuje kompleksową obsługę prawną firm i przedsiębiorców. Dzięki doświadczeniu i znajomości realiów rynkowych pomagamy naszym Klientom skutecznie poruszać się w złożonym świecie prawa gospodarczego.', 'kancelaria'); ?>
      </p>

      <div class="mt-8 flex flex-wrap gap-3">
        <a href="#kontakt"
           class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-medium text-black hover:bg-white/90">
          <?php esc_html_e('Umów spotkanie', 'kancelaria'); ?>
          <span aria-hidden="true">→</span>
        </a>
        <a href="#uslugi" class="inline-flex items-center gap-2 rounded-md border border-white/20 px-5 py-3 text-sm text-white/90 hover:bg-white/10">
          <?php esc_html_e('Zobacz usługi', 'kancelaria'); ?>
        </a>
      </div>
    </div>

    <div class="person-wrap absolute right-[10%] col-span-12 mt-10 md:col-span-5 md:mt-0 lg:col-span-6">
      <img
        src="<?php echo esc_url($person_url); ?>"
        alt="<?php esc_attr_e('Radca prawny – portret', 'kancelaria'); ?>"
        class="person-img mx-auto md:ml-auto max-h-[700px] w-auto select-none pointer-events-none object-contain drop-shadow-[0_40px_80px_rgba(0,0,0,0.6)]"
        loading="eager"
        fetchpriority="high"
      />
    </div>
  </div>
</section>
