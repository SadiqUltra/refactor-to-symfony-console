## Refactoring ugly code!
Ugly code: `app.ugly.php`

You can also find a less ugly version in `app.backup.php` file

### Installation
`$ git clone git@github.com:SadiqUltra/refactor-to-symfony-console.git`

`$ cd refactor-to-symfony-console && composer install && cp .env.example .env`

You can set `exchange rates api`, `bin list api` and `base currency` in `.env` file 

In `data/currency.json` file you can set or update country wise currency.
This files path is also configurable via `.env` file. You can even set a url 

### Run application
`$ php app.php input.txt`

### Unit Test
`$ ./vendor/bin/phpunit`

#### Contact
Any queries?
contact me @ sadikultra@gmail.com