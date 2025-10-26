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
          <div class="flex flex-col gap-2 border-b-2 border-red-700 pb-6">
            <span class="text-4xl font-semibold text-neutral-950">
              <span data-counter data-counter-target="1200" data-counter-duration="1800">0</span><span aria-hidden="true">+</span>
            </span>
            <span class="text-sm uppercase tracking-[0.2em] text-neutral-500"><?php esc_html_e('Zadowolonych klientów', 'your-textdomain'); ?></span>
          </div>

          <div class="flex flex-col gap-2 border-b-2 border-red-700 pb-6">
            <span class="text-4xl font-semibold text-neutral-950">
              <span data-counter data-counter-target="25" data-counter-duration="1400">0</span><span aria-hidden="true">+</span>
            </span>
            <span class="text-sm uppercase tracking-[0.2em] text-neutral-500"><?php esc_html_e('Lat doświadczenia', 'your-textdomain'); ?></span>
          </div>

          <div class="flex flex-col gap-2 border-b-2 border-red-700 pb-6">
            <span class="text-4xl font-semibold text-neutral-950">
              <span data-counter data-counter-target="35" data-counter-duration="1200">0</span>
            </span>
            <span class="text-sm uppercase tracking-[0.2em] text-neutral-500"><?php esc_html_e('Nagród i wyróżnień', 'your-textdomain'); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
      counters.forEach(function (counter) {
        counter.textContent = counter.dataset.counterTarget || '0';
      });
      return;
    }

    var animateCounter = function (counter) {
      var started = counter.dataset.counterStarted;
      if (started) return;
      counter.dataset.counterStarted = 'true';

      var target = parseInt(counter.dataset.counterTarget || '0', 10);
      var duration = parseInt(counter.dataset.counterDuration || '1500', 10);
      var startTime = null;

      var tick = function (timestamp) {
        if (!startTime) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / duration, 1);
        var value = Math.floor(progress * target);
        counter.textContent = value.toLocaleString('pl-PL');
        if (progress < 1) {
          requestAnimationFrame(tick);
        } else {
          counter.textContent = target.toLocaleString('pl-PL');
        }
      };

      requestAnimationFrame(tick);
    };

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });

    counters.forEach(function (counter) {
      observer.observe(counter);
    });
  });
</script>
