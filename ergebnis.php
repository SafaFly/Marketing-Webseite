<?php
// Empfänger-E-Mail-Adresse (Ziel-E-Mail-Adresse)
$ziel_email = "koco166@gmail.com";

// Betreff der E-Mail
$betreff = "Neue Anfrage von der Webseite";

// Benutzerdaten aus dem POST-Array
$name = $_POST['name'];
$telefon = $_POST['telefon'];
$webseite = $_POST['webseite'];
$email = $_POST['email'];

// E-Mail-Inhalt zusammenstellen
$nachricht = "Name: $name\n";
$nachricht .= "Telefonnummer: $telefon\n";
$nachricht .= "Webseite: $webseite\n";
$nachricht .= "E-Mail: $email\n";

// E-Mail versenden (PHP mail-Funktion)
mail($ziel_email, $betreff, $nachricht);

// Optional: Bestätigungs-E-Mail an den Absender senden
$absender_email = $email;
$absender_betreff = "Vielen Dank für Ihre Anfrage";
$absender_nachricht = "Vielen Dank für Ihre Anfrage. Wir werden uns in Kürze bei Ihnen melden.";
mail($absender_email, $absender_betreff, $absender_nachricht);

// Optional: Weiterleitung zur Dankeseite oder Rückmeldung an die Frontend-Anwendung
// Hier ein einfaches JSON-Objekt zurückgeben, das angibt, dass die E-Mail gesendet wurde
echo json_encode(['success' => true]);
?>
