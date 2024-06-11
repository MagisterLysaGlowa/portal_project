<?php
$user_id = $_GET['user_id'];
$school_name = $_GET['school_name'];
$school_level = $_GET['school_level'];
$school_type = $_GET['school_type'];
$school_start_date = $_GET['school_start_date'];
$school_end_date = $_GET['school_end_date'];

$insert_query = "INSERT INTO education(school_name,school_level,school_type,school_start_date,school_end_date,user_id) VALUES ('$school_name','$school_level','$school_type','$school_start_date','$school_end_date',$user_id)";

$connect = @new mysqli("localhost","root","","job_portal_db");
$connect->query($insert_query);

$select_query = "SELECT * FROM education WHERE user_id=$user_id";
$result = $connect->query($select_query);

while($row = $result->fetch_assoc()){
    echo '<div class="bg-white rounded-xl px-4 py-8 border-2 border-dashed border-gray-500 mt-5">';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Nawa szkoły / uczelni: <span class="ml-3">'.$row['school_name'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Poziom szkoły / uczelni: <span class="ml-3">'.$row['school_level'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Kierunek: <span class="ml-3">'.$row['school_type'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Data rozpoczęcia nauki: <span class="ml-3">'.$row['school_start_date'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Data zakończenia nauki: <span class="ml-3">'.$row['school_end_date'].'</span></h1>';
        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-2 rounded-md mt-3" onclick="handleEducationDeleteClick('.$row['education_id'].')">Usuń wykształcenie</button>';
    echo '</div>';
}

$connect->close();
?>