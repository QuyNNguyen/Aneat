<?php




/////////////////////////////////////////////////////////////////////////////
////////////////               SETUP                  ///////////////////////
////////////////////////////////////////////////////////////////////////////


// Helper-functions

function round100Down($number)
{
return floor( $number / 100 ) * 100;
}


// fetch 1 row with this query and this connection
function fetch_row($query, $conn){
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc(); 

    $stmt->free_result();
    $stmt->close();

    return $row;
}


// Multiply ingredients list by new serving_size 
//$ ingredients is a list of ingredients (string)
//return new ingredients list
function multiply_ingredients($ingredients, $serving_size){

    $new_ingredients = "";
    //handling ingredients (find number of each row then multiply it by serving size)
    foreach (preg_split("/((\r?\n)|(\r\n?))/", $ingredients) as $line) {
        $number = preg_replace('/[^0-9]/', '', $line);
        $new_number = (float)$number * $serving_size;
        $new_line = str_replace($number, $new_number, $line);
        $new_ingredients .= $new_line."\r\n";
    }

    return $new_ingredients;
}



//multiply all info of a dish  by new serving
function multiply_serving($dish, $serving_size){

    $dish['ingredients'] = multiply_ingredients($dish['ingredients'], $serving_size);
    $dish['calo_per_serving'] *= $serving_size;
    $dish['protein_per_serving'] *= $serving_size;
    $dish['fat_per_serving'] *= $serving_size;
    $dish['carb_per_serving'] *= $serving_size;
    return $dish;

}

//multiply info of a snack by new serving
function multiply_snack_serving($snack, $serving_size){

    $snack['amount'] *= $serving_size;
    $snack['calo_per_serving'] *= $serving_size;
    $snack['protein_per_serving'] *= $serving_size;
    $snack['fat_per_serving']*= $serving_size;
    $snack['carb_per_serving']*= $serving_size;
    return $snack;
}




//an emty snack
// $empty_snack = [ 
//     'dish_name' => ""
//     'amount' => 0;
//     'calo_per_serving' =>0;
//     'protein_per_serving' => 0;
//     'fat_per_serving' => 0;
//     'carb_per_serving' => 0;

// ]

//helper-psuedo-class definition
//$total_x assosiative array is a array that contain stats for total of each meal and total of all day combineed
//The current version of this algo will not use protein, fat, carb for each meal, only the allday combined
//looks like this 
//   $total_x= [
//     'total_calo' => X,
//     'total_protein' => X, 
//     'total_fat' => X,
//     'total_carb' => X, 
//      ]
    





// DATABASE STUFF

$username="quyn9770_admin";
$password="2019webnum1";
$database="quyn9770_quickfit";

// Create connection
$conn = new mysqli("localhost", $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


//Debugging
// echo json_encode($total_calo_wanted);
// echo "Connected successfully";
//End debugging




// Note on database: 100less = fruit, 100-300 light, 400-500 heavy 

//Others: Returned JSON object with array of breakfastx2, lunch, and dinner
//Each meal is an array that carry [name, calories, amount of ingredients1, same for 2, same for 3, how to cook, protein, fat, carb]
//$result_array=[$breakfast1, $breakfast2, $total_breakfast, $lunch1, $lunch2, $total_lunch, $dinner1, $dinner2, $total_dinner, $total_day]

$result_array =[];


// Get desired calorie: 
$total_calo_wanted = $_POST['calo-input'];




/////////////////////////////////////////////////////////////////////////////
////////////////                BREAKFAST             ///////////////////////
////////////////////////////////////////////////////////////////////////////

//Calulate and fetch for breakfast
//Write more documentation for this algorithm
//breakfast = 0.3, lunch = 0.3, dinner = 0.4;
$breakfast_calo_wanted = $total_calo_wanted * 0.3;


//First option - round down take closest hundred then pull 1 from either 200 or 300 database + 1 fruit 

//[PICKED] Second option - pick 1 from either 200 and 300 then fill with 100less till breakfast_calo_wanted is reached


if ($breakfast_calo_wanted <= 300){

    $result_array['breakfast1'] = fetch_row('SELECT * FROM twohundred ORDER BY RAND() LIMIT 1;', $conn);

        // echo json_encode($result_array);

} 
else if ($breakfast_calo_wanted <= 600) {  

    //pick random  from 200 and 300 

    $randomness = rand(); 
    if (($randomness % 2) == 0) {
        $result_array['breakfast1'] = fetch_row('SELECT * FROM threehundred ORDER BY RAND() LIMIT 1;', $conn);
    }

    else{
        $result_array['breakfast1'] = fetch_row('SELECT * FROM twohundred ORDER BY RAND() LIMIT 1;', $conn);
    }
} 

else{

    //Pick random then x2
    $randomness = rand(); 
    if (($randomness % 2) == 0) {
        $row = fetch_row('SELECT * FROM threehundred ORDER BY RAND() LIMIT 1;', $conn);
    }

    else{
        $row = fetch_row('SELECT * FROM twohundred ORDER BY RAND() LIMIT 1;', $conn);
    }

    $result_array['breakfast1'] = multiply_serving($row, 2);


}






// Calculate number of fruit/snack added to meal 
$breakfast_calo_left = $breakfast_calo_wanted - $result_array['breakfast1']['calo_per_serving'];   
$num_breakfast_snack = ceil($breakfast_calo_left/100);

// echo $num_breakfast_snack ."\n"; 


// Create/update appropriate amount of fruit/snack and its stats then stick it to $result_array[1]
// This can be optimized to call both snack for breakfast and lunch so the database gret less hit (1/2n)

if ($num_breakfast_snack <= 0) {
    $result_array['breakfast2'] = NULL;
}

else {
    $row = fetch_row('SELECT * FROM zerohundred ORDER BY RAND() LIMIT 1;', $conn);
    $result_array['breakfast2'] = multiply_snack_serving($row, $num_breakfast_snack);
}




//Create total for breakfast
//Doesn't need to calcualte protein, fat, carb total now cuz we will do it later anwyay so we don't need to do it twice
$total_breakfast= [
    'total_calo' => $result_array['breakfast2']['calo_per_serving']+ $result_array['breakfast1']['calo_per_serving'],
];
$result_array['total_breakfast'] = $total_breakfast;









/////////////////////////////////////////////////////////////////////////////
////////////////               LUNCH                 ///////////////////////
////////////////////////////////////////////////////////////////////////////


//Calculate for lunch 
$lunch_calo_wanted = $total_calo_wanted * 0.3;


if ($lunch_calo_wanted <= 300){

    $result_array['lunch1'] = fetch_row('SELECT * FROM twohundred ORDER BY RAND() LIMIT 1;', $conn);

        // echo json_encode($result_array);

} 
else if ($lunch_calo_wanted <= 600) {  

    //pick random  from 200 and 300 

    $randomness = rand(); 
    if (($randomness % 2) == 0) {
        $result_array['lunch1'] = fetch_row('SELECT * FROM threehundred ORDER BY RAND() LIMIT 1;', $conn);
    }

    else{
        $result_array['lunch1'] = fetch_row('SELECT * FROM twohundred ORDER BY RAND() LIMIT 1;', $conn);
    }
} 

else{

    //Pick random then x2
    $randomness = rand(); 
    if (($randomness % 2) == 0) {
        $row = fetch_row('SELECT * FROM threehundred ORDER BY RAND() LIMIT 1;', $conn);
    }

    else{
        $row = fetch_row('SELECT * FROM twohundred ORDER BY RAND() LIMIT 1;', $conn);
    }

    $result_array['lunch1'] = multiply_serving($row, 2);


}





// Calculate number of fruit/snack added to meal 
$lunch_calo_left = $lunch_calo_wanted - $result_array['lunch1']['calo_per_serving'];   
$num_lunch_snack = ceil($lunch_calo_left/100);

// Create/update appropriate amount of fruit/snack and its stats then stick it to $result_array[1]

if ($num_lunch_snack <= 0) {
    $result_array['lunch2'] = NULL;
}

else {
    $row = fetch_row('SELECT * FROM zerohundred ORDER BY RAND() LIMIT 1;', $conn);
    $result_array['lunch2'] = multiply_snack_serving($row, $num_lunch_snack);
}








//Create total for lunch
$total_lunch= [
    'total_calo' => $result_array['lunch2']['calo_per_serving']+ $result_array['lunch1']['calo_per_serving'],
];
$result_array['total_lunch'] = $total_lunch;






/////////////////////////////////////////////////////////////////////////////
////////////////              DINNER                 ///////////////////////
////////////////////////////////////////////////////////////////////////////



$dinner_calo_wanted = $total_calo_wanted * 0.4;

// $result_array['dinner2'] = NULL;

//3XX calories
if ($dinner_calo_wanted < 400){
    $result_array['dinner1'] = fetch_row('SELECT * FROM threehundred ORDER BY RAND() LIMIT 1;', $conn);
} 
//4XX to 5XX
else if($dinner_calo_wanted < 600){
    $result_array['dinner1'] = fetch_row('SELECT * FROM fourhundred ORDER BY RAND() LIMIT 1;', $conn);
}
//6XX
else if ($dinner_calo_wanted < 700){   
    $result_array['dinner1'] = fetch_row('SELECT * FROM fivehundred ORDER BY RAND() LIMIT 1;', $conn);
} 
//7xx
else if ($dinner_calo_wanted < 800){   
    $result_array['dinner1'] = fetch_row('SELECT * FROM sixhundred ORDER BY RAND() LIMIT 1;', $conn);
} 
//8XX to 9XX
else if ($dinner_calo_wanted < 1000){   
    $row = fetch_row('SELECT * FROM fourhundred ORDER BY RAND() LIMIT 1;', $conn);
    $result_array['dinner1'] = multiply_serving($row, 2);
} 
//10XX to 11XX
else if ($dinner_calo_wanted < 1200){   
    $row = fetch_row('SELECT * FROM fivehundred ORDER BY RAND() LIMIT 1;', $conn);
    $result_array['dinner1'] = multiply_serving($row, 2);
} 

else{
    $row = fetch_row('SELECT * FROM sixhundred ORDER BY RAND() LIMIT 1;', $conn);
    $result_array['dinner1'] = multiply_serving($row, 2);
}


//Create total for dinner
$total_dinner= [
    'total_calo' => $result_array['dinner1']['calo_per_serving']
];
$result_array['total_dinner'] = $total_dinner;



/////////////////////////////////////////////////////////////////////////////
////////////////              ALL DAY                 ///////////////////////
////////////////////////////////////////////////////////////////////////////




$total_day= [
    'total_calo' => $result_array['total_breakfast']['total_calo']+ $result_array['total_lunch']['total_calo']+ $result_array['dinner1']['calo_per_serving'],
    'total_protein' => $result_array['breakfast1']['protein_per_serving'] + $result_array['breakfast2']['protein_per_serving']+
                    $result_array['lunch1']['protein_per_serving'] + $result_array['lunch2']['protein_per_serving']+
                    $result_array['dinner1']['protein_per_serving'] + $result_array['dinner2']['protein_per_serving'], 

    'total_fat' => $result_array['breakfast2']['fat_per_serving'] + $result_array['breakfast1']['fat_per_serving']+
                    $result_array['lunch1']['fat_per_serving'] + $result_array['lunch2']['fat_per_serving']+
                    $result_array['dinner2']['fat_per_serving'] + $result_array['dinner1']['fat_per_serving'],


    'total_carb' => $result_array['breakfast1']['carb_per_serving'] + $result_array['breakfast2']['carb_per_serving']+
                    $result_array['lunch1']['carb_per_serving'] + $result_array['lunch2']['carb_per_serving']+
                    $result_array['dinner1']['carb_per_serving'] + $result_array['dinner2']['carb_per_serving'],
];

$result_array['total_day'] =  $total_day;




//Debugging
// echo nl2br("breakfast total:". $breakfast_calo_wanted . "\n\n");
// echo nl2br("breakfast dish1: ".$result_array['breakfast1']['dish_name'].$result_array['breakfast1']['calo_per_serving']. "\n");
// echo nl2br("breakfast dish2: ".$result_array['breakfast2']['dish_name'].$result_array['breakfast2']['calo_per_serving']."\n");
// echo nl2br("total breakfast:".$total_breakfast['total_calo']."\n");
// echo nl2br("lunch dish1: ".$result_array['lunch1']['dish_name'].$result_array['lunch1']['calo_per_serving']. "\n");
// echo nl2br("lunch dish2: ".$result_array['lunch2']['dish_name'].$result_array['lunch2']['calo_per_serving']."\n");
// echo nl2br( "total lunch:".$total_lunch['total_calo']."\n");
// echo nl2br( "total day calo:".$total_day['total_calo']."\n"."total day protein:".$total_day['total_protein'] );
// echo nl2br("dinner: ".$result_array['dinner1']['dish_name'].$result_array['dinner1']['calo_per_serving']."\n");







//TODO: fill database each table with 1 entry, test with several case, pack result_array in json, done for the day! 

// echo($result_array);
echo json_encode($result_array);

//close connection here

$conn->close();



?>