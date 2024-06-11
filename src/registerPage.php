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
    
    if(isset($_SESSION['loged'])){
        header("Location: index.php");
    }
    
    if(isset($_POST['btn_submit'])){
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $birthday = $_POST['birthday'];
        $location = $_POST['location'];
        $password = $_POST['password'];
        $password_repeat = $_POST['password_repeat'];

        $correct = true;
        $connect = @new mysqli("localhost","root","","job_portal_db");

        if($password != $password_repeat){
            $correct = false;
        }

        $select_email_query = "SELECT * FROM user WHERE email='$email'";
        $email_count = $connect->query($select_email_query)->num_rows;
        if($email_count > 0){
            $correct = false;
        }

        $select_phone_query = "SELECT * FROM user WHERE phone_number='$phone'";
        $phone_count = $connect->query($select_phone_query)->num_rows;
        if($phone_count > 0){
            $correct = false;
        }

        if($correct){
            $options = [
                'cost' => 12,
            ];
            $hash = password_hash($password, PASSWORD_BCRYPT, $options);
            $insert_query = "INSERT INTO user(name,surname,phone_number,email,password,birth_date,location,access) VALUES ('$name','$surname','$phone','$email','$hash','$birthday','$location','user')";
            $connect->query($insert_query);
            $connect->close();
            header("Location: registerPage.php");
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

    <section class="flex flex-col items-center mt-10">
        <h1 class="text-white text-6xl uppercase font-Tiny5">Zarejestruj się</h1>
        <form method="post"
            class="w-full max-w-[600px] bg-gray-900 shadow-lg shadow-cyan-400 px-8 py-8 rounded-xl grid-cols-2 grid gap-5 mt-10">
            <div class="w-full">
                <h1 class="font-Tiny5 text-white text-lg tracking-wide uppercase">Imię</h1>
                <input type="text" name="name"
                    class="w-full rounded-md outline-none shadow-md shadow-cyan-800 h-12 pl-2 font-Tiny5 text-xl"
                    placeholder="Imię" required>
            </div>

            <div>
                <h1 class="font-Tiny5 text-white text-lg tracking-wide uppercase">Nazwisko</h1>
                <input type="text" name="surname"
                    class="w-full rounded-md outline-none shadow-md shadow-cyan-800 h-12 pl-2 font-Tiny5 text-xl"
                    placeholder="Nazwisko" required>
            </div>

            <div>
                <h1 class="font-Tiny5 text-white text-lg tracking-wide uppercase">E-mail</h1>
                <input type="email" name="email"
                    class="w-full rounded-md outline-none shadow-md shadow-cyan-800 h-12 pl-2 font-Tiny5 text-xl"
                    placeholder="E-mail" required>
            </div>

            <div>
                <h1 class="font-Tiny5 text-white text-lg tracking-wide uppercase">Numer telefonu</h1>
                <input type="number" name="phone"
                    class="w-full rounded-md outline-none shadow-md shadow-cyan-800 h-12 pl-2 font-Tiny5 text-xl"
                    placeholder="Numer telefonu" required>
            </div>

            <div>
                <h1 class="font-Tiny5 text-white text-lg tracking-wide uppercase">Hasło</h1>
                <input type="password" name="password"
                    class="w-full rounded-md outline-none shadow-md shadow-cyan-800 h-12 pl-2 font-Tiny5 text-xl"
                    placeholder="Hasło" required>
            </div>

            <div>
                <h1 class="font-Tiny5 text-white text-lg tracking-wide uppercase">Powtórz hasło</h1>
                <input type="password" name="password_repeat"
                    class="w-full rounded-md outline-none shadow-md shadow-cyan-800 h-12 pl-2 font-Tiny5 text-xl"
                    placeholder="Powtórz hasło" required>
            </div>

            <div>
                <h1 class="font-Tiny5 text-white text-lg tracking-wide uppercase">Data urodzenia</h1>
                <input type="date" name="birthday" placeholder="Data urodzin"
                    class="w-full rounded-md outline-none shadow-md shadow-cyan-800 h-12 pl-2 font-Tiny5 text-xl"
                    required>
            </div>

            <div>
                <h1 class="font-Tiny5 text-white text-lg tracking-wide uppercase">Miejscowość</h1>
                <input type="text" name="location"
                    class="w-full rounded-md outline-none shadow-md shadow-cyan-800 h-12 pl-2 font-Tiny5 text-xl"
                    placeholder="Miejscowość" required>
            </div>
            <input type="hidden" name="btn_submit" value="true">
            <div class="flex col-span-2 justify-center">
                <button
                    class="w-full max-w-[300px] font-Tiny5 text-xl uppercase tracking-wide text-white bg-cyan-700 rounded-md h-12">Zarejestruj
                    się</button>
            </div>
        </form>
    </section>
</body>
<script src="js/registerPage.js">
</script>
<script src="js/burger_menu.js"></script>

</html>