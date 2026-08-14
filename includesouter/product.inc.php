<?php

$id = $_GET['id'];
$userId = $_COOKIE['user_id'];

//Grab Name of Product
$query = 'SELECT * FROM products WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="premiumshop"><<</a>';
echo '</div>';

echo '<div style="display:flex;flex-direction:column;align-items:center;">';

//Title
echo '<h3>' . $result['title'] . '</h3>';

//Picture & Description
echo '<img src="resources/' . $result['image'] . '.png" style="width:50%;">';

echo '<h1>Price</h1>';
echo '<p style="width:70%;">' . $result['price'] . '$ USD</p>';

echo '<h1>Description</h1>';
echo '<p style="width:70%;">' . nl2br($result['description']) . '</p>';

//Other Importance
if ($id < 5 && $id > 0) {
    echo '<h1>Early Access Codes are emailed by hand.</h1><h1>They may take up to 48 hours to arrive.</h1>';
    
    //Grab All Codes
    $query = 'SELECT chosenID FROM earlyaccess';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $codes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $codearray = [];
    foreach ($codes as $code) {
        array_push($codearray, $code['chosenID']);
    }
} else if ($id > 4 && $id < 10) {
    echo '<h1>You will be emailed to discuss your idea.</h1><h1>The 1st email will be sent within 48 hours.</h1>';
}

if ($id == 2) {
    echo '<hr>';
    echo '<h3>Available Codes</h3>';
    echo '<p>Use Ctrl + f to check if your wanted ID is still available</p><br>';
    echo '<div style="display:flex;justify-content:space-evenly;gap:10px;flex-wrap:wrap;width:80%;">';
    for ($i = 100; $i < 1000; $i++) {
        if (!in_array($i, $codearray)) {
            echo '<div style="border:silver 1px solid;border-radius:5px;padding:3px;"><p>' . $i . '</p></div>';
        }
    }
    echo '</div>';
} else if ($id == 4) {
    echo '<hr>';
    echo '<h3>Available Codes</h3>';
    echo '<p>Use Ctrl + f to check if your wanted ID is still available</p><br>';
    echo '<div style="display:flex;justify-content:space-evenly;gap:10px;flex-wrap:wrap;width:80%;">';
    for ($i = 11; $i < 100; $i++) {
        if (!in_array($i, $codearray)) {
            echo '<div style="border:silver 1px solid;border-radius:5px;padding:3px;"><p>' . $i . '</p></div>';
        }
    }
    echo '</div>';
} else if ($id == 3) {
    echo '<hr>';
    echo '<h3>Possible Codes</h3>';
    echo '<p>You will randomly recieve one of the following IDs</p><br>';
    echo '<div style="display:flex;justify-content:space-evenly;gap:10px;flex-wrap:wrap;width:80%;">';
    for ($i = 11; $i < 100; $i++) {
        if (!in_array($i, $codearray)) {
            echo '<div style="border:silver 1px solid;border-radius:5px;padding:3px;"><p>' . $i . '</p></div>';
        }
    }
    echo '</div>';
}

