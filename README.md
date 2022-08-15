# phpunit-htmlhint

add phpunit assertion by htmlhint

## install

composer require irukasano/phpunit-htmlhint

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
