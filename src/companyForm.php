<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portal Ogłoszeniowy</title>
    <link rel="stylesheet" href="./output.css" />
    <link rel="stylesheet" href="./input.css" />
</head>

<?php 

  session_start();

  if(isset($_POST['btn_submit'])){
    require "services/companyService.php";
    $company = new Company();
    $company->company_name = $_POST['company_name'];
    $company->company_location = $_POST['company_location'];
    $company->company_address = $_POST['company_address'];
    $company->company_description = $_POST['company_description'];

    if($_POST['edit_mode'] == "true"){
      UpdateCompany($_POST['company_id'],$company);
      header("Location: companyPage.php");
    }else{
      InsertCompany($company);
      header("Location: companyForm.php");
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

        <section class="w-full flex flex-col items-center mt-10">
            <form method="POST"
                class=" w-full text-2xl uppercase max-w-[1000px] rounded-3xl  text-white  font-Tiny5 bg-gray-800 px-8 py-14">
                <?php
              require "services/companyService.php";
              $company_edit_info = new Company();
              if(isset($_GET['company_id'])){
                $company_edit_info = GetCompany($_GET['company_id']);
              }
              ?>
                <div>
                    <h1>Nazwa firmy</h1>
                    <input type="text" name="company_name" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['company_id']) ? $company_edit_info->company_name : "" ?>">
                </div>

                <div>
                    <h1>Lokalizacja firmy</h1>
                    <input type="text" name="company_location" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['company_id']) ? $company_edit_info->company_location : "" ?>">
                </div>

                <div>
                    <h1>Adres firmy</h1>
                    <input type="text" name="company_address" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['company_id']) ? $company_edit_info->company_address : "" ?>">
                </div>

                <div>
                    <h1>Opis firmy</h1>
                    <textarea type="text" name="company_description"
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        required><?php echo isset($_GET['company_id']) ? $company_edit_info->company_description : "" ?></textarea>
                </div>

                <input type="hidden" value="true" name="btn_submit">
                <?php
              echo isset($_GET['company_id']) 
              ? '<input type="hidden" value="true" name="edit_mode"> <input type="hidden" value="'.$_GET['company_id'].'" name="company_id">' 
              : '<input type="hidden" value="false" name="edit_mode">';
              
              ?>
                <div class="flex justify-center">
                    <?php 
                  echo isset($_GET['company_id']) 
                  ? '<button class="bg-yellow-500 rounded-md uppercase px-10 py-2">Edytuj firmę</button>'
                  : '<button class="bg-green-500 rounded-md uppercase px-10 py-2">Dodaj firmę</button>';
                  ?>
                </div>
            </form>
        </section>
    </main>
</body>
<script src="js/burger_menu.js"></script>

</html>