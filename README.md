# el-team-wp-theme
Das WordPress-Theme der Website des El-Team Münsterland (https://el-team-muensterland.de).

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

Ab 1.7 tragen Links auf andere Websites im Inhaltsbereich ein kleines Symbol (Kästchen mit
Pfeil), reines CSS ohne zusätzliche Abrufe. Für den Haftungshinweis zeigt
`[externer_link text="Beispiel-Link"]` einen Muster-Link mit Symbol, `[externer_link]` nur
das Symbol. Das Symbol stammt aus Lucide („external-link“, ISC) bzw. Feather (MIT); die
Lizenztexte stehen am Ende von `assets/css/custom.css`. Ab 1.7.1 tragen auch die
Schaltflächen „Webseite aufrufen“ der Linkempfehlungen dieses Symbol statt des Pfeils.

Ab 1.8 ist das Theme aufgeräumt: `style.css` enthält nur noch die Grundlagen (Farben als
CSS-Variablen `--el-color-…`, Schrift, Links), Layout und Bausteine stehen in
`assets/css/custom.css`, Schriftgrößen in rem. Neu sind `page.php` (Seiten ohne Datum und
Kategorien), Blättern in Beitragslisten und Archiven, ein Menü-Knopf auf dem Handy, ein
„Zum Inhalt springen“-Link und der Link zur Datenschutzerklärung im Footer
(**Einstellungen → Datenschutz**). Zeitungskürzel wie „rn:“ erscheinen nur noch in den
Übersichten und auf der Beitragsseite als Logo und sind sonst ausgeblendet. Presse, Werkstatt
und Solarchallenge nutzen eine gemeinsame Vorlage
(`template-parts/content/kategorie-uebersicht.php`). Die Versionsnummer wird nur noch in
`style.css` gepflegt.

Ab 1.9 hat die Website ein neues Aussehen: Das Gelb bleibt Hintergrund, Inhalte stehen auf
weißen Karten, Kopfbereich mit Suche und Menü in einer Zeile, Übersichten als Listen mit
Zeitungslogos. Schrift ist Atkinson Hyperlegible Next (SIL Open Font License, im Theme unter
`assets/fonts/`, kein fremder Server). Neue Startseite (`front-page.php`) mit Begrüßung,
Kacheln, neuesten Beiträgen und Presse, einstellbar unter **Design → Startseite**; dort
entfällt die Beitragsliste im Footer.

Ab 1.9.1 zeigt „Neues aus dem Team“ auf der Startseite alle Beiträge außer reinen
Presseartikeln (Presse plus z. B. Werkstatt erscheint dort), „Presse“ nur Beiträge, die
ausschließlich der Presse-Kategorie zugeordnet sind. Presseartikel ohne Zeitungskürzel
erhalten auf der Startseite und in der Presse-Übersicht das eigene Logo (Website-Icon,
sonst Logo der Website).
