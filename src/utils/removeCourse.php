<?php
$course_id = $_GET['course_id'];
$user_id = $_GET['user_id'];
$connect = @new mysqli("localhost","root","","job_portal_db");
$connect->query("DELETE FROM course WHERE course_id=$course_id");

$select_query = "SELECT * FROM course WHERE user_id=$user_id";
$result = $connect->query($select_query);

while($row = $result->fetch_assoc()){
    echo '<div class="bg-white rounded-xl px-4 py-8 border-2 border-dashed border-gray-500 mt-5">';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Nazwa kursu: <span class="ml-3">'.$row['course_name'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Organizator kursu: <span class="ml-3">'.$row['course_organizer'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Miejscowość odbywania kursu: <span class="ml-3">'.$row['course_location'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Data rozpoczęcia kursu: <span class="ml-3">'.$row['course_start_date'].'</span></h1>';
        echo '<h1 class="font-Tiny5 uppercase text-xl">Data zakończenia kursu: <span class="ml-3">'.$row['course_end_date'].'</span></h1>';
        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-2 rounded-md mt-3" onclick="handleCourseDeleteClick('.$row['course_id'].')">Usuń Kurs</button>';
    echo '</div>';
}

$connect->close();
?>