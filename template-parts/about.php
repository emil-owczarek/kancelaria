<?php
/**
 * About section.
 */
?>

<section id="onas" class="relative bg-stone-100 text-neutral-900 section-rise">
  <div class="mx-auto max-w-7xl px-6 py-24">
    <div class="grid gap-16 lg:grid-cols-12 lg:items-center">
      <div class="lg:col-span-7 xl:col-span-6 rise-child">
        <p class="text-sm font-semibold tracking-[0.4em] text-red-900/80"><?php esc_html_e('O NAS', 'your-textdomain'); ?></p>
        <h2 class="mt-6 text-lg leading-relaxed text-neutral-600">
          <?php esc_html_e('Kancelaria Adwokacka Pawła Noworolnika świadczy kompleksową pomoc prawną z najwyższą starannością i zaangażowaniem. Łączymy wiedzę, doświadczenie i indywidualne podejście, by skutecznie chronić interesy naszych Klientów. Działamy odpowiedzialnie, z pełnym zrozumieniem realiów prawnych i biznesowych.', 'your-textdomain'); ?>
        </h2>

        <div class="mt-10">
          <a href="<?php echo esc_url(home_url('/o-nas')); ?>" class="inline-flex items-center gap-3 rounded-full bg-neutral-900 px-6 py-3 text-sm font-medium tracking-wide text-white transition hover:bg-neutral-800">
            <?php esc_html_e('Więcej o nas', 'your-textdomain'); ?>
            <span aria-hidden="true" class="text-lg">→</span>
          </a>
        </div>
      </div>

      <div class="relative lg:col-span-5 xl:col-span-5 rise-child" style="--rise-delay: 0.35s;">
        <div class="relative overflow-hidden rounded-3xl border border-neutral-200 bg-white p-10 shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
          <span class="pointer-events-none absolute -right-10 -top-10 text-[12rem] font-semibold leading-none text-neutral-100" aria-hidden="true">N</span>
          <div class="relative">
            <p class="text-sm font-semibold tracking-[0.4em] text-red-900/80"><?php esc_html_e('Nasza misja', 'your-textdomain'); ?></p>
            <h3 class="mt-4 text-2xl font-semibold text-neutral-900">
              <?php esc_html_e('Naszą misją jest zapewnienie rzetelnej i skutecznej ochrony prawnej, opartej na zaufaniu, wiedzy i pełnym zaangażowaniu.', 'your-textdomain'); ?>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
