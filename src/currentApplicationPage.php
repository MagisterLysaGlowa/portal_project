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

if(isset($_GET['add_current'])){
    if(isset($_SESSION['loged_user_id'])){
        $job_ofert_id = $_GET['job_ofert_id'];
        $insert_query = "INSERT INTO current_application(job_ofert_id,user_id) VALUES ('$job_ofert_id','".$_SESSION['loged_user_id']."')";
        $connect = @new mysqli("localhost","root","","job_portal_db");
        $connect->query($insert_query);
        $connect->close();
        header("Location: applicationsPage.php");
    }
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

    <?php
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $user_result = $connect->query("SELECT * FROM user WHERE user_id=".$_SESSION['loged_user_id'])->fetch_assoc();
    $job_ofert_result = $connect->query("SELECT * FROM job_ofert JOIN company USING(company_id) WHERE job_ofert_id=".$_GET['job_ofert_id'])->fetch_assoc();
    $connect->close();
    ?>

    <section class="w-full flex flex-col items-center">
        <div class="w-full max-w-[1400px] bg-gray-800 flex items-center py-8 flex-col rounded-md mt-10">
            <h1 class="font-Tiny5 text-white text-4xl uppercase"><?php echo $job_ofert_result['position_name']; ?></h1>
            <h2 class="font-Tiny5 text-gray-300 italic text-2xl uppercase">
                <?php echo $job_ofert_result['company_name']; ?>
            </h2>
        </div>
        <div class="bg-gray-600 w-full max-w-[1400px] px-8 py-8 flex flex-col rounded-b-3xl">
            <div class="flex font-Tiny5 uppercase text-white text-2xl">
                <h2>Imię: </h2>
                <span class="ml-3"><?php echo $user_result['name']; ?></span>
            </div>

            <div class="flex font-Tiny5 uppercase text-white text-2xl">
                <h2>Nazwisko: </h2>
                <span class="ml-3"><?php echo $user_result['surname']; ?></span>
            </div>

            <div class="flex font-Tiny5 uppercase text-white text-2xl">
                <h2>E-mail: </h2>
                <span class="ml-3"><?php echo $user_result['email']; ?></span>
            </div>

            <div class="flex font-Tiny5 uppercase text-white text-2xl">
                <h2>Numer telefonu: </h2>
                <span class="ml-3"><?php echo $user_result['phone_number']; ?></span>
            </div>

            <div class="flex font-Tiny5 uppercase text-white text-2xl">
                <h2>Miejscowość: </h2>
                <span class="ml-3"><?php echo $user_result['location']; ?></span>
            </div>

            <div class="flex font-Tiny5 uppercase text-white text-2xl">
                <h2>Data urodzenia: </h2>
                <span class="ml-3"><?php echo $user_result['birth_date']; ?></span>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1400px] rounded-3xl p-8 mt-10 shadow-md">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Wykształcenie</h1>
            <div class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM education WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-8 border-2 border-dashed border-gray-500 mt-5">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Nawa szkoły / uczelni: <span class="ml-3">'.$row['school_name'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Poziom szkoły / uczelni: <span class="ml-3">'.$row['school_level'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Kierunek: <span class="ml-3">'.$row['school_type'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Data rozpoczęcia nauki: <span class="ml-3">'.$row['school_start_date'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Data zakończenia nauki: <span class="ml-3">'.$row['school_end_date'].'</span></h1>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1400px] rounded-3xl p-8 mt-10 shadow-md">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Doświadczenie</h1>
            <div id="experience-wrapper" class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM experience WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-8 border-2 border-dashed border-gray-500 mt-5">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Nazwa stanowiska: <span class="ml-3">'.$row['position_name'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Nazwa firmy: <span class="ml-3">'.$row['company_name'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Data rozpoczęcia pracy: <span class="ml-3">'.$row['work_start_date'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Data zakończenia pracy: <span class="ml-3">'.$row['work_end_date'].'</span></h1>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1400px] rounded-3xl p-8 mt-10 shadow-md">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Kursy</h1>
            <div id="course-wrapper" class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM course WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-8 border-2 border-dashed border-gray-500 mt-5">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Nazwa kursu: <span class="ml-3">'.$row['course_name'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Organizator kursu: <span class="ml-3">'.$row['course_organizer'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Miejscowość odbywania kursu: <span class="ml-3">'.$row['course_location'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Data rozpoczęcia kursu: <span class="ml-3">'.$row['course_start_date'].'</span></h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl">Data zakończenia kursu: <span class="ml-3">'.$row['course_end_date'].'</span></h1>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1400px] rounded-3xl p-8 mt-10 shadow-md">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Uprawnienia / Umiejętności</h1>
            <div id="ability-wrapper" class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM ability WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-2 border-2 border-dashed border-gray-500 mt-5 flex items-center">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center w-full">'.$row['ability_content'].'</h1>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1400px] rounded-3xl p-8 mt-10 shadow-md">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Znane języki</h1>
            <div id="language-wrapper" class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM language WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-2 border-2 border-dashed border-gray-500 mt-5 flex items-center">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center mr-2 text-green-500">'.$row['language_level'].'</h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center w-full">'.$row['language_content'].'</h1>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1400px] rounded-3xl p-8 mt-10 shadow-md">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Linki do innych portali</h1>
            <div id="link-wrapper" class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM link WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-2 border-2 border-dashed border-gray-500 mt-5 flex items-center">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center w-full">'.$row['link_content'].'</h1>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <form class="w-full flex justify-center max-w-[1400px]">
            <input type="hidden" value="true" name="add_current">
            <input type="hidden" value="<?php echo $job_ofert_result['job_ofert_id']; ?>" name="job_ofert_id">
            <button class="bg-green-500 font-Tiny5 uppercase text-2xl text-white px-10 py-4 rounded-xl my-10">Aplikuj na
                stanowisko</button>
        </form>
    </section>

</body>
<script src="js/burger_menu.js"></script>

</html>