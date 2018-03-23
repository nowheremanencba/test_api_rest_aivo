<?php
  
    $app->get('/facebook/[{id}]', function ($request, $response, $args) {
         $id     = $request->getAttribute('id');
        try{ 
              //Buscar el usuario en facebook api
              $config['App_ID']      =   '166419427280612';
              $config['App_Secret']  =   '7a54e597ef5162a765c9d08ee96f7952';
             
              $token = $config['App_ID']."|".$config['App_Secret'];  

              $json = @file_get_contents('https://graph.facebook.com/'.$id.'?fields=first_name,last_name&access_token='.$token);
              
              $userDetails = json_decode($json); 
              //Si existe el usuario insertar/actualizar en la bd  
               if ($userDetails) {
                    $sth = $this->db->prepare("SELECT * FROM users WHERE id=:id");
                    $sth->bindParam("id", $args['id']);
                    $sth->execute();
                    $user = $sth->fetchObject();

                    $con = $this->db;
                    $id = $userDetails->id;
                    $nombre = $userDetails->first_name;
                    $apellidos = $userDetails->last_name;   

                   if($user){ 
                        //actualizar Usuario
                        $sql = "UPDATE users SET first_name=:name,last_name=:last_name WHERE id = :id";
                        $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                        $values = array(
                        ':name' => $nombre,
                        ':last_name' => $apellidos, 
                        ':id' => $id
                        );
                        $result =  $pre->execute($values);
                        if($result){
                               return $response->withJson(array('status' => 'true','User Updated'=> $userDetails),200);
                        }else{
                               return $response->withJson(array('status' => 'User Not Updated'),422);
                        }
                    }else{
                        //agregar Usuario  
                        $sql = "INSERT INTO `users`(`id`,`first_name`, `last_name`) VALUES (:id,:first_name,:last_name)";
                        $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                        $values = array(
                        ':id' => $id,
                        ':first_name' => $nombre,
                        ':last_name' => $apellidos
                        );
                        $result = $pre->execute($values);
                        if($result){
                            return $response->withJson(array('status' => 'true','User New'=> $userDetails),200);
                        }else{
                            return $response->withJson(array('status' => 'User Not Updated'),422);
                        }
                    }
               } else{
                        return $response->withJson(array('status' => 'User Not Found'),422);
               } 
        }
        catch(\Exception $ex){
            return $ex->getMessage();
        }
        return $response ;
    });