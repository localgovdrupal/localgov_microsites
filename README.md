# LocalGov Drupal Microsites

Drupal distribution and install profile to help UK councils collaborate and
share Drupal code for publishing website content across a number of 
microsites from a single Drupal installation.

This repository is the Drupal installation profile that is best installed using
composer to require a project template, localgov_microsites_project, to scaffold 
and build the codebase which includes this profile.

Please see https://github.com/localgovdrupal/localgov_microsites_project

## Funding

This work was initially funded by the Local Digital Fund (https://www.localdigital.gov.uk/fund/) from the Department for Levelling Up, Housing and Communities (DLUCH).


## Supported branches

We are actively supporting and developing the 2.x branch for Drupal 9.

The 1.x branch is no longer actively supported and not recommended for new sites.

If for any reason you are still using the 1.x branch on your site, please [create an issue on Github](https://github.com/localgovdrupal/localgov_microsites/issues) to let us know.

## Documentation

Further documentation for developers, content designers and other audiences can
be found at [https://docs.localgovdrupal.org/microsites/](https://docs.localgovdrupal.org/microsites/).

## Installation 

For installation steps, see: https://github.com/localgovdrupal/localgov_microsites_project

## Requirements for installing LocalGov Drupal locally for testing and development

To install LocalGov Drupal locally you will need an appropriate versions of:

 - PHP (see https://www.drupal.org/docs/system-requirements/php-requirements)
 - A database server like MySQL (see https://www.drupal.org/docs/system-requirements/database-server-requirements)
 - A web server like APache2 (see https://www.drupal.org/docs/system-requirements/web-server-requirements) 

Many of us use the Lando file included to run a local docker environmnent for testing and development, but seom people prefer to run the web servers natively on their host machine.

### PHP requirements

We folllow Drupal's PHP recomendations: https://www.drupal.org/docs/system-requirements/php-requirements#versions

We currently recomend and test against PHP 8.1.

You will also need to have certain PHP extensions enabled (see https://www.drupal.org/docs/system-requirements/php-requirements#extensions) including: 

 - PHP mbstring
 - PHP cURL
 - GD library
 - XML 

If you see errors when running composer require, double check your PHP extensions.

## Developer notes for default content

This profile creates a single node of demo content using the https://www.drupal.org/project/default_content module.

This node includes layout paragraphs and paragraph content to demonstrate some of the content components available for a new microsite. When a new microsite is created, it attempts to clone this node into the new microsite. 

As developers, we often want to update the default content, using drush.

To export an item of content and all references:

```bash
lando drush dcer <entity type> <entity id> --folder=profiles/contrib/localgov_microsites/content/
```

So for node/1: 

```bash
lando drush dcer node 1 --folder=profiles/contrib/localgov_microsites/content/
```

## Composer and Lando

To install locally, you will need Composer and we recommend using Lando for a consistent developer environment.

 - https://getcomposer.org/
 - https://lando.dev/

Please also see the Lando requirements section for details of Docker
requirements for different operating systems.

https://docs.lando.dev/basics/installation.html#system-requirements

## Installing LocalGov Drupal locally with composer

To install LocalGov Drupal locally for testing or development, use the
[Composer-based project template](https://github.com/localgovdrupal/localgov_microsites_project).

Change `MY_PROJECT` to whatever you'd like your project directory to be called.

```bash
composer create-project localgovdrupal/localgov_microsites_project --stability beta --no-install MY_PROJECT
```

Change directory into the MY_PROJECT directory and run lando start.

```bash
cd MY_PROJECT
lando start
```

Once lando has finished building, use lando to run composer install and the site installer.

```bash
lando composer install
lando drush si localgov_microsites -y
```

Note: As you might be running a different version of PHP on your host machine from the 
version that Lando runs, it is advisable to run composer install from within Lando. 
This ensures dependencies reflect the PHP version that the webserver is actually running. 

## Composer notes

If developing locally and you want to force composer to clone again
from source rather than use composer cache, you can add the `--no-cache` flag.

```bash
lando composer create-project localgovdrupal/localgov_microsites_project --stability beta --stability beta --no-cache --no-install  MY_PROJECT
```

If you just want to pull in the latest changes to LocalGov Drupal run composer
update with the `--no-cache` flag.

```bash
lando composer update --no-cache
```

If you want to be sure you are getting the latest commits when developing,
clearing composer cache, deleting the folders and re-running composer update
seems to be a solid approach:

```bash

rm -rf web/profiles/contrib/ web/modules/contrib/ web/themes/contrib/;
composer clear-cache; composer update --with-dependencies --no-cache;
lando start;
lando drush si localgov_microsites -y;

```

If you run into [memory limit errors](https://getcomposer.org/doc/articles/troubleshooting.md#memory-limit-errors)
when running Composer commands, prefix the commands with `COMPOSER_MEMORY_LIMIT=-1`.
For example, to install the project run:

```bash
COMPOSER_MEMORY_LIMIT=-1 composer create-project localgovdrupal/localgov_microsites_project MY_PROJECT
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for current contribution guidelines.

## Issue tracking

Most issues will be tracked in this repository
<https://github.com/localgovdrupal/localgov_microsites/issues>.

Development issues relating to specific projects or module should be tracked in
the project repository.

## Development setup

The main development environment in use is currently
[Lando](https://docs.lando.dev/) – a Docker based development environment that
works on Linux, MacOS and Windows.

@todo Document Lando setup.

## Coding standards

PHP CodeSniffer is installed as a dev dependency by Composer and configured to
use Drupal coding standards and best practices. It is a good idea to run these
before committing any code. All code in pull requests should pass all
CodeSniffer tests.

To check code using Lando run:

```bash
lando phpcs
```

To attempt to automatically fix coding errors in Lando run:

```bash
lando phix
```

### Coding standards resources

* [Drupal coding standards](https://www.drupal.org/docs/develop/standards)

## Running tests

The included `phpunit.xml.dist` file contains configuration for automatically
running the LocalGov Drupal test suite.

To run all LocalGov Drupal tests with Lando use:

```bash
lando phpunit
```

To run all the tests for a specific module use:

```bash
lando phpunit web/modules/contrib/localgov_my_module
```

Tests can be filtered using the `--filter` option. To only run a specific test
use:

```bash
lando phpunit --filter=myTestName
```

### Testing resources

* [PHPUnit documentation](https://phpunit.readthedocs.io/en/7.5/)
* [Drupal 8 PHPUnit documentation](https://www.drupal.org/docs/8/testing/phpunit-in-drupal-8)
* [Drupal 8 testing documentation](https://www.drupal.org/docs/8/testing)
* [Workshop: Automated Testing and Test Driven Development in Drupal 8](https://github.com/opdavies/workshop-drupal-automated-testing)

## Maintainers

This project is currently maintained by: 

 - Ekes: https://www.drupal.org/u/ekes
 - Finn Lewis: https://www.drupal.org/u/finn-lewis
 - Maria Young: https://www.drupal.org/u/mariay-0
 - Mark Conroy: https://www.drupal.org/u/markconroy
 - Stephen Cox: https://www.drupal.org/u/stephen-cox 
