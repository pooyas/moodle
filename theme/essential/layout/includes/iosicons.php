<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

if ($OUTPUT->get_setting('iphoneicon')) {
    $iphoneicon = $OUTPUT->get_setting('iphoneicon');
} else {
    $iphoneicon = $OUTPUT->pix_url('homeicon/iphone', 'theme');
}
if ($OUTPUT->get_setting('ipadicon')) {
    $ipadicon = $OUTPUT->get_setting('ipadicon');
} else {
    $ipadicon = $OUTPUT->pix_url('homeicon/ipad', 'theme');
}
if ($OUTPUT->get_setting('iphoneretinaicon')) {
    $iphoneretinaicon = $OUTPUT->get_setting('iphoneretinaicon');
} else {
    $iphoneretinaicon = $OUTPUT->pix_url('homeicon/iphone_retina', 'theme');
}
if ($OUTPUT->get_setting('ipadretinaicon')) {
    $ipadretinaicon = $OUTPUT->get_setting('ipadretinaicon');
} else {
    $ipadretinaicon = $OUTPUT->pix_url('homeicon/ipad_retina', 'theme');
}
?>

<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $iphoneicon ?>"/>
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ipadicon ?>"/>
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $iphoneretinaicon ?>"/>
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $ipadretinaicon ?>"/>