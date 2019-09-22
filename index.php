<?php>
//open localhost url
print_r($_POST);
$verb = $_SERVER["REQUEST_METHOD"];

if($verb == "GET"){
  echo "GET HERE REQ";
} else if($verb == "POST"){
  echo "OH YEA POSTMAN";
} else {
  echo "USAGE GET or POST";
}

?>
