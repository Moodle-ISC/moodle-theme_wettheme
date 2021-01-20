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

namespace theme_wettheme\output;

use coding_exception;
use core_analytics\course;
use html_writer;
use image_icon;
use tabobject;
use tabtree;
use custom_menu_item;
use custom_menu;
use filter_manager;
use block_contents;
use navigation_node;
use action_link;
use stdClass;
use moodle_url;
use preferences_groups;
use action_menu;
use help_icon;
use single_button;
use single_select;
use paging_bar;
use url_select;
use context_course;
use pix_icon;
use theme_config;
use core_course;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_wettheme
 * @copyright  2020 DK
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class core_renderer extends \core_renderer
{
    public function edit_button(moodle_url $url)
    {
        return '';
    }

    // DK: If exists, add course description to course header.
    public function course_header()
    {
        global $PAGE, $CFG;

        // skip any page unrelated to 'course'
        if (strpos($PAGE->pagetype, 'course-') !== true)
        {
            return parent::course_header();
        }
        else
        {
            $header = parent::course_header();
            // load course fields
            $course = $PAGE->course;
            $handler = core_course\customfield\course_handler::create();
            $customfields = $handler->export_instance_data_object($course->id);

            // desc should exist - print that, otherwise print summary
            if (!empty($customfields->addcourse_description)) {
                $append = $customfields->addcourse_description;
            } elseif (!empty($course->summary)) {
                $append = $course->summary;
            }
            $message = html_writer::start_div('course-message');
            $message .= html_writer::empty_tag('img', array('class' => 'fas fa-university', 'src' => $CFG->wwwroot . '/theme/wettheme/pix/course/university-solid.svg'));
            $message .= html_writer::tag('p', $append, array('class' => 'course-desc'));
            $message .= html_writer::end_div();
            return $header . '' . $message;
        }
    }

/* TODO: Trying to add WET header... */

  /*  public function get_header()
    {
        global $CFG, $_PAGE;

        $header = new stdClass();
        $header->wwwroot = $CFG->wwwroot;
        $header->langmenu = $_PAGE['langmenu'];
        $header->wetboew = $CFG->wwwroot . '/theme/wettheme/toolkit';
        $header->lang = current_language();
        return $this->render_from_template('theme_wettheme/header', $header);
    } */
}

