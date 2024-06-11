<?php
$education_id = $_GET['education_id'];
$user_id = $_GET['user_id'];
$connect = @new mysqli("localhost","root","","job_portal_db");
$connect->query("DELETE FROM education WHERE education_id=$education_id");

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