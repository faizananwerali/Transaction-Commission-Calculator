# Transaction Commission Calculator

The Transaction Commission Calculator is a tool that can be used to calculate the commission for any type of transaction. It is a versatile tool that can be used by merchants, businesses, and individuals.

The Transaction Commission Calculator is easy to use. Simply enter the amount of the transaction, the currency, and the country of the transaction. The calculator will then calculate the commission and display it on the screen.

The Transaction Commission Calculator is a valuable tool for anyone who needs to calculate the commission for a transaction. It is accurate, easy to use, and versatile.

## Project Info
This project for the Transaction Commission Calculator is for the Job Test at TECIZ EVERYTHING.
See here for the [Test Info](https://github.com/TecizEverything/PHP_Test01/blob/Development/Task%20-%20PHP%20-%20Refactoring.md).

## Features

* Calculates the commission for any type of transaction
* Easy to use
* Versatile

## Requirements

PHP 8.1 or higher
Composer

## Installation

* Clone the repository.
* Run `composer install`.
* Copy `.env.example` to `.env`.
* Make sure to update the environment variables in `.env` file.

## Tests

* Run `composer test`

## Usage

1. Enter the amount of the transaction, the currency of the transaction, the country of the transaction in JSON Format, in a single line, in txt file.
2. Run `php index.php /path/to/input.txt` or `php index.php tests/App/test_files/input.txt`

### Example

* input.txt file
```
{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
{"bin":"41417360","amount":"130.00","currency":"USD"}
{"bin":"4745030","amount":"2000.00","currency":"GBP"}
```

### Result
```
1
0.47
1.36
2.4
45.89
```

## Contact
If you have any questions or feedback, please contact me at my email address.