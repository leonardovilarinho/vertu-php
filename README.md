# Vertu PHP

An tool with objective of analyze the quality of an code builded in PHP, calculating some metrics that represents your quality.

The VertuPHP name, come of french 'virtue', with pronuncie 'vert', on way that the virtue is any thing that we want, is the correct, an objective common.

## Installation

No we contains an concrete method of installation, on end, all the project it will be available in an PHAR file, as the Composer and PHPUnit.

At now, install the project cloning this repository:
```
git clone https://github.com/leonardovilarinho/vertu-php.git
```

And installing your dependencies:
```
composer install
```

## Settinging

You can personalizate the Vertu, adding the config file `.env`, defining some options:

```
# path to project to be rated
PROJECT= /home/vagrant/php/phar/esquelete

# directories without checked
EXCLUDE_DIR= vendor|tests

# files extesions to be verified
EXTENSION= *.php

# quantity of files to be rated and displayed
RANKING= 6

# type of files to be excluded in result
# types of file: file, class, abstract class e interface
OMIT= interface
```

## Executing

Actually, to execute the tool, use the following command in VertuPHP folder:
```
php src/index.php run
```