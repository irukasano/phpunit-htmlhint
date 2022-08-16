# phpunit-htmlhint

![phpunit](https://github.com/irukasano/phpunit-htmlhint/actions/workflows/phpunit.yml/badge.svg)

add assertion of phpunit with htmlhint.

```php
$this->assertHtmlhintOk("<!DOCTYPE html><h1>Hello<div></h1>");
```

will failed because "div" tag must be paired.(message by htmlhint)

## install

install this library,

```bash
$ composer require irukasano/phpunit-htmlhint
```

and also needs to install [htmlhint](https://htmlhint.com/docs/user-guide/getting-started)

```bash
$ sudo apt install nodejs npm
$ sudo npm install n -g
$ sudo n stable
$ sudo npm install htmlhint -g
```

## usage

### cakephp3

in your testcase ( ex. tests/TestCase/PagesControllerTest.php ), 

```php
use PHPUnitHmtlhint\LintTestTrait;

class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;
    use LintTestTrait;

    public function test()
    {
        $this->get('/');
        $html = $this->_response->getBody();
        $this->assertHtmlhintOk($html);
    }
}

```
