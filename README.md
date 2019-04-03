# ./unhack
Delete nasty eval'ed base64 code from your files. Often found in infected Wordpress/Magento installations.

## Usage
- **This script may fall for false positives, so back-up your files before using this!**
- Clone the repository somewhere near the directory with infected files.
- `cd unhack`
- `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`
- `php composer-setup.php`
- `php composer.phar install`
- Example: `./unhack ../public_html -e jpg`
