<?php
// This file is part of Lion - http://lion.org/
//
// Lion is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Lion is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Lion.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package     theme_essential
 * @copyright   2013 Julian Ridden
 * @copyright   2014 Gareth J Barnard, David Bezemer
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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
