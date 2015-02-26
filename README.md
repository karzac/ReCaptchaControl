reCAPTCHA for Nette Framework
=============================

* Official documentation: https://developers.google.com/recaptcha/
* Forum (CZE): http://forum.nette.org/cs/21770-nova-recaptcha-pro-formulare


Installation
------------

```
composer require "uestla/recaptcha-control" 2.*
```


Usage
-----

**config.neon**

```
extensions:
	reCaptcha: ReCaptchaControl\ReCaptchaExtension

reCaptcha:
	siteKey: '<your_site_key>'
	secretKey: '<your_secret_key>'
	methodName: 'addReCaptcha' # optional
```


**Form**

```php
$form->addReCaptcha('captcha')
		->addRule(ReCaptchaControl::VALID, 'Incorrect text code.');
```


**Template**

The most robust way to render reCAPTCHA is to do it by hand. Take a look
at [recaptcha.js](client-side/recaptcha.js) where this is done using jQuery.
So if you are using jQuery on your site, you can load this script after
you've loaded jQuery.

And that's it!
