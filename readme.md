# Passetonbillet
Train ticket resales

## Requirements
1. Homestead (https://laravel.com/docs/5.7/homestead), Laravel valet (https://laravel.com/docs/5.7/valet), or Laravel valet linux (https://cpriego.github.io/valet-linux/)
2. Composer (tested on Version 1.6.3 but may work with earlier versions)
3. Npm (tested on Version 3.5.2 but may work with earlier versions)
4. PhP (tested on Version 7.3 but may work with earlier versions)
    - Php7.3-stringmb
    - Php7.3-zip
    - Php7.3-gd
    - Php7.3-curl
    - Php7.3-pgsql
    - Php7.3-mysql
    - Php7.3-bcmath
5. PostgreSQL (May also work with MySQL but untested)

## Setting up the dev environment
( Thanks to J for the tips ;) )


```console
$ composer install
$ npm install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed --class=StationsTableSeeder
$ php artisan scout:import App\\Station
```
### Set the values in .env
1. The key:generate command will write to the .env file automatically
and set the value for APP_KEY 
2. For the other APP_* variables, use the example values for a development environment
3. Create a database in postgres with the same name as the user
which created the database. Enter these values, and the password for this user.
4. If you are using redis, setting a password is optional.
5. SENTRY_DSN (https://docs.sentry.io/error-reporting/quickstart/?platform=javascript)
6. Pusher (https://pusher.com/)
7. NOCAPTCHA_* (https://www.google.com/recaptcha/admin#list)
8. NEXMO (https://www.nexmo.com/?utm_source=google_search&utm_medium=paid&utm_campaign=brand_uk&gclid=EAIaIQobChMI-Lzt-YSA4AIVwjLTCh35pghOEAAYASAAEgJhivD_BwE)
9. The AWS key must be configured for at least read and write permissions to a single S3 bucket

```console
$ cd PTB 
$ valet link
$ valet secure
```
Open a browser at https://PTB.test or look at the file routes/web.php for the full list of URI routes

## Coding Practices & Process

### New features
Working on a new feature? Here is how to proceed:
* When working on a feature, we create a new branch. If the feature is related to a Trello card (most likely it will always be the case), you open the trello card in your browser, and find the id + name of the card. For instance if I open a card and find that the url is `https://trello.com/c/93WXWmyu/193-revert-a-ticket-sold` then I use `193-revert-a-ticket-sold` as a name for my branch.
* I try to name commits correctly so it’s easy to follow, then I push my branch to github.
* Finally I create a pull request to the master branch, and set someone as reviewer for it. If possible, and if needed, try to add a quick description of the work done, and the strategy adopted. Make sure to merge master on this branch before creating the pull request so that there is no conflicts when the time to merge comes.
* Then if there is some feedback, or some changes are required, I do them, re-push to update the pull request and let the reviewer know it was updated.
* Then hourray! Code is merged to master (either by reviewer, or by the creator of the branch if asked by reviewer) and branch previously created is closed.

