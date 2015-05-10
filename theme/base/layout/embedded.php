<?php

/**
 * The embedded layout for the base theme.
 *
 * @package   theme
 * @subpackage base
 * @copyright 2015 Pooya Saeedi
 * 
 */

echo $OUTPUT->doctype(); ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

<!-- END OF HEADER -->

    <div id="page-content" class="clearfix">
        <?php echo $OUTPUT->main_content() ?>
    </div>

<!-- START OF FOOTER -->
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>