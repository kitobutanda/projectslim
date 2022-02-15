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
$app->get('/products',function(Request $request,Response $response, array $params)use ($db){
    // var_dump(' la liste des produits');
    $stmt=$db->query('select * from products');
    $rs=$stmt->fetchAll();
    echo(json_encode($rs));

});

$app->post('/products',function(Request $request,Response $response, array $params)use ($db)
{

    $body=$request->getbody();
    $data = json_decode($body,true);
    $name=$data['name'];
    $description=$data['description'];
    $price=$data['price'];
// $name=$request->getparam('name');
// $designation=$request->getparam('designation');
// $price=$request->getparam('price');

$stmt=$db->prepare("INSERT INTO products(name,description,price) VALUES(:name,:description,:price)");
$stmt->execute([
    'name'=>$name,
    'description'=>$description,
    'price'=>$price

]);

});

// $app->get('/products/{id}',function(Request $request,Response $response, array $params){
//  var_dump('le parametre est',$params['id']);

// });
$app->put('/products/{id}',function(Request $request,Response $response, array $params)use ($db)
{
    $body=$request->getbody();
    $data = json_decode($body,true);
    $name=$data['name'];
    $description=$data['description'];
    $price=$data['price'];
$id=$params['id'];

$stmt=$db->prepare("UPDATE  products SET name=:name,description=:description,price=:price WHERE id=:id");
$stmt->execute([
    'name'=>$name,
    'description'=>$description,
    'price'=>$price,
    'id'=>$id

]);
echo('modification recu a l"indice :' .$id);

});

$app->delete('/products/{id}',function(Request $request,Response $response, array $params)use ($db)
{
// $name=$request->getparam('name');
// $designation=$request->getparam('designation');
// $price=$request->getparam('price');
$id=$params['id'];

$stmt=$db->prepare("DELETE   FROM products  WHERE id=:id");
$stmt->execute([

    'id'=>$id

]);
echo('supression reussi avec succes le produit:' .$id);

// echo('vous envoyer :' .$name .$designation  .$price);
});
$app->post('/Personnes',function(Request $request,Response $response, array $params)use ($db)
{
    $body=$request->getbody();
    $data = json_decode($body,true);
    $noms=$data['noms'];
    $sexe=$data['sexe'];
    $age=$data['age'];


$stmt=$db->prepare("INSERT INTO Personnes(noms,sexe,age) VALUES(:noms,:sexe,:age)");
$stmt->execute([
    'noms'=>$noms,
    'sexe'=>$sexe,
    'age'=>$age

]);
});
$app->run();



