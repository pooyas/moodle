<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

require_once($OUTPUT->get_include_file('header'));
?>

<div id="page" class="container-fluid">
    <section role="main-content">
        <!-- Start Main Regions -->
        <div id="page-content" class="row-fluid">
            <section id="region-main" class="span12">
                <?php
                echo $OUTPUT->course_content_header();
                echo $OUTPUT->main_content();
                echo $OUTPUT->course_content_footer();
                ?>
            </section>
        </div>
        <!-- End Main Regions -->
    </section>
</div>

<?php require_once($OUTPUT->get_include_file('footer')); ?>
</body>
</html>
