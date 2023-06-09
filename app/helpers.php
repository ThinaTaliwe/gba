<?php
/**
 * PHP version 9
 *
 * @author    Siyabonga Alexander Mnguni <alexmnguni57@gmail.com>
 * @copyright 2023 1Office
 * @license   MIT License
 * @link      https://github.com/alexmnguni57/1Office-GBA
 */
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

//This Changes the background color of the age (Green/Yellow/Red)
function changeAgeBackground($age)
{
    if($age<15) {
        return 'bg-gradient-success';
    }
    elseif($age<20) {
        return  'bg-gradient-warning';
    }
    else{
        return 'bg-gradient-danger';
    }   
}

//This returns the age of a person from their date of birth
function ageFromDOB($dob)
{
    return Carbon::parse($dob)->diff(Carbon::now())->y;
}
   
function dobBreakdown($dob)
{
   
    return new Carbon($dob);   
}

//These call a stored procedure in the database to check if a record exists, if it doesnt exist it is then added
//Stored Procedure Call For Country  
function checkCountry($countryName)
{
    DB::select('CALL store_country(?)', array($countryName));
}

//Stored Procedure Call For Province
function checkProvince($provinceName,$countryID)
{
    DB::select('CALL store_province(?,?)', array($provinceName, $countryID));
}

//Stored Procedure Call For City
function checkCity($cityName,$countryID,$provinceID)
{
    DB::select('CALL store_city(?,?,?)', array($cityName,$countryID,$provinceID));
}


//SA ID Validation
function verify_id_number($id_number)
{

    $validated = false;


    if (is_numeric($id_number) && strlen($id_number) === 13) {

        $errors = false;

        $num_array = str_split($id_number);


        // Validate the day and month

        $id_month = $num_array[2] . $num_array[3];

        $id_day = $num_array[4] . $num_array[5];


        if ($id_month < 1 || $id_month > 12) {
            $errors = true;
        }

        if ($id_day < 1 || $id_day > 31) {
            $errors = true;
        }

        //Just added this for February but it doesnt check for leap-year
        if ($id_month == 2 && $id_day < 1 || $id_day > 28) {
            $errors = true;
        }


        

        // Validate gender

        //When using this validation, add a parameter for gender (, $gender = '') next to $id_number 

        // $id_gender = $num_array[6] >= 5 ? 'male' : 'female';

        // if ($gender && strtolower($gender) !== $id_gender) {

        //     $errors = true;

        // }




        // if errors haven't been set to true by any one of the checks, we can change verified to true;
        if (!$errors) {
            $validated = true;
        }

    }

    return $validated;

}