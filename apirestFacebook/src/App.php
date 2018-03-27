<?php
namespace Test\InfoProfileAPI;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
class App
{
    /**
     * Stores an instance of the Slim application.
     *
     * @var \Slim\App
     */
    private $app;
    public function __construct() {
        $app = new \Slim\App;
        
        $app->get('/', function (Request $request, Response $response) {
            $response->getBody()->write("Hola Test");
            return $response;
        });
        $app->group('/profile/facebook', function () {
            $todoIdValid = function ($id) {
                return (int)$id && $id > 0;
            }; 
            $this->get('/{id}', function (Request $request, Response $response, $args) use ($todoIdValid) {
                if($todoIdValid($args['id'])) {
				  $id     = $request->getAttribute('id');
				  //Buscar el usuario en facebook api
				  $config['App_ID']      =   '166419427280612';
				  $config['App_Secret']  =   '7a54e597ef5162a765c9d08ee96f7952';
				 
				  $token = $config['App_ID']."|".$config['App_Secret'];  

				  $json = @file_get_contents('https://graph.facebook.com/'.$id.'?fields=first_name,last_name&access_token='.$token);
				  
				  $userDetails = json_decode($json);  
				  if ($userDetails) { 
					   $idFound = $userDetails->id;
						//validar si existe en la bd para insertar o actualizar
					   if($idFound != 1084994699){ //  Si existe el id en bd 
							 return $response->withJson(['message' => "Profile Facebook updated successfully"]);
						}else{//  Si no exista el id en bd
							return $response->withJson(['message' => "Profile Facebook saved successfully"]);
						}  
						return $response->withJson(['message' => "Profile Facebook saved successfully"]);
				  }else{ 
						return $response->withJson(['message' => 'Profile Facebook Not Found'], 404);    
				  }
                      
                }
                return $response->withJson(['message' => 'Profile Facebook Not Found'], 404);    
            });  
			 
        });
        $this->app = $app;
    }
    /**
     * Get an instance of the application.
     *
     * @return \Slim\App
     */
    public function get()
    {
        return $this->app;
    }
}
 