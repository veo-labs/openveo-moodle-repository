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
 * Defines the plugin uninstaller.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace repository_openveo\local;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/repository/lib.php');

use repository;

/**
 * Defines the plugin uninstaller.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class uninstaller {

    /**
     * Removes repository files.
     *
     * Moodle repositories supporting FILE_REFERENCE should normally be able to download external files to import them
     * into Moodle when uninstalling. The OpenVeo repository does not support the download of an OpenVeo
     * video, consequently no files will be imported when uninstalling the repository. As Moodle expects files to be
     * imported it doesn't remove the files associated to the repository, this is the purpose of this function.
     * Removed files won't appear in filemanager and links created in the editor will refer to missing files.
     */
    public static function remove_repository_files() {
        global $DB;

        // Retrieve OpenVeo Repository instances.
        $instances = repository::get_instances(array('type' => 'openveo'));

        foreach ($instances as $instance) {

            // Remove files associated to the instance.
            $instance->remove_files();

        }
    }

}
