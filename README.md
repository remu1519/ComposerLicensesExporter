# ComposerLicensesExporter

ComposerLicensesExporter is a PHP script that extracts and outputs the list of dependencies and their license information from a `composer.lock` file into a CSV format.

## Features

- Reads the list of dependencies from `composer.lock`.
- Analyzes license information for each package.
- Outputs this information into a `licenses.csv` file.

## Usage

To use this script, follow these steps:

1. Clone or download this repository.
2. Navigate to the directory containing the script via command line.
3. Run the script with `php license.php`.

Upon execution, the script will analyze the `composer.lock` file in the same directory and generate a `licenses.csv` file.

## Requirements

- PHP 7.0 or higher

## License

This project is open-sourced under the [MIT License](LICENSE).

## Contributing

Feedback, bug reports, and pull requests are always welcome!
