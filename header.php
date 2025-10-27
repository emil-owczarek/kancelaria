<?php
/**
 * Header template
 *
 * @package Kancelaria
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&display=swap" rel="stylesheet" />

  <?php if (is_front_page()) : ?>
  <link rel="preload" as="image" href="<?php echo esc_url(get_template_directory_uri() . '/assets/hero-bg.jpg'); ?>" fetchpriority="high" />
  <link rel="preload" as="image" href="<?php echo esc_url(get_template_directory_uri() . '/assets/person.webp'); ?>" type="image/webp" fetchpriority="high" />
  <?php endif; ?>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Helvetica Neue', 'Helvetica', 'ui-sans-serif', 'system-ui', 'Inter', 'Arial', 'sans-serif'],
            helvetica: ['Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif']
          },
        }
      }
    }
  </script>
  <script>
    document.documentElement.classList.add('js');
  </script>
  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-black text-white antialiased'); ?>>
<?php wp_body_open(); ?>
