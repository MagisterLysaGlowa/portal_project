<?php
$ability_id = $_GET['ability_id'];
$user_id = $_GET['user_id'];
$connect = @new mysqli("localhost","root","","job_portal_db");
$connect->query("DELETE FROM ability WHERE ability_id=$ability_id");

$select_query = "SELECT * FROM ability WHERE user_id=$user_id";
$result = $connect->query($select_query);

while($row = $result->fetch_assoc()){
    echo '<div class="bg-white rounded-xl px-4 py-2 border-2 border-dashed border-gray-500 mt-5 flex items-center">';
        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center w-full">'.$row['ability_content'].'</h1>';
        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-3 rounded-md mt-3 text-2xl" onclick="handleAbilityDeleteClick('.$row['ability_id'].')"><i class="fa-solid fa-trash-can"></i></button>';
    echo '</div>';
}

$connect->close();
?>