<?php
  // --- USTAWIENIA ---
  $bgUrl      = '/wp-content/themes/kancelaria/assets/hero-bg.jpg';      // pełnoekranowe tło (bez człowieka)
  $personUrl  = '/wp-content/themes/kancelaria/assets/person.webp';       // wycięta postać z przezroczystością
  $logoSvg    = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19V7l8-4 8 4v12M4 19h16M8 21h8"/></svg>';
?>

<?php
  $mapApiKey     = get_theme_mod('law_firm_map_api_key', '');
  $mapLat        = get_theme_mod('law_firm_map_lat', '50.064650');
  $mapLng        = get_theme_mod('law_firm_map_lng', '19.944980');
  $mapZoom       = get_theme_mod('law_firm_map_zoom', 16);
  $mapLabel      = get_theme_mod('law_firm_map_label', __('Kancelaria Adwokacka Paweł Noworolnik', 'your-textdomain'));
  $mapAddress    = get_theme_mod('law_firm_map_address', __('ul. Pawia 5, 31-154 Kraków', 'your-textdomain'));
  ?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kancelaria</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&display=swap" rel="stylesheet" />

  <!-- Tailwind via CDN (z produkcyjnym projektem możesz to usunąć i użyć swojego bundla) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // drobna konfiguracja pod gradient i font-weighty
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['ui-sans-serif', 'system-ui', 'Inter', 'Arial', 'sans-serif'] },
        }
      }
    }
  </script>
  <script>
    document.documentElement.classList.add('js');
  </script>
  <style>
    /* body {
      opacity: 0;
      transition: opacity 0.6s ease-in-out;
      will-change: opacity;
    }

    body.loaded {
      opacity: 1;
    } */
  </style>
  <?php wp_head(); ?>
