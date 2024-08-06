

## Setup Guide (local)
If you are an ubuntu

1. Unpack project in a directory if php is install globally any directory should okay.
2. Create database in mysql
3. In project root directory there is a file config.php set database information there.
4. Run "php migrate.php" to run migrations
5. Run "php -S localhost:8000" or your prefer port

If xampp all step are same except you have to unpack the project in htdocs directory

Note: In RAW PHP I don't know the standard way of structuring project, this way I prefer but if I have to work on any kinds of structure I cn work.
