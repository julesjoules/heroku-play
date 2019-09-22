<?php>
//open localhost url
print_r($_POST);
$verb = $_SERVER["REQUEST_METHOD"];

if($verb == "GET"){
  echo "GET HERE REQ";
} else if($verb == "POST"){
  //set constants
  $author = "anonymous";
  $content = "shakespeare was a fake";
  echo "OH YEA POSTMAN";//default  message
  if(isset($_POST["author"])){
    $author = $_POST["author"];
  }
   if(isset($_POST["content"])){
    $constent = $_POST["content"];
   }
} else {
  echo "USAGE GET or POST";
}

?>
