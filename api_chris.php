<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);        // schakel notices uit (zijn niet interessant maar mollen de JSON output wel)
header('Access-Control-Allow-Origin: *');  // kan ook van andere servers dan alleen localhost benaderd worden
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // staat toe dat je headers met bijv. authorization verstuurd
header('Content-Type: application/json');  // geef aan dat deze file een JSON format teruggeeft

/* ----- start ------ koppeling met DB opzetten --------------------------------------------------- */
    $host    = "localhost";
    $username = "user";
    $password = "password";
    $database = "database";
    // is netter als deze gegevens niet hier in de API staan. Zet in config file of in een db.php die je include
    include_once("db.php");
    $con = mysqli_connect($host, $username, $password, $database);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    // om de data in de juiste charachter-set op te halen. ZONDER DEZE KAN JE JSON CORRUPT ZIJN => GEEN OUTPUT!!
    mysqli_query($con, "SET NAMES 'utf8'");
/* ----- stop ------- koppeling met DB opzetten --------------------------------------------------- */

/* ----- start ------ functies voor header / bearer / authorization ------------------------------- */
    function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
    $headers = getAuthorizationHeader(); // get access token from header

    $_SESSION["role"] = "nog geen rol";
    function getRoleFromBearer($bearer, $con)
    {
        $arr = explode(",", $bearer);
        $sql = "SELECT id, inaam, naam, token, token_date, email, rol
                FROM user
                WHERE id = '" . $arr[0] . "' AND token ='" . $arr[1] . "'; ";
        $res = mysqli_query($con, $sql);
        if ($res) {
            $lst = array();
            // while ($rij = mysqli_fetch_assoc($res)) {}
            $rij = mysqli_fetch_assoc($res); // haalt maar 1 rij op, maximaal 1 match..!
            $_SESSION["role"] = $rij["rol"];
        }
    }

    // haal rol op uit header (van bearer-token)
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            //return $matches[1];
            $_SESSION["bearer"] = $matches[1];
            getRoleFromBearer($_SESSION["bearer"], $con);
        }
    }
/* ----- stop ------ functies voor header / bearer / authorization ------------------------------- */


/* ----- start ----- algemene functies en standaard json voor output ----------------------------- */
// Deze API geeft in ieder geval onderstaande array in JSON terug   
$json = array(
    "sMessage" => "nog geen action geset, wel connectie met database",
    "bearer" => "nog niet geset",
    "bSuccess" => false,
    "data" => null,
);

// algemene functie die $sql verwerkt en een $json voor the response retourneert
    function verwerkQuery($con, $sql, $sSoort, $sActie, $test = "test")
    {
        // uitvoeren van query op $con (=database-connectie))
        $res = mysqli_query($con, $sql);
        if ($res) {
            $lst = array();
            while ($rij = mysqli_fetch_assoc($res)) {
                // zorgt evt. dat characterset in UTF8 staat //array_map("utf8_encode", $rij);
                $lst[] = $rij; 
            }
            $json = array(
                "sMessage" => $sActie . " van " . $sSoort . " is gelukt ",
                "bearer" => $_SESSION["bearer"],
                "bSuccess" => true,
                "data" => $lst,
                // handig: geef in message ook $sql weer (NIET in productie natuurlijk)
                "sql" => $sql,
                "test" => $_SESSION["role"],
            );
        } else {
            $json = array(
                "sMessage" => "kan " . $sSoort . " NIET " . $sActie,
                "bearer" => "",
                "bSuccess" => false,
                "data" => null,
                // handig: geef in message ook $sql weer als query fout gaat (NIET in productie natuurlijk)
                "sql" => $sql,
                "test" => $_SESSION["role"],
            );
        }
        return $json;
    }
/* ----- stop ------ algemene functies en standaard json voor output ----------------------------- */

// Via de URL: https://[pad naar API]/api.php?action=??? kun je de API aanspreken
// De API verwacht in ieder geval een $_GET["action"] waar de endpoint in gegeven wordt
// API verwacht dat andere variabelen bijv. id's ook als $_GET["id"] meegegeven wordt 

