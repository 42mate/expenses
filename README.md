# My Expenses

A simple app to keep track of expenses and iconmes.

# Development

# Requirements

In order to develop you'll need to have installed Lando and Docker.

  Lando https://docs.lando.dev/getting-started/installation.html

## Environment setup

Once you cloned the repo the .env in the src folder will be all set to run in local with lando, for others
environment you'll have to setup the configuration varialbes on the .env file.

Once is cloned, run lando start to launch the environment 

`lando start` 

Once lando has started, run migrate to install the database schema.

`lando migrate` 

To use composer, run

`lando composer COMMAND` 

To use artisan, run

`lando artisan COMMAND`

To use npm, run 

`lando npm COMMAND` 

To Compile scss and js, use

`lando npm run dev` 

To access to mysql, use

`lando mysql laravel`

To tests emails, enter to the Mailhog service.