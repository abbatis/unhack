# ./unhack
Delete nasty eval'ed base64 code from your files

## Usage
- Back-up your files before using this
- Clone the repository somewhere near the directory with infected files
- `cd unhack`
- `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`
- `php composer-setup.php`
- `php composer.phar install`
- `./unhack <directory> [-e <excluded files>]
