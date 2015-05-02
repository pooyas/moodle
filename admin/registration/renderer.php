<?php

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// This file is part of Lion - http://lion.org/                      //
// Lion - Modular Object-Oriented Dynamic Learning Environment         //
//                                                                       //
// Lion is free software: you can redistribute it and/or modify        //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation, either version 3 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// Lion is distributed in the hope that it will be useful,             //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details.                          //
//                                                                       //
// You should have received a copy of the GNU General Public License     //
// along with Lion.  If not, see <http://www.gnu.org/licenses/>.       //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

/**
 * Registration renderer.
 * @package   lion
 * @subpackage registration
 * @copyright 2010 Lion Pty Ltd (http://lion.com)
 * @author    Jerome Mouneyrac
 * 
 */
class core_register_renderer extends plugin_renderer_base {

    /**
     * Display Lion.org registration message about benefit to register on Lion.org
     *
     * @return string
     */
    public function lionorg_registration_message() {

        $lionorgstatslink = html_writer::link('http://lion.net/stats',
                                               get_string('statslionorg', 'admin'),
                                               array('target' => '_blank'));

        $hublink = html_writer::link('https://lion.net/mod/page/view.php?id=1',
                                      get_string('lionorghubname', 'admin'),
                                      array('target' => '_blank'));

        $lionorgregmsg = get_string('registerlionorg', 'admin', $hublink);
        $items = array(get_string('registerlionorgli1', 'admin'),
                       get_string('registerlionorgli2', 'admin', $lionorgstatslink));
        $lionorgregmsg .= html_writer::alist($items);
        return $lionorgregmsg;
    }

    /**
     * Display a box message confirming a site registration (add or update)
     * @param string $confirmationmessage
     * @return string
     */
    public function registration_confirmation($confirmationmessage) {
        $linktositelist = html_writer::tag('a', get_string('sitelist', 'hub'),
                        array('href' => new lion_url('/local/hub/index.php')));
        $message = $confirmationmessage . html_writer::empty_tag('br') . $linktositelist;
        return $this->output->box($message);
    }

    /**
     * Display the listing of registered on hub
     */
    public function registeredonhublisting($hubs) {
        global $CFG;
        $table = new html_table();
        $table->head = array(get_string('hub', 'hub'), get_string('operation', 'hub'));
        $table->size = array('80%', '20%');

        foreach ($hubs as $hub) {
            if ($hub->huburl == HUB_LIONORGHUBURL) {
                $hub->hubname = get_string('registeredlionorg', 'hub', $hub->hubname);
            }
            $hublink = html_writer::tag('a', $hub->hubname, array('href' => $hub->huburl));
            $hublinkcell = html_writer::tag('div', $hublink, array('class' => 'registeredhubrow'));

            $unregisterhuburl = new lion_url("/" . $CFG->admin . "/registration/index.php",
                            array('sesskey' => sesskey(), 'huburl' => $hub->huburl,
                                'unregistration' => 1));
            $unregisterbutton = new single_button($unregisterhuburl,
                            get_string('unregister', 'hub'));
            $unregisterbutton->class = 'centeredbutton';
            $unregisterbuttonhtml = $this->output->render($unregisterbutton);

            //add button cells
            $cells = array($hublinkcell, $unregisterbuttonhtml);
            $row = new html_table_row($cells);
            $table->data[] = $row;
        }

        return html_writer::table($table);
    }

}
