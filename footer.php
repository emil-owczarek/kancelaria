<?php
/**
 * Footer template
 */
?>
<footer class="bg-black text-white">
  <div class="mx-auto max-w-7xl px-6 py-16 grid gap-10 md:grid-cols-2">
    <!-- Lewa kolumna -->
    <div>
      <h2 class="text-3xl md:text-4xl font-semibold leading-tight">
        Jesteśmy do Twojej dyspozycji –<br class="hidden md:block" />
        skontaktuj się z nami!
      </h2>

      <!-- Social -->
      <div class="mt-8 flex items-center gap-4">
        <a href="https://facebook.com" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white" aria-label="Facebook" rel="noopener" target="_blank">
          <!-- Facebook SVG -->
          <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
            <path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07C2 17.09 5.66 21.23 10.44 22v-7.01H7.9v-2.92h2.54V9.83c0-2.5 1.49-3.88 3.77-3.88 1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56v1.87h2.78l-.44 2.92h-2.34V22C18.34 21.23 22 17.09 22 12.07z"/>
          </svg>
        </a>
        <a href="https://linkedin.com" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white" aria-label="LinkedIn" rel="noopener" target="_blank">
          <!-- LinkedIn SVG -->
          <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
            <path d="M6.94 6.5A2.44 2.44 0 1 1 6.93 1.6a2.44 2.44 0 0 1 0 4.9zM3.9 22.4h6.1V8.9H3.9v13.5ZM13.3 22.4h6.1v-7.5c0-4-4.3-3.7-5.1-1.8v-4.2H13.3v13.5Z"/>
          </svg>
        </a>
      </div>
    </div>

    <!-- Prawa kolumna -->
    <div class="space-y-5">
      <a href="tel:+48612213022" class="group flex items-center gap-3">
        <!-- phone -->
        <svg viewBox="0 0 24 24" class="h-5 w-5 text-white/80 group-hover:text-white" fill="currentColor" aria-hidden="true">
          <path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 .96-.26c1.05.26 2.18.4 3.32.4a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C12.3 21 3 11.7 3 1a1 1 0 0 1 1-1h3.68a1 1 0 0 1 1 1c0 1.14.14 2.27.4 3.32a1 1 0 0 1-.26.96l-2.2 2.2Z"/>
        </svg>
        <span class="text-lg">61 221 30 22</span>
      </a>

      <a href="mailto:biuro@noworolnik.com" class="group flex items-center gap-3">
        <!-- mail -->
        <svg viewBox="0 0 24 24" class="h-5 w-5 text-white/80 group-hover:text-white" fill="currentColor" aria-hidden="true">
          <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 4-8 5L4 8V6l8 5 8-5v2Z"/>
        </svg>
        <span class="text-lg">biuro@noworolnik.com</span>
      </a>

      <a href="https://maps.google.com/?q=ul.+Stanis%C5%82awa+Taczaka+23/2,+61-819+Pozna%C5%84" target="_blank" rel="noopener" class="group flex items-center gap-3">
        <!-- pin -->
        <svg viewBox="0 0 24 24" class="h-5 w-5 text-white/80 group-hover:text-white" fill="currentColor" aria-hidden="true">
          <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
        </svg>
        <span class="text-lg">ul. Stanisława Taczaka 23/2, 61-819 Poznań</span>
      </a>
    </div>
  </div>

  <div class="border-t border-white/10">
    <div class="mx-auto max-w-7xl px-6 py-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <p class="text-sm text-white/70">
        © <?php echo date('Y'); ?> Paweł Noworolnik. Wszelkie Prawa Zastrzeżone.
      </p>

      <!-- (opcjonalnie) menu w stopce -->
      <?php if (has_nav_menu('footer')): ?>
        <nav aria-label="Footer menu">
          <?php
            wp_nav_menu([
              'theme_location' => 'footer',
              'menu_class'     => 'flex flex-wrap gap-x-6 gap-y-2 text-sm text-white/80',
              'container'      => false,
              'depth'          => 1,
              'fallback_cb'    => false,
            ]);
          ?>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
