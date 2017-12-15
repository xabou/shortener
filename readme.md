
# URL Shortener

Shortener is a, Slim framework-based, URL shortening microservice that encapsulates third-party services to provide said functionality.  

Currently, two providers are supported, Google and Bitly.

## Getting Started

These instructions will get you the project up and running on your local machine for development and testing purposes.

### Prerequisites

* Apache2
* PHP >= 7.0.0

Finally, Shortener utilizes [Composer](https://getcomposer.org/) to manage dependencies. So make sure you have Composer installed on your machine.

### Installation

1. Add a new entry in your `hosts` file. Hosts file can be found in `/etc` directory in Linux\OSX.

    ```text
    127.0.0.1	www.shortener.dev
    ```

2. Move the project in the `/var/www/html` directory and add a new virtual host in your apache2. 

    ```text
    <VirtualHost *:80>
         <Directory /var/www/html/shortener/public>
                        AllowOverride All
         </Directory>
        ServerName www.shortener.dev
        ServerAlias shortener.dev
        DocumentRoot /var/www/html/shortener/public
    </VirtualHost>
    ```
    
3. Reload the apache2 configuration

    ```bash
    systemctl reload apache2
    ```
4. You might have to give some permissions if your local machine is running on Linux\OSX.

    ```bash
    sudo chmod 777 -R logs cache
    ```
    
## Configuration

#### Api Key
In order to start using the Google Shortener API you must obtain first a
[Google API key](https://developers.google.com/url-shortener/v1/getting_started#APIKey).
 
#### Access Token
Moreover, uou will need to create a [Bitly Access token](https://dev.bitly.com/authentication.html).

After getting the required credentials update the `key` entries in [config/providers.php](config/providers.php).

```php
    'google' => [
        'url' => 'https://www.googleapis.com/urlshortener/v1/url',
        'key' => 'YOUR_API_KEY'
    ],
```
    
## Running the tests

Run the tests from the project root.

```bash
vendor/bin/phpunit tests
```
## Design

Shortener utilizes various components on top of the Slim framework. Each component has a single responsibility. 

### Entry point

The [public/index.php](public/index.php) file is the entry point of the application. This is the place where the composer autoloader and 
the bootstrapping are registered. Finally, once we have the application ready we can handle the incoming request. 

The [bootstrap/app.php](bootstrap/app.php) file is where we bootstrap the framework. There are some important steps happening here that 
will get the application ready for use.

1. Create the Slim application
2. Set the container configuration
3. Register various dependencies, defined in [bootstrap/dependencies.php](bootstrap/dependencies.php)
4. Register routes, defined in [app/routes.php](app/routes.php)
5. Register controller, located in `app/Controllers` directory

### Services

This is the place where we get to define how each service, required by the application, is registered to the container.
Each service is a class responsible for choosing the desired implementation, instantiating it and finally returning it. 
As we mentioned earlier these implementations are registered to the container in the `bootstrap/dependencies.php` file.
Currently the services provided are:

1. The [ConfigurationService](app/Services/ConfigurationService.php) for loading config files 
2. The [LoggingService](app/Services/LoggingService.php) for reporting errors
3. The [ValidationService](app/Services/ValidationService.php) for validating request data
4. The [HttpClientService](app/Services/HttpClientService.php) for sending HTTP requests
5. The [ErrorHandlingService](app/Services/ErrorHandlingService.php) for handling exceptions
6. The [ShorteningService](app/Services/ShorteningService.php) for registering shortening providers
7. The [CachingService](app/Services/CachingService.php) for caching responses from external services

### Providers

This is the place where the providers of third-party shortening services live. Each provider defines the logic for 
building the request, hitting the API of the external service and returning the result back to the caller. 
This communication is achieved by the HttpClient registered via the `HttpClientService`. When a request to an external
shortening service fails a `GuzzleException` is thrown.
Currently the third-party services provided are:

1. The [GoogleProvider](app/Providers/GoogleProvider.php) for [Google](https://developers.google.com/url-shortener/) 
   service
2. The [BitlyProvider](app/Providers/BitlyProvider.php) for [Bitly](https://dev.bitly.com/api.html) 
   service 

### Middleware

There is only one middleware within this application and it is responsible for validating the request data. This 
middleware is attached to the single route provided, and uses the Validator registered via the `ValidationService`. 
When a request fails to pass validation a `ValidationException` is thrown.

### Exception Handler

The [Handler](app/Exceptions/Handler.php) class is responsible for reporting and rendering the exceptions. The reporting
uses the Logger registered via `LoggingService` while the rendering creates an HTTP response for the 
`ValidationException` and the `GuzzleException`. Under the hood we are registering, via the `ErrorHandlingService`, 
a custom error handler to override the default error handler of the framework.

### Controller

The only available controller is the `ShorteningController`. Every request hitting this controller has already been
validated. Moreover, the appropriate provider has already been instantiated via the `ShorteningService`.
The only step left is to return the response back to the user.

##License

This package is released under the MIT License.
