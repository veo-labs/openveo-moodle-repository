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
 * Defines an OpenVeo file reference.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace repository_openveo\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use stdClass;
use renderer_base;

/**
 * Defines an OpenVeo file reference.
 *
 * An OpenVeo file reference is caracterised by a Moodle URL.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class openveo_file_reference implements renderable, templatable {

    /**
     * The OpenVeo video URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Creates a new openveo_file_reference.
     *
     * @param string $url The OpenVeo video URL
     */
    public function __construct(string $url) {
        $this->url = $url;
    }

    /**
     * Exports openveo_file_reference data to be exposed to a template.
     *
     * @see templatable
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export
     * @return stdClass Data to expose to the template
     */
    public function export_for_template(renderer_base $output) : stdClass {
        $data = new stdClass();
        $data->url = $this->url;
        return $data;
    }

}
