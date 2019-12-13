## TODO App

This application aims to show code practices and testing practices.

## Setup

If you've just downloaded the code, congratulations!

To get it working, follow these steps:

**Install**

All the following are for development, replace `dev` by `prod` if you want prod

- Create the required image:

```bash
make php-image-dev
```

Now you can start your application!

```bash
make app-dev
```

You'll probably want to see logs for fpm:
```bash
docker-compose logs -f fpm
```

## Architecture and guidelines

This project completely decouples the front end and the back end

### Bounded Contexts

> A bounded context represents a **functional perimeter**. 
> This is where a model is implemented and reflects a language spoken by every member of the team. 
> Typically, a bounded context belongs to only one team and is decoupled from the others. 

#### What are our Bounded Contexts ?

- **Todo**: Here all our todo logics thing
- **ShareSpace**: Is not a real bounded context, it is the glue of our application and provides all the generic tools 
(please do no try to abstract everything, it is dangerous).

### Context map

> A context map defines how bounded contexts communicate and are integrated together.

TODO: explain the relations which exists

### Aggregates

According to Martin Fowler, "A DDD aggregate is a cluster of domain objects that can be treated as a single unit."
(https://martinfowler.com/bliki/DDD_Aggregate.html).

For most objects, the aggregate definition is pretty simple: a User is a single unit that has its own properties, like
the user name, the login, the password.

See http://www.cqrs.nu/Faq/aggregates for even more details.

 - Aggregate Root

"Any references from outside the aggregate should only go to the aggregate root. The root can thus ensure the integrity of the aggregate as a whole.", Martin Fowler.

 -  Transaction

When persisting all the parts of the aggregate, this must be done in one transaction. Indeed, if one object
of the aggregate cannot be persisted, then the whole aggregate must be rejected, as it's not valid anymore.

 - Accessing referenced objects outside of the aggregate

For objects that are not part of the aggregate, we reference them by their identifiers/
If a service needs to get the object behind the reference, it can use the associated repository.

### Backend

The back is in `back` folder and is build on top of PHP 7.3 using Symfony 4 and will follow a UseCase architecture.

All commands you can do are located in the Makefile, take time to read it :).

#### Dependencies

- For now, no database, we can work without.
- For now, no cache, it is clearly pre-matured.
- For now, no asynchronous (e.g RabbitMQ).

#### Use Case architecture

A use case architecture is an architecture which is resilient, scalable, and very important: focused on Use cases.

- Keywords: DDD, Hexagonal Architecture, Port and Adapters, CQRS, CQS
- People: Matthias Noback, Arnaud Lemaire, Thomas Pierrain, Greg young, Cyrille Martraire

It is represented like that (when needed of course):

```
src/
    Todo/ -> The bounded context
        Application/ -> All the use cases of the application
            .../
                Read/   -> All use cases for reading data, we call it Query
                    Query (e.g GetAllTodos) 
                        -> is a simple DTO immutable objet which represents the user intent
                        -> is what enters in the QueryBus
                    Query.yml -> is a way to validate the Query with SymfonyValidator
                    QueryHandler
                        -> is rarely asynchronous
                        -> is a service which handles the Query (1-1 relation)
                        -> it fetches the data (using a DomainQuery) 
                        -> it returns a result
                Write/  -> All use cases for mutating the application, we call it Command
                    Command (e.g AddTodo) 
                        -> is a simple DTO immutable objet which represents the user intent
                        -> is what enters in the CommandBus
                    Command.yml -> is a way to validate the Command with SymfonyValidator
                    CommandHandler
                        -> is often asynchronous
                        -> is a service which handles the Command (1-1 relation)
                        -> processes business mutation
                        -> returns nothing
        Domain/ -> Where our business objects stand
            .../
                Read/   -> All the DTO we can use for reading data in our business problem
                    -> It contains Reading object 
                    -> It contains interface for QueryingData (another kind of Query, let's call it DomainQuery)
                Write/  -> All the Entity/ValueObjects we can use for mutating data in our business problem
                    -> It contains RepositoryInterface (Write only), Factory, Types
        Infrastructure/ -> What is glueing the application and deal with the outside of the application
                Application/
                    -> What makes the glue works (e.g Framework etc)
                Storage/
                    -> What deals with data
                    -> We find real implementations of Query and Repositories
                    -> We find in_memory (fake) implementations of Query and Repositories
                UserInterface/
                    -> We find controllers (one controller per user action)
                    -> We find CLI things                      
```

