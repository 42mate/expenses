# Expenses

A simple app to keep track of expenses and incomes.

# Development

# Requirements

In order to develop you'll need to have installed Lando and Docker.

  Lando https://docs.lando.dev/getting-started/installation.html

## Environment setup

Once you cloned the repo the .env in the src folder will be all set 
to run in local with lando, for others environment you'll have 
to setup the configuration variables on the .env file.

`
cd src
cp .env.local .env
`

Run lando start to launch the environment 

`lando start`

Once lando has started, install all dependencies (inside of src/ directory)

`lando composer install`
`lando npm install`

Run migrate to install the database schema.

`lando artisan migrate`

Seed the database to have sample data.

`lando artisan db:seed`

Create the currencies

`lando artisan db:seed CurrenciesSeeder`

Done!, access to the site and start playing.

## Toolkit

To use composer, run

`lando composer COMMAND` 

To use artisan, run

`lando artisan COMMAND`

To use npm, run 

`lando npm COMMAND`

## Fronted Development

To Compile scss and js, use for development

`lando npm run dev`

## Database

To access to mysql, use

`lando mysql laravel`

## Email

To tests emails, enter to the Mailhog service with your browser.

## Deployment

There is a script for deploy the current source code into a server.

First you need to create a .server_env file in the project root, copy the .server_env.example as .server_env and set the proper values.

The user needs to have configured the ssh keys properly to get access to the servers

In production, you have to setup your .env file, for prod, manually (you can leave it in the document root of the server)

To deploy, cd to the root of the project and run

`bash script/deploy.sh`

This will copy all current files in the local machine to the servers, without any config such as .env or files as storage, only source files and assets.
