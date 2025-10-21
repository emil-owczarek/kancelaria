<?php
?>

<main id="primary" class="site-main">
    <div class="container">
        <h1>Witaj w Kancelarii Prawnej Pawła Noworolnika</h1>
        <p>Profesjonalne usługi prawne na najwyższym poziomie.</p>
        
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_content();
                        ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <p>Brak treści do wyświetlenia.</p>
            <?php
        endif;
        ?>
    </div>
</main>

