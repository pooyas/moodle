<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

$numberofslides = theme_essential_showslider();

if ($numberofslides) {
    $slideinterval  = $OUTPUT->get_setting('slideinterval');
    $captionscenter = ($OUTPUT->get_setting('slidecaptioncentred'))? ' centred' : '';
    $captionoptions = $OUTPUT->get_setting('slidecaptionoptions');
    $captionsbelowclass  = ($captionoptions == 2) ? ' below' : '';
    ?>
    <div class="row-fluid">
        <div class="span12">
            <div id="essentialCarousel" class="carousel slide" data-interval="<?php echo $slideinterval;?>">
                <?php echo $OUTPUT->essential_edit_button('theme_essential_slideshow');?>
                <ol class="carousel-indicators">
                    <?php
                    for ($indicatorslideindex = 0; $indicatorslideindex < $numberofslides; $indicatorslideindex++) {
                        echo '<li data-target="#essentialCarousel" data-slide-to="'.$indicatorslideindex.'"';
                        if ($indicatorslideindex == 0) {
                            echo 'class="active"';
                        }
                        echo '></li>';
                    }
                    ?>
                </ol>
                <div class="carousel-inner<?php echo $captionscenter.$captionsbelowclass;?>">
                    <?php for ($slideindex = 1; $slideindex <= $numberofslides; $slideindex++) {
                        echo $OUTPUT->render_slide($slideindex, $captionoptions);
                    } ?>
                </div>
                <?php echo $OUTPUT->render_slide_controls($left); ?>
            </div>
        </div>
    </div>
<?php } ?>