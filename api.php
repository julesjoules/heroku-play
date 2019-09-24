<?php

    //this is the basic way of getting a database handler from PDO, PHP's built in quasi-ORM
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
       
//function to select a rack
    function select_rack($letLength){
        //list 7 of each letters, in case rack = 7 of 1 letter
        $possibleLet = "AAAAAAAAABBCCDDDDEEEEEEEEEEEEFFGGGHHIIIIIIIIIJKLLLLMMNNNNNNOOOOOOOOPPQRRRRRRSSSSTTTTTTUUUUVVWWXYYZ";
        $rack_pick = substr(str_shuffle($possibleLet), 0, $letLength);//select random shuffled letter group
        $tmp = str_split($rack_pick);//prepare to sort
        sort($tmp);//sort alpha
        return implode($tmp);//collapse back and return sorted letter group
    };
//post/get rack
    //if(($_POST)){
       // $newrack = $POST['user-rack'];
       // console.log("post, rack picked);
      // } else{
       $newrack = select_rack(7);//generate new rack with length of 7
       
       //create array of racks for game
       $racks = [];
       for($i=0; $i < pow(2, strlen($newrack)); $i++){
        $wordList = "";
        for($j=0; $j < strlrn($newrack); $j++){
            if(($i >> $j) %2){
                $wordList = $rack[$j];
                }
                }
                if(strlen($wordList) > 1){
                    $newracks[] = $wordList;
                    }
                    }
                    $newrack = array_unique($newrack);
                    $response = array('letters' => $rack, 'word' => array());
                    
    foreach($racks as $subracks) {
    $query = "SELECT words FROM racks WHERE rack = ?";
       
    //this is a sample query which gets some data, the order by part shuffles the results
    //the limit 0, 10 takes the first 10 results.
    // you might want to consider taking more results, implementing "pagination", 
    // ordering by rank, etc.
//figure out how to do reset/ get new button to start game and load rack of words
    //$query = "SELECT rack, words FROM racks WHERE length=7 and weight <= 10 order by random() limit 0, 10";
    
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(1, $subrack, PDO::PARAM_STR);//binder
    $statement->execute();
    
    //The results of the query are typically many rows of data
    //there are several ways of getting the data out, iterating row by row,
    //I chose to get associative arrays inside of a big array
    //this will naturally create a pleasant array of JSON data when I echo in a couple lines
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    //echo jason_encode($results);
//else, if not new button pressed, if its the check button, than cross check the words
    //set up rack and variables needed to return all combinations of words

          foreach($results as $row){
          $response['words'] explode('@@', $row['words']));
          }
          }
        
    
    //this part is perhaps overkill but I wanted to set the HTTP headers and status code
    //making to this line means everything was great with this request
    header('HTTP/1.1 200 OK');
    //this lets the browser know to expect json
    header('Content-Type: application/json');
    //this creates json and gives it back to the browser
    echo json_encode($results);

?>
