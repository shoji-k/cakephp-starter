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
            'components' => ['Paginator', 'Flash'],
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


    public function testAddアクションで保存が失敗したときメッセージがセットされること() {
        $this->controller->Post->expects($this->once())
            ->method('save')->will($this->returnValue(false));
        $this->controller->Flash->expects($this->once())
            ->method('__call')->with($this->equalTo('error'));

        $this->testAction('/posts/add',
            ['method' => 'post', 'data' => ['title' => 'Title1', 'body' => 'Body1']]
        );
    }

    public function testAddアクションで保存が成功したときはメッセージがセットされ一覧表示にリダイレクトされること() {
        $this->controller->Post->expects($this->once())
            ->method('save')->will($this->returnValue(true));
        $this->controller->Flash->expects($this->once())
            ->method('__call')->with($this->equalTo('success'));
        $this->controller->expects($this->once())
            ->method('redirect')->with($this->equalTo(['action' => 'index']));
        $this->testAction('/posts/add', ['method' => 'post', 'data' => ['title' => 'Title1', 'body' => 'Body1']]);
    }
}