</head>
<body class="bg-black text-white antialiased">
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
  <!-- HERO -->
  <section class="relative isolate overflow-hidden min-h-screen">
    <!-- TŁO -->
    <img
      src="<?= htmlspecialchars($bgUrl) ?>"
      alt=""
      class="absolute inset-0 -z-20 h-full w-full object-cover"
      loading="eager"
      fetchpriority="high"
    />

    <!-- PRZYCIEMNIENIE / GRADIENT -->
    <!-- <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#2a0000]/95 via-[#180000]/80 to-black/95"></div> -->

    <!-- NAV -->
    <header class="relative z-10">
      <div class="mx-auto max-w-7xl px-6 py-6">
        <div class="flex items-center justify-between gap-4">
          <!-- Logo -->
          <a href="/" class="inline-flex items-center gap-2 text-white/90 hover:text-white">
            <span class="inline-block"><?= $logoSvg ?></span>
            <span class="sr-only">Kancelaria</span>
          </a>

          <!-- Menu -->
          <nav class="hidden md:flex items-center gap-8 text-sm">
            <a href="#onas" class="text-white/80 hover:text-white transition">O nas</a>
            <a href="#zespol" class="text-white/80 hover:text-white transition">Nasz zespół</a>
            <a href="#uslugi" class="text-white/80 hover:text-white transition">Usługi</a>
          </nav>

          <!-- Akcje -->
          <div class="flex items-center gap-3">
            <a href="#kontakt"
               class="group inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur transition hover:bg-white/15 hover:border-white/30">
              <span>Kontakt</span>
              <span aria-hidden="true" class="transition-transform group-hover:translate-x-0.5">↗</span>
            </a>

            <!-- Język -->
            <button type="button"
                    class="hidden sm:inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-3 py-2 text-xs text-white/80 hover:bg-white/10">
              PL <span aria-hidden="true">▾</span>
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- TREŚĆ -->
    <div class="relative z-10 mx-auto grid min-h-[60vh] max-w-7xl grid-cols-12 items-center px-6 pt-4 md:pb-24 md:pt-10">
      <!-- LEWA kolumna: tekst -->
      <div class="col-span-12 md:col-span-7 lg:col-span-6">
      <p class="hero-subtext mb-4 text-lg italic text-white/70">
          <span class="mask-line pt-5" style="--delay: 1s;">Prawo, które rozumie biznes.</span>
        </p>
        <h1 class="text-4xl leading-tight font-semibold tracking-tight sm:text-5xl md:text-6xl">
          Twoi prawnicy<br />
          <span class="text-white/90">w&nbsp;świecie biznesu</span>
        </h1>

        <p class="mt-6 max-w-2xl text-base leading-relaxed text-white/80">
          Kancelaria Pawła Noworolnika oferuje kompleksową obsługę prawną firm i przedsiębiorców. Dzięki doświadczeniu
          i znajomości realiów rynkowych pomagamy naszym Klientom skutecznie poruszać się w złożonym świecie prawa gospodarczego.
        </p>

        <div class="mt-8 flex flex-wrap gap-3">
          <a href="#kontakt"
             class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-medium text-black hover:bg-white/90">
            Umów spotkanie <span aria-hidden="true">→</span>
          </a>
          <a href="#uslugi" class="inline-flex items-center gap-2 rounded-md border border-white/20 px-5 py-3 text-sm text-white/90 hover:bg-white/10">
            Zobacz usługi
          </a>
        </div>
      </div>

      <!-- PRAWA kolumna: osoba -->
      <div class="person-wrap absolute right-[10%] col-span-12 mt-10 md:col-span-5 md:mt-0 lg:col-span-6">
        <!-- Osoba jako osobny plik PNG/WebP -->
        <img
          src="<?= htmlspecialchars($personUrl) ?>"
          alt="Radca prawny – portret"
          class="person-img mx-auto md:ml-auto max-h-[700px] w-auto select-none pointer-events-none object-contain drop-shadow-[0_40px_80px_rgba(0,0,0,0.6)]"
          loading="eager"
          fetchpriority="high"
        />
      </div>
    </div>

    <!-- Delikatny gradient u dołu -->
    <!-- <div class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/40 to-transparent"></div> -->
  </section>

    <!-- SEKCA: Zaufanie i doświadczenie -->
    <section class="bg-neutral-50 text-neutral-900 section-rise" id="doswiadczenie">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:py-24">
      <div class="grid gap-12 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] lg:items-center">
        <figure class="relative isolate overflow-hidden bg-neutral-100 shadow-[0_40px_120px_rgba(18,18,18,0.18)] rise-child">
          <img
            src="/wp-content/themes/kancelaria/assets/group.jpg"
            alt="Zespół prawników kancelarii - profesjonaliści w dziedzinie prawa"
            class="h-full w-full object-cover"
            loading="lazy"
          />
        </figure>

        <div class="lg:pl-10 xl:pl-16 rise-child" style="--rise-delay: 0.4s;">
          <!-- <p class="text-sm font-semibold uppercase tracking-[0.4em] text-red-800">Zaufanie budowane latami</p>
          <h2 class="mt-4 text-4xl font-semibold leading-tight text-neutral-950 sm:text-5xl">
            Wspieramy przedsiębiorców w&nbsp;każdym etapie rozwoju
          </h2>
          <p class="mt-6 text-base leading-relaxed text-neutral-600 sm:text-lg">
            Od pierwszych kroków na rynku po złożone procesy fuzji i&nbsp;przejęć – prowadzimy naszych Klientów przez każdy etap rozwoju biznesu. Nasz zespół łączy doświadczenie, specjalistyczną wiedzę oraz partnerskie podejście.
          </p> -->

          <div class="mt-12 space-y-6">
            <div class="flex flex-col gap-2 border-l-4 border-red-700 pl-6">
              <span class="text-4xl font-semibold text-neutral-950">1200+</span>
              <span class="text-sm uppercase tracking-[0.2em] text-neutral-500">Zadowolonych klientów</span>
            </div>

            <div class="flex flex-col gap-2 border-l-4 border-red-700 pl-6">
              <span class="text-4xl font-semibold text-neutral-950">25+</span>
              <span class="text-sm uppercase tracking-[0.2em] text-neutral-500">Lat doświadczenia</span>
            </div>

            <div class="flex flex-col gap-2 border-l-4 border-red-700 pl-6">
              <span class="text-4xl font-semibold text-neutral-950">35</span>
              <span class="text-sm uppercase tracking-[0.2em] text-neutral-500">Nagród i wyróżnień</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

    <!-- O NAS -->
    <section id="onas" class="relative bg-neutral-100 text-neutral-900 section-rise">
    <div class="mx-auto max-w-7xl px-6 py-24">
      <div class="grid gap-16 lg:grid-cols-12 lg:items-center">
        <!-- Tekst główny -->
        <div class="lg:col-span-7 xl:col-span-6 rise-child">
          <p class="text-sm font-semibold tracking-[0.4em] text-red-900/80">O NAS</p>
          <h2 class="mt-6 text-4xl font-semibold leading-tight md:text-5xl">
            Kancelaria Adwokacka Pawła Noworolnika świadczy kompleksową pomoc prawną z najwyższą starannością i zaangażowaniem.
          </h2>
          <p class="mt-6 text-lg leading-relaxed text-neutral-600">
            Łączymy wiedzę, doświadczenie i indywidualne podejście, by skutecznie chronić interesy naszych Klientów. Działamy odpowiedzialnie, z pełnym zrozumieniem realiów prawnych i biznesowych.
          </p>
          <div class="mt-10">
            <a href="/o-nas" class="inline-flex items-center gap-3 rounded-full bg-neutral-900 px-6 py-3 text-sm font-medium tracking-wide text-white transition hover:bg-neutral-800">
              Więcej o nas
              <span aria-hidden="true" class="text-lg">→</span>
            </a>
          </div>
        </div>

        <!-- Karta misji -->
        <div class="relative lg:col-span-5 xl:col-span-5 rise-child" style="--rise-delay: 0.35s;">
          <div class="relative overflow-hidden rounded-3xl border border-neutral-200 bg-white p-10 shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
            <span class="pointer-events-none absolute -right-10 -top-10 text-[12rem] font-semibold leading-none text-neutral-100" aria-hidden="true">N</span>
            <div class="relative">
              <p class="text-sm font-semibold tracking-[0.4em] text-red-900/80">Nasza misja</p>
              <h3 class="mt-4 text-2xl font-semibold text-neutral-900">
                Naszą misją jest zapewnienie rzetelnej i skutecznej ochrony prawnej, opartej na zaufaniu, wiedzy i pełnym zaangażowaniu.
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php
echo do_shortcode('[team_section subtitle="NASZ ZESPÓŁ" title="Specjaliści w różnych dziedzinach prawa"]');
echo do_shortcode('[specializations_section subtitle="USŁUGI" title="Obszary naszych kompetencji" open_first="true"]');

