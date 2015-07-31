# Hexagonal architecture test

sample application that showcases an implementation of the
Entity-Boundary-Interactor pattern (aka Hexagonal Architecture or Ports and
Adapters).

## Setup

In order to set up the project, first install the dependencies via composer:

$ composer install --dev

Then populate the production database (it's an sqlite db in the `store`
directory):

$ make init

Install redis

Install node.js

Install npm

Now you should be able to start the webserver and hit the page at
`localhost:8080`:

$ make web