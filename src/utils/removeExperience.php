<?php
$experience_id = $_GET['experience_id'];
$user_id = $_GET['user_id'];
$connect = @new mysqli("localhost","root","","job_portal_db");
$connect->query("DELETE FROM experience WHERE experience_id=$experience_id");

$select_query = "SELECT * FROM experience WHERE user_id=$user_id";
$result = $connect->query($select_query);

while($row = $result->fetch_assoc()){
    echo '<div class="bg-white rounded-xl px-4 py-8 border-2 border-dashed border-gray-500 mt-5">';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Nazwa stanowiska: <span class="ml-3">'.$row['position_name'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Nazwa firmy: <span class="ml-3">'.$row['company_name'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Data rozpoczęcia pracy: <span class="ml-3">'.$row['work_start_date'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Data zakończenia pracy: <span class="ml-3">'.$row['work_end_date'].'</span></h1>';
        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-2 rounded-md mt-3" onclick="handleExperienceDeleteClick('.$row['experience_id'].')">Usuń Doświadczenie</button>';
    echo '</div>';
}

$connect->close();
?>