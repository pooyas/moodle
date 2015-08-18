<?php


/**
 * Essentials is a basic child theme of Essential to help you as a theme
 * developer create your own child theme of Essential.
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

require_once($OUTPUT->get_include_file('header'));
?>
<div id="page" class="container-fluid">

    <section role="main-content">
        <div id="page-content" class="row-fluid">
            <section id="<?php echo $regionbsid; ?>">
                <section id="region-main" class="span9 desktop-first-column">
                <?php
                    echo $OUTPUT->course_content_header();
                    echo '<h1 class="frontpagetitle">'.get_string('frontpagetitle', 'theme_essentials').'</h1>';
                    echo '<p class="frontpagedetails">'.get_string('frontpagedetails', 'theme_essentials').'</p>';
                    echo $OUTPUT->main_content();
                    echo $OUTPUT->course_content_footer();
                    ?>
                </section>
                <?php
                    echo $OUTPUT->blocks('side-pre', 'span3 pull-right');
                ?>
            </section>
        </div>
    </section>
</div>

<?php 
require_once($OUTPUT->get_include_file('footer'));
?>
</body>
</html>
