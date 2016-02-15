webunit
=======

The UI for using PHPUnit with Yii 1. It doesn't require the installed PHPUnit 

Install
=======
1. Download [the webunit extension](https://github.com/megahertz/webunit/archive/v0.1.0.zip)

2. Extract to protected/extensions

3. Add extension to your application config
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
    
4. Go to the http://you-app.url/index.php?r=webunit

The original idea http://mattmueller.me/blog/phpunit-test-report-unit-testing-in-the-browser
