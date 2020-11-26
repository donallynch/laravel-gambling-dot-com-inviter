# KAXMEDIA API

## Installation

1. Git clone the project
2. Run "composer install" to install all its dependencies
3. Copy .env.example to a new file called .env and set DB credentials(Create a new DB)
4. Run "php artisan key:generate" in the console
5. Run "php artisan migrate" in the console
6. Run "php artisan passport:install" in the console
7. You can run "php artisan db:seed" if you choose to test fake data or you can manually insert rows into tables as there are only 3 tables involved.
8. Run the project "php artisan serve" in the root directory to run locally your project or use docker/laradock to spin up the project containers.

## Notes
With very limited information in the documentation and no way to get additional information from product owners etc, I have made the following assumptions:
1. Must read the provided json file, line by line into memory (max 1 lines in memory at any given time).
2. Must extract data items from each line and determine if line should be added to a data structure or not.
3. Must implement *any algorithm that can calculate the distance between two lat and lng points of interest.
4. Must append each line of the file into a data structure that is key sortable, only if it meets the requirement that it is within the 100KM threshold.
5. Must ignore points that are outside the 100KM threshold.
6. Must sort data structure by affiliate_id after filling with data.
7. Must then loop over sorted data structure and generate a very basic HTML view (Laravel Blade) that identifies the name and affiliate ID of each individual who was identified as being within the 100 KM threshold.
8. "Must supply code that is production ready, clean and tested" has led me to believe that a website with a single route is required. We discussed Laravel and Symfony PHP frameworks in detail during the technical interview and as a result I've decided to use the Laravel framework for this assignment.
9. Must build a very basic frontend that "output the name and affiliate ids of matching affiliates (within 100KM), sorted by Affiliate ID (ascending)".

## Routes

1. http://localhost/index

### Author

Donal Lynch donal.lynch.msc@gmail.com