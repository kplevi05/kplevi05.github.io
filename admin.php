<html>
<head>
    <title>Admin</title>
    <script>
        function scroll(){
            window.scrollBy(0,300);
        }
    </script>
    <script>
    function radio_eye(){
        var eye = document.getElementById("eye");
        var eye2 =document.getElementById("eye2");
        var pass = document.getElementById("pass");
        

        if(eye.style.display === "block"){
            eye.style.display = "none";
            eye2.style.display = "block";
            pass.type = "text";
        }
        else{
            eye.style.display = "block";
            eye2.style.display = "none";
            pass.type = "password";
        }

        
    }
</script>
    <style>
        body{

          background-color:lightblue;
           
          margin-top: 25%;
           height: 100%;
           
        }
        table, th, td {
            border: 1px solid black;
            
        }
        #adminlogin{
            
        }
        #main{
            padding-top: 1%;
            margin-left: 25%;
            margin-right: 25%;
            background-color: white;
            border: 3px solid orange;
            background-size: 100%;
            background-repeat: repeat-y;
            box-shadow: 5px, 10px;
            min-height: 100%;           
            
        }
        
        #main_content{
            margin-left: 7%;
            background-color: whitesmoke;
            margin-right: 7%;
        }
        table{
            height: 50px;
        }
    </style>
    <script>
        function hideadmin(){
            var adminform =document.getElementById("adminlogin");
            var main = document.getElementById("main");
           // main.style.display = "100%";
            
            adminform.style.display = "none";
        }
    </script>
</head>
<body>
    
    <div id="main">
        <div id="main_content">


        <form action="admin.php">
        <input type="submit" value="Kilépés" style="float: right;">
    </form>
<?php

session_start();

$username = "admin";
$password = "pass";


?>

<div id="adminlogin">
<form action="admin.php" method="POST" style="display: block;" id="adminlogin" >
<h5>Felhasználónév:</h5>
<input type="text" name="username">
<h5>jelszó:</h5>
<p><input id="pass" type="password" name="password"><img style="display:block;" id="eye" src="imgs/admin_res/closed.png" width="30" height="25" alt="show/hide password" onclick="radio_eye()"> <img style="display:none;" id="eye2" src="imgs/admin_res/opened.png" width="30" height="25" alt="show/hide password" onclick="radio_eye()"></p>
<button type="submit" name="login">Belépés</button>
</form></div>

   
<?php

