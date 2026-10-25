<?php
/** Theme-Dokumentation im WordPress-Administrationsbereich. */
if (!defined('ABSPATH')) { exit; }
add_action('admin_menu', function () {
    add_theme_page('Theme-Dokumentation', 'Theme-Dokumentation', 'edit_theme_options', 'meine-theme-dokumentation', 'sm_theme_dokumentation_render');
});
if (!function_exists('sm_theme_dokumentation_render')) {
    function sm_theme_dokumentation_render() {
        if (!current_user_can('edit_theme_options')) { return; }
        ?>
        <div class="wrap">
            <h1>Theme-Dokumentation</h1>
            <p>Übersicht über die individuellen Funktionen dieses WordPress-Themes.</p>
            <p>Diese Seite ist unter <strong>Design → Theme-Dokumentation</strong> für Benutzer mit der Berechtigung <code>edit_theme_options</code> erreichbar. Die Admin-Seite wird über <code>sm_theme_dokumentation_render</code> ausgegeben.</p>
            <hr>
            <h2>Theme-Grundfunktionen</h2>
            <p>Beim Laden des Themes werden die WordPress-Unterstützungen eingerichtet: Seitentitel, RSS-Feeds, Beitragsbilder, responsives Einbetten, Editor-Stile, eigenes Logo, Header und Hintergrund. Außerdem werden die Navigationsbereiche <strong>Primary Menu</strong> und <strong>Secondary Menu</strong> sowie die Widget-Bereiche <strong>Primary Sidebar</strong> und <strong>Footer</strong> registriert.</p>
            <p>Frontend-CSS und JavaScript werden zentral geladen. Das Antwort-Skript für Kommentare wird nur auf einzelnen Inhalten geladen, wenn Kommentare geöffnet und verschachtelte Kommentare aktiviert sind.</p>
            <p>Funktionen: <code>el_team_setup_theme</code>, <code>el_team_register_sidebars</code>, und <code>el_team_enqueue_scripts</code>.</p>
            <p>Technik: <code>inc/setup.php</code> und <code>inc/enqueue.php</code>; Setup-Hook: <code>after_setup_theme</code>, Sidebar-Hook: <code>widgets_init</code>.</p>

            <h2>Aufgabenteilung Theme und Plugin „CityEL Werkstatt“</h2>
            <p>Seit Version 1.1 liefert das Theme nur noch Darstellung: Vorlagen, Styles, Menüs, Seitenleisten und Presse-Logos. Daten und Bearbeitung liegen im Plugin <strong>CityEL Werkstatt</strong>: die Inhaltstypen <strong>Fahrzeuge</strong> (<code>fahrzeug</code>) und <strong>Werkstattberichte</strong> (<code>werkstattbericht</code>) mit Status, Steckbrief, Historie, Unterlagen und Zuordnung, die Eingabe der <strong>Linkempfehlungen</strong> (Meta-Feld <code>_el_team_links</code>) und die <strong>Seitenmatrix</strong> (Shortcode und Block). Slugs, Meta-Felder und Shortcodes sind unverändert; bestehende Inhalte funktionieren ohne Anpassung weiter. Beschreibung und Einstellungen: <strong>CityEL → Einstellungen</strong>.</p>
            <h3>Fahrzeuge</h3>
            <p><code>single-fahrzeug.php</code> zeigt nach dem Inhalt den Steckbrief des Plugins (<code>cityel_the_vehicle_profile</code>) und darunter die zugeordneten Werkstattberichte (<code>el_team_get_werkstattberichte_for_fahrzeug</code>, nutzt <code>cityel_vehicle_reports</code>). Das Theme meldet dafür <code>add_theme_support( 'cityel-werkstatt-vehicle-profile' )</code>, damit das Plugin den Steckbrief nicht zusätzlich an den Inhalt hängt. <code>page-fahrzeuge.php</code> listet die Fahrzeuge nach Status.</p>
            <h3>Linkempfehlungen</h3>
            <p>Seiten mit dem Template <strong>Linkempfehlungen</strong> (<code>page-linkempfehlungen.php</code>) erhalten die Eingabebox vom Plugin. Das Template holt die sortierten Einträge über <code>el_team_get_link_recommendations</code> (nutzt <code>cityel_link_recommendations</code>).</p>
            <h3>Ohne Plugin</h3>
            <p><code>inc/plugin-compat.php</code> registriert die beiden Inhaltstypen minimal weiter, damit bestehende Seiten erreichbar bleiben, und zeigt im Adminbereich einen Hinweis. Steckbriefe, Zuordnung, Linkempfehlungs-Eingabe und Seitenmatrix fehlen dann.</p>

            <h2>Seitenleisten und Presse-Logos</h2>
            <p>Auf Seiten mit veröffentlichten Unterseiten zeigt die Seitenleiste eine automatisch erzeugte Liste dieser Unterseiten. Gibt es keine Unterseiten, wird stattdessen – sofern eingerichtet – der reguläre Widget-Bereich angezeigt. Die Unterseiten werden nach Menü-Reihenfolge und danach nach Titel sortiert.</p>
            <p>In den Presse-, SCM- und Werkstatt-Übersichten können Titel mit einem der konfigurierten Präfixe (zum Beispiel <code>wn:</code> oder <code>az:</code>) automatisch durch das passende Logo ersetzt werden. Die Zuordnung von Präfixen zu Bilddateien ist in <code>el_team_get_presselogo_map</code> hinterlegt; neue Logos gehören nach <code>assets/images/presselogo/</code>.</p>
            <p>Funktionen: <code>el_team_has_subpages</code>, <code>el_team_get_subpages</code>, <code>el_team_get_presselogo_map</code> und <code>el_team_replace_title_prefix_with_logo</code>.</p>
            <p>Technik: <code>functions.php</code>, <code>sidebar.php</code>, <code>page-presse.php</code>, <code>page-scm.php</code> und <code>page-werkstatt.php</code>.</p>

            <h2>Seitenmatrix</h2>
            <p>Zeigt veröffentlichte Unterseiten der aktuellen Seite horizontal in einer Tabelle (Block <strong>Seitenmatrix</strong> oder Shortcode). Seit Theme 1.1 kommt sie aus dem Plugin <strong>CityEL Werkstatt</strong>; Darstellung, Block-Einstellungen und Shortcodes sind gleich geblieben.</p>
            <p><code>[seitenmatrix]</code> – alle Ebenen im Stil Werkstatthandbuch.</p>
            <p><code>[seitenmatrix tiefe="2" stil="bilder"]</code> – zwei Ebenen mit Beitragsbildern und Kurztext.</p>
            <p><code>[seitenmatrix id="123" tiefe="1"]</code> – direkte Unterseiten der Seite 123.</p>
            <h3>Seitenpflege</h3>
            <p>Die Hierarchie unter <strong>Seiten → Alle Seiten</strong> über „Übergeordnete Seite“ festlegen. Die Sortierung folgt „Reihenfolge“, bei Gleichstand dem Titel. Es werden nur veröffentlichte Seiten angezeigt.</p>
        </div>
        <?php
    }
}
