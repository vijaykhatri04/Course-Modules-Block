<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Outputs the Course modules list.
 *
 * @package   block_course_modules
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_course_modules_renderer extends plugin_renderer_base {

    public function diplay_list_if_modules($courseid) {
        global $DB, $USER;
        $output = '';
        $modinfo = get_course_mods($courseid);
        $hyphen = get_string('hyphen', 'block_course_modules');
        
        $output .= html_writer::start_div('course-modules-content');
        $output .= html_writer::start_div('row');
        if ($modinfo) {
            foreach ($modinfo as $mod) {
                $fielddata = array();
                $fielddata[] = $mod->id;
                $modname = $DB->get_field($mod->modname, 'name', array('id' => $mod->instance));
                $modurl = new moodle_url("/mod/$mod->modname/view.php", array('id' => $mod->id));
                $modname = html_writer::link($modurl, $modname, array('target' => '_blank'));
                $fielddata[] = $modname;
                $fielddata[] = userdate($mod->added, '%d-%b-%Y');
                if ($mod->completion) {
                    $completion = ($DB->get_record('course_modules_completion', array('coursemoduleid' => $mod->id,
                                'userid' => $USER->id, 'completionstate' => COMPLETION_COMPLETE))) ?
                                get_string('completed', 'block_course_modules') : '';
                    if ($completion) {
                        $fielddata[] = $completion;
                    }
                }

                $output .= html_writer::start_div('col-md-12');
                $output .= implode($hyphen, $fielddata);
                $output .= html_writer::end_div();
            }
        } else {
            $output .= html_writer::start_div('col-md-12');
            $output .= get_string('nomodulefound', 'block_course_modules');
            $output .= html_writer::end_div();
        }
        $output .= html_writer::end_div();
        $output .= html_writer::end_div();

        return $output;
    }

}
