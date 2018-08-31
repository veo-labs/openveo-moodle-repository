# OpenVeo Moodle Repository

OpenVeo Moodle Repository is a Moodle Repository plugin which lets you add videos from [OpenVeo Publish](https://github.com/veo-labs/openveo-publish) into Moodle.

# Getting Started

## Prerequisites

- Moodle version >=3.4.0
- [Openveo](https://github.com/veo-labs/openveo-core) >=5.1.1
- [Openveo Publish plugin](https://github.com/veo-labs/openveo-publish) >=7.1.0
- [OpenVeo Moodle API plugin](https://github.com/veo-labs/openveo-moodle-api) >=1.0.0
- Allow external links using Moodle administration interface (**Plugins > Repositories > Allow external links is activated**)
- Create a new file type using Moodle administration interface (**Server > File types > Add a new file type**) with the following configuration:
    - Extension: **openveo**
    - MIME type: **video/mp4**
    - File icon: **mpeg**
    - Type groups: -
    - Description type: **Alternative language string (from mimetypes.php)**
    - Custom description: -
    - Alternative language string: **video**
    - Default icon for MIME type: **No**
- OpenVeo web service client for Moodle must have scope **Get videos**
- OpenVeo Moodle API plugin should be configured to communicate with OpenVeo web service

## Installation

- Download zip file corresponding to the latest stable version of the OpenVeo Moodle Repository plugin
- Unzip it and rename **openveo-moodle-repository-\*** directory into **openveo**
- Move your **openveo** folder into **MOODLE_ROOT_PATH/repository/** where MOODLE_ROOT_PATH is your Moodle installation folder
- In your Moodle site (as admin) go to **Settings > Site administration > Notifications**: you should get a message saying the plugin is installed
- In your Moodle site (as admin) go to **Settings > Site administration > Plugins > Repositories > Manage repositories**: activate the repository (**Enabled and visible**)

If you experience troubleshooting during installation, please refer to the [Moodle](https://docs.moodle.org) installation plugin documentation.

## Uninstallation

Be careful when uninstalling, all OpenVeo videos added to Moodle won't be downloaded to Moodle as it could be with another repository plugin. Links in rich text editors will point to missing files.

# Contributors

Maintainer: [Veo-Labs](http://www.veo-labs.com/)

# License

[GPL3](http://www.gnu.org/licenses/gpl.html)
