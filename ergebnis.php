<?php
// Datenbankverbindung aufbauen (lokale Verbindung)
$servername = "localhost";
$username = "root"; // Standardbenutzername für XAMPP
$password = ""; // Standardpasswort für XAMPP ist leer
$dbname = "benutzerdaten";

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// Daten aus dem POST-Array erhalten (vorausgesetzt, dass das Formular per POST gesendet wird)
$name = $_POST['name'];
$telefon = $_POST['telefon'];
$webseite = $_POST['webseite'];
$email = $_POST['email'];
$antworten = $_POST['antworten']; // Antwortdaten als JSON-String

// JSON-String in Array konvertieren
$antworten_array = json_decode($antworten, true);

// Überprüfen, ob "bei uns" ausgewählt wurde und ob eine Adresse vorhanden ist
if (isset($antworten_array['Drehen wir bei euch oder bei uns?']) && $antworten_array['Drehen wir bei euch oder bei uns?'] === 'bei uns' && isset($antworten_array['Adresse']) && !empty($antworten_array['Adresse'])) {
    // Adresse ist bereits im Antworten-Array vorhanden
} else {
    // Entferne die Adresse aus dem Antworten-Array, falls vorhanden
    unset($antworten_array['Adresse']);
}

// JSON-String der Antworten vorbereiten mit JSON_UNESCAPED_UNICODE
$antworten_json = json_encode($antworten_array, JSON_UNESCAPED_UNICODE);

// SQL-Befehl, um Daten einzufügen (hier prepared statement verwenden)
$sql = "INSERT INTO benutzer (name, telefon, webseite, email, antworten) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $telefon, $webseite, $email, $antworten_json);

// SQL-Befehl ausführen
if ($stmt->execute()) {
    echo "Neuer Datensatz wurde erfolgreich eingefügt";
} else {
    echo "Fehler beim Einfügen des Datensatzes: " . $conn->error;
}

// Verbindung schließen
$stmt->close();
$conn->close();
?>
