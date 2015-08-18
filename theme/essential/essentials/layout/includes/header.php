<?php


/**
 * Essentials is a basic child theme of Essential to help you as a theme
 * developer create your own child theme of Essential.
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

require_once($OUTPUT->get_include_file('pagesettings'));

$breadcrumbstyle = 2;

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?> class="no-js">
<!-- Essentials Header -->
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>"/>
    <?php echo $OUTPUT->get_csswww(); ?>
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google web fonts -->
    <?php require_once($OUTPUT->get_include_file('fonts')); ?>
</head>

<body <?php echo $OUTPUT->body_attributes($bodyclasses); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner">
    <div id="page-header" class="clearfix<?php echo ($oldnavbar) ? ' oldnavbar' : ''; ?>">
        <div class="container-fluid">
            <div class="row-fluid">
                <!-- HEADER: LOGO AREA -->
                <div class="<?php echo $logoclass;
                echo (!$left) ? ' pull-right' : ' pull-left'; ?>">
                    <?php if (!$haslogo) { ?>
                        <a class="textlogo" href="<?php echo preg_replace("(https?:)", "", $CFG->wwwroot); ?>">
                            <i id="headerlogo" class="fa fa-<?php echo $OUTPUT->get_setting('siteicon'); ?>"></i>
                            <?php echo $OUTPUT->get_title('header'); ?>
                        </a>
                    <?php } else { ?>
                        <a class="logo" href="<?php echo preg_replace("(https?:)", "", $CFG->wwwroot); ?>" title="<?php print_string('home'); ?>"></a>
                    <?php } ?>
                </div>
                <?php if ($hassocialnetworks || $hasmobileapps) { ?>
                <a class="btn btn-icon" data-toggle="collapse" data-target=".icon-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="icon-collapse collapse pull-<?php echo ($left) ? 'right' : 'left'; ?>">
                    <?php
                    }
                    // If true, displays the heading and available social links; displays nothing if false.
                    if ($hassocialnetworks) {
                        ?>
                        <div class="pull-<?php echo ($left) ? 'right' : 'left'; ?>" id="socialnetworks">
                            <p id="socialheading"><?php echo get_string('socialnetworks', 'theme_essential') ?></p>
                            <ul class="socials unstyled">
                                <?php
                                echo $OUTPUT->render_social_network('googleplus');
                                echo $OUTPUT->render_social_network('twitter');
                                echo $OUTPUT->render_social_network('facebook');
                                echo $OUTPUT->render_social_network('linkedin');
                                echo $OUTPUT->render_social_network('youtube');
                                echo $OUTPUT->render_social_network('flickr');
                                echo $OUTPUT->render_social_network('pinterest');
                                echo $OUTPUT->render_social_network('instagram');
                                echo $OUTPUT->render_social_network('vk');
                                echo $OUTPUT->render_social_network('skype');
                                echo $OUTPUT->render_social_network('website');
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    // If true, displays the heading and available social links; displays nothing if false.
                    if ($hasmobileapps) {
                        ?>
                        <div class="pull-<?php echo ($left) ? 'right' : 'left'; ?>" id="mobileapps">
                            <p id="socialheading"><?php echo get_string('mobileappsheading', 'theme_essential') ?></p>
                            <ul class="socials unstyled">
                                <?php
                                echo $OUTPUT->render_social_network('ios');
                                echo $OUTPUT->render_social_network('android');
                                echo $OUTPUT->render_social_network('winphone');
                                echo $OUTPUT->render_social_network('windows');
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    if ($hassocialnetworks || $hasmobileapps) {
                    ?>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
    <nav role="navigation">
        <div id='essentialnavbar' class="navbar<?php echo ($oldnavbar) ? ' oldnavbar' : ''; ?> lion-has-zindex">
            <div class="container-fluid navbar-inner">
                <div class="row-fluid">
                    <div class="custommenus pull-<?php echo ($left) ? 'left' : 'right'; ?>">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <?php echo $OUTPUT->get_title('navbar'); ?>
                    <div class="pull-<?php echo ($left) ? 'right' : 'left'; ?>">
                        <div class="usermenu">
                            <?php echo $OUTPUT->custom_menu_user(); ?>
                        </div>
                        <div class="messagemenu">
                            <?php echo $OUTPUT->custom_menu_messages(); ?>
                        </div>
                        <div class="gotobottommenu">
                            <?php echo $OUTPUT->custom_menu_goto_bottom(); ?>
                        </div>
                    </div>
                        <div class="nav-collapse collapse pull-<?php echo ($left) ? 'left' : 'right'; ?>">
                            <div id="custom_menu_language">
                                <?php echo $OUTPUT->custom_menu_language(); ?>
                            </div>
                            <div id="custom_menu_courses">
                                <?php echo $OUTPUT->custom_menu_courses(); ?>
                            </div>
                            <?php if ($colourswitcher) { ?>
                                <div id="custom_menu_themecolours">
                                    <?php echo $OUTPUT->custom_menu_themecolours(); ?>
                                </div>
                            <?php } ?>
                            <div id="custom_menu">
                                <?php echo $OUTPUT->custom_menu(); ?>
                            </div>
                            <div id="custom_menu_activitystream">
                                <?php echo $OUTPUT->custom_menu_activitystream(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
