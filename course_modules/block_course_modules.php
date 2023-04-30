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
 * Course Modules List block.
 *
 * @package    block_course_modules
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_course_modules extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_course_modules');
    }

    public function applicable_formats() {
        return array('course' => true);
    }

    public function hide_header() {
        return false;
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        $courseid = $this->page->course->id;
        if ($courseid <= 0) {
            $courseid = SITEID;
        }
        // Display process.
        $renderer = $this->page->get_renderer('block_course_modules');
        $output = $renderer->diplay_list_if_modules($courseid);

        $this->content->text .= $output;

        return $this->content;
    }

    public function instance_allow_config() {
        return true;
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function get_aria_role() {
        return 'navigation';
    }

    public function has_config() {
        return true;
    }

}
