# el-team-wp-theme
The Wordpress Theme which is used at the el-team Website

Ab Version 1.1 enthält das Theme nur noch die Darstellung (Vorlagen, Styles, Menüs,
Seitenleisten, Presse-Logos). Fahrzeuge, Werkstattberichte, Linkempfehlungen und die
Seitenmatrix kommen aus dem Plugin **CityEL Werkstatt** (ab 2.0). Ohne das Plugin bleiben
Fahrzeug- und Werkstattbericht-Seiten erreichbar (`inc/plugin-compat.php`), die
Eingabe- und Zusatzfunktionen fehlen dann.

Ab 1.2 unterstützt das Theme die Block-Ausrichtungen „Weite Breite“ und „Volle Breite“.

Ab 1.3 zeigt der Footer Logo und die neuesten Beiträge aus frei wählbaren Inhaltstypen
(auch eigenen, z. B. Werkstattberichte). Inhaltstypen, Anzahl, Überschrift und
Hintergrundfarbe (Standard: Schwarz) stehen unter **Design → Footer**. Copyright und
Impressum-Link bleiben unverändert darunter.

Ab 1.4 nutzen die Fahrzeugvorlagen die Ansichten des Plugins (ab 2.4): Die Seite mit der
Vorlage **Fahrzeuge** zeigt unter dem Inhalt die Übersicht als Karten – oder nichts
zusätzlich, wenn der Block „CityEL Fahrzeuge“ schon im Inhalt steht. Die Fahrzeugseite zeigt
die Werkstattberichte im selben Stil wie Steckbrief und Chronik; steht der Block
„CityEL Fahrzeug-Steckbrief“ im Fahrzeugtext, bestimmt er die Teile. Ohne Plugin (oder mit
einer älteren Version) bleibt es bei den bisherigen Listen. „Weite/Volle Breite“ wirkt jetzt
auch in den Seitenvorlagen (Fahrzeuge, Werkstatt, Presse, SCM, Linkempfehlungen).

Ab 1.5 ist unter den Footer-Beiträgen immer der neueste aus einer wählbaren Kategorie
(**Design → Footer → Immer dabei**, Standard: Presse). Ist unter den neuesten Beiträgen
keiner aus der Kategorie, nimmt ihr neuester Beitrag den letzten Platz ein.

Ab 1.6 stehen auf der Fahrzeugseite Beitragsbild und Steckbrief (Plugin ab 2.20
nebeneinander), Herkunft, Chronik, Werkstattberichte, Unterlagen und Fahrzeugpapiere vor
dem Fahrzeugtext; der Text aus dem Blockeditor kommt zum Schluss. Mit einer älteren
Plugin-Version fehlt nur das Beitragsbild.


/*
Theme Name: el-team-wp-theme
Theme URI: https://github.com/El-Team-Munsterland/el-team-wp-theme
Author: Lukas Nacke
Author URI: https://el-team-muensterland.de
Description: Ein WordPress Theme für das El Team
Version: 1.4.0
Requires at least: 5.0
Requires PHP: 7.4
License: GPL v3
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: el-team-wp-theme
Domain Path: /languages
Tags: responsive, modern, custom-colors, custom-header, custom-logo

This theme, like WordPress, is licensed under the GPL.
*/