##### Bus

In this kind of application, there is often buses ;). Here we use [Messenger](https://symfony.com/doc/current/components/messenger.html)

We have two buses used (stored in `ShareSpace/Tool/MessageBus`):
- CommandBus (1-1 Command - CommandHandler)
    - Returns the identifier of the aggregate root
    - Middlewares:
        - Validation middleware:
            - run validation on commands when they enter the bus
            - throw an exception
        - Identifier middleware:
            - provides an identifier (uuid) for command which needs it
            - stamps the envelope with this identifier
- QueryBus (1-1 Query - QueryHandler)
    - Returns the data queried
    - Middlewares:
        - Validation middleware:
            - run validation on queries when they enter the bus
            - throw an exception
            
##### Symfony Environments

- default: common for all other environments
- in_memory: no infrastructure dependencies (use only fakes)
- dev: like in_memory now
- prod: use the infrastructure, does not work for now

#### Code Quality

##### Static analysis

The code must pass all the analysis rules: `make back-static` or `make <your-bounded-context>-back-static`
You can disable some rules but only where it is red, not globally. It uses PHPStan, PSalm, PHP-CS-Fixer.

##### Tests because we love softwares which are working well not by magic <3

You are skeptical about tests? -> read [that](https://matthiasnoback.nl/2019/09/is-not-writing-tests-unprofessional/)

They are all located under `tests/`

It's better if you know how to do TDD, it makes a good way to have a minimalist application which is fully tested.
Here is an example on how to do TDD [here](https://github.com/42skillz/kata-TrainReservation/blob/master/RidMeOfThoseTestingPyramids.md)

What are our weapons?

- [Blackbox](https://github.com/Innmind/BlackBox/tree/master) is a generator of values and allow to do some Property based testing (PBT)
It could be used along with [Faker](https://github.com/fzaninotto/Faker). Look usages to understand.

- [PHPSpec](http://www.phpspec.net/en/stable/manual/introduction.html) is a specification framework
well designed for doing TDD.
```
Usage:

# Generate a specification (very good for TDD)
make todo-back-desc-spec F="the/path/to/your/non-existent-class"

# Run all the specs of a bounded context
make todo-back-run-spec

# Run specific tests of a bounded context
make todo-back-run-spec F="your/folder"
```

- [Behat](https://behat.org/en/latest/guides.html) is a story BDD framework, it is well designed for describing features
  - We use Behat for acceptance testing (meaning no Infrastructure dependencies) (tagged `@acceptance`)
  - We use Behat for end-to-end testing (meaning with Infrastructure dependencies) (tagged `@end-to-end`)
    - The use of Infrastructure has a significant time cost, only critical use cases may be tagged
  - It's harder to do TDD with it as it does not embed a generator
  - Behat uses feature files which are located next to `back` folder.
```
Usage:

# Run all the acceptance tests of a bounded context
make todo-back-acceptance

# Run specific acceptance tests of a bounded context
make todo-back-acceptance F="your/folder"

# Run all the end-to-end tests of a bounded context
make todo-back-end-to-end

# Run specific end-to-end tests of a bounded context
make todo-back-end-to-end F="your/folder"
```

#### Rules

- No useless setters and getters, avoid anemic domain models. Make then smart, rich!
- We should not be able to instantiate or mutates entities by making them invalid, throw as much exceptions as possible.
- Types, types and types. What is a string? nothing.
- Be immutable as much as possible
- No autoincrement id, it should stay in 80's we have uuid now

#### Libraries which help

- [Safe](https://github.com/thecodingmachine/safe) for throwing exceptions on unsafe operations
- [Ramsey/Uuid](https://github.com/ramsey/uuid) for having Uuid in PHP
- [ConvenientImmutability](https://github.com/matthiasnoback/convenient-immutability) for help making DTO
- [php-ds](https://github.com/php-ds/polyfill) for the lack of Collections in PHP
- [Webmozart/assert](https://github.com/webmozart/assert) for assertions on data

#### WebStorm (all idea based IDE) setup

You are of course free to use the ide you want, but here is the setup for all Jetbrains IDE

- [Symfony Plugin](https://plugins.jetbrains.com/idea/plugin/7219-symfony-plugin)
- [Configure Xdebug](./docs/xdebug.md)

#### Blackfire

- [Configure Blackfire](./docs/blackfire.md)

#### Troubleshooting

Error on composer install: the environment may not be working, try prefixing you command by APP_ENV=dev