/* ----- start ----- endpoints (get actions) die niet achter auth liggen ------------------------- */
// Ophalen van 1 user op basis van inlognaam en wachtwoord
if ($_GET["action"] == "getSongs") {
    // user: inaam, naam, wachtwoord, token, token_date, email

    $sql = "SELECT *
			FROM song  ";
            //WHERE inaam = '" . $_GET["inaam"] . "' AND wachtwoord ='" . $_GET["ww"] . "'; ";

    // functie verwerkQuery() levert $json. 
    $json = verwerkQuery($con, $sql, "gebruiker", "ophalen", $_GET);
    // $con = db-connectie, $sql=query, volgende 2 strings zijn voor nette weergave van response message
}

if ($_GET["action"] == "getBeers") {
    // bier: id, naam, type, gisting, perc, prijs, id_brouwer
    $sql = "SELECT *
			FROM b__bier; ";
    $json = verwerkQuery($con, $sql, "biertjes", "ophalen");
}

if ($_GET["action"] == "getBeersBrouwers") {
    // geeft biertjes terug met geneste brouwer
    $sql = "SELECT *
			FROM b__bier; ";
    $res = mysqli_query($con, $sql);
    if ($res) {
        $lst = array();
        while ($rij = mysqli_fetch_assoc($res)) {
            // haal brouwer info op
            $sql_brouwer = "SELECT naam, plaats, adres
                            FROM b__brouwer
                            WHERE id = ".$rij['id_brouwer']."; ";
            $res_brouwer = mysqli_query($con, $sql_brouwer);
            
            if ($res_brouwer) {
                $rij['brouwer'] = mysqli_fetch_assoc($res_brouwer);
            } else {
                $rij['brouwer'] = $sql_brouwer;
                
            }
            $lst[] = $rij; 
        }
        $json = array(
            "sMessage" => "biertjes met geneste brouwer opgehaald",
            "bearer"   => "nog niet geset",
            "bSuccess" => true,
            "data"     => $lst,
        );
    } else {
        $json = array(
            "sMessage" => "biertjes zijn NIET opgehaald",
            "bearer"   => "nog niet geset",
            "bSuccess" => false,
            "data"     => null,
        );
    }
    
}
/* ----- stop ------ endpoints (get actions) die niet achter auth liggen ------------------------- */

/* ----- start ----- endpoints (get actions) die WEL achter auth liggen -------------------------- */
// Bij onderstaande GET actions staan binnen een token-check, wordt gecontroleerd of
// $_SESSION["role"] in toegestane rol-array staan

$aAuthLevelA = ['adm'];
$aAuthLevelB = ['adm', 'doc'];
$aAuthLevelC = ['adm', 'doc', 'user'];

$json_no_auth = array(
    "sMessage" => "te weinig rechten voor deze opvraag",
    "bSuccess" => false,
    "data" => null,
);

//if($_SESSION["role"] == 'admin') { // in geval van role-based access. $_SESSION["role"] wordt bovenaan in het authorization gedeelte uit de bearer gehaald  

    if ($_GET["action"] == "getUsers") {
        // user: inaam, naam, wachtwoord, token, token_date, email
        if (in_array($_SESSION["role"], $aAuthLevelA)) {
            $sql = "SELECT inaam, naam, token, rol, token_date, email
                FROM user; ";
            $json = verwerkQuery($con, $sql, "gebruikers (met Auth)", "ophalen");
        } else {
            $json = $json_no_auth;
        }
    }

    if ($_GET["action"] == "updateBeer") {
        $sql = "UPDATE bieren SET
                naam 	= '" . $_POST["naam"] . "',
                brouwer = '" . $_POST["brouwer"] . "',
                type	= '" . $_POST["type"] . "',
                gisting	= '" . $_POST["gisting"] . "',
                perc	= '" . $_POST["perc"] . "'
            WHERE id = " . $_POST["id"] . "; ";
        $res = mysqli_query($con, $sql);
        $json = verwerkQuery($con, $sql, "biertje", "gewijzigd");
    }

    if ($_GET["action"] == "deleteBeer") {
        $sql = "DELETE FROM bier
            WHERE id = " . $_POST["id"] . "; ";
        $json = verwerkQuery($con, $sql, "biertje", "gewist");
    }

    if ($_GET["action"] == "insertBeer") {
        // verzin hem zelf ;-)
    }
    
//} // bij toepassing authorization


/* ----- stop ------ endpoints (get actions) die WEL achter auth liggen -------------------------- */


echo json_encode($json);
