Webgriffe Triveneto PHP library
==========================================

[![Run Status](https://travis-ci.org/webgriffe/lib-triveneto.svg?branch=master)](https://travis-ci.org/webgriffe/lib-triveneto)

This library is tasked with providing a higher lever access to the Consorzio Triveneto payment gateway. It was developed following the technical documentation provided by Consorzio Triveneto (version 1.1.1 released in January 2017).

Installation
------------

In order to use this library, first of all import it using composer:

```
composer require webgriffe/lib-triveneto
```

Usage
-----

Then you can start using the library in your code. To do so start by instantiating a Webgriffe\LibTriveneto\Client object:

```php
$client = new \Webgriffe\LibTriveneto\Client($logger);
```

where *$logger* is an optional instance of a logger that the library will use to log relevant information.

After that, initialize the client by calling

```php
$client->init($tranPortalId, $password, $initUrl, $action, $secretKey);**
```

where *$tranPortalId* is the merchant id provided by Consorzio Triveneto, *$password* is the password provided by Consorzio Triveneto, *$initUrl* is the gateway URL that is used to initialize the payment operation, *$action* defines the payment action (1 for "purchase" action, 4 for "authorize" action) and *$secretKey* is an arbitrarily chosen security key that is used to perform an additional security check on the received payment confirmation.
The *$initUrl* param can be either *https://ipg.constriv.com/IPGWeb/servlet/PaymentInitHTTPServlet* for Trivento's production environment or *https://ipg-test4.constriv.com/IPGWeb/servlet/PaymentInitHTTPServlet* for Triveneto's test environment. Please notice that it may be necessary to use specific values for *$tranPortalId* and *$passowrd* depending on which environment is being used (test or production), so make sure to use the correct values for these variables when switching from one environment to the other.
The *$secretKey* variable should contain a value that is randomly generated once and then passed unaltered every time the library is instanciated. For example, his value may be generated in an installation script of the component that used this library and the generated value may be saved in the database every time the library needs to be invoked. It is important to pass the same value in this variable when initiating the payment and when checking the payment notification that is sent by Consorzio Triveneto, otherwise the library will report an error saying that the signature doesn't match.

After the library has been initialized, it's possible to perform two main operations: either initiate a new payment or verify the outcome of a previously initiated payment.
To initiate a new payment you must call the paymentInit method:

```php
$client->paymentInit($merchantTransactionId, $amount, $currencyCode, $languageId, $notifyUrl, $errorUrl);
```

The *$merchantTransactionId* variable must contain a merchant reference of the transaction, such an order number or the like; *$amount* is the payment amount in Euro (the only currency currently supported by Consorzio Triveneto); please notice that this value cannot have more than 2 decimal places; *$currencyCode* must be 978 (Euro, the only allowed currency); *$languageId* must be the code of one of the supported languages (see below); *$notifyUrl* must contain the URL that Triveneto will use to notify the outcome of the transaction and *$errorUrl* must contain an URL that the customer will be redirected to if an error occurs.
For the *$languageId* variable the list of allowed values is: ITA USA FRA DEU ESP SLO SRB POR RUS.
The result of this call (unless an exception is thrown) is a Webgriffe\LibTriveneto\PaymentInit\Result object containing the payment id generated by Triveneto and URL that the customer should be redirected to in order to complete the payment.

After the customer reaches this page and completes the payment form (or cancels the payment), Triveneto will perform a server to server call to the notify URL specified in the argument to the paymentInit() function. The list of request parameters that were sent together with this server to server call should be packed into an associative array and passed to the paymentVerify() method:

```php
$client->paymentVerify($requestParams);
```

where *$requestParams* is an associative array containing all of the request params:

```php
$requestParams = array('paymentid' => ..., 'tranid' => ..., 'result' => ..., etc...);
```

Again, unless an error occurs and an exception is thrown, then this call will return an instance of Webgriffe\LibTriveneto\NotificationMessage\Result\NotificationResultInterface
The concrete type of this object can be either Webgriffe\LibTriveneto\NotificationMessage\Result\NotificationErrorResult if a serious error occurred (the error code and message are contained in the object) or an instance of Webgriffe\LibTriveneto\NotificationMessage\Result\NotificationResult.
In the latter case it's necessary to check the getIsSuccess() and getIsPending() methods to assess if the response is actually reporting a succesful transaction. Indeed this result object is also used to indicate that the gateway did not authorize a transaction, so the use of these methods is necessary. It is also possible to check the raw result using the getResult() method if needed. In addition, all other request parameters are packed in this object and can be accessed through a series of getter methods.
In any case the server must return a response to Triveneto when this server to server request is received. In order to build this response it's possible to use the Webgriffe\LibTriveneto\NotificationMessage\Response\GeneratorFactory object:

```php
$factory = new Webgriffe\LibTriveneto\NotificationMessage\Response\GeneratorFactory($result, $successUrl, $errorUrl);
$response = $factory->getGenerator()->generate();
```

where *$result* is the object that was returned by the call to paymentVerify(), *$successUrl* is the URL that the customer must be redirected to if the verification outcome is succesful and *$errorUrl* is the URL that the customer must be redirected to if the payment verification outcome is not succesful. *$response* will then be filled with the raw response that must be sent back to Triveneto in order to redirect the customer to the desired URL.
In this case "succesful" means that $result must be an instance of NotificationResult and that at least one of the getIsSuccess() and getIsPending() methods must return true.

Please notice that even though a *$merchantTransactionId* field is provided, this value is NOT returned by Triveneto in case of error. The only identifier that is always present is the payment id, so it's recommended to use this value to uniquely identify the payment.

Contributing
------------

Fork this repository, make your changes and submit a pull request.
Please run the tests and the coding standards checks before submitting a pull request. You can do it with:

```
vendor/bin/phpspec run
vendor/bin/phpcs --standard=PSR2 src/
```

Credits
-------

Developed by [Webgriffe®](http://www.webgriffe.com/).
