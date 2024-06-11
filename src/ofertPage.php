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
    $job_ofert_id = $_GET['job_ofert_id'];
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $select_job_ofert_query = "SELECT * FROM job_ofert JOIN company USING(company_id) WHERE job_ofert_id=$job_ofert_id";
    $full_job_ofert = $connect->query($select_job_ofert_query)->fetch_assoc();
    $connect->close();
    ?>

    <section class="w-full flex flex-col items-center">
        <div class="w-full max-w-[1000px] bg-gray-800 mt-10 px-4 py-8 flex flex-col items-center rounded-t-xl">
            <h1 class="font-Tiny5 text-5xl text-white uppercase"><?php echo $full_job_ofert['position_name']?></h1>
            <h2 class="font-Tiny5 text-3xl text-gray-500 uppercase italic"><?php echo $full_job_ofert['company_name']?>
            </h2>
        </div>
        <div class="w-full max-w-[1000px] bg-gray-600 px-10 py-8 rounded-b-3xl">
            <div class="flex items-center border-2 border-green-300 text-green-300 max-w-[400px] px-2 py-4 rounded-xl">
                <i class="fa-solid fa-map-location-dot ml-2 text-3xl"></i>
                <h2 class="ml-5 font-Tiny5 uppercase tracking-wider text-2xl">
                    <?php echo $full_job_ofert['company_address']; ?>
                </h2>
            </div>
            <div
                class="flex items-center border-2 border-yellow-500 text-yellow-600 max-w-[500px] px-2 py-4 rounded-xl mt-3">
                <i class="fa-solid fa-chart-simple ml-2 text-3xl"></i>
                <h2 class="ml-5 font-Tiny5 uppercase tracking-wider text-2xl">
                    <?php echo $full_job_ofert['position_level']; ?>
                </h2>
            </div>

            <div
                class="flex items-center border-2 border-pink-500 text-pink-500 max-w-[600px] px-2 py-4 rounded-xl mt-3">
                <i class="fa-regular fa-newspaper ml-2 text-3xl"></i>
                <h2 class="ml-5 font-Tiny5 uppercase tracking-wider text-2xl">
                    <?php echo $full_job_ofert['employment_contract']; ?>
                </h2>
            </div>

            <div
                class="flex items-center border-2 border-purple-400 text-purple-400 max-w-[600px] px-2 py-4 rounded-xl mt-3">
                <i class="fa-solid fa-mug-saucer ml-2 text-3xl"></i>
                <h2 class="ml-5 font-Tiny5 uppercase tracking-wider text-2xl">
                    <?php echo $full_job_ofert['employment_type']; ?>
                </h2>
            </div>

            <div class="flex items-center border-2 border-red-300 text-red-300 max-w-[500px] px-2 py-4 rounded-xl mt-3">
                <i class="fa-regular fa-calendar-xmark ml-2 text-3xl"></i>
                <h2 class="ml-5 font-Tiny5 uppercase tracking-wider text-2xl">
                    <?php echo $full_job_ofert['recruitment_end_date']; ?>
                </h2>
            </div>

            <div
                class="flex items-center border-2 border-cyan-300 text-cyan-300 max-w-[400px] px-2 py-4 rounded-xl mt-3">
                <i class="fa-solid fa-house-laptop ml-2 text-3xl"></i>
                <h2 class="ml-5 font-Tiny5 uppercase tracking-wider text-2xl">
                    <?php echo $full_job_ofert['job_type']; ?>
                </h2>
            </div>
        </div>

        <div class="w-full max-w-[1000px] bg-gray-800 mt-10 px-4 py-8 flex flex-col items-center rounded-xl">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Wymagania</h1>
            </h2>
        </div>
        <div class="w-full max-w-[1000px] bg-gray-600 px-10 py-8 rounded-b-3xl">
            <ul>
                <?php
            $connect = @new mysqli("localhost","root","","job_portal_db");
            $select_query = "SELECT * FROM job_ofert_requirement WHERE job_ofert_id=".$full_job_ofert['job_ofert_id'];
            $result = $connect->query($select_query);
            while($row = $result->fetch_assoc()){
                echo '<li class="flex items-center gap-5 my-2 text-green-300">'; 
                    echo '<i class="fa-solid fa-square-caret-right mr-2 text-3xl"></i>';
                    echo '<h2 class="font-Tiny5 uppercase text-xl text-white">'.$row['requirement_content'].'</h2>';
                echo '</li>';
            }
            $connect->close();
            ?>
            </ul>
        </div>

        <div class="w-full max-w-[1000px] bg-gray-800 mt-10 px-4 py-8 flex flex-col items-center rounded-xl">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Korzyści</h1>
            </h2>
        </div>
        <div class="w-full max-w-[1000px] bg-gray-600 px-10 py-8 rounded-b-3xl">
            <ul>
                <?php
            $connect = @new mysqli("localhost","root","","job_portal_db");
            $select_query = "SELECT * FROM job_ofert_benefit WHERE job_ofert_id=".$full_job_ofert['job_ofert_id'];
            $result = $connect->query($select_query);
            while($row = $result->fetch_assoc()){
                echo '<li class="flex items-center gap-5 my-2 text-pink-400">'; 
                    echo '<i class="fa-solid fa-square-caret-right mr-2 text-3xl"></i>';
                    echo '<h2 class="font-Tiny5 uppercase text-xl text-white">'.$row['benefit_content'].'</h2>';
                echo '</li>';
            }
            $connect->close();
            ?>
            </ul>
        </div>

        <div class="w-full max-w-[1000px] bg-gray-800 mt-10 px-4 py-8 flex flex-col items-center rounded-xl">
            <h1 class="font-Tiny5 text-5xl text-white uppercase">Obowiązki</h1>
            </h2>
        </div>
        <div class="w-full max-w-[1000px] bg-gray-600 px-10 py-8 rounded-b-3xl">
            <ul>
                <?php
            $connect = @new mysqli("localhost","root","","job_portal_db");
            $select_query = "SELECT * FROM job_ofert_duty WHERE job_ofert_id=".$full_job_ofert['job_ofert_id'];
            $result = $connect->query($select_query);
            while($row = $result->fetch_assoc()){
                echo '<li class="flex items-center gap-5 my-2 text-blue-400">'; 
                    echo '<i class="fa-solid fa-square-caret-right mr-2 text-3xl"></i>';
                    echo '<h2 class="font-Tiny5 uppercase text-xl text-white">'.$row['duty_content'].'</h2>';
                echo '</li>';
            }
            $connect->close();
            ?>
            </ul>
        </div>

        <div class="grid grid-cols-2 w-full max-w-[1000px] gap-20 my-10 px-4">
            <?php
            $connect = @new mysqli("localhost","root","","job_portal_db");
            $application = $connect->query("SELECT * FROM current_application WHERE job_ofert_id=".$full_job_ofert['job_ofert_id']." AND user_id=".$_SESSION['loged_user_id'])->num_rows;
            $favourite = $connect->query("SELECT * FROM favourite_application WHERE job_ofert_id=".$full_job_ofert['job_ofert_id']." AND user_id=".$_SESSION['loged_user_id'])->num_rows;
            $connect->close();
            ?>
            <form method="GET" class="w-full <?php echo $application < 1 ? 'block' : 'hidden'?>">
                <input type="hidden" value="true" name="add_current">
                <input type="hidden" value="<?php echo $full_job_ofert['job_ofert_id']; ?>" name="job_ofert_id">
                <button class="bg-green-500 h-14 rounded-md font-Tiny5 uppercase text-2xl text-white w-full">Aplikuj na
                    stanowisko</button>
            </form>
            <form method="GET" class="w-full <?php echo $favourite < 1 ? 'block' : 'hidden'?>">
                <input type="hidden" value="true" name="add_favourite">
                <input type="hidden" value="<?php echo $full_job_ofert['job_ofert_id']; ?>" name="job_ofert_id">
                <button class="bg-pink-500 h-14 rounded-md font-Tiny5 uppercase text-2xl text-white w-full">Dodaj do
                    ulubionych</button>
            </form>
        </div>

    </section>

</body>
<script src="js/burger_menu.js"></script>

</html>