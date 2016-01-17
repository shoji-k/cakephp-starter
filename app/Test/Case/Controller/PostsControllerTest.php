<?php
App::uses('PostsController', 'Controller');

/**
 * PostsController Test Case
 */
class PostsControllerTest extends ControllerTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.post'
    );

    public function setUp() {
        parent::setUp();
        $this->controller = $this->generate('Posts', [
            'components' => ['Paginator', 'Session'],
            'models' => ['Post' => ['save']],
            'methods' => ['redirect']
        ]);
        $this->controller->autoRender = false;
    }


    public function testIndexアクションではページングの結果がpostsにセットされること() {
        $data = ['Post' => ['title' => 'sample', 'body' => 'blaaah']];
        $this->controller->Paginator->expects($this->once())
            ->method('paginate')->will($this->returnValue($data));
        $vars = $this->testAction('/posts', ['method' => 'get', 'return' => 'vars']);
        $this->assertEquals($data, $vars['posts']);
    }

}
