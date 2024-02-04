# Customer Management System
<p align="center">
 <img src="https://i.ibb.co/rpDYbhw/Customer-Management-System.png" alt="Customer-Management-System" border="0" width="100%">
</p>

## Table of Contents
- [Description](#description)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage) 
- [Contributing](#contributing)
- [Testing](#testing)
- [Documentation](#documentation)
- [License](#license) 
- [Acknowledgements](#acknowledgements) 
- [Demo](#demo) 
- [Contact Information](#contact-information)
- [Version History](#version-history)

![GitHub commit activity](https://img.shields.io/github/commit-activity/y/terrychitter/customer-management-system) ![GitHub repo size](https://img.shields.io/github/repo-size/terrychitter/customer-management-system)


## Description
This project is a customer management system for a fictional business that sanitizes dustbins.

The program is responsible for managing customers details such as personal, contact and sanitizing details.  Comments may be added for customers for administration use. Additionally, payment-related features can be used such as viewing the customers' current balance, payments made by the customer, and generated invoices for the customer. Customer accounts may also be deactivated or activated.

The payment section allows for administration to record payments made by customers. The payments page handles duplicate payments, balance updating, payment reversal, and other validation.

The invoice section allows for administration to generate invoices for customers and holds many searching and filtering features to quickly find the customer or group of customers the user is looking for. Invoices may be generated in batch and also allows the user to tweak certain dates on the invoice such as issue, fee, and brought-forward dates. Lastly, invoices for customers may be downloaded in batch for selected months.

The settings page allows administration staff to change or set certain features such as adding or removing bank details to display on customer invoices.

The project makes use of programming languages such as HTML5, CSS3, JavaScript, NodeJS and PHP. Additionally Bootstrap is used for styling.


## Installation
See below instructions to quickly set up and install the project. The project makes use of all frameworks below.
### Composer
 1. Ensure you have [Composer](https://getcomposer.org/) installed.
 2. Navigate to the project directory: `cd cms`.
 3. Install PHP dependencies: `composer install`.
### Node.js
 4. Ensure you have [Node.js](https://nodejs.org/) installed.
 5. Navigate to the project directory: `cd cms`.
 6. Install Node.js dependencies: `npm install`.
### Bootstrap
 7. Bootstrap can be added to your project in several ways: 
-**Using npm:**  ```bash npm install bootstrap```
-**Using yarn:** ```bash yarn add bootstrap```

## Configuration
### Config Folder
You will find a folder in the repository labelled `config`. It is important that you place this folder in the previous directory of the repository. The project has been set up this way as it is good security practice.
#### db_conn.php
The `db_conn.php` file holds the database connection. See the [installation](##Installation) regarding database set up. Ensure that the `db_conn.php` file holds the correct details to successfully connect to your database.

<div align="center">
<img src="https://i.ibb.co/DMqGj49/Snap.png" alt="Snap" border="0">
</div>

#### keys.php
The `keys.php` file holds additional keys used in the site. The `$secretLoginToken` is used as the login token when accessing the token and you may set this to whatever you like.

The `$recaptchaKey` should be the secret key for your Google reCaptcha. See [here](https://www.youtube.com/watch?v=i3Uq3-ulW-k) how to setup your Google reCaptcha for the site. Please ensure to use reCaptcha v2 – "I am not a Robot" Checkbox. **Note**: Unfortunately as of the current version there is no work around to the Google reCaptcha and I apologise for the inconvenience this may cause in testing the project.

<div align="center">
<img src="https://i.ibb.co/ZXdbyGr/Snap-3.png" alt="Snap-3" border="0">
</div>

### Other Configurations
Lastly, in addition to providing your secret key for Google reCaptcha, ensure to provide your public key [here]() in the project.

## Usage
## Contributing
## Testing
## Documentation
## License
## Acknowledgements
## Demo
## Contact Information
For any questions and support, contact me at t.sikenaris@gmail.com
## Version History
