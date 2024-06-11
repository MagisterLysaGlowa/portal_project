<?php

$postion_name = $_GET['position_name'];
$position_level = $_GET['position_level'];
$employment_contract = $_GET['employment_contract'];
$employment_type = $_GET['employment_type'];
$job_type = $_GET['job_type'];
$salary_minimum = $_GET['salary_minimum'];
$salary_maximum = $_GET['salary_maximum'];

$is_first = true; 
$select_query = "SELECT * FROM job_ofert";

if($postion_name != ""){
    if($is_first){
        $select_query = $select_query." WHERE position_name LIKE '%".$postion_name."%'";
    }else{
        $select_query = $select_query." AND position_name LIKE '%".$postion_name."%'";
        
    }
    $is_first = false;
}

if($position_level != ""){
    $select_query .= $is_first ? " WHERE position_level='$position_level'" : " AND position_level='$position_level'";
    $is_first = false;
}

if($employment_contract != ""){
    $select_query .= $is_first ? " WHERE employment_contract='$employment_contract'" : " AND employment_contract='$employment_contract'";
    $is_first = false;
}

if($employment_type != ""){
    $select_query .= $is_first ? " WHERE employment_type='$employment_type'" : " AND employment_type='$employment_type'";
    $is_first = false;
}

if($job_type != ""){
    $select_query .= $is_first ? " WHERE job_type='$job_type'" : " AND job_type='$job_type'";
    $is_first = false;
}

if($salary_minimum != ""){
    $select_query .= $is_first ? " WHERE salary_minimum>'$salary_minimum'" : " AND salary_minimum>'$salary_minimum'";
    $is_first = false;
}

if($salary_maximum != ""){
    $select_query .= $is_first ? " WHERE salary_maximum<'$salary_maximum'" : " AND salary_maximum<'$salary_maximum'";
    $is_first = false;
}


$connect = @new mysqli("localhost","root","","job_portal_db");
$result = $connect->query($select_query);
while($row = $result->fetch_assoc()){
    $company_for_job_ofert = $connect->query("SELECT * FROM company WHERE company_id=".$row['company_id'])->fetch_assoc();
    echo '<a class="bg-gray-900 rounded-md w-full px-8 py-8 shadow-sm shadow-cyan-500 text-white" href="ofertPage.php?job_ofert_id='.$row['job_ofert_id'].'">';
        echo '<h1 class="font-Tiny5 text-white text-4xl uppercase">'.$row['position_name'].'</h1>';
        echo '<div class="flex items-center text-gray-300 mt-[-0.8em] mb-2">';
            echo '<i class="fa-solid fa-location-dot"></i>';
            echo '<span class="ml-2 font-Tiny5 text-2xl uppercase">'.$company_for_job_ofert['company_location'].'</span>';
        echo '</div>';
        echo '<div class="grid grid-cols-2">';
            echo '<div class="flex flex-col gap-5">';
                echo '<div class="flex items-center text-pink-300 border-2 border-pink-300 max-w-[300px] py-2 justify-center rounded-md">';
                    echo '<i class="fa-solid fa-newspaper"></i>';
                    echo '<span class="ml-2 font-Tiny5">'.$row['employment_contract'].'</span>';
                echo '</div>';

                echo '<div class="flex items-center text-green-300 border-2 border-green-300 max-w-[300px] py-2 justify-center rounded-md">';
                    echo '<i class="fa-solid fa-briefcase"></i>';
                    echo '<span class="ml-2 font-Tiny5">'.$row['employment_type'].'</span>';
                echo '</div>';

                echo '<div class="flex items-center text-blue-300 border-2 border-blue-300 max-w-[300px] py-2 justify-center rounded-md">';
                    echo '<i class="fa-solid fa-laptop"></i>';
                    echo '<span class="ml-2 font-Tiny5">'.$row['job_type'].'</span>';
                echo '</div>';
            echo '</div>';

            echo '<div class=" flex flex-col justify-center items-end gap-5">';
                echo '<form class="max-w-[250px] w-full">';
                    echo '<input type="hidden" value="true name="add_current">'; 
                    echo '<button class="text-green-400 border-2 border-green-400 text-lg font-Tiny5 uppercase w-full rounded-lg py-2">Aplikuj</button>';
                echo '</form>';
                echo '<form class="max-w-[250px] w-full">';
                    echo '<input type="hidden" value="true name="add_favourite">'; 
                    echo '<button class="text-red-400 border-2 border-red-400 text-lg font-Tiny5 uppercase w-full rounded-lg py-2">Zapisz</button>';
                echo '</form>';
            echo '</div>';
        echo '</div>';
    echo '</a>';
}
$connect->close();
?>