<?php

session_start();
if(isset($_POST['reset'])){
    //figure out how to reset the settion and remove the cookie id
}
    //function to select a rack
    function select_rack($letLength){
        //list 7 of each letters, in case rack = 7 of 1 letter
        $possibleLet = "AAAAAAAAABBCCDDDDEEEEEEEEEEEEFFGGGHHIIIIIIIIIJKLLLLMMNNNNNNOOOOOOOOPPQRRRRRRSSSSTTTTTTUUUUVVWWXYYZ";
        $rack_pick = substr(str_shuffle($possibleLet), 0, $letLength);//select random shuffled letter group
        $tmp = str_split($rack_pick);//prepare to sort
        sort($tmp);//sort alpha
        return implode($tmp);//collapse back and return sorted letter group
    };

    //this is the basic way of getting a database handler from PDO, PHP's built in quasi-ORM
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    //check inital
    if(isset($_POST['user-rack'])){
        $newrack=$_POST['user-rack'];
        //console.log("post, user-rack);
    }
    else{
        $newrack = generateLetters(7)//generate new rack with length of 7
    }
       
    //create array of racks for game
	$racks = [];
	for($i = 0; $i < pow(2, strlen($newrack)); $i++){
		$answer = "";
		for($j = 0; $j < strlen($rack); $j++){
			if (($i >> $j) % 2) {
			  $answer .= $newrack[$j];
			}
		}
		if (strlen($answer) > 1){
			$racks[] = $answer;	
		}
	}
	$racks = array_unique($racks);
	$totalRacks = sizeof($racks);
	$words = $weights = array();
	//$response = array('letters' => $rack, 'words' => array());

    for ($i=0; $i<$numracks;$i++) {
        if (array_key_exists($i,$racks)) {
            $thisrack = $racks[$i];
            //this is a sample query which gets some data, the order by part shuffles the results
            //the limit 0, 10 takes the first 10 results.
            // you might want to consider taking more results, implementing "pagination", 
            // ordering by rank, etc.
        //figure out how to do reset/ get new button to start game and load rack of words
            //$query = "SELECT rack, words FROM racks WHERE length=7 and weight <= 10 order by random() limit 0, 10";
    
            //this next line could actually be used to provide user_given input to the query to 
            //avoid SQL injection attacks
            $query = "SELECT words,weight FROM racks WHERE rack='".$thisrack."'";
            
            $statement = $dbhandle->prepare($query);
            $statement->execute();
            //$statement->bindParam(1, $subrack, PDO::PARAM_STR);//binder
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($results) > 0){
                $str= $results[0]['words'];
                $this_words = (explode("@@",$str));
                $this_weight = $results[0]['weight'];
                
                for ($j=0; $j<count($this_words); $j++) {
                    array_push($words,$this_words[$j]);
                    array_push($weights,$this_weight);
                    $numLetters = strlen($this_words[$j]);
                }
            }
        }
    }
    $results_array = array_combine($words,$weights);
    arsort($results_array);
    
    $valid_guess = "";
    $this_guess = "";
    $points = 0;
    
    if(!empty($_POST['user-guesses'])) {
        $this_guess = $_POST['user-guesses'];
        for ($i = 0; $i< sizeof($words); $i++) {
            if ($this_guess==$words[$i]) {
                $points = $weights[$i];
                $valid_guess = $this_guess;
           }
        }
    }
    //attempt to score results wih cookies?
    //doesnt work
    //if (!isset($_SESSION["points"])){
      //  $_SESSION["points"] = 0;
        //$_SESSION["recent_points"] = 0;

        
        
    //    foreach ($results as $row) {
    //        $response['words'] = array_merge(
    //            $response['words'],
    //            explode('@@', $row['words'])
     //       );
    //    }
    //}
    
    //this part is perhaps overkill but I wanted to set the HTTP headers and status code
    //making to this line means everything was great with this request
    header('HTTP/1.1 200 OK');
    //this lets the browser know to expect json
    header('Content-Type: application/json');
    //this creates json and gives it back to the browser
    echo json_encode($results);
?>
