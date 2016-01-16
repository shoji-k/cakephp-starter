<?php
App::uses('Post', 'Model');

/**
 * Post Test Case
 */
class PostTest extends CakeTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.post'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->Post = ClassRegistry::init('Post');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Post);
        parent::tearDown();
    }

    /**
     * @dataProvider exampleValidationErrors
     */
    public function testValidationError($column, $value, $message) {
        $default = ['title' => 'sample', 'body' => 'abc'];
        $this->Post->create(array_merge($default, [$column => $value]));
        $this->assertFalse($this->Post->validates());
        $this->assertEquals([$message], $this->Post->validationErrors[$column]);
    }

    public function exampleValidationErrors() {
        return [
            ['title', '', 'Input title.'],
            ['title', str_pad('', 256, "a"), 'Input title in 255 characters or less.'],
            ['body', '', 'Input body.'],
            ['body', str_pad('', 256, "a"), 'Input body in 255 characters or less.'],
        ];
    }

}
