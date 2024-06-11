<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portal Ogłoszeniowy</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./output.css" />
    <link rel="stylesheet" href="./input.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php
session_start();

if(!isset($_SESSION['loged'])){
    header("Location: loginPage.php");
}

if(isset($_GET['delete_btn_submit'])){
    $job_ofert_id = $_GET['job_ofert_id'];
    $delete_query = "DELETE FROM current_application WHERE job_ofert_id='$job_ofert_id' AND user_id=".$_SESSION['loged_user_id'];
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $connect->query($delete_query);
    $connect->close();
    header("Location: applicationsPage.php");
}
?>

<body class="main-bg overflow-x-hidden">
    <nav class="bg-black  px-4 py-4 shadow-lg shadow-cyan-400 flex items-center">
        <h1 class="font-Tiny5 text-white text-2xl w-full tracking-wider">PracaPopłaca.pl </h1>
        <ul id="burger-menu"
            class="flex flex-col gap-5 items-center absolute top-[70px] right-0 bg-black w-full max-w-[600px] pb-10 rounded-b-xl transition-all duration-700 translate-x-[800px]">
            <li
                class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">
                <a href="index.php">Strona główna</a>
            </li>
            <?php 
                if(isset($_SESSION['loged'])){
                    $connect = @new mysqli("localhost","root","","job_portal_db");
                    $user_result = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['loged_user_id'])->fetch_assoc();
                    $connect->close();

                    if($user_result['access'] == "admin"){
                        echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">
                                <a href="companyPage.php">Konfiguracja Firm</a>
                              </li>';
                        echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">
                                <a href="jobOfertPage.php">Konfiguracja Ofert</a>
                              </li>';
                        echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">
                                <a href="companyForm.php">Dodaj Firmę</a>
                              </li>';
                        echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">
                                <a href="jobOfertForm.php">Dodaj ofertę</a>
                              </li>';
                    }
                }
                ?>

            <?php
                if(isset($_SESSION['loged'])){
                    if($_SESSION['loged']){
                        echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">';
                            echo '<a href="profilePage.php">Twój profil</a>';
                        echo '</li>';
                        echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">';
                            echo '<a href="applicationsPage.php">Aplikowane oferty</a>';
                        echo '</li>';
                        echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">';
                            echo '<a href="favouritePage.php">Ulubione oferty</a>';
                        echo '</li>';
                        echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">';
                            echo '<a href="logoutPage.php">Wyloguj się</a>';
                        echo '</li>';
                    }
                }else{
                    echo '<li class="font-Tiny5 w-full max-w-[300px] flex items-center justify-center border-4 uppercase border-cyan-500 text-cyan-500 rounded-md py-2 hover:cursor-pointer hover:bg-cyan-500 hover:text-white transition-all duration-500">';
                        echo '<a href="loginPage.php">Zaloguj się</a>';
                    echo '</li>';
                }
                ?>
        </ul>

        <button class="w-[40px] h-[40px] flex flex-col justify-evenly" onclick="burgerMenuClick()">
            <div class="bg-white w-full h-1 rounded-full"></div>
            <div class="bg-white w-full h-1 rounded-full"></div>
            <div class="bg-white w-full h-1 rounded-full"></div>
        </button>
    </nav>

    <section class="w-full flex flex-col items-center">
        <h1
            class="font-Tiny5 uppercase text-5xl text-white bg-gray-800 w-full max-w-[1400px] text-center mt-10 py-8 rounded-lg">
            Aplikowane
            oferty</h1>

        <div class="bg-gray-800 w-full max-w-[1400px] px-8 flex flex-col gap-5 mt-10 py-12 rounded-xl">
            <?php 
                $select_query = "SELECT * FROM current_application JOIN job_ofert USING (job_ofert_id) WHERE user_id=".$_SESSION['loged_user_id'];
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="flex">';
                        echo '<a class="bg-white flex px-4 py-8 rounded-l-md items-center w-full" href="ofertPage.php?job_ofert_id='.$row['job_ofert_id'].'">';
                            echo '<h1 class="w-full font-Tiny5 text-gray-800 uppercase text-3xl">'.$row['position_name'].'</h1>';
                        echo '</a>';
                        echo '<form class="flex items-center bg-white rounded-r-md">';
                            echo '<input type="hidden" name="job_ofert_id" value="'.$row['job_ofert_id'].'">';
                            echo '<input type="hidden" name="delete_btn_submit" value="true">';
                            echo '<button class="bg-red-400 rounded-md text-3xl text-white px-4 py-3 mr-5">'; 
                                echo '<i class="fa-solid fa-trash-can"></i>';
                            echo '</button>';
                        echo '</form>';
                    echo '</div>';
                }
                $connect->close();
            ?>
        </div>
    </section>
</body>
<script src="js/burger_menu.js"></script>

</html>