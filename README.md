# PHP: Test-Driven Development with PHPUnit
https://www.linkedin.com/learning/php-test-driven-development-with-phpunit/how-to-use-the-exercise-files

Develop better software with less bugs, and save more time for developing new features, with test-driven development.

* [Objectives](#objectives)
* [Local setup](#local-setup)
* [Contributing](#contributing)
* [License](#license)

## Objectives
This course takes developers from writing their first unit test in PHPUnit to improving code coverage in their applications. Justin Yost covers writing test doubles to deal with dependencies in software, writing exception-based tests, and rapidly adding test cases to the core suite of unit tests. Developers will come away with a basic understanding of the test-driven development (TDD) cycle and understand how to use unit tests to write code, as well as refactor legacy code.

- Why use unit testing?
- Writing unit tests
- Extending unit tests
- Filtering PHPUnit tests
- Building dummy objects
- Working with data providers
- Writing an exception-based test
- Using TDD tactics
- Using PHPUnit advanced tactics, such as database tests

## Local setup
Follow the instructions to get the project up and running for local development and testing purposes.
- Install php 7.3 (7.1 EOL soon): https://php-osx.liip.ch/. 
- Configure the IDE CLI Interpreter to use php 7.3.
- Install composer (https://getcomposer.org/) and confirm the installation was successful by running: 
    ```
    composer --version
    ```
- Install phpunit, phpstan and roave security packages by running the following (from the project root):
    ```
    make install
    ```
- Configure the IDE Test Framework: https://www.jetbrains.com/help/phpstorm/using-phpunit-framework.html.
- The project already provides a phpunit configuration template that will be used when running tests via the Makefile. 
Add a replica of the tests run configuration in the IDE for easier development.

## Contributing
[![Contributor Covenant](https://img.shields.io/badge/Contributor%20Covenant-v2.0%20adopted-ff69b4.svg)](.github/CONTRIBUTING.md)

## License
[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](LICENSE.md)


