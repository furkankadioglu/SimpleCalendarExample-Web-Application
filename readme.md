![Demo Video](https://media.giphy.com/media/1eAv85RJxLsaIWNgHd/giphy.gif)

# Simple Calendar Example
This is a sample code project. Made according to the task given. Some extra features have not been made due to time constraints.

# Task

This is the code test sent to applicants for back-end developer roles. Using PHP (preferably OOP and an MVC structure), MySQL and HTML, create a simple application that will allow the user to display a list of events from a database table with three columns - id, event title and event date. Also enable the user to add, edit and delete events. The code will be judged on structure, readability and security. Using Jquery calendar [http://fullcalendar.io/](http://fullcalendar.io/) (or something similar) display these events in a calendar underneath the list of events created above.

We are looking for a representation of good code to fulfill the mission. How you choose to approach this and in what detail is up to you. We do not however want you spending a ridiculous amount of time on this so if there is something you would have done but would time-consuminging then you can simply note this alongside the code.

# How To Start

- Clone the project.
- Open project folder with terminal.
- Edit .env file with your credentials.
- Run **"sh run.sh"** command or start manually. (it's a shell script for everything)
- Go to localhost:8000 with your browser.

**Base requirements**
- PHP 7+
- MySQL
- NPM / Yarn
- Composer


**Start manually**
composer install;
npm install;
php artisan migrate;
php artisan db:seed;
vendor/bin/phpunit --debug;
npm run production;
php artisan serve;

**Just run server**
> php artisan serve

# Project Features & TODO

- Laravel 5.8 ✅
- OOP & Eloquent ORM ✅
- API Resources (Collections, Resource models) ✅
- Restful API ✅
- JWT & Bearer Auth ✅
- Modern Frontend (VueJS) ✅
- Shell Script for Installation ✅
- PHPUnit & Testcases ✅
- Security Checks (Throttle ✅, JWT ✅)
- PSR Standarts ✅
- Eloquent Relationships ✅
- Eloquent mutators ✅
- Migration Files ✅
- Factories ✅
- DB Seeds ✅
- Insomnia Rest Client Support  ✅
- Cached queries with Redis ✅
- Queued calendar event jobs with Horizon 🚫
- Auto generated documentation with PHPDocs 🚫
- Notification system 🚫
- Scheduled commands 🚫

**If desired, I can make the missing parts.** 

## Insomnia Export

![Example project Insomnia API](https://user-images.githubusercontent.com/5060068/54467053-cefd9280-4793-11e9-988b-0d1ca961f7dc.png)

Insomnia export is in the project root directory. (Insomnia.json) You can import your [insomnia](insomnia.rest) client.