echo '<hr>';
echo '<h3 style="margin-bottom:20px;">Buy ' . $result['title'] . '</h3><br>';
//Buy Button
if ($id == 1) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="4CBQR7NNFCEGN" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 2) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="NZZHR4LB7D2LG" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
        <input type="hidden" name="on1" value="ID Chosen:"/>
        <label for="os1" class="form" style="margin-right:5px;">ID Chosen:</label>
        <input type="number" name="os1" maxLength="200" min="101" max="999" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 3) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="PSSSXPKHZ6H9S" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
}  else if ($id == 4) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="SMMQZ2EFA4E68" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
        <input type="hidden" name="on1" value="ID Chosen:"/>
        <label for="os1" class="form" style="margin-right:5px;">ID Chosen:</label>
        <input type="number" name="os1" maxLength="200" min="11" max="99" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 5) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="3B4K7REA59M82" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 6) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="HPE4V2RW6RTWE" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 8) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="ZA5V2797E6UQJ" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 7) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="K57RKNV43PNVQ" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 9) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="BTVFHE6CBGJZ8" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 10) {
    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick" />
  <input type="hidden" name="hosted_button_id" value="M9ZXXFZRS7HCW" />
  <input type="hidden" name="on0" value="Email:"/>
        <label for="os0" class="form" style="margin-right:5px;">Email:</label>
        <input type="email" name="os0" maxLength="200" required /><br><br>
<input type="hidden" name="currency_code" value="USD" />
  <input type="image" style="width:200px;" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Buy Now" />
</form>';
} else if ($id == 12) {
    echo '<div>
  <style>.pp-UV9SXC2WAYERL{text-align:center;border:none;border-radius:0.25rem;min-width:11.625rem;padding:0 2rem;height:2.625rem;font-weight:bold;background-color:#FFD140;color:#000000;font-family:"Helvetica Neue",Arial,sans-serif;font-size:1rem;line-height:1.25rem;cursor:pointer;}</style>
  <form action="https://www.paypal.com/ncp/payment/UV9SXC2WAYERL" method="post" target="_blank" style="display:inline-grid;justify-items:center;align-content:start;gap:0.5rem;">
    <input class="pp-UV9SXC2WAYERL" type="submit" value="Buy Now" />
    <img src=https://www.paypalobjects.com/images/Debit_Credit_APM.svg alt="cards" />
    <section style="font-size: 0.75rem;"> Powered by <img src="https://www.paypalobjects.com/paypal-ui/logos/svg/paypal-wordmark-color.svg" alt="paypal" style="height:0.875rem;vertical-align:middle;"/></section>
  </form>
</div>';
} else if ($id == 13) {
    echo '<div>
  <style>.pp-F4TJ3KEKTF8RN{text-align:center;border:none;border-radius:0.25rem;min-width:11.625rem;padding:0 2rem;height:2.625rem;font-weight:bold;background-color:#FFD140;color:#000000;font-family:"Helvetica Neue",Arial,sans-serif;font-size:1rem;line-height:1.25rem;cursor:pointer;}</style>
  <form action="https://www.paypal.com/ncp/payment/F4TJ3KEKTF8RN" method="post" target="_blank" style="display:inline-grid;justify-items:center;align-content:start;gap:0.5rem;">
    <input class="pp-F4TJ3KEKTF8RN" type="submit" value="Buy Now" />
    <img src=https://www.paypalobjects.com/images/Debit_Credit_APM.svg alt="cards" />
    <section style="font-size: 0.75rem;"> Powered by <img src="https://www.paypalobjects.com/paypal-ui/logos/svg/paypal-wordmark-color.svg" alt="paypal" style="height:0.875rem;vertical-align:middle;"/></section>
  </form>
</div>';
} else if ($id == 14) {
    echo '<div>
  <style>.pp-P469M4PGV6MYY{text-align:center;border:none;border-radius:0.25rem;min-width:11.625rem;padding:0 2rem;height:2.625rem;font-weight:bold;background-color:#FFD140;color:#000000;font-family:"Helvetica Neue",Arial,sans-serif;font-size:1rem;line-height:1.25rem;cursor:pointer;}</style>
  <form action="https://www.paypal.com/ncp/payment/P469M4PGV6MYY" method="post" target="_blank" style="display:inline-grid;justify-items:center;align-content:start;gap:0.5rem;">
    <input class="pp-P469M4PGV6MYY" type="submit" value="Buy Now" />
    <img src=https://www.paypalobjects.com/images/Debit_Credit_APM.svg alt="cards" />
    <section style="font-size: 0.75rem;"> Powered by <img src="https://www.paypalobjects.com/paypal-ui/logos/svg/paypal-wordmark-color.svg" alt="paypal" style="height:0.875rem;vertical-align:middle;"/></section>
  </form>
</div>';
} else if ($id == 15) {
    echo '<div>
  <style>.pp-29ECESM62637S{text-align:center;border:none;border-radius:0.25rem;min-width:11.625rem;padding:0 2rem;height:2.625rem;font-weight:bold;background-color:#FFD140;color:#000000;font-family:"Helvetica Neue",Arial,sans-serif;font-size:1rem;line-height:1.25rem;cursor:pointer;}</style>
  <form action="https://www.paypal.com/ncp/payment/29ECESM62637S" method="post" target="_blank" style="display:inline-grid;justify-items:center;align-content:start;gap:0.5rem;">
    <input class="pp-29ECESM62637S" type="submit" value="Buy Now" />
    <img src=https://www.paypalobjects.com/images/Debit_Credit_APM.svg alt="cards" />
    <section style="font-size: 0.75rem;"> Powered by <img src="https://www.paypalobjects.com/paypal-ui/logos/svg/paypal-wordmark-color.svg" alt="paypal" style="height:0.875rem;vertical-align:middle;"/></section>
  </form>
</div>';
}

echo '</div>';







