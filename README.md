# Event Manger Server
This is server repo for [Event Manager Desktop App](https://github.com/feat7/event-manager-desktop-application)

# Built with Surface
Surface is simple, light-weight, MVC based framework written in PHP to provide a faster, secure and efficent way to build websites.

# Features
- Object Relational Mapper used - Eloquent
- Templating Engine - Twig
- Simple Router
- Serverend Validation
- SMTP settings to send mail
- Easy and simple middlewares
- MVC design pattern
- Easy integration with 3rd party packages

# Installation
## Recommended way (Works on Linux, Windows and MacOS)
```
git clone https://github.com/feat7/event-manager-server.git <app-name>
cd <app-name>
composer install
```

To serve:
```
php -S 0.0.0.0:8000
```
Checkout ```http://localhost:8000``` in your browser!

### For database:
Add connection settings to `env.config.php` file.
run `php cli` command in your terminal.
Your database will be ready :)


## Troubleshooting
Make sure you've following packages:
`php libapache2-mod-php php-common php-mbstring php-xmlrpc php-soap php-gd php-xml php-mysql php-cli php-mcrypt php-zip`

# Database Schema
It is available in `cli` file.

## Other methods of installation

## On Linux (Ubuntu/Debian based)
1. Install ```LAMP``` stack on your PC.
2. Install [virtualhost](https://github.com/RoverWire/virtualhost) bash script.
3. Create a virtualhost as per given in above link.
4. ```cd /var/www/```
5. Delete the folder created by your virtualhost. Please note the name of the folder before deleting.
6. ```git clone https://github.com/feat7/Surface.git <folder-name-you-just-deleted>```
7. Open that folder in terminal and run ```composer install```
8. Done! Check the website from your browser!

## On Windows
If you're using ```XAMPP``` then simply move of the contents to ```htdocs``` folder. Note that htdocs should be root folder and don't make any subfolder inside it.

# LICENSE
The MIT LICENSE.
See [LICENSE](LICENSE) for more.
