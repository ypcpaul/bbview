<?php
include __DIR__ . '/../src/BBView.php';

use tunalaruan\bbview\BBView;

class BBViewTest extends PHPUnit_Framework_TestCase
{
    public static function setupBeforeClass()
    {
        $content = '<?php
echo $testVariable;';
        file_put_contents(__DIR__ . '/testview.php', $content);
    }

    public function testGenerate()
    {
        $bbview = new BBView(__DIR__ . '/testview.php', ['testVariable' => 'hello']);
        $result = $bbview->generate(true);
        $this->assertEquals('hello', $result);

        ob_start();
        $bbview->generate();
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('hello', $content);
    }

    public function testInsert()
    {
        $bbview = new BBView(__DIR__ . '/testview.php');

        $content = 'hi';
        file_put_contents(__DIR__ . '/testview2.php', $content);

        $bbview->insert(new BBView(__DIR__ . '/testview2.php'), 'testVariable');
        $contents = $bbview->generate(true);
        $this->assertEquals('hi', $contents);

        unlink(__DIR__ . '/testview2.php');
    }

    public static function tearDownAfterClass()
    {
        unlink(__DIR__ . '/testview.php');
    }
}
