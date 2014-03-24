<?php

require 'vendor/autoload.php';

class ProduktHandler
{
	$link = mysql_connect('localhost', 'root', '');
	//Unter der Vorraussetzung, dass die DB webshop heisst und der root user verw. wird

	//Registriert den Benutzer wenn er noch nicht angemeldet ist.
	//Autor: David Boeheim
	function put($name, $beschreibung, $bewertung)
	{
		mysql_select_db('webshop', $link);
		$result = mysql_query($link,"INSERT INTO `products` (name, beschr, bewertung)VALUES ($name, $beschreibung,$bewertung");
		if($result)
		{
			echo 'Hinzugefuegt';
		}
	}

	//Liefert ein Produkt anhand seiner ID zurueck
	//Autor: Daniel Herczeg
	function get()
	{
		mysql_select_db('webshop', $this->link);
		$erg = mysql_query('select * from products limit by 1', $this->link);
		//Bekommt nur das erste Element, muss noch implementiert werden

		while($row = mysql_fetch_array($erg))
		{
			echo $row['id']."; ".$row['beschr'];
		}
	}

	 // Liefert Produkte anhand deren ID zurueck
	 // Autor: Florian Dienesch
	 function getProdukte(){
		// Verbindung aufbauen, auswählen einer Datenbank
		$link = mysql_connect("localhost", "root", "letmein")
		 or die("Verbindung fehlgeschlagen: " . mysql_error());
		echo "Verbindung zum Datenbankserver erfolgreich";
		mysql_select_db("webshop") or die("Auswahl der Datenbank fehlgeschlagen");

		// Abfragen der Produkte
		$query = "SELECT * FROM products order by id asc";
		$result = mysql_query($query) or die("Query fehlgeschlagen: " . mysql_error());

		// Ausgabe der Daten in einer HTML Tabelle
		echo "<table>\n";
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			echo "\t<tr>\n";
    			foreach ($line as $col_value) {
				echo "\t\t<td>$col_value</td>\n";
    			}
    			echo "\t</tr>\n";
		}
		echo "</table>\n";

		// Ressourcen wieder freigeben
		mysql_free_result($result);

		// Verbindung schliessen
		mysql_close($link);
	}
}

ToroHook::add("404", function() {
	echo "404 - ATOMLOL! Seite nicht gefunden!";
});

Toro::serve(array(
	"/products.php" => "ProduktHandler", //PUT - Registrieren
	"/products/log/show.php" => "ProduktHandler", //GET - Anzeigen
));
?>
