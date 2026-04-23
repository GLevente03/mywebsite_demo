<?php
    require_once __DIR__ .  '/../../model/DatabaseConnection.php';
    require_once __DIR__ . '/../model/ProviderType.php';

    session_start();
    if (!isset($_SESSION["userid"])) {
        header("Location: /login.php?error=accessdenied");
        exit();
    }

    $userid = $_SESSION["userid"];
    $providerModel = new ProviderType();
    $providers = $providerModel->getProvidersByUser($userid);

    if (!isset($_SESSION['lang']) && isset($_COOKIE['lang'])) {
        $_SESSION['lang'] = $_COOKIE['lang'];
    }
    
    $lang = $_SESSION['lang'] ?? 'en';
    
    $translations = require __DIR__ . "/../../view/lang/{$lang}.php";
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üdvözli a Számla Nyilvántartó!</title>
    <link rel="stylesheet" href="styles/billregistry.css">
    <link rel="stylesheet" href="/styles/header.css">
    <link rel="stylesheet" href="/styles/general.css">
    <link rel="stylesheet" href="/styles/reset.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>

</head>
<body>
    <?php include_once __DIR__ .  "/../../view/header.php"?>
    <section>
    <form action="/billregistry/controller/add_new_provider.contr.php" method="post">
        <input type="text" class="provider-input" id="provider-input" name="provider_name" placeholder="Szolgáltató neve" value="<?php if(isset($_SESSION["provider_name"])){ echo htmlspecialchars($_SESSION["provider_name"]); } ?>">
        <p id="err-msg-for-provider-input"></p>

        <input type="text" class="provider-input" id="account-number" name="provider_account_number" placeholder="Szolgáltató számlaszáma" value="<?php if(isset($_SESSION["provider_account_number"])){ echo htmlspecialchars($_SESSION["provider_account_number"]); } ?>">
        <p id="err-msg-for-account-number"></p>

        <input type="tel" class="provider-input" id="telephone" name="telephone" placeholder="Szolgáltató telefonszáma" value="<?php if(isset($_SESSION["telephone"])){ echo htmlspecialchars($_SESSION["telephone"]); } ?>">
        <p id="err-msg-for-telephone"></p>

        <label for="provider_type">Válassz egy szolgáltató-típust!</label>
        <select name="provider_type" id="provider_type" default="<?php if(isset($_SESSION["provider_type"])){ echo htmlspecialchars($_SESSION["provider_type"]); } ?>">
            <option value="" disabled selected>Válassz!</option>
            <option value="water">Víz</option>
            <option value="gas">Gáz</option>
            <option value="electricity">Áram</option>
            <option value="phone">Telefon</option>
            <option value="sewer">Csatorna</option>
            <option value="garbage">Hulladék</option>
            <option value="else">Egyéb</option>
        </select>
        <button type="submit">Mentés</button>
    </form>
    
    <form action="/billregistry/controller/add_new_bill.contr.php" method="post">
        <input type="number" name="amount" placeholder="Befizetett összeg">
        <input type="text" name="bill_number" placeholder="Számla szonosítószáma">
        <label for="provider">Válassz szolgáltatót:</label>
        <select name="provider_id" id="provider">
            <option value="" disabled selected>Válassz!</option>
            <?php foreach($providers as $provider): ?>
                <option value="<?php echo htmlspecialchars($provider['id'])?>">
                    <?php echo htmlspecialchars($provider['provider_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="paid_at">Számla befizetésének időpontja</label>
        <input type="date" name="paid_at" id="paid_at">
        <textarea name="description" id="description" cols="30" rows="10" placeholder="Megjegyzés"></textarea>
        <button type="submit">Mentés</button>
    </form>
    <form action="/billregistry/controller/search_bills.php" method="post">
        <input type="text" name="bill-number" placeholder="Számlaazonosító">
        <label for="date-from">Szűrés kezdődátuma</label>
        <input type="date" name="from-date" id="date-from">
        <label for="date-to">Szűrés végdátuma</label>
        <input type="date" name="to-date" id="date-to">
        <label for="provider">Válassz szolgáltatót:</label>
        <select name="provider_id" id="provider">
            <option value="" disabled selected>Válassz!</option>
            <?php foreach($providers as $provider): ?>
                <option value="<?php echo htmlspecialchars($provider['id'])?>">
                    <?php echo htmlspecialchars($provider['provider_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Keresés</button>
    </form>
    </section>
    <?php
        /* session_start(); */
        $results = $_SESSION["results"];

        if(isset($_SESSION["results"])){
            if($results == false){
                echo "Nincs találat!";
            } else{
        ?>
            <section class="bill-grid">
                <p>Számla azonosítószáma</p>
                <p>Összeg</p>
                <p>Befizetés dátuma</p>
                <p>Regisztrálás dátuma</p>
                <p>Szolgáltató neve</p>
                <p>Megjegyzés</p>
                <p></p>

                <?php foreach($results as $bill): ?>
                    <p>
                        <?php echo htmlspecialchars($bill['bill_number']); ?>
                    </p>
                    <p>
                        <?php echo htmlspecialchars($bill['amount']); ?>
                    </p>
                    <p>
                        <?php echo htmlspecialchars($bill['paid_at']); ?>
                    </p>
                    <p>
                        <?php echo htmlspecialchars($bill['registered_at']); ?>
                    </p>
                    <p>
                        <?php echo htmlspecialchars($bill['provider_name']); ?>
                    </p>
                    <p>
                        <?php echo htmlspecialchars($bill['description']); ?>
                    </p>
                    <button
                        class="delete-btn"
                        id="<?php echo htmlspecialchars($bill['bill_number']); ?>"
                        data-id="<?php echo htmlspecialchars($bill['id']); ?>">
                        Törlés
                    </button>
                <?php endforeach; ?>
            </section>
        <?php
            }
        }
    ?>
    <script src="scripts/add_new_provider.js"></script>
    <script src="scripts/delete_bill.js"></script>
	<script src="/scripts/change-lang.js"></script>
	<script src="/scripts/hamburger-menu-toggle.js"></script>
</body>
</html>
