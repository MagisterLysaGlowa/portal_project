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

    <section class="flex flex-col items-center">
        <?php
        $connect = @new mysqli("localhost","root","","job_portal_db");
        $select_query = "SELECT * FROM user WHERE user_id=".$_SESSION['loged_user_id'];
        $user_result = $connect->query($select_query)->fetch_assoc();
        $connect->close();
        ?>
        <div class="w-full max-w-[1000px] bg-gray-800 mt-10 px-8 py-8">
            <h1 class="text-white text-5xl uppercase font-Tiny5">
                <?php echo  $user_result['name']." ".$user_result['surname']?>
            </h1>
        </div>

        <div class="bg-gray-600 w-full max-w-[1000px] rounded-b-3xl p-8">
            <form method="POST" class="grid grid-cols-2 gap-y-5 gap-x-24">
                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Imię</h1>
                    <input type="text"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="name" value="<?php echo $user_result['name'] ?>">
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Nazwisko</h1>
                    <input type="text"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="surname" value="<?php echo $user_result['surname'] ?>">
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">E-mail</h1>
                    <input type="email"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="email" value="<?php echo $user_result['email'] ?>">
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Numer telefonu</h1>
                    <input type="number"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="phone" value="<?php echo $user_result['phone_number'] ?>">
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Data urodzenia</h1>
                    <input type="date"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="birthday" value="<?php echo $user_result['birth_date'] ?>">
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Miejscowość</h1>
                    <input type="text"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="location" value="<?php echo $user_result['location'] ?>">
                </div>

                <div>
                    <input type="hidden" name="user_id" value="<?php echo $user_result['user_id'] ?>">
                </div>

                <button class="bg-red-800 rounded-md h-12 text-white uppercase text-2xl font-Tiny5" type="button"
                    id="profile_button" onclick="handleProfileEditClick()">Zakończ edytowanie</button>
            </form>
        </div>

        <div class="bg-gray-600 w-full max-w-[1000px] rounded-3xl p-8 mt-10 shadow-md shadow-yellow-600">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Wykształcenie</h1>
            <form method="POST" class="grid grid-cols-2 gap-y-5 gap-x-24">
                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Nazwa szkoły / uczelni</h1>
                    <input type="text"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="school_name" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Kierunek</h1>
                    <input type="text"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="school_type" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Data rozpoczęcia nauki</h1>
                    <input type="date"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="school_start_date" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Data zakończenia nauki</h1>
                    <input type="date"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="school_end_date" required>
                </div>

                <div class="col-span-2">
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Poziom szkoły / uczelni</h1>
                    <select
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="school_level" required>
                        <option>Podstawowa</option>
                        <option>Średnia</option>
                        <option>Licencjat</option>
                        <option>Wyższa</option>
                    </select>
                </div>

                <div class="col-span-2 flex justify-center">
                    <button type="button"
                        class="bg-yellow-600 text-2xl h-12 w-full mt-4 max-w-[600px] rounded-lg font-Tiny5 text-white uppercase"
                        onclick="handleEducationInsert()">Dodaj
                        wykształcenie</button>
                </div>
            </form>

            <div id="educations-wrapper" class="mt-10">
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
                        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-2 rounded-md mt-3" onclick="handleEducationDeleteClick('.$row['education_id'].')">Usuń wykształcenie</button>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1000px] rounded-3xl p-8 mt-10 shadow-md shadow-green-400">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Doświadczenie</h1>
            <form method="POST" class="grid grid-cols-2 gap-y-5 gap-x-24">
                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Nazwa stanowiska</h1>
                    <input type="text"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="position_name" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Nazwa firmy</h1>
                    <input type="text"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="company_name" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Data rozpoczęcia pracy</h1>
                    <input type="date"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="work_start_date" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Data zakończenia pracy</h1>
                    <input type="date"
                        class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full profile-input-group"
                        name="work_end_date" required>
                </div>

                <div class="col-span-2 flex justify-center">
                    <button type="button"
                        class="bg-green-400 text-2xl h-12 w-full mt-4 max-w-[600px] rounded-lg font-Tiny5 text-white uppercase"
                        onclick="handleExperienceInsert()">Dodaj
                        Doświadczenie</button>
                </div>
            </form>

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
                        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-2 rounded-md mt-3" onclick="handleExperienceDeleteClick('.$row['experience_id'].')">Usuń Doświadczenie</button>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1000px] rounded-3xl p-8 mt-10 shadow-md shadow-purple-500">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Kursy / Szkolenia</h1>
            <form method="POST" class="grid grid-cols-2 gap-y-5 gap-x-24">
                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Nazwa kursu</h1>
                    <input type="text" class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="course_name" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Organizator kursu</h1>
                    <input type="text" class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="course_organizer" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Lokalizacja odbywania kursu
                    </h1>
                    <input type="text" class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="course_location" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Data rozpoczęcia kursu</h1>
                    <input type="date" class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="course_start_date" required>
                </div>

                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Data zakończenia kursu</h1>
                    <input type="date" class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="course_end_date" required>
                </div>

                <div class="col-span-2 flex justify-center">
                    <button type="button"
                        class="bg-purple-500 text-2xl h-12 w-full mt-4 max-w-[600px] rounded-lg font-Tiny5 text-white uppercase"
                        onclick="handleCourseInsert()">Dodaj
                        Kurs</button>
                </div>
            </form>

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
                        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-2 rounded-md mt-3" onclick="handleCourseDeleteClick('.$row['course_id'].')">Usuń Kurs</button>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1000px] rounded-3xl p-8 mt-10 shadow-md shadow-pink-500">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Umiejętności / Uprawnienia</h1>
            <form method="POST" class="grid grid-cols-2 gap-y-5 gap-x-24 items-end">
                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Umiejętność uprawnienie</h1>
                    <input type="text" class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="ability_content" required>
                </div>
                <button type="button"
                    class="bg-pink-500 text-2xl h-12 w-full mt-4 max-w-[600px] rounded-lg font-Tiny5 text-white uppercase"
                    onclick="handleAbilityInsert()">Dodaj
                    Umiejętność</button>
            </form>

            <div id="ability-wrapper" class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM ability WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-2 border-2 border-dashed border-gray-500 mt-5 flex items-center">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center w-full">'.$row['ability_content'].'</h1>';
                        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-3 rounded-md mt-3 text-2xl" onclick="handleAbilityDeleteClick('.$row['ability_id'].')"><i class="fa-solid fa-trash-can"></i></button>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1000px] rounded-3xl p-8 mt-10 shadow-md shadow-orange-500">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Znane języki</h1>
            <form method="POST" class="grid grid-cols-2 gap-y-5 gap-x-24 items-end">
                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Język</h1>
                    <input type="text" class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="language_content" required>
                </div>
                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Poziom języka</h1>
                    <select class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="language_level" required>
                        <option>A1</option>
                        <option>A2</option>
                        <option>B1</option>
                        <option>B2</option>
                        <option>C1</option>
                        <option>C2</option>
                    </select>
                </div>
                <button type="button"
                    class="bg-orange-500 text-2xl h-12 w-full mt-4 max-w-[600px] rounded-lg font-Tiny5 text-white uppercase"
                    onclick="handleLanguageInsert()">Dodaj
                    Język</button>
            </form>

            <div id="language-wrapper" class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM language WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-2 border-2 border-dashed border-gray-500 mt-5 flex items-center">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center mr-2 text-green-500">'.$row['language_level'].'</h1>';
                        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center w-full">'.$row['language_content'].'</h1>';
                        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-3 rounded-md mt-3 text-2xl" onclick="handleLanguageDeleteClick('.$row['language_id'].')"><i class="fa-solid fa-trash-can"></i></button>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>

        <div class="bg-gray-600 w-full max-w-[1000px] rounded-3xl p-8 mt-10 shadow-md shadow-cyan-500 mb-20">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Linki do innych portali</h1>
            <form method="POST" class="grid grid-cols-2 gap-y-5 gap-x-24 items-end">
                <div>
                    <h1 class="text-gray-800 uppercase font-Tiny5 tracking-wider text-xl">Link</h1>
                    <input type="text" class="rounded-md outline-none font-Tiny5 text-xl text-gray-800 pl-2 h-12 w-full"
                        name="link_content" required>
                </div>
                <button type="button"
                    class="bg-cyan-500 text-2xl h-12 w-full mt-4 max-w-[600px] rounded-lg font-Tiny5 text-white uppercase"
                    onclick="handleLinkInsert()">Dodaj
                    link</button>
            </form>

            <div id="link-wrapper" class="mt-10">
                <?php
                $connect = @new mysqli("localhost","root","","job_portal_db");
                $select_query="SELECT * FROM link WHERE user_id=".$user_result['user_id'];
                $result = $connect->query($select_query);
                while($row = $result->fetch_assoc()){
                    echo '<div class="bg-white rounded-xl px-4 py-2 border-2 border-dashed border-gray-500 mt-5 flex items-center">';
                        echo '<h1 class="font-Tiny5 uppercase text-xl flex items-center w-full">'.$row['link_content'].'</h1>';
                        echo '<button class="bg-red-400 font-Tiny5 uppercase text-white px-4 py-3 rounded-md mt-3 text-2xl" onclick="handleLinkDeleteClick('.$row['link_id'].')"><i class="fa-solid fa-trash-can"></i></button>';
                    echo '</div>';
                }
                $connect->close();
                ?>
            </div>
        </div>
    </section>
</body>
<script src="js/profilePage.js">
</script>
<script src="js/burger_menu.js"></script>

</html>