# edf-telereleve-display
Web interface for view data from the [edf-telereleve](https://github.com/Mactronique/edf-telereleve)

# Install

Clone this repo or down load the latest release.

Install all dependencies for production with [composer](http://getcomposer.org) :

```
composer install -o --no-dev --prefer-dist
```

# Configure

If you use the SQLITE db, copy your DB file into `app/datas/datas.sqlite`. Doctrine is already configured in this case.

Il you use another database, change the doctrine DBAL configuration into `app/config/config.yml` and in your `app/config/parameters.yml`.

# Launch server

```
bin/console server:start
```

# Browse an use

Open your browser and get : `http://127.0.0.1:8000`

The default graph is for today.

# Howto work ?

This little web site have one page. This page call the `/datas` URL for get and display datas.
The first feature display the consumption for one day only. For  this moment is work only for the dual pricing HC/HP from EDF.

# Contribute

If you are interested in this project, you can help me. Fork this repository, work on your copy and pull request for integrate your change in the main repository.

