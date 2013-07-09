webunit
=======

Yii PHPUnit web interface

It's first alpha version, but you can use it now. It does not require PHPUnit installed

Install
=======
1. Clone the code
```
cd protected/extensions
git clone git@github.com:megahertz/webunit.git
```
2. Add extension to your application config
```php
    ...
	'modules' => [
		'gii' => [
			...
		],

		'webunit' => [
			'class' => 'ext.webunit.WebunitModule',
			'password' => 'password',
			'ipFilters' => ['127.0.0.1', '::1'],
			'pathUnitTests' => 'application.tests.unit', // optional
			'pathWebTests' => 'application.tests.functional' // optional
		]
	],
	...
```
3. Go to http://you-app.url/webunit


The original idea http://mattmueller.me/blog/phpunit-test-report-unit-testing-in-the-browser
