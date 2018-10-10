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
 * Defines french translations.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Plugin name displayed in settings and as the default name of the repository in file pickers
$string['pluginname'] = 'Dépôt OpenVeo';

// Settings page: Header
$string['configplugin'] = 'Configuration Dépôt OpenVeo';

// Global settings
$string['settingssupportedfiletypeslabel'] = 'Types de vidéos';
$string['settingssupportedfiletypes'] = 'Types de vidéos';
$string['settingssupportedfiletypes_help'] = 'La liste des types de vidéos que le dépôt OpenVeo peut ajouter. Seuls les champs de formulaire acceptant les types de vidéos listés ici pourront ajouter une vidéo avec le Dépôt OpenVeo.';

// Capabilities
$string['openveo:view'] = 'Utiliser OpenVeo dans le sélecteur de fichiers';

// Privacy (GDPR)
$string['privacy:metadata'] = 'Le plugin Dépôt OpenVeo n\'enregistre ni ne transmet de données personnelles.';

// Search form
$string['searchformlinkfieldlabel'] = 'URL de la vidéo OpenVeo :';
$string['searchformsubmitlabel'] = 'Rechercher';

// File details
$string['referencedetails'] = 'Vidéo OpenVeo : {$a}';
$string['lostsource'] = 'Erreur. La vidéo OpenVeo "{$a}" n\'existe plus.';

// Errors
$string['errorlocalpluginnotconfigured'] = 'Le plugin local "OpenVeo API" n\'est pas configuré.';

// Events
$string['eventgettingvideosfailed'] = 'Récupération des vidéos echouée';
