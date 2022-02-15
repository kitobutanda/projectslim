<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require './src/connexion.php';
$app = new \Slim\App;

$app-> get('/test',function(Request $request,Response $response, array $params){
    echo('hello juditth');
});
//pour afficher les elements de la table dans l'api
$app->get('/personnes',function(Request $request,Response $response, array $params)use ($db){
   
    $stmt=$db->query('select * from personnes');
    $rs=$stmt->fetchAll();
    echo(json_encode($rs));
    echo("affichage ressi" .$noms .$sexe .$age);

});


$mw= function($request,$response,$next){
 
    $body=$request->getBody();
    $data = json_decode($body,true);

    if($data['age']<=0) 
    {
  $response->getBody()->write('age not correct');
    }
    else
    {
        $response=$next($request,$response);
        

    }
    return $response;
};


$app->post('/personnes',function(Request $request,Response $response, array $params)use ($db)
{
    $body=$request->getbody();
    $data = json_decode($body,true);
    $noms=$data['noms'];
    $sexe=$data['sexe'];
    $age=$data['age'];

$stmt=$db->prepare("INSERT INTO personnes (noms,sexe,age) VALUES (:noms,:sexe,:age)");
$stmt->execute([
    'noms'=>$noms,
    'sexe'=>$sexe,
    'age'=>$age

]);
echo('insertion reusi');
})->add($mw);
$app->run();



