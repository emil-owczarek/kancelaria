<?php
  // --- USTAWIENIA ---
  $bgUrl      = '/wp-content/themes/kancelaria/assets/hero-bg.jpg';      // pełnoekranowe tło (bez człowieka)
//   $personUrl  = '/wp-content/themes/kancelaria/assets/person.png';       // wycięta postać z przezroczystością
  $logoSvg    = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19V7l8-4 8 4v12M4 19h16M8 21h8"/></svg>';
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kancelaria – Sekcja Hero</title>

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
  <?php wp_head(); ?>
</head>
<body class="bg-black text-white antialiased">
<style>
.not-splide ul {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
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
    <div class="relative z-10 mx-auto grid min-h-[60vh] max-w-7xl grid-cols-12 items-center px-6 pb-16 pt-4 md:pb-24 md:pt-10">
      <!-- LEWA kolumna: tekst -->
      <div class="col-span-12 md:col-span-7 lg:col-span-6">
        <p class="mb-4 text-lg italic text-white/70">Prawo, które rozumie biznes.</p>

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
      <div class="relative col-span-12 mt-10 md:col-span-5 md:mt-0 lg:col-span-6">
        <!-- Osoba jako osobny plik PNG/WebP -->
        <!-- <img
          src="<?= htmlspecialchars($personUrl) ?>"
          alt="Radca prawny – portret"
          class="mx-auto md:ml-auto md:mr-0 max-h-[72vh] w-auto select-none pointer-events-none object-contain drop-shadow-[0_40px_80px_rgba(0,0,0,0.6)]"
          loading="eager"
          fetchpriority="high"
        /> -->
      </div>
    </div>

    <!-- Delikatny gradient u dołu -->
    <!-- <div class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/40 to-transparent"></div> -->
  </section>
  <?php
// --- SEKCA NASZ ZESPÓŁ ---
echo do_shortcode('[team_section subtitle="NASZ ZESPÓŁ" title="Specjaliści w różnych dziedzinach prawa"]');

get_footer();
?>

