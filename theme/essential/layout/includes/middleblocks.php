<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */
?>

<div class="row-fluid" id="middle-blocks">
    <?php
    echo $OUTPUT->blocks('home-left', 'span4 pull-left');
    echo $OUTPUT->blocks('home-middle', 'span4 center');
    echo $OUTPUT->blocks('home-right', 'span4 pull-right');
    ?>
</div>