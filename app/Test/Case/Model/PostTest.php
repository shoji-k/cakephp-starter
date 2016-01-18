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

    public function test一覧表示時は5件で新しい順である() {
        for($i = 0; $i < 10; $i++) {
            $this->Post->create();
            $this->Post->save(['Post' =>
                ['id' => false, 'title' => 'user1 post', 'body' => 'sample']
            ]);
        }
        $actual = $this->Post->find('all', $this->Post->getPaginateSettings());
        $this->assertCount(5, $actual);
        $this->assertEquals([10, 9, 8, 7, 6], Hash::extract($actual, '{n}.Post.id'));
        $this->assertEquals('user1 post', $actual[0]['Post']['title']);
    }

}
