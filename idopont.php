<?php
// Start the session
session_start();

?>
<html>
  <head><title>Adat rögzítő</title></head>
  <script>
  function close() {
    window.close();
  }
  function blackout(){
    var bo = document.getElementById("blakkout");
    bo.style.display= "block";
  }
</script>
<body>
<div id="blakkout" style="display: none; background-color:black; color:white; width:100%; height:100%; text-align:center; position:absolute; margin:0px; left:-5px; top:-5px; right:-5px; padding-top:25%">
        <h1>bezárhatja az ablakot</h1>
    </div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teszt";
$connection = true;
try{$conn = new mysqli($servername, $username, $password, $dbname);
}
catch(mysqli_sql_exception $e){
  echo' 
  <script>
  function hiba() {
    alert("Hiba! Nem sikerűlt kapcsoaltot létesíteni a szerverrel");
    
    blackout();
  }
hiba();
window.location.href = "index.html";
  </script>
  ';
}


if($connection==true) {
  //if(isset($_POST["ok"])){
    if(!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["date"])&& !empty($_POST["start"])&& !empty($_POST["end"])){
      
      //név ellenőrzés///////////
      $name = $_POST["name"];
      $pattern = "/^[a-zA-ZáÁéÉíÍóÓöÖőŐúÚüÜűŰ' -]*$/";
      
      if (!preg_match($pattern, $name)) {
       
        echo' 
                  <script>
                  function emailerror() {
                    alert("Érvénytelen név!");
                  }
                  emailerror();
                
                blackout();
                  </script>
                  '. $nameErr;
      }
      else {
          $_SESSION["name"] = $_POST["name"];
      }
      //////////////////////////////
      
      //email ellenőrzés//////////
     
      
          $checkemail = $_POST["email"];
          if (!filter_var($checkemail, FILTER_VALIDATE_EMAIL)) {
            echo' 
            <script>
            function emailerror() {
              alert("Helytelen e-mail cím!");
            }
            emailerror();
         
         blackout();
            </script>
            ';
                  }
                  else {
                    $_SESSION["email"] = $_POST["email"];
                  }
                  
      ///////////////////////////

      //dátum ellenőrzés/////////
      
      function isFutureDate($date) {
        
        $inputDate = DateTime::createFromFormat('Y-m-d', $date);
        
       
        if (!$inputDate || $inputDate->format('Y-m-d') !== $date) {
            return false; 
        }
        
        
        $currentDate = new DateTime();
        
       
        $currentDate->setTime(0, 0, 0);
        $inputDate->setTime(0, 0, 0);
        
       
        if ($inputDate >= $currentDate) {
            return true; 
        } else {
            return false;
        }
    }
    
    $date = $_POST["date"];
    if (isFutureDate($date)) {
      $_SESSION["date"] = $_POST["date"];
    } else {
      echo' 
      <script>
      function dateerror() {
        alert("Helytelen dátum!");
        
        blackout();
      }
      dateerror();
    blackout();
      </script>
      ';
    }

      //////////////////////////////////////
      

       //óra ellenőrzés//////////////////     
      if($_POST["end"]>$_POST["start"]){
        $_SESSION["start"] = $_POST["start"];
        $_SESSION["end"] = $_POST["end"];
      }
      else{
        echo' 
                    <script>
                    function clockerror() {
                      alert("Helytelen óra formátum!");
                    }
                    clockerror();
                 window.close()
                 blackout();
                    </script>
                    ';
      }
      //////////////////////////////
      echo"<h3>Helyesek az alábbi adatok?:</h3> 
            Név: " . $_SESSION["name"] . "<br> 
            E-mail: " . $_SESSION["email"] . "<br> 
            Dátum: " . $_SESSION["date"]. "<br>
            Időtartam: ". $_SESSION["start"]. "-". $_SESSION["end"];
            
            
            echo'<form method="POST" tabindex=""> 
      <input type="submit" name="send"
              class="button" value="Igen!" /> 
      
  </form> ';
      
      
    }
    else{
      echo"Hiányosan, vagy érvénytelenül adott meg adatokat, kérem térjen vissza a fő oldalra";
  
    }
  }
//}

  

?>
<br>


<?php


  $name = $_SESSION["name"];
$email = $_SESSION["email"];
$date = $_SESSION["date"];
$ido = $_SESSION["start"]. "-" . $_SESSION["end"];

function generateUniqueAzon($conn) {
  do {
      
      $azon = rand(111111, 999999);

      
      $sql = "SELECT azon FROM `info` WHERE azon = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $azon);
      $stmt->execute();
      $stmt->store_result();

      
      $exists = $stmt->num_rows > 0;
      $stmt->close();
  } while ($exists);

  return $azon;
}
$uniqueAzon = generateUniqueAzon($conn);







        if(isset($_POST["send"])) {
          $id = 0; 
          $sql = "INSERT INTO info (id, nev, email, dátum, ido, azon)
                  VALUES ('$id', '$name', '$email', '$date', '$ido', '$uniqueAzon');";        
                  
        
                  try{
                    mysqli_query($conn, $sql);
                    echo' 
                    <script>
                    function sqldone() {
                      alert("Kész! Az adatok sikeresen mentésre kerűltek");
                    }
                  sqldone();
                  
                  blackout();
                    </script>
                    ';
                    
                  }
                  catch (mysqli_sql_exception $e){
                    echo' 
                    <script>
                    function sqlhiba() {
                      alert("Hiba! nem sikerült az adatok mentése");
                      
                      blackout();
                    }
                  sqlhiba();
                  window.location.href = "index.html";
                    </script>
                    ';
                    
                  }
                  mysqli_close($conn);
                } 
        
        

    ?> 
   



    

<br>





</body>
</html>