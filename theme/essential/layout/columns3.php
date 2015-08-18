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
    <div id="page-navbar" class="clearfix row-fluid">
        <div
            class="breadcrumb-nav pull-<?php echo ($left) ? 'left' : 'right'; ?>"><?php echo $OUTPUT->navbar(); ?></div>
        <nav
            class="breadcrumb-button pull-<?php echo ($left) ? 'right' : 'left'; ?>"><?php echo $OUTPUT->page_heading_button(); ?></nav>
    </div>
    <section role="main-content">
        <!-- Start Main Regions -->
        <div id="page-content" class="row-fluid">
            <div id="<?php echo $regionbsid ?>" class="span9">
                <div class="row-fluid">
                    <?php if (!$left) { ?>
                    <section id="region-main" class="span8 pull-right">
                        <?php } else { ?>
                        <section id="region-main" class="span8 desktop-first-column">
                            <?php } ?>
                            <?php if ($COURSE->id > 1) {
                                echo $OUTPUT->heading(format_string($COURSE->fullname), 1, 'coursetitle');
                                echo '<div class="bor"></div>';
                            } ?>
                            <?php echo $OUTPUT->course_content_header(); ?>
                            <?php echo $OUTPUT->main_content(); ?>
                            <?php if (empty($PAGE->layout_options['nocoursefooter'])) {
                                echo $OUTPUT->course_content_footer();
                            }?>
                        </section>
                        <?php if (!$left) { ?>
                            <?php echo $OUTPUT->blocks('side-pre', 'span4 desktop-first-column'); ?>
                        <?php } else { ?>
                            <?php echo $OUTPUT->blocks('side-pre', 'span4 pull-right'); ?>
                        <?php } ?>
                </div>
            </div>
            <?php echo $OUTPUT->blocks('side-post', 'span3'); ?>
        </div>
        <!-- End Main Regions -->
    </section>
</div>

<?php require_once($OUTPUT->get_include_file('footer')); ?>
</body>
</html>
