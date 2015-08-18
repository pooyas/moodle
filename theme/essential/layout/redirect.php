<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

echo $OUTPUT->doctype();
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>

<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>"/>
    <?php 
    echo $OUTPUT->get_csswww();
    echo $OUTPUT->standard_head_html();
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html(); ?>
<section role="main-content">
    <div id="page" class="container-fluid maintenance">

        <div id="page-content" class="row-fluid text-center">
            <section id="region-main" class="span12">
                <?php echo $OUTPUT->main_content(); ?>
                <i class="fa fa-refresh fa-spin fa-2x" style="margin-bottom: 10px;"></i>
            </section>
        </div>

    </div>
</section>
<?php echo $OUTPUT->standard_end_of_body_html(); ?>
</body>
</html>