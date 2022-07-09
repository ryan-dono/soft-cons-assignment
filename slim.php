<?php
require 'vendor/autoload.php';
require 'db.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

$app = new \Slim\App;

//PUT - update/modif user based on id
$app->put('/user/{id}',function($request, $response, $args){
    $id = $args['id'];
    //connect to database
    //sql update based on id etc....
    //return the status update berjaya/tidak, as a response

});

//DETELE
$app->delete('/user/{id}',function($request, $response, $args){
    $id = $args['id'];
    //connect to database
    //sql delete based on id etc....
    //return the status delete berjaya/tidak, as a response
    $response->getBody()->write("this operation will delete user with id : $id");

    return $response;
});

////GET - endpoints, api for the get requests
$app->get('/', function ($request,  $response, $args) {
    $response->getBody()->write("this is the root directory");

    return $response;
});

$app->get('/hello/{name}', function ($request,  $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/user', function ($request,  $response, $args) {
    // $response->getBody()->write("this will return all users");
    // return $response;

    $sql = "SELECT * FROM user";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);
    }catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

$app->get('/user/{id}', function ($request,  $response, $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM user WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
    
        $stmt = $db->query($sql);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e){
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
    // $response->getBody()->write("this will return single user with id : $id");
    // return $response;
});

// part that i add for assignment4
$app->get('/video_path', function ($request,  $response, $args) {
    // $response->getBody()->write("this will return all users");
    // return $response;

    $sql = "SELECT * FROM question1";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user, JSON_PRETTY_PRINT);

    }catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

$app->get('/participants', function ($request,  $response, $args) {
    // $response->getBody()->write("this will return all users");
    // return $response;

    $sql = "SELECT * FROM question1_participants";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);

    }catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

$app->delete('/participants/delete/{name}',function($request, $response, $args){
    $name = $args['name'];
    //connect to database
    $db = new db();
    $db = $db->connect();

    //sql delete based on id etc....
    $sql = "DELETE FROM question1_participants WHERE name='$name'";
    $stmt = $db->query($sql);
    //return the status delete berjaya/tidak, as a response
    $response->getBody()->write("this operation will delete user with name : $name");

    return $response;
});

$app->put('/participants/add/{name}',function($request, $response, $args){
    $name = $args['name'];
    //connect to database
    $db = new db();
    $db = $db->connect();

    //sql delete based on id etc....
    $sql = "INSERT INTO question1_participants (name) VALUES ('$name')";
    $stmt = $db->query($sql);
    //return the status delete berjaya/tidak, as a response
    $response->getBody()->write("this operation will add user with name : $name");

    return $response;
});

$app->post('/addForm',function($request, $response, $args){
    //connect to database
    $db = new db();
    $db = $db->connect();
    //sql insert etc....
    $name = $request->getParam('name');
    $id = $request->getParam('id');

// $inputJSON = file_get_contents('php://input');
// $input = json_decode($inputJSON, TRUE);
// $name = $input["name"];


    try {
        $sql = "INSERT INTO question1_participants (id, name) VALUES ('$id', '$name')";
        $stmt = $db->query($sql);
        $count = $stmt->rowCount();
        $db = null;
    
        $data = array(
            "status" => "success",
            "rowcount" =>$count
        );
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
        echo $name.$id;
    }
        

    //return the status insert berjaya/tidak, as a response
    // $response->getBody()->write("this operation will insert user ti database table");
    // return $response;
});

$app->post('/deleteForm',function($request, $response, $args){
    //connect to database
    $db = new db();
    $db = $db->connect();
    //sql insert etc....
    $name = $request->getParam('name');
    // $name = $_POST['name'];


    try {
        $sql = "DELETE FROM question1_participants WHERE name='$name'";
        // $db = new db();
        // // Connect
        // $db = $db->connect();
        $stmt = $db->query($sql);
        // $stmt->bindValue(':name', $name);
        
        // $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;
    
        $data = array(
            "status" => "success",
            "rowcount" =>$count,
            
        );
        
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }

});



// end of part that i add

///POST - add a single user record
$app->post('/user',function($request, $response, $args){
    //connect to database
    //sql insert etc....
// $name = $_POST["name"];
// $id = $_POST["postuserid"];
// $email = $_POST["email"];
// $post = $_POST["post"];

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);
$name = $input["name"];
$id = $input["id"];
$email = $input["email"];
$post = $input["post"];


    try {
        $sql = "INSERT INTO user (name,id,email,post) VALUES (:name,:id,:email,:post)";
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':post', $post);
    
        $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;
    
        $data = array(
            "status" => "success",
            "rowcount" =>$count
        );
        echo json_encode($data);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
        


    //return the status insert berjaya/tidak, as a response
    // $response->getBody()->write("this operation will insert user ti database table");
    // return $response;
});


$app->run();