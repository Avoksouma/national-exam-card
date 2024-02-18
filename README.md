# National Exam Card

The Office National des Examens et Concours du Superieur commonly referred to as ONECS is a key institution in Chad responsible for overseeing and managing examination and admission process for higher education institutions in the country....

## Requirements

-   php 7.4
-   composer 2
-   database: Sqlite, MySQL, or PostgreSQL
-   web browser
-   code editor
-   git

## Installation

### Composer and PHP

-   git clone https://github.com/6hislain/national-exam-card
-   cd national-exam-card
-   composer install
-   php artisan key:generate
-   rename _.env.example_ to _.env_
-   edit _.env_ to connect with your local database
-   php artisan migrate
-   php artisan serve

### Docker

-   docker build -t student-sponsorship .
-   docker run -d -p 8000:8000 student-sponsorship

## TODO

-   [ ] calendar
-   [ ] message
-   [ ] exam results (transcript)
-   [ ] student dashboard
-   [ ] seeder: applications
-   [ ] report: subject, school, student

### Database Tables

-   [x] User -> Student
-   [x] School
-   [x] Application
-   [x] Subject
-   [x] Marks
-   [x] Paper
-   [ ] Calendar Event
-   [ ] Message
-   [x] Notification
-   [x] Combination
