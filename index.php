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
  echo n12br("OH YEA POSTMAN \r\n");//default  message, n12br is for new line breaks
  if(isset($_POST["author"])){
    $author = $_POST["author"];
  }
   if(isset($_POST["content"])){
    $constent = $_POST["content"];
   }
  echo "$author: $content";
} else {
  echo "USAGE GET or POST";
}

?>
