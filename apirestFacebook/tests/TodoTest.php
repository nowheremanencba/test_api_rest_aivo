<?php 
use Test\InfoProfileAPI\App;
use Slim\Http\Environment;
use Slim\Http\Request;
class TodoTest extends PHPUnit_Framework_TestCase
{
    protected $app;
    public function setUp()
    {
        $this->app = (new App())->get();
    } 
    public function testGetProfile() {
        $id = 1084994699 ; // My ID Facebook Profile: Cristian Ortega
		 
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/profile/facebook/'.$id,
            'CONTENT_TYPE'   => 'application/x-www-form-urlencoded',
        ]);
        $req = Request::createFromEnvironment($env)->withParsedBody([]);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
        $this->assertSame($result["message"], "Profile Facebook saved successfully");
    }  
}
 