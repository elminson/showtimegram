# Project Showtimegram 

The Goal:
For this homework we are having you build out a mini Instagram called showtimegram.

The goals for the homework are the following:
The ability for a person to load a page with an “add an image button” that will show them (ajax) or take them to a page with a form that has a button to upload an image, put a username and a caption on that image.

Upon posting that form, it will store the necessary data in an sqlite database and upload the image to a directory (relative - > /images)

When the home page is reloaded, the image will be shown with the username and caption on it

Bonus:

The user can delete an image that was posted. (any image since we aren’t using auth)

We’re attaching a ui here for what the home page could look like. It does not need to match perfectly, this is just a guide.

Here the image is 600px wide max with an 30px username and 18px caption. There is a 20px padded container with a semi transparent background.
These are just rough guides.

Expected tech stack:
* PHP (any framework is fine, just make sure either a composer file or the dependencies are included)
* SQLite
* Any HTML/JS/CSS included

Zip up the files and send them named following (yourname).fullstackhomework.zip (or gzip). If the file is too large to email, please put it in a dropbox or shared file space and email the link.

If the app requires any build processes (running composer/npm install/etc) please include those directions in your email.

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
```
<b>Ubuntu Server 16.04</b>
PHP7.1
npm 5.03
nodejs 8.x
composer 1.2.1
php7.1-sqlite3
sqlite3
libpng-dev
libjpeg-dev
libsqlite3-dev
```

### Ubuntu with PHP7.1
If the server is running Apache with PHP just copy the zip content to `/var/www/htm/` (default location) 
```
unzip elminson.fullstackhomework.zip
chown -R www-data:www-data showtimegram
cd showtimegram
chmod 777 public/images
composer install
php artisan key:generate
php artisan migrate
npm install
npm rebuild node-sass
npm run dev
php artisan serve --port=8080 --host=YOUR_IP
````

### Docker installation
Git <Br>
Docker<br>

Install Git following these instructions 
```
https://git-scm.com/book/en/v2/Getting-Started-Installing-Git
```
Install Docker following these instructions 
```
https://docs.docker.com/compose/install/
```

### Installing and running on Docker
In order to run the project after install git and docker you will need
1) Unzip the project.
2) Build the app.
3) Start and runs the entire app.
```
unzip elminson.fullstackhomework.zip
cd showtimegram
docker-compose build
docker-compose up
```
The app will be accesible by the port 8080 
```
http://127.0.0.1:8080/
```
## Tested
The project was tested in a new droplet in Digital Ocean (https://digitalocean.com) following the "Installing and running
" instructions. Droplet used <b>Ubuntu Docker 17.12.0~ce on 16.04 <b>
![Screenshot_showtimegram_3](https://github.com/elminson/showtimegram/blob/master/Screenshot_showtimegram_3.png)

## Configuration 
Pagination is set to 2 items per page, you can change the number of items 
```
file => app/Http/Controllers/ImageController.php
$this->number_of_page = 2;
```

## Built With

* [Laravel](https://laravel.com/) - The PHP framework used
* [React](https://reactjs.org/) - The frontend framework used
* [Vuejs](https://vuejs.org) Vuejs
* [Bootstrap-vue](https://bootstrap-vue.js.org/) Bootstrap-vue
* [Docker](https://docker.com) - Used for containerization

## Screenshots
![Screenshot_1](https://github.com/elminson/showtimegram/blob/master/Screenshot_showtimegram.png)

## Authors

* **Elminson De Oleo Baez** - [elminson](https://github.com/elminson)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