if(isset($_POST["login"])){
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $_POST["password"];
    if($_SESSION["username"] == $username && $_SESSION["password"] == $password){
        echo"<script>hideadmin()</script>";
        echo'<script>scroll()</script>';
        
        echo '<h1>Rögzített adatok kezelése</h1>
<p style="font-size: 18;">Használati útmutató: <br></p>
<p>Az alábbi táblázatban az elfogadott illetve függőben lévő foglalások találhatóak.<br>
<b>X</b>: Törli az adott sorhoz tartozó foglalót illetve adatait. Továbbá tájékoztatja a foglalót, hogy az időpontja törölve lett.<br>
<b>✔</b>: Megerősíti az adott sorhoz tartozó foglaló időpontját. Továbbá tájékoztatja erről a foglalót. Ha a pipa zöld akkor már megerősítésre kerűlt.   <br>
<b>Törlés</b>: Törli az összes olyan foglalást ami már lejárt. <br>


</p>';
        

            echo'<div style="overflow-x:auto; overflow-y:auto;"> 
                <table>
                <th>Név</th>
                  <th>E-mail</th>
                  <th>Dátum</th>
                  <th>Idő</th>
                  <th>Azonosító</th>';

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "teszt";
        $connection = true;
        try{
            $conn = new mysqli($servername, $username, $password, $dbname);
    
            $sql = 'SELECT id, nev, email, dátum, ido, azon FROM info';
            $result = $conn->query($sql);
            $buttonindex = 0;
            if($result->num_rows > 0){
                  while($row = $result->fetch_assoc()){
                      $buttonindex++;
                      echo'
                      <tr> 
                      <td>'. $row["nev"]. '</td> 
                      <td>'. $row["email"] . '</td> 
                      <td>'. $row["dátum"]. '</td> 
                      <td>'. $row["ido"]. '</td> 
                      <td>'. $row["azon"]. '</td>
                      <td> <form method="POST" action="" >
                              <input type="hidden" name="id" value="'.$row["azon"].'" width="2px" height="2px">
                              <input type="submit" name="delete" value="X" style="background-color:lightcoral; color darkred" width="2px" height="2px">
                              </form>
                      </td>';
                       if($row["id"] == 1){
                          echo '<style> #green'. $row["azon"]. ':hover{background-color:grey; color:black;}</style>';
                       echo'<style>.checked{background-color: lightgreen; color: darkgreen;}</style>';
                       echo'
                          <td> <form method="POST" action="" >
                              <input type="hidden" name="okayid" value="'.$row["azon"].'" width="2px" height="2px">
                              <input type="submit" name="okay" value="✔" width="2px" height="2px" class="checked" id="green'.$row["azon"].'">
                              
                              </form>
                      </td>
                       ';
                       
                       }else{
                              echo'
                                 <td> <form method="POST" action="" >
                              <input type="hidden" name="okayid" value="'.$row["azon"].'" width="2px" height="2px">
                              <input type="submit" name="okay" value="✔" width="2px" height="2px">
                              </form>
                      </td>
                              ';
                       }
                      
                        echo' 
                        </tr>';
                    }
              }
              echo'</table></div>';
              echo'    <script>
        function submit_delete(){
            var old_del = document.getElementsByClassName("old_del");
            var old_del_start =document.getElementById("old_del_start");
            old_del_start.style.display= "none";

            for(var i = 0; i<old_del.length; i++){
                old_del[i].style.display = "inline";
            }

           
        }
        function dropp_submit_delete(){
            var old_del = document.getElementsByClassName("old_del");
            var old_del_start =document.getElementById("old_del_start");
            old_del_start.style.display= "block";

            for(var i = 0; i<old_del.length; i++){
                old_del[i].style.display = "none";
            }
        }

    </script>
<form action="" method="POST">
                           
                           <p id="old_del_start" style="display:block;">Elavult adatok törlése: <input type="button" value="törlés" onclick="submit_delete()"></p>
                            
                          
                           <div>
                            <p class="old_del" style="display:none;">Biztosan törli azokat az adatokat, amelyek korábbi dátumokat tartalmaznak?</p><br>
                            
                                <input  type="submit" value="igen" name="old_del" class="old_del" style="display:none;">
                                <input type="button" value="nem" class="old_del" style="display:none;" onclick="dropp_submit_delete()">
                            </div>
                            
                            </form>';
                    
                    
                


        }
        catch(mysqli_sql_exception $e){
          echo' 
          <script>
          function hiba() {
            alert("Hiba! Nem sikerűlt kapcsoaltot létesíteni a szerverrel");
          }
        hiba();
        window.location.href = "index.html";
          </script>
          '; 
        }
        
        
    
    }
    else{echo"Hibás, vagy hiányzó adatok";}    
}
        $connection = true;
        try{
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "teszt";
            $connection = true; 
            $conn = new mysqli($servername, $username, $password, $dbname);
            if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])){
                echo '<h1>Rögzített adatok kezelése</h1>
<p style="font-size: 18;">Használati útmutató: <br></p>
<p>Az alábbi táblázatban az elfogadott illetve függőben lévő foglalások találhatóak.<br>
<b>X</b>: Törli az adott sorhoz tartozó foglalót illetve adatait. Továbbá tájékoztatja a foglalót, hogy az időpontja törölve lett.<br>
<b>✔</b>: Megerősíti az adott sorhoz tartozó foglaló időpontját. Továbbá tájékoztatja erről a foglalót. Ha a pipa zöld akkor már megerősítésre kerűlt.   <br>
<b>Törlés</b>: Törli az összes olyan foglalást ami már lejárt. <br>


</p>';
                echo' <div style="overflow-x:auto;"> <table><th>Név</th>
                <th>E-mail</th>
                <th>Dátum</th>
                <th>Idő</th>
                <th>Azonosító</th>';

                $deleteazon = $_POST['id'];
                $stmt = $conn->prepare('DELETE FROM info WHERE azon = ?');
                $stmt->bind_param('i', $deleteazon);
            
                if($stmt->execute()){
                    
                }
                $stmt->close();
                
            
                echo"<script>hideadmin()</script>";
                echo'<script>scroll()</script>';
        
                echo '<h1>Rögzített adatok kezelése</h1>
<p style="font-size: 18;">Használati útmutató: <br></p>
<p>Az alábbi táblázatban az elfogadott illetve függőben lévő foglalások találhatóak.<br>
<b>X</b>: Törli az adott sorhoz tartozó foglalót illetve adatait. Továbbá tájékoztatja a foglalót, hogy az időpontja törölve lett.<br>
<b>✔</b>: Megerősíti az adott sorhoz tartozó foglaló időpontját. Továbbá tájékoztatja erről a foglalót. Ha a pipa zöld akkor már megerősítésre kerűlt.   <br>
<b>Törlés</b>: Törli az összes olyan foglalást ami már lejárt. <br>


</p>';
            
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "teszt";
                $connection = true;
                try{
                    $conn = new mysqli($servername, $username, $password, $dbname);
            
                    $sql = 'SELECT id, nev, email, dátum, ido, azon FROM info';
                    $result = $conn->query($sql);
                    $buttonindex = 0;
                    if($result->num_rows > 0){
                          while($row = $result->fetch_assoc()){
                              $buttonindex++;
                                echo'
                                <tr> 
                                <td>'. $row["nev"]. '</td> 
                                <td>'. $row["email"] . '</td> 
                                <td>'. $row["dátum"]. '</td> 
                                <td>'. $row["ido"]. '</td> 
                                <td>'. $row["azon"]. '</td>
                                
                                <td> <form method="POST" action="" >
                                <input type="hidden" name="id" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="delete" value="X" style="background-color:lightcoral; color darkred" width="2px" height="2px">
                                </form>
                        </td>';
                         if($row["id"] == 1){
                            echo '<style> #green'. $row["azon"]. ':hover{background-color:grey; color:black;}</style>';
                         echo'<style>.checked{background-color: lightgreen; color: darkgreen;}</style>';
                         echo'
                            <td> <form method="POST" action="" >
                                <input type="hidden" name="okayid" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="okay" value="✔" width="2px" height="2px" class="checked" id="green'.$row["azon"].'">
                                </form>
                        </td>
                         ';
                         
                         }else{
                                echo'
                                   <td> <form method="POST" action="" >
                                <input type="hidden" name="okayid" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="okay" value="✔" width="2px" height="2px">
                                </form>
                        </td>
                                ';
                         }
                        
                        echo' 
                        </tr>';
                            }
                      }
                      echo'</table></div>';
                      echo'    <script>
        function submit_delete(){
            var old_del = document.getElementsByClassName("old_del");
            var old_del_start =document.getElementById("old_del_start");
            old_del_start.style.display= "none";

            for(var i = 0; i<old_del.length; i++){
                old_del[i].style.display = "inline";
            }

           
        }
        function dropp_submit_delete(){
            var old_del = document.getElementsByClassName("old_del");
            var old_del_start =document.getElementById("old_del_start");
            old_del_start.style.display= "block";

            for(var i = 0; i<old_del.length; i++){
                old_del[i].style.display = "none";
            }
        }

    </script>
<form action="" method="POST">
                           
                           <p id="old_del_start" style="display:block;">Elavult adatok törlése: <input type="button" value="törlés" onclick="submit_delete()"></p>
                            
                          
                           <div>
                            <p class="old_del" style="display:none;">Biztosan törli azokat az adatokat, amelyek korábbi dátumokat tartalmaznak?</p><br>
                            
                                <input  type="submit" value="igen" name="old_del" class="old_del" style="display:none;">
                                <input type="button" value="nem" class="old_del" style="display:none;" onclick="dropp_submit_delete()">
                            </div>
                            
                            </form>';
        
                        
        
        
                }
                catch(mysqli_sql_exception $e){
                  echo' 
                  <script>
                  function hiba() {
                    alert("Hiba! Nem sikerűlt kapcsoaltot létesíteni a szerverrel");
                  }
                hiba();
                window.location.href = "index.html";
                  </script>
                  '; 
                }
                
                
            
            
            }
            
            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['okay'])){

                $okayazon = $_POST['okayid'];
                
                $sql = "SELECT id FROM info WHERE azon = $okayazon";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {                
                 while($row = $result->fetch_assoc()){
                         if($row["id"] != 1){
                             $sql2 = "UPDATE `info` SET `id`='1' WHERE azon = $okayazon;";
                     try{
                         mysqli_query($conn, $sql2);
                     }
                     catch(mysqli_sql_exception $e){
                     
                     }
                         }
                         
                 }
             
             }

                echo"<script>hideadmin()</script>";
                echo'<script>scroll()</script>';
        
                echo '<h1>Rögzített adatok kezelése</h1>
<p style="font-size: 18;">Használati útmutató: <br></p>
<p>Az alábbi táblázatban az elfogadott illetve függőben lévő foglalások találhatóak.<br>
<b>X</b>: Törli az adott sorhoz tartozó foglalót illetve adatait. Továbbá tájékoztatja a foglalót, hogy az időpontja törölve lett.<br>
<b>✔</b>: Megerősíti az adott sorhoz tartozó foglaló időpontját. Továbbá tájékoztatja erről a foglalót. Ha a pipa zöld akkor már megerősítésre kerűlt.   <br>
<b>Törlés</b>: Törli az összes olyan foglalást ami már lejárt. <br>


</p>';
        
                    echo' <div style="overflow-x:auto;"> <table><th>Név</th>
                          <th>E-mail</th>
                          <th>Dátum</th>
                          <th>Idő</th>
                          <th>Azonosító</th>';
        
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "teszt";
                $connection = true;
                try{
                    $conn = new mysqli($servername, $username, $password, $dbname);
            
                    $sql = 'SELECT id, nev, email, dátum, ido, azon FROM info';
                    $result = $conn->query($sql);
                    $buttonindex = 0;
                    if($result->num_rows > 0){
                          while($row = $result->fetch_assoc()){
                              $buttonindex++;
                                echo'
                                <tr> 
                                <td>'. $row["nev"]. '</td> 
                                <td>'. $row["email"] . '</td> 
                                <td>'. $row["dátum"]. '</td> 
                                <td>'. $row["ido"]. '</td> 
                                <td>'. $row["azon"]. '</td>
                               
                                <td> <form method="POST" action="" >
                                <input type="hidden" name="id" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="delete" value="X" style="background-color:lightcoral; color darkred" width="2px" height="2px">
                                </form>
                        </td>';
                         if($row["id"] == 1){
                            echo '<style> #green'. $row["azon"]. ':hover{background-color:grey; color:black;}</style>';
                         echo'<style>.checked{background-color: lightgreen; color: darkgreen;}</style>';
                         echo'
                            <td> <form method="POST" action="" >
                                <input type="hidden" name="okayid" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="okay" value="✔" width="2px" height="2px" class="checked" id="green'.$row["azon"].'">
                                </form>
                        </td>
                         ';
                         
                         }else{
                                echo'
                                   <td> <form method="POST" action="" >
                                <input type="hidden" name="okayid" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="okay" value="✔" width="2px" height="2px">
                                </form>
                        </td>
                                ';
                         }
                        
                        echo' 
                        </tr>';
                            }
                      }
                      echo'</table></div>';
                      echo'    <script>
                function submit_delete(){
                    var old_del = document.getElementsByClassName("old_del");
                    var old_del_start =document.getElementById("old_del_start");
                    old_del_start.style.display= "none";
        
                    for(var i = 0; i<old_del.length; i++){
                        old_del[i].style.display = "inline";
                    }
        
                   
                }
                function dropp_submit_delete(){
                    var old_del = document.getElementsByClassName("old_del");
                    var old_del_start =document.getElementById("old_del_start");
                    old_del_start.style.display= "block";
        
                    for(var i = 0; i<old_del.length; i++){
                        old_del[i].style.display = "none";
                    }
                }
        
            </script>
        <form action="" method="POST">
                                   
                                   <p id="old_del_start" style="display:block;">Elavult adatok törlése: <input type="button" value="törlés" onclick="submit_delete()"></p>
                                    
                                  
                                   <div>
                                    <p class="old_del" style="display:none;">Biztosan törli azokat az adatokat, amelyek korábbi dátumokat tartalmaznak?</p><br>
                                    
                                        <input  type="submit" value="igen" name="old_del" class="old_del" style="display:none;">
                                        <input type="button" value="nem" class="old_del" style="display:none;" onclick="dropp_submit_delete()">
                                    </div>
                                    
                                    </form>';
                            
                            
                        
        
        
                }
                catch(mysqli_sql_exception $e){
                  echo' 
                  <script>
                  function hiba() {
                    alert("Hiba! Nem sikerűlt kapcsoaltot létesíteni a szerverrel");
                  }
                hiba();
                window.location.href = "index.html";
                  </script>
                  '; 
                }

                
                    
                
                
            }

            if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['old_del'])){
                echo '<h1>Rögzített adatok kezelése</h1>
<p style="font-size: 18;">Használati útmutató: <br></p>
<p>Az alábbi táblázatban az elfogadott illetve függőben lévő foglalások találhatóak.<br>
<b>X</b>: Törli az adott sorhoz tartozó foglalót illetve adatait. Továbbá tájékoztatja a foglalót, hogy az időpontja törölve lett.<br>
<b>✔</b>: Megerősíti az adott sorhoz tartozó foglaló időpontját. Továbbá tájékoztatja erről a foglalót. Ha a pipa zöld akkor már megerősítésre kerűlt.   <br>
<b>Törlés</b>: Törli az összes olyan foglalást ami már lejárt. <br>


</p>';

                echo' <div style="overflow-x:auto;"> <table><th>Név</th>
                <th>E-mail</th>
                <th>Dátum</th>
                <th>Idő</th>
                <th>Azonosító</th>';

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "teszt";
                
                
                $conn = new mysqli($servername, $username, $password, $dbname);


                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                }


                $sql = "DELETE FROM info WHERE dátum < CURRENT_DATE";

                if ($conn->query($sql) === TRUE) {
                    echo' 
                    <script>
                    function old_del() {
                      alert("Régi adatok sikeresen törölve!");
                    }
                  old_del();
                  window.location.href = "admin.php";
                  
                    </script>
                    '; 
                    echo"<script>hideadmin()</script>";
                    echo'<script>scroll()</script>';
        

            
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "teszt";
                    $connection = true;
                    try{
                        $conn = new mysqli($servername, $username, $password, $dbname);
                
                        $sql = 'SELECT id, nev, email, dátum, ido, azon FROM info';
                        $result = $conn->query($sql);
                        $buttonindex = 0;
                        if($result->num_rows > 0){
                              while($row = $result->fetch_assoc()){
                                  $buttonindex++;
                                    echo'
                                    <tr> 
                                    <td>'. $row["nev"]. '</td> 
                                    <td>'. $row["email"] . '</td> 
                                    <td>'. $row["dátum"]. '</td> 
                                    <td>'. $row["ido"]. '</td> 
                                    <td>'. $row["azon"]. '</td>
                                    <td> <form method="POST" action="" >
                                <input type="hidden" name="id" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="delete" value="X" style="background-color:lightcoral; color darkred" width="2px" height="2px">
                                </form>
                        </td>';
                         if($row["id"] == 1){
                            echo '<style> #green'. $row["azon"]. ':hover{background-color:grey; color:black;}</style>';
                         echo'<style>.checked{background-color: lightgreen; color: darkgreen;}</style>';
                         echo'
                            <td> <form method="POST" action="" >
                                <input type="hidden" name="okayid" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="okay" value="✔" width="2px" height="2px" class="checked" id="green'.$row["azon"].'">
                                </form>
                        </td>
                         ';
                         
                         }else{
                                echo'
                                   <td> <form method="POST" action="" >
                                <input type="hidden" name="okayid" value="'.$row["azon"].'" width="2px" height="2px">
                                <input type="submit" name="okay" value="✔" width="2px" height="2px">
                                </form>
                        </td>
                                ';
                         }
                        
                        echo' 
                        </tr>';
                                }
                          }
                          echo'</table></div>';
                          echo'    <script>
        function submit_delete(){
            var old_del = document.getElementsByClassName("old_del");
            var old_del_start =document.getElementById("old_del_start");
            old_del_start.style.display= "none";

            for(var i = 0; i<old_del.length; i++){
                old_del[i].style.display = "inline";
            }

           
        }
        function dropp_submit_delete(){
            var old_del = document.getElementsByClassName("old_del");
            var old_del_start =document.getElementById("old_del_start");
            old_del_start.style.display= "block";

            for(var i = 0; i<old_del.length; i++){
                old_del[i].style.display = "none";
            }
        }

    </script>
<form action="" method="POST">
                           
                           <p id="old_del_start" style="display:block;">Elavult adatok törlése: <input type="button" value="törlés" onclick="submit_delete()"></p>
                            
                          
                           <div>
                            <p class="old_del" style="display:none;">Biztosan törli azokat az adatokat, amelyek korábbi dátumokat tartalmaznak?</p><br>
                            
                                <input  type="submit" value="igen" name="old_del" class="old_del" style="display:none;">
                                <input type="button" value="nem" class="old_del" style="display:none;" onclick="dropp_submit_delete()">
                            </div>
                            
                            </form>';
            
                            
            
            
                    }
                    catch(mysqli_sql_exception $e){
                      echo' 
                      <script>
                      function hiba() {
                        alert("Hiba! Nem sikerűlt kapcsoaltot létesíteni a szerverrel");
                      }
                    hiba();
                    window.location.href = "index.html";
                      </script>
                      '; 
                    }
                    
                    
                  
                } else {
                        echo "Error deleting records: " . $conn->error;
                        }
                        $conn->close();


            }
            
        }
            catch(mysqli_sql_exception $e){
            echo"hiba";
            }





?>



        





        </div>
        
        
    
    
    
    </div>
    <div id="grass">
            

        </div>
            
</body>





</html>








