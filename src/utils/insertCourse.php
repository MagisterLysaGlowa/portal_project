<?php
$user_id = $_GET['user_id'];
$course_name = $_GET['course_name'];
$course_organizer = $_GET['course_organizer'];
$course_location = $_GET['course_location'];
$course_start_date = $_GET['course_start_date'];
$course_end_date = $_GET['course_end_date'];

$insert_query = "INSERT INTO course(course_name,course_organizer,course_location,course_start_date,course_end_date,user_id) VALUES ('$course_name','$course_organizer','$course_location','$course_start_date','$course_end_date',$user_id)";

$connect = @new mysqli("localhost","root","","job_portal_db");
$connect->query($insert_query);

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