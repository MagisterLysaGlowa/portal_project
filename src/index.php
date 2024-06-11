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
        header("Location: currentApplicationPage.php?job_ofert_id=$job_ofert_id");
    }
}

if(isset($_GET['add_favourite'])){
    if(isset($_SESSION['loged_user_id'])){
        $job_ofert_id = $_GET['job_ofert_id'];
        $insert_query = "INSERT INTO favourite_application(job_ofert_id,user_id) VALUES ('$job_ofert_id','".$_SESSION['loged_user_id']."')";
        $connect = @new mysqli("localhost","root","","job_portal_db");
        $connect->query($insert_query);
        $connect->close();
        header("Location: favouritePage.php?job_ofert_id=$job_ofert_id");
    }
}

?>

<body class="main-bg overflow-x-hidden">
    <main>
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

        <article class="w-full flex flex-col items-center">

            <section class="bg-gray-900 max-w-[1400px] px-8 py-8 w-full mt-5 rounded-md shadow-md shadow-cyan-400">
                <h1 class="font-Tiny5 text-white text-2xl">Filtruj</h1>
                <form class="grid grid-cols-2 gap-5">
                    <div class="col-span-2">
                        <h2 class="text-white font-Tiny5 uppercase" id="esa">Nazwa stanowiska</h2>
                        <input type="text" placeholder="Nazwa stanowiska"
                            class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400"
                            name="position_name_input">
                    </div>
                    <div>
                        <h2 class="text-white font-Tiny5 uppercase">Kategoria</h2>
                        <select class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400">
                            <option disabled selected>Wybierz kategorię</option>
                            <?php
                            $connect = @new mysqli("localhost","root","","job_portal_db");
                            $result = $connect->query("SELECT * FROM category");
                            while($row = $result->fetch_assoc()){
                                echo '<option>'.$row['category_name'].'</option>';
                            }
                            $connect->close();
                            ?>
                        </select>
                    </div>
                    <div>
                        <h2 class="text-white font-Tiny5 uppercase">Poziom stanowiska</h2>
                        <select name="position_level_select"
                            class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400">
                            <option>praktykant/stażysta</option>
                            <option>asystent</option>
                            <option>junior</option>
                            <option>mid</option>
                            <option>senior</option>
                            <option <>ekspert</option>
                            <option>kierownik/koordynator</option>
                            <option>menedżer</option>
                            <option>dyrektor</option>
                            <option>prezes</option>
                            <option disabled selected>Wybierz poziom stanowiska</option>
                        </select>
                    </div>

                    <div class="col-span-2 grid grid-cols-3 gap-5">
                        <div>
                            <h2 class="text-white font-Tiny5 uppercase">Rodzaj umowy</h2>
                            <select name="employment_contract_select"
                                class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400">
                                <option>Umowa o pracę na czas nieokreślony</option>
                                <option>Umowa o pracę na czas określony</option>
                                <option>Umowa o pracę na czas częściowy</option>
                                <option>Umowa o pracę tymczasową</option>
                                <option disabled selected>Wybierz rodzaj umowy</option>
                            </select>
                        </div>
                        <div>
                            <h2 class="text-white font-Tiny5 uppercase">Wymiar zatrudnienia</h2>
                            <select name="employment_type_select"
                                class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400">
                                <option>Pełny etat</option>
                                <option>Czas częściowy</option>
                                <option>Zatrudnienie na okresie próbnym</option>
                                <option>Praca sezonowa</option>
                                <option>Zatrudnienie tymczasowe</option>
                                <option disabled selected>wybierz wymiar zatrudnienia</option>
                            </select>
                        </div>
                        <div>
                            <h2 class="text-white font-Tiny5 uppercase">Rodzaj pracy</h2>
                            <select name="job_type_select"
                                class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400">
                                <option>Zdalna</option>
                                <option>Stacjonarna</option>
                                <option>Hybrydowa</option>
                                <option disabled selected>Wybierz rodzaj pracy</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-white font-Tiny5 uppercase">Wynagrodzenie minimum</h2>
                        <input type="number" name="salary_minimum_select"
                            class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400">
                    </div>
                    <div>
                        <h2 class="text-white font-Tiny5 uppercase">Wynagrodzenie maximum</h2>
                        <input type="number" name="salary_maximum_select"
                            class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400">
                    </div>

                    <div class="col-span-2">
                        <h2 class="text-white font-Tiny5 uppercase">Data zakończenia rekrutacji</h2>
                        <input type="date" name="recruitment_end_date_select"
                            class="w-full pl-2 py-2 rounded-md bg-slate-600 font-Tiny5 uppercase text-slate-400">
                    </div>

                    <div class="col-span-2 flex justify-end">
                        <button type="button" onclick="submitFilterForm()"
                            class="max-w-[350px] w-full bg-blue-400 h-12 rounded-md text-white font-Tiny5">Filtruj</button>
                    </div>
                </form>
            </section>

            <section class="max-w-[1400px] w-full">
                <h1>Oferty pracy</h1>
                <div class="flex flex-col gap-10" id="filtered">
                    <?php
                    $connect = @new mysqli("localhost","root","","job_portal_db");
                    $select_query = "SELECT * FROM job_ofert";
                    $result = $connect->query($select_query);
                    while($row = $result->fetch_assoc()){
                        $job_ofert_id = intval($row['job_ofert_id']);
                        $company_for_job_ofert = $connect->query("SELECT * FROM company WHERE company_id=".$row['company_id'])->fetch_assoc();
                        echo '<a class="bg-gray-900 rounded-md w-full px-8 py-8 shadow-sm shadow-cyan-500" href="ofertPage.php?job_ofert_id='.$job_ofert_id.'">';
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

                                if(isset($_SESSION['loged'])){                                    
                                    echo '<div class=" flex flex-col justify-center items-end gap-5">';
                                        $application = $connect->query("SELECT * FROM current_application WHERE job_ofert_id=$job_ofert_id AND user_id=".$_SESSION['loged_user_id'])->num_rows;
                                        $favourite = $connect->query("SELECT * FROM favourite_application WHERE job_ofert_id=$job_ofert_id AND user_id=".$_SESSION['loged_user_id'])->num_rows;
    
                                        if($application < 1){
                                            echo '<form class="max-w-[250px] w-full" method="GET">';
                                                echo '<input type="hidden" value="true" name="add_current">'; 
                                                echo '<input type="hidden" value="'.$row['job_ofert_id'].'" name="job_ofert_id">'; 
                                                echo '<button class="text-green-400 border-2 border-green-400 text-lg font-Tiny5 uppercase w-full rounded-lg py-2">Aplikuj</button>';
                                            echo '</form>';
                                        }
                                        if($favourite < 1){
                                            echo '<form class="max-w-[250px] w-full" method="GET">';
                                                echo '<input type="hidden" value="true" name="add_favourite">'; 
                                                echo '<input type="hidden" value="'.$row['job_ofert_id'].'" name="job_ofert_id">'; 
                                                echo '<button class="text-red-400 border-2 border-red-400 text-lg font-Tiny5 uppercase w-full rounded-lg py-2">Zapisz</button>';
                                            echo '</form>';
                                        }
                                    echo '</div>';
                                }
                            echo '</div>';
                        echo '</a>';
                    }
                    $connect->close();
                    ?>
                </div>
            </section>

        </article>

        <footer>
            esa
        </footer>
        <h1>index</h1>
    </main>
</body>
<script src="js/index.js"></script>
<script src="js/burger_menu.js"></script>


</html>