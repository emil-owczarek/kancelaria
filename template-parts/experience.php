<?php
/**
 * Experience and trust section.
 */
?>

<section class="bg-stone-100 text-neutral-900 section-rise" id="doswiadczenie">
  <div class="mx-auto max-w-7xl px-6 py-20 lg:py-24">
    <div class="grid gap-12 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] lg:items-center">
      <figure class="relative isolate overflow-hidden bg-neutral-100 rise-child">
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/group.jpg'); ?>"
          alt="<?php esc_attr_e('Zespół prawników kancelarii - profesjonaliści w dziedzinie prawa', 'your-textdomain'); ?>"
          class="h-full w-full object-cover"
          loading="lazy"
        />
      </figure>

      <div class="lg:pl-10 xl:pl-16 rise-child" style="--rise-delay: 0.4s;">
        <div class="mt-12 space-y-6">
          <div class="flex flex-col gap-2 border-l-4 border-red-700 pl-6">
            <span class="text-4xl font-semibold text-neutral-950">1200+</span>
            <span class="text-sm uppercase tracking-[0.2em] text-neutral-500"><?php esc_html_e('Zadowolonych klientów', 'your-textdomain'); ?></span>
          </div>

          <div class="flex flex-col gap-2 border-l-4 border-red-700 pl-6">
            <span class="text-4xl font-semibold text-neutral-950">25+</span>
            <span class="text-sm uppercase tracking-[0.2em] text-neutral-500"><?php esc_html_e('Lat doświadczenia', 'your-textdomain'); ?></span>
          </div>

          <div class="flex flex-col gap-2 border-l-4 border-red-700 pl-6">
            <span class="text-4xl font-semibold text-neutral-950">35</span>
            <span class="text-sm uppercase tracking-[0.2em] text-neutral-500"><?php esc_html_e('Nagród i wyróżnień', 'your-textdomain'); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
