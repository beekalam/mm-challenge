# Run 
```
$ composer install
$ php artisan storage:link 
$ php artisan serve
```

**Login** 

```username:``` user@demo.com

```password:``` secret

**note**: A Sqlite database with seed data is provided.
If you want to use Mysql instead,change the appropriate ```.env``` keys  and run

```
$ php artisan migrate:fresh --seed
```

# Running the tests
```
$ vendor\bin\phpunit
```


