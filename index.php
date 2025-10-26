<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package Kancelaria
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<main class="bg-stone-100 text-neutral-900">
    <div class="mx-auto max-w-7xl px-6 py-16">
        <?php if (have_posts()) : ?>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="mb-4 overflow-hidden rounded-lg">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover transition-transform hover:scale-105']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h2 class="mb-3 text-xl font-semibold text-neutral-900">
                            <a href="<?php the_permalink(); ?>" class="hover:text-red-600 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        
                        <div class="mb-4 text-sm text-neutral-500">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </div>
                        
                        <div class="text-neutral-700">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <div class="mt-4">
                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-700 transition-colors">
                                <?php esc_html_e('Czytaj więcej', 'kancelaria'); ?>
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php
            // Paginacja
            the_posts_pagination([
                'prev_text' => __('← Poprzednia strona', 'kancelaria'),
                'next_text' => __('Następna strona →', 'kancelaria'),
                'class' => 'mt-12 flex justify-center'
            ]);
            ?>
            
        <?php else : ?>
            <div class="text-center py-16">
                <h1 class="mb-4 text-3xl font-semibold text-neutral-900">
                    <?php esc_html_e('Brak wpisów', 'kancelaria'); ?>
                </h1>
                <p class="text-neutral-600">
                    <?php esc_html_e('Nie znaleziono żadnych wpisów.', 'kancelaria'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
