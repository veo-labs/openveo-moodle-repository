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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Defines the renderer for the plugin.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace repository_openveo\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

/**
 * Defines the plugin renderer.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Renders an openveo_file_reference using template engine.
     *
     * @param openveo_file_reference $filereference The OpenVeo file reference
     * @return string The computed HTML of the OpenVeo file reference
     */
    public function render_openveo_file_reference(openveo_file_reference $filereference) : string {
        $data = $filereference->export_for_template($this);
        return parent::render_from_template('repository_openveo/openveo_file_reference', $data);
    }

}
