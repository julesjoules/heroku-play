<?php

    //this is the basic way of getting a database handler from PDO, PHP's built in quasi-ORM
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $count = 1;
    $binvar = decbin($count);

    $reciever = $_GET['reciever'];

    $rack = $reciever;
    $sizeRack = strlen($rack);

    $finalRack = array();
    $outcount = 0;

    //while loop to check for all words associated
   // while(strlen(decbin($count)) < $sizeRack + 10{
     //   $binvar = decbin($count);
       // $binvar = strrev($binvar);
      //  $count++;
       // $tempArr = "";
        //for($x=0; $x< strlen($binvar); $x++){
          //  if($binvar[$x] == "1"){
            //    $tempArr = $tempArr.$rack[$x];
            //}
        //}
        
      //  $query = "SELECT words FROM racks WHERE rack = \"$tmpArr\"";
        //$statement = $dbhanfle->prepare($query);
        //$statement->execute();
        //$results = $statemebt->fetchA
 

    //this is a sample query which gets some data, the order by part shuffles the results
    //the limit 0, 10 takes the first 10 results.
    // you might want to consider taking more results, implementing "pagination", 
    // ordering by rank, etc.
//figure out how to do reset/ get new button to start game and load rack of words
    $query = "SELECT rack, words FROM racks WHERE length<7 and weight <= 10 order by random() limit 0, 10";
    
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    
    //The results of the query are typically many rows of data
    //there are several ways of getting the data out, iterating row by row,
    //I chose to get associative arrays inside of a big array
    //this will naturally create a pleasant array of JSON data when I echo in a couple lines
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo jason_encode($results);
//else, if not new button pressed, if its the check button, than cross check the words
    //set up rack and variables needed to return all combinations of words
  //  if($results == array()){
    //}
    //else{
     //      $finalResults = array();
       //    foreach($results[0] as $values){
         //   $finalResults = $values;
         //}
    //$explodArr = explode('@@', $finalResults);
   // for($y = 0;$y<count($explodArr); $y++){
     //   array_ush($finalRack, $explodArr[$y]);
   // }
//}
   // }
          
        
    
    //this part is perhaps overkill but I wanted to set the HTTP headers and status code
    //making to this line means everything was great with this request
    header('HTTP/1.1 200 OK');
    //this lets the browser know to expect json
    header('Content-Type: application/json');
    //this creates json and gives it back to the browser
    echo json_encode($results);

?>
