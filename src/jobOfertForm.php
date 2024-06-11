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

  if(isset($_POST['btn_submit'])){
    require "services/jobOfertService.php";
    require "services/companyService.php";
    $job_ofert = new JobOfert();
    $job_ofert->position_name = $_POST['position_name'];
    $job_ofert->position_level = $_POST['position_level'];
    $job_ofert->recruitment_end_date = $_POST['recruitment_end_date'];
    $job_ofert->employment_contract = $_POST['employment_contract'];
    $job_ofert->employment_type = $_POST['employment_type'];
    $job_ofert->job_type = $_POST['job_type'];
    $job_ofert->salary_minimum = $_POST['salary_minimum'];
    $job_ofert->salary_maximum = $_POST['salary_maximum'];
    $job_ofert->work_days = $_POST['work_days'];
    $job_ofert->work_start_hour = $_POST['work_start_hour'];
    $job_ofert->work_end_hour = $_POST['work_end_hour'];

    if($_POST['company_add'] == "true"){
        $company = new Company();
        $company->company_name = $_POST['company_name'];
        $company->company_location = $_POST['company_location'];
        $company->company_address = $_POST['company_address'];
        $company->company_description = $_POST['company_description'];
        $job_ofert->company_id = InsertCompany($company);
    }else{
        $job_ofert->company_id = $_POST['company_from_db'];
    }

    function AddRequirements($job_ofert_id){
        if(isset($_POST['requirements'])){
            $requirements = $_POST['requirements'];
            $connect = @new mysqli("localhost","root","","job_portal_db");
            for ($i=0; $i < count($requirements); $i++) { 
                $insert_query = "INSERT INTO job_ofert_requirement(job_ofert_id,requirement_content) VALUES('$job_ofert_id','".$requirements[$i]."') ";
                $connect->query($insert_query);
            }
            $connect->close();
        }
    }

    function RemoveRequirements($job_ofert_id){
        if(isset($_POST['requirements'])){
            $connect = @new mysqli("localhost","root","","job_portal_db");
            $delete_query = "DELETE FROM job_ofert_requirement WHERE job_ofert_id=$job_ofert_id";
            $connect->query($delete_query);
            $connect->close();
        }
    }

    function AddBenefits($job_ofert_id){
        if(isset($_POST['benefits'])){
            $benefits = $_POST['benefits'];
            $connect = @new mysqli("localhost","root","","job_portal_db");
            for ($i=0; $i < count($benefits); $i++) { 
                $insert_query = "INSERT INTO job_ofert_benefit(job_ofert_id,benefit_content) VALUES('$job_ofert_id','".$benefits[$i]."') ";
                $connect->query($insert_query);
            }
            $connect->close();
        }
    }

    function RemoveBenefits($job_ofert_id){
        if(isset($_POST['benefits'])){
            $connect = @new mysqli("localhost","root","","job_portal_db");
            $delete_query = "DELETE FROM job_ofert_benefit WHERE job_ofert_id=$job_ofert_id";
            $connect->query($delete_query);
            $connect->close();
        }
    }

    function AddDuties($job_ofert_id){
        if(isset($_POST['duties'])){
            $duties = $_POST['duties'];
            $connect = @new mysqli("localhost","root","","job_portal_db");
            for ($i=0; $i < count($duties); $i++) { 
                $insert_query = "INSERT INTO job_ofert_duty(job_ofert_id,duty_content) VALUES('$job_ofert_id','".$duties[$i]."') ";
                $connect->query($insert_query);
            }
            $connect->close();
        }
    }

    function RemoveDuties($job_ofert_id){
        if(isset($_POST['duties'])){
            $connect = @new mysqli("localhost","root","","job_portal_db");
            $delete_query = "DELETE FROM job_ofert_duty WHERE job_ofert_id=$job_ofert_id";
            $connect->query($delete_query);
            $connect->close();
        }
    }

    function AddCategories($job_ofert_id){
        if(isset($_POST['categories'])){
            $categories = $_POST['categories'];
            $connect = @new mysqli("localhost","root","","job_portal_db");
            for ($i=0; $i < count($categories); $i++) { 
                $select_category = "SELECT * FROM category WHERE category_name='".$categories[$i]."'";
                $is_in_db = $connect->query($select_category)->num_rows;
                if($is_in_db > 0){
                    $category = $connect->query($select_category)->fetch_assoc();
                    $insert_query = "INSERT INTO job_ofert_category(job_ofert_id,category_id) VALUES('$job_ofert_id','".$category['category_id']."') ";
                    $connect->query($insert_query);
                }else{
                    $category = $connect->query($select_category)->fetch_assoc();
                    $insert_query_1 = "INSERT INTO category(category_name) VALUES ('".$categories[$i]."')";
                    $connect->query($insert_query_1);
                    $category_id = $connect->insert_id;
                    $insert_query_2 = "INSERT INTO job_ofert_category(job_ofert_id,category_id) VALUES('$job_ofert_id','".$category_id."') ";
                    $connect->query($insert_query_2);
                }
            }
            $connect->close();
        }
    }

    function RemoveCategories($job_ofert_id){
        if(isset($_POST['categories'])){
            $connect = @new mysqli("localhost","root","","job_portal_db");
            $select_categories = "SELECT category_id FROM job_ofert_category WHERE job_ofert_id=$job_ofert_id";
            $categories_result = $connect->query($select_categories);
            $delete_query = "DELETE FROM job_ofert_category WHERE job_ofert_id=$job_ofert_id";
            $connect->query($delete_query);
            while ($row = $categories_result->fetch_assoc()) { 
                $select_query = "SELECT * FROM job_ofert_category WHERE category_id=".$row['category_id'];
                $number = $connect->query($select_query)->num_rows;
                if($number < 1){
                    $delete_category_query = "DELETE FROM category WHERE category_id=".$row['category_id'];
                    $connect->query($delete_category_query);
                }
            }
            $connect->close();
        }
    }

    if($_POST['edit_mode'] == "true"){
        UpdateJobOfert($_POST['job_ofert_id'],$job_ofert);
        RemoveRequirements($_POST['job_ofert_id']);
        RemoveBenefits($_POST['job_ofert_id']);
        RemoveDuties($_POST['job_ofert_id']);
        RemoveCategories($_POST['job_ofert_id']);
        
        AddRequirements($_POST['job_ofert_id']);
        AddBenefits($_POST['job_ofert_id']);
        AddDuties($_POST['job_ofert_id']);
        AddCategories($_POST['job_ofert_id']);
        header("Location: jobOfertPage.php");
    }else{
      $job_ofert_id = InsertJobOfert($job_ofert);
      AddRequirements($job_ofert_id);
      AddBenefits($_POST['job_ofert_id']);
      AddDuties($_POST['job_ofert_id']);
      header("Location: jobOfertPage.php");
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

        <section class="w-full flex justify-center">
            <form method="POST"
                class="grid grid-cols-2 w-full max-w-[1000px] bg-gray-800 rounded-3xl mt-10 px-8 py-12 gap-x-20 gap-y-5">
                <?php
                require "services/jobOfertService.php";
                require "services/companyService.php";
                $job_ofert_edit_info = new JobOfert();
                if(isset($_GET['job_ofert_id'])){
                $job_ofert_edit_info = GetJobOfert($_GET['job_ofert_id']);
                }
                ?>
                <h1 class="col-span-2 font-Tiny5 text-3xl text-white uppercase">Firma</h1>
                <div class="col-span-2">
                    <select id="company-select" name="company_from_db"
                        class="w-full h-14 outline-none font-Tiny5 bg-slate-400 uppercase text-center text-xl text-white rounded-md">
                        <option disabled selected value="0">--- Wybierz firmę ---</option>
                        <?php 
                        $companies_result = GetAllCompanies();
                        $is_set = false;
                        $result = null;
                        if(isset($_GET['job_ofert_id'])){
                            $is_set = true;
                            $connect = @new mysqli("localhost","root","","job_portal_db");
                            $result = $connect->query("SELECT * FROM job_ofert JOIN company USING(company_id) WHERE job_ofert_id=".$_GET['job_ofert_id'])->fetch_assoc();
                            $connect->close();
                        }

                        while($row = $companies_result->fetch_assoc()){
                            if($is_set){
                                if($row['company_name'] == $result['company_name']){
                                    echo "<option value='".$row['company_id']."' selected>".$row['company_name']."</option>";
                                }else{
                                    echo "<option value='".$row['company_id']."'>".$row['company_name']."</option>";
                                }
                            }else{
                                echo "<option value='".$row['company_id']."'>".$row['company_name']."</option>";
                            }
                        }
                        ?>
                        <option>Dodaj nową</option>
                    </select>
                </div>

                <div id="company-input-wrapper" class="hidden grid-cols-2 col-span-2 gap-10">
                    <input type="hidden" name="company_add" value="false">
                    <div>
                        <h1 class="font-Tiny5 text-white uppercase text-xl">Nazwa firmy</h1>
                        <input type="text" name="company_name"
                            class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white">
                    </div>

                    <div>
                        <h1 class="font-Tiny5 text-white uppercase text-xl">Lokalizacja firmy</h1>
                        <input type="text" name="company_location"
                            class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white">
                    </div>

                    <div class="col-span-2">
                        <h1 class="font-Tiny5 text-white uppercase text-xl">Adres firmy</h1>
                        <input type="text" name="company_address"
                            class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white">
                    </div>

                    <div class="col-span-2">
                        <h1 class="font-Tiny5 text-white uppercase text-xl">Opis firmy</h1>
                        <textarea type="text" name="company_description"
                            class="w-full rounded-md outline-none h-48 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"></textarea>
                    </div>
                </div>

                <h1 class="col-span-2 font-Tiny5 text-3xl text-white uppercase">Opis stanowiska</h1>
                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Nazwa stanowiska</h1>
                    <input type="text" name="position_name" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['job_ofert_id']) ? $job_ofert_edit_info->position_name : "" ?>">
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Data końca rekrutacjii</h1>
                    <input type="date" name="recruitment_end_date" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['job_ofert_id']) ? $job_ofert_edit_info->recruitment_end_date : "" ?>">
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Poziom stanowiska</h1>
                    <select name="position_level"
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white">
                        <option
                            <?php if($job_ofert_edit_info->position_level == "praktykant/stażysta") echo "selected" ?>>
                            praktykant/stażysta</option>
                        <option <?php if($job_ofert_edit_info->position_level == "asystent") echo "selected" ?>>asystent
                        </option>
                        <option <?php if($job_ofert_edit_info->position_level == "junior") echo "selected" ?>>junior
                        </option>
                        <option <?php if($job_ofert_edit_info->position_level == "mid") echo "selected" ?>>mid</option>
                        <option <?php if($job_ofert_edit_info->position_level == "senior") echo "selected" ?>>senior
                        </option>
                        <option <?php if($job_ofert_edit_info->position_level == "ekspert") echo "selected" ?>>ekspert
                        </option>
                        <option
                            <?php if($job_ofert_edit_info ->position_level== "kierownik/koordynator") echo "selected" ?>>
                            kierownik/koordynator</option>
                        <option <?php if($job_ofert_edit_info->position_level == "menedżer") echo "selected" ?>>menedżer
                        </option>
                        <option <?php if($job_ofert_edit_info->position_level == "dyrektor") echo "selected" ?>>dyrektor
                        </option>
                        <option <?php if($job_ofert_edit_info->position_level == "prezes") echo "selected" ?>>prezes
                        </option>
                        <option disabled <?php if($job_ofert_edit_info->position_level == "") echo "selected" ?>>Wybierz
                            poziom stanowiska
                        </option>
                    </select>
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Rodzaj umowy</h1>
                    <select name="employment_contract"
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white">
                        <option
                            <?php if($job_ofert_edit_info->employment_contract == "Umowa o pracę na czas nieokreślony") echo "selected" ?>>
                            Umowa o pracę na czas nieokreślony</option>
                        <option
                            <?php if($job_ofert_edit_info->employment_contract == "Umowa o pracę na czas określony") echo "selected" ?>>
                            Umowa o pracę na czas określony</option>
                        <option
                            <?php if($job_ofert_edit_info->employment_contract == "Umowa o pracę na czas częściowy") echo "selected" ?>>
                            Umowa o pracę na czas częściowy</option>
                        <option
                            <?php if($job_ofert_edit_info->employment_contract == "Umowa o pracę tymczasową") echo "selected" ?>>
                            Umowa o pracę tymczasową</option>
                        <option <?php if($job_ofert_edit_info->employment_contract == "B2B") echo "selected" ?>>B2B
                        </option>
                        <option disabled <?php if($job_ofert_edit_info->employment_contract == "") echo "selected" ?>>
                            Wybierz rodzaj umowy</option>
                    </select>
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Wymiar zatrudnienia</h1>
                    <select name="employment_type"
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white">
                        <option <?php if($job_ofert_edit_info->employment_type == "Pełny etat") echo "selected" ?>>Pełny
                            etat</option>
                        <option <?php if($job_ofert_edit_info->employment_type == "Czas częściowy") echo "selected" ?>>
                            Czas częściowy</option>
                        <option
                            <?php if($job_ofert_edit_info->employment_type == "Zatrudnienie na okresie próbnym") echo "selected" ?>>
                            Zatrudnienie na okresie próbnym</option>
                        <option <?php if($job_ofert_edit_info->employment_type == "Praca sezonowa") echo "selected" ?>>
                            Praca sezonowa</option>
                        <option
                            <?php if($job_ofert_edit_info->employment_type == "Zatrudnienie tymczasowe") echo "selected" ?>>
                            Zatrudnienie tymczasowe</option>
                        <option disabled <?php if($job_ofert_edit_info->employment_type == "") echo "selected" ?>>
                            Wybierz
                            wymiar zatrudnienia</option>
                    </select>
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Rodzaj pracy</h1>
                    <select name="job_type"
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white">
                        <option <?php if($job_ofert_edit_info->job_type == "Zdalna") echo "selected" ?>>Zdalna</option>
                        <option <?php if($job_ofert_edit_info->job_type == "Stacjonarna") echo "selected" ?>>Stacjonarna
                        </option>
                        <option <?php if($job_ofert_edit_info->job_type == "Hybrydowa") echo "selected" ?>>Hybrydowa
                        </option>
                        <option disabled <?php if($job_ofert_edit_info->job_type == "") echo "selected" ?>>Wybierz
                            rodzaj
                            pracy</option>
                    </select>
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Pensja minimalna</h1>
                    <input type="number" name="salary_minimum" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['job_ofert_id']) ? $job_ofert_edit_info->salary_minimum : "" ?>">
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Pensja maksymalna</h1>
                    <input type="number" name="salary_maximum" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['job_ofert_id']) ? $job_ofert_edit_info->salary_maximum : "" ?>">
                </div>

                <div class="col-span-2">
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Dni pracy</h1>
                    <input type="text" name="work_days" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['job_ofert_id']) ? $job_ofert_edit_info->work_days : "" ?>">
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Godzina rozpoczęcia pracy</h1>
                    <input type="time" name="work_start_hour" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['job_ofert_id']) ? $job_ofert_edit_info->work_start_hour : "" ?>">
                </div>

                <div>
                    <h1 class="font-Tiny5 text-white uppercase text-xl">Godzina zakończenia pracy</h1>
                    <input type="time" name="work_end_hour" required
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white"
                        value="<?php echo isset($_GET['job_ofert_id']) ? $job_ofert_edit_info->work_end_hour : "" ?>">
                </div>


                <h1 class="font-Tiny5 text-white uppercase text-3xl col-span-2">Dodaj kategorię</h1>
                <div>
                    <select id="category-select"
                        class="w-full h-14 outline-none font-Tiny5 bg-slate-400 uppercase text-center text-xl text-white rounded-md">
                        <option selected disabled>--- Wybierz kategorię ---</option>
                        <?php
                        $connect = @new mysqli("localhost","root","","job_portal_db");
                        $result = $connect->query("SELECT * FROM category");
                        $connect->close();
                        while($row = $result->fetch_assoc()){
                            echo '<option>'.$row['category_name'].'</option>';
                        }
                        ?>
                        <option>Inna</option>
                    </select>
                    <input type="text" id="cateogry-input"
                        class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white mt-2 hidden">
                </div>
                <button id="category-button" type="button"
                    class="bg-gray-700 font-Tiny5 uppercase rounded-md text-white">Dodaj kategorię</button>
                <ul id="category-list" class="flex flex-col gap-2">
                    <?php
                    if(isset($_GET['job_ofert_id']) ){
                        $connect = @new mysqli("localhost","root","","job_portal_db");
                        $result = $connect->query("SELECT * FROM job_ofert_category JOIN category USING(category_id) WHERE job_ofert_id=".$_GET['job_ofert_id']);
                        $counter = 0;
                        while($row = $result->fetch_assoc()){
                            echo '<li class="flex items-center text-2xl" group="category-li-'.$counter.'">
                                <i class="fa-solid fa-square-caret-right mr-3 text-2xl text-pink-600"></i>
                                <input name="categories[]" value="'.$row['category_name'].'" class="w-full bg-transparent align-middle outline-none pointer-events-none font-Tiny5 uppercase text-white text-xl">
                                <button type="button" onclick="deleteCategoryLiClick('.$counter.')" class="bg-red-400 px-3 rounded-md py-1 text-white">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </li>';
                            $counter++;
                        }
                        $connect->close();
                    }
                    ?>
                </ul>

                <h1 class="font-Tiny5 text-white uppercase text-3xl col-span-2">Dodaj wymagania</h1>
                <input type="text" id="requirement-input"
                    class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white mt-2">
                <button id="requirement-button" type="button"
                    class="bg-gray-700 font-Tiny5 uppercase rounded-md text-white">Dodaj wymaganie</button>
                <ul id="requirement-list" class="flex flex-col gap-2">
                    <?php
                    if(isset($_GET['job_ofert_id']) ){
                        $connect = @new mysqli("localhost","root","","job_portal_db");
                        $result = $connect->query("SELECT * FROM job_ofert_requirement WHERE job_ofert_id=".$_GET['job_ofert_id']);
                        $counter = 0;
                        while($row = $result->fetch_assoc()){
                            echo '<li class="flex items-center text-2xl" group="requirement-li-'.$counter.'">
                            <i class="fa-solid fa-square-caret-right mr-3 text-2xl text-green-300"></i>
                            <input name="requirements[]" value="'.$row['requirement_content'].'"  class="w-full bg-transparent align-middle outline-none pointer-events-none font-Tiny5 uppercase text-white text-xl">
                            <button type="button" onclick="deleteRequirementClick('.$counter.')"  class="bg-red-400 px-3 rounded-md py-1 text-white">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </li>';
                        $counter++;
                        }
                        $connect->close();
                    }
                    ?>
                </ul>

                <h1 class="font-Tiny5 text-white uppercase text-3xl col-span-2">Dodaj korzyści</h1>
                <input type="text" id="benefit-input"
                    class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white mt-2">
                <button id="benefit-button" type="button"
                    class="bg-gray-700 font-Tiny5 uppercase rounded-md text-white">Dodaj korzyść</button>
                <ul id="benefit-list" class="flex flex-col gap-2">
                    <?php
                    if(isset($_GET['job_ofert_id']) ){
                        $connect = @new mysqli("localhost","root","","job_portal_db");
                        $result = $connect->query("SELECT * FROM job_ofert_benefit WHERE job_ofert_id=".$_GET['job_ofert_id']);
                        $counter = 0;
                        while($row = $result->fetch_assoc()){
                            echo '<li class="flex items-center text-2xl" group="benefit-li-'.$counter.'">
                            <i class="fa-solid fa-square-caret-right mr-3 text-2xl text-yellow-300"></i>
                            <input name="benefits[]" value="'.$row['benefit_content'].'" class="w-full bg-transparent align-middle outline-none pointer-events-none font-Tiny5 uppercase text-white text-xl">
                            <button type="button" onclick="deleteBenefitClick('.$counter.')" class="bg-red-400 px-3 rounded-md py-1 text-white">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            </li>';
                            $counter++;
                        }
                        $connect->close();
                    }
                    ?>
                </ul>

                <h1 class="font-Tiny5 text-white uppercase text-3xl col-span-2">Dodaj obowiązki</h1>
                <input type="text" id="duty-input"
                    class="w-full rounded-md outline-none h-14 text-xl font-Tiny5 uppercase pl-2 bg-slate-400 text-white mt-2">
                <button id="duty-button" type="button"
                    class="bg-gray-700 font-Tiny5 uppercase rounded-md text-white">Dodaj obowiązek</button>
                <ul id="duty-list" class="flex flex-col gap-2">
                    <?php
                    if(isset($_GET['job_ofert_id']) ){
                        $connect = @new mysqli("localhost","root","","job_portal_db");
                        $result = $connect->query("SELECT * FROM job_ofert_duty WHERE job_ofert_id=".$_GET['job_ofert_id']);
                        $counter = 0;
                        while($row = $result->fetch_assoc()){
                            echo '<li class="flex items-center text-2xl" group="duty-li-'.$counter.'">
                            <i class="fa-solid fa-square-caret-right mr-3 text-2xl text-sky-300"></i>
                            <input name="duties[]" value="'.$row['duty_content'].'"  class="w-full bg-transparent align-middle outline-none pointer-events-none font-Tiny5 uppercase text-white text-xl">
                            <button type="button" onclick="deleteDutyClick('.$counter.')"  class="bg-red-400 px-3 rounded-md py-1 text-white">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            </li>';
                            $counter++;
                        }
                        $connect->close();
                    }
                    ?>
                </ul>

                <input type="hidden" value="true" name="btn_submit">
                <?php
                echo isset($_GET['job_ofert_id']) 
                ? '<input type="hidden" value="true" name="edit_mode"> 
                   <input type="hidden" value="'.$_GET['job_ofert_id'].'" name="job_ofert_id">' 
                : '<input type="hidden" value="false" name="edit_mode">';
                
                ?>
                <div class="flex w-full justify-center mt-10 col-span-2 ">
                    <button
                        class="px-6 py-4 w-full max-w-[300px] bg-green-500 rounded-md font-Tiny5 text-white uppercase text-2xl">Dodaj
                        ofertę pracy</button>
                </div>
            </form>
        </section>
    </main>
</body>
<script src="js/jobOfertForm.js"></script>
<script src="js/burger_menu.js"></script>

</html>