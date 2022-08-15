# phpunit-htmlhint

add phpunit assertion by htmlhint

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