?>

  
  <section id="lokalizacja" class="bg-white text-neutral-900 section-rise">
    <div class="mx-auto flex w-full max-w-7xl flex-col gap-10 px-6 py-20 lg:flex-row lg:items-start">
      <div class="w-full lg:w-2/5 rise-child">
        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-red-900">Nasza siedziba</p>
        <h2 class="mt-4 text-4xl font-semibold leading-tight text-neutral-900 md:text-5xl">Spotkania w centrum miasta</h2>
        <p class="mt-6 text-base leading-relaxed text-neutral-600">
          Zapraszamy do biura w sercu Krakowa. W Personalizacji motywu możesz wprowadzić dokładny adres, aby wyświetlić go poniżej.
        </p>
        <?php if (!empty($mapAddress)): ?>
          <div class="mt-8 rounded-2xl border border-neutral-200 bg-neutral-50 p-6 text-sm text-neutral-700 shadow-sm">
            <div class="font-medium text-neutral-900"><?php echo esc_html($mapLabel); ?></div>
            <div class="mt-2 leading-relaxed"><?php echo esc_html($mapAddress); ?></div>
            <div class="mt-4 flex items-center gap-2 text-xs uppercase tracking-[0.2em] text-neutral-500">
              <span class="inline-block h-px w-6 bg-neutral-300"></span>
              <span>Dojazd</span>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <div class="w-full lg:w-3/5 rise-child" style="--rise-delay: 0.45s;">
        <div class="relative aspect-[16/9] w-full overflow-hidden rounded-3xl border border-neutral-200 shadow-2xl shadow-neutral-900/10">
          <div
            data-law-map
            class="h-full w-full bg-neutral-200"
            data-api-key="<?php echo esc_attr($mapApiKey); ?>"
            data-lat="<?php echo esc_attr($mapLat); ?>"
            data-lng="<?php echo esc_attr($mapLng); ?>"
            data-zoom="<?php echo esc_attr($mapZoom); ?>"
            data-marker-title="<?php echo esc_attr($mapLabel); ?>"
          ></div>

          <?php if (empty($mapApiKey)): ?>
            <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 bg-neutral-900/80 p-6 text-center text-sm text-white">
              <span class="text-base font-semibold">Mapa będzie widoczna po dodaniu klucza API.</span>
              <p class="max-w-md text-white/80">
                Dodaj klucz Google Maps w panelu <strong>Wygląd → Personalizacja → Mapa kancelarii</strong>, a następnie uzupełnij współrzędne lokalizacji.
              </p>
              <?php if (current_user_can('manage_options')): ?>
                <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=law_firm_map_section')); ?>" class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-neutral-900">
                  Otwórz personalizację
                  <span aria-hidden="true">↗</span>
                </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<!-- 
  <script>
    window.addEventListener('load', function () {
      document.body.classList.add('loaded');
    });
  </script> -->

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var sections = document.querySelectorAll('.section-rise');
      if (!sections.length) return;

      var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      var supportsObserver = 'IntersectionObserver' in window;

      if (prefersReducedMotion || !supportsObserver) {
        sections.forEach(function (section) {
          section.classList.add('is-visible');
        });
        return;
      }

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
    });
  </script>

  <?php
  // --- SEKCA NASZ ZESPÓŁ ---
get_footer();
?>
