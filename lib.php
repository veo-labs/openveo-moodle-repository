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
 * Defines the repository class.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/openveo_api/lib.php');

use Openveo\Client\Client;
use Openveo\Exception\ClientException;
use local_openveo_api\event\connection_failed;

/**
 * Defines the OpenVeo repository.
 *
 * @package repository_openveo
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class repository_openveo extends repository {

    /**
     * The OpenVeo web service client.
     *
     * @var Openveo\Client\Client
     */
    protected $client;

    /**
     * URL of OpenVeo CDN.
     *
     * @var string
     */
    protected $cdnurl;

    /**
     * Builds the repository and prepares OpenVeo web service client.
     *
     * OpenVeo web service client is available through the local plugin "OpenVeo API".
     *
     * @see repository To know more about parameters
     * @param int $repositoryid Instance id of the repository
     * @param int|stdClass $context A context id or context object
     * @param array $options Repository options which may contain a property "ajax" (bool) indicating if user is
     * using the AJAX filepicker or not and a property "mimetypes" containing the list of accepted mime types or *
     * for all types. It also contains the settings saved in the database.
     * @param int $readonly Indicate this repository is readonly or not
     */
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array(), $readonly = 0) {
        parent::__construct($repositoryid, $context, $options, $readonly);

        // We make use of the local plugin "OpenVeo API" to get connection information to communicate with OpenVeo
        // web service.
        $this->cdnurl = get_config('local_openveo_api', 'settingscdnurl');
        $url = get_config('local_openveo_api', 'settingswebserviceurl');
        $clientid = get_config('local_openveo_api', 'settingswebserviceclientid');
        $clientsecret = get_config('local_openveo_api', 'settingswebserviceclientsecret');
        $certificatefilepath = get_config('local_openveo_api', 'settingswebservicecertificatefilepath');

        try {
            $this->client = new Client($url, $clientid, $clientsecret, $certificatefilepath);
        } catch(ClientException $e) {
            throw new moodle_exception('localpluginnotconfigurederror', 'repository_openveo');
        }
    }

    /**
     * Indicates if repository manage datas by users.
     *
     * @see repository To know more about this method
     * @return boolean false The OpenVeo repository does not access videos regarding a particular user.
     */
    public function contains_private_data() : bool {
        return false;
    }

    /**
     * Indicates the type of files supported by this repository.
     *
     * OpenVeo Repository is available everywhere a video can be added.
     *
     * @return array The list of supported file types
     */
    public function supported_filetypes() : array {
        return array('video');
    }

    /**
     * Indicates how the files can be picked from this repository.
     *
     * OpenVeo repository is not capable of downloading the file into Moodle, it only works by linking the video
     * into Moodle, thus it doesn't support FILE_INTERNAL.
     *
     * @return int A value representing the list of supported methods: FILE_EXTERNAL and FILE_REFERENCE
     */
    public function supported_returntypes() : int {
        return (FILE_EXTERNAL | FILE_REFERENCE);
    }

    /**
     * Indicates how the files can be picked from this repository by default.
     *
     * If FILE_EXTERNAL and FILE_REFERENCE are both supported by the file picker then the default preselected value
     * will be FILE_EXTERNAL.
     *
     * @return int A value representing the default method to use: FILE_EXTERNAL
     */
    public function default_returntype() : int {
        return FILE_EXTERNAL;
    }

    /**
     * Builds search form instead of login form.
     *
     * OpenVeo repository does not need user to log to OpenVeo, the client defined in OpenVeo API plugin is used to
     * request OpenVeo web service. Moodle offers the possibility to build a search form instead of a login form by
     * adding the property "login_btn_action" with value "search" instead of "login". "search" method will then be
     * called when submitting the formular instead of "signin".
     * The fact that Moodle interprets the property "login_btn_action" to transform a login form into a search form,
     * seems to be a hack. It is not documented but used by plugins like the Youtube repository.
     *
     * @return array The description of the formular as expected by Moodle with a property "login" containing the
     * description of the fields to add to the login form, with for each field: properties "type" (one of "popup",
     * "textarea", "select", "input", "radiogroup" or "checkbox"), "id", "name" and "label". Also a property
     * "login_btn_label" containing the submit button label, a property "login_btn_action" set to "search" and a
     * property "allowcaching" set to true to authorize browser to cache the formular.
     */
    public function print_login() : array {
        $searchform = array();

        // Link field.
        // We could have name it "s" because lib/repository_ajax.php already handle "s" parameter from the search
        // form but we expect an URL, not a search query (validation will be different).
        $linkfield = new stdClass();
        $linkfield->type = 'text';
        $linkfield->id   = 'search';
        $linkfield->name = 'url';
        $linkfield->label = get_string('searchformlinkfieldlabel', 'repository_openveo');

        $searchform['login'] = array($linkfield);
        $searchform['login_btn_label'] = get_string('searchformsubmitlabel', 'repository_openveo');
        $searchform['login_btn_action'] = 'search';
        $searchform['allowcaching'] = true;
        return $searchform;
    }

    /**
     * Indicates if user is logged in to the repository.
     *
     * OpenVeo repository does not authorize user to log in as it uses a unique client to connect to OpenVeo web
     * service.
     *
     * @return bool false, user is never logged
     */
    public function check_login() : bool {
        return false;
    }

    /**
     * Gets link from source.
     *
     * Source is the id of the video for this repository, thus it is concatenated to the OpenVeo CDN URL to have a
     * valid OpenVeo URL.
     *
     * @param string $source The video id
     * @return string The video URL
     */
    public function get_link($source) : string {
        return trim($this->cdnurl, '/') . '/publish/video/' . $source;
    }

    /**
     * Gets human readable information about the original.
     *
     * @param string $reference The video id on OpenVeo
     * @param int $filestatus status of the file, 0 - ok, 666 - source missing
     * @return string The title of the video from OpenVeo
     */
    public function get_reference_details($reference, $filestatus = 0) : string {
        if ($filestatus || empty($reference)) {
            return get_string('lostsource', 'repository_openveo', $reference);
        }

        try {
            $response = $this->client->get('publish/videos/' . $reference);
            $video = $response->entity;
        } catch(Exception $e) {
            $event = connection_failed::create(array(
                'context' => context_system::instance(),
                'other' => array(
                    'message' => $e->getMessage()
                )
            ));
            $event->trigger();
            return '';
        }

        if (!empty($video) && $video->state === 12) {
            return $video->title;
        } else {
            return get_string('lostsource', 'repository_openveo', $reference);
        }
    }

    /**
     * Finds an OpenVeo video from an URL.
     *
     * Search form is used here to validate the OpenVeo URL submitted in "url" parameter, not to get a list of
     * videos corresponding to searched keywords. Consequently only one video is returned, the video corresponding
     * to the URL.
     *
     * @param string $search_text Does not contain anything, "url" parameter is used instead of "s" parameter
     * @param int $page Not used by this repository as only one video is retrieved
     * @return array The list of results as expected by Moodle with several properties. Property "list" containing
     * the list of results, here only one video in the results; Properties "pages" and "page" both set to 1 as only
     * one video can be searched; Properties "nosearch", "nologin" and "norefresh" set to true to deactivate Moodle
     * search and login forms. Finally a property "manage" to specify the URL of the OpenVeo administration
     * interface.
     */
    public function search($search_text, $page = 0) : array {
        $video = null;
        $list = array();
        $list['list'] = array();
        $list['pages'] = 1;
        $list['page'] = 1;
        $list['nosearch'] = true;
        $list['nologin'] = true;
        $list['norefresh'] = true;
        $list['manage'] = trim($this->cdnurl, '/') . '/be';

        // Retrieve URL from submitted data (e.g. https://openveo.local.com/publish/video/ryiKXvW1X?lang=en).
        $url = optional_param('url', '', PARAM_RAW_TRIMMED);
        try {
            $moodleurl = new moodle_url($url);

            // Retrieve video id from path.
            if (preg_match('/^\/publish\/video\/([\w\-]+)$/', $moodleurl->get_path(false), $matches)) {

                // Use video id to get full information about the video from OpenVeo web service.
                $response = $this->client->get('publish/videos/' . $matches[1]);
                $video = $response->entity;

            }
        } catch(moodle_exception $e) {
            return $list;
        } catch(Exception $e) {
            $event = connection_failed::create(array(
                'context' => context_system::instance(),
                'other' => array(
                    'message' => $e->getMessage()
                )
            ));
            $event->trigger();
            return $list;
        }

        // Video should be published.
        if (!empty($video) && $video->state === 12) {
            $list['list'][0] = array(
                'size' => 0,
                'source' => $video->id,
                'shorttitle' => $video->title,
                'title' => $video->title . '.openveo',
                'thumbnail' => $video->thumbnail . '?style=publish-square-142',
                'thumbnail_width' => 142,
                'thumbnail_height' => 142,
                'date' => $video->date / 1000
            );
        }

        return $list;
    }

    /**
     * Downloads a file from external repository and saves it in temp dir.
     *
     * OpenVeo Repository is not capable of downloading the content, consequently this does nothing.
     *
     * @param string $url The file reference (the video id)
     * @param string $filename The filename (without path)
     * @return array An empty array
     */
    public function get_file($url, $filename = '') : array {
        return array();
    }

    /**
     * Downloads the file from external repository and saves it in moodle filepool.
     *
     * OpenVeo Repository is not capable of importing external files into Moodle, consequently this does nothing.
     *
     * @param stored_file $file The file to import
     * @param int $maxbytes File size limit (0 means no limit)
     */
    public function import_external_file_contents(stored_file $file, $maxbytes = 0) {}

}