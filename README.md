# concrete5.org Documentation Website

This repo contains the source code for [documentation.concrete5.org](https://documentation.concrete5.org). It installs the shared concrete5.org theme, as well as a couple of add-ons.

## Installation Instructions.

1. Clone this repo.
2. Install dependencies by running `composer install`.
3. Install concrete5, making sure to select the `concrete5_documentation` starting point. Here is an example of installation via the command line.

`concrete/bin/concrete5 c5:install -vvv --db-server=localhost --db-database=concrete5_documentation --db-username=user --db-password=password --starting-point=concrete5_documentation --admin-email=your@email.com --admin-password=password`
