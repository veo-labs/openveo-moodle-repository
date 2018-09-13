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
 * Defines english translations.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Plugin name displayed in settings and as the default name of the repository in file pickers
$string['pluginname'] = 'OpenVeo Repository';

// Settings page: Header
$string['configplugin'] = 'OpenVeo Repository settings';

// Global settings
$string['settingssupportedfiletypeslabel'] = 'Video types';
$string['settingssupportedfiletypes'] = 'Video types';
$string['settingssupportedfiletypes_help'] = 'The list of video types the OpenVeo Repository can add. Only form fields accepting the video types listed here will be able to add videos using OpenVeo Repository.';

// Capabilities
$string['openveo:view'] = 'Use OpenVeo in file picker';

// Privacy (GDPR)
$string['privacy:metadata'] = 'The plugin OpenVeo Repository does not store or transmit any personal data.';

// Search form
$string['searchformlinkfieldlabel'] = 'OpenVeo video URL:';
$string['searchformsubmitlabel'] = 'Search';

// Original source is missing
$string['lostsource'] = 'Error. OpenVeo video "{$a}" is missing.';

// Errors
$string['errorlocalpluginnotconfigured'] = 'Local plugin "OpenVeo API" is not configured.';

// Events
$string['eventgettingvideosfailed'] = 'Getting videos failed';
