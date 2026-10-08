<?php
/** Dokumentation für eigene Theme-Funktionen im WordPress-Adminbereich. */
if (!defined('ABSPATH')) { exit; }

add_action('admin_menu', function () {
    add_theme_page(
        'Theme-Dokumentation',
        'Theme-Dokumentation',
        'edit_theme_options',
        'meine-theme-dokumentation',
        'sm_theme_dokumentation_render'
    );
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
            <p>Frontend-CSS und JavaScript werden zentral geladen. Das Antwort-Skript für Kommentare wird nur auf einzelnen Inhalten geladen, wenn Kommentare geöffnet und verschachtelte Kommentare aktiviert sind. Medienbibliothek und zusätzliche Eingabestile für Linkempfehlungen werden nur beim Bearbeiten oder Anlegen von Seiten eingebunden.</p>
            <p>Funktionen: <code>el_team_setup_theme</code>, <code>el_team_register_sidebars</code>, <code>el_team_enqueue_scripts</code> und <code>el_team_enqueue_admin_scripts</code>.</p>
            <p>Technik: <code>inc/setup.php</code> und <code>inc/enqueue.php</code>; Setup-Hook: <code>after_setup_theme</code>, Sidebar-Hook: <code>widgets_init</code>.</p>

            <h2>Fahrzeuge und Werkstattberichte</h2>
            <p>Das Theme ergänzt die Inhaltstypen <strong>Fahrzeuge</strong> (<code>fahrzeug</code>) und <strong>Werkstattberichte</strong> (<code>werkstattbericht</code>). Fahrzeuge haben keinen Archiv-Aufruf; für Werkstattberichte ist ein Archiv unter dem URL-Präfix <code>/werkstattberichte</code> aktiviert. Beide Inhaltstypen unterstützen den Block-Editor.</p>
            <h3>Fahrzeug-Status</h3>
            <p>Im Fahrzeug-Editor kann der Status <strong>Aktiv</strong> oder <strong>Inaktiv</strong> gesetzt werden. Ohne gespeicherten Status gilt ein Fahrzeug als aktiv. In der Fahrzeug-Übersicht im Adminbereich wird der Status zusätzlich als farbige Spalte angezeigt.</p>
            <h3>Zuordnung von Werkstattberichten</h3>
            <p>Im Werkstattbericht-Editor kann ein veröffentlichtes Fahrzeug zugeordnet oder die Zuordnung entfernt werden. Die Zuordnung erscheint als verlinkte Fahrzeug-Spalte in der Werkstattbericht-Übersicht. Auf der Detailseite eines Fahrzeugs werden die zugehörigen Werkstattberichte nach Datum absteigend aufgelistet.</p>
            <p>Funktionen: <code>el_team_register_custom_post_types</code>, <code>el_team_add_fahrzeug_status_meta_box</code>, <code>el_team_fahrzeug_status_meta_box_callback</code>, <code>el_team_save_fahrzeug_status_meta_box</code>, <code>el_team_add_fahrzeug_status_column</code>, <code>el_team_fahrzeug_status_column_content</code>, <code>el_team_add_admin_styles</code>, <code>el_team_register_werkstattbericht_meta_box</code>, <code>el_team_render_werkstattbericht_meta_box</code>, <code>el_team_save_werkstattbericht_meta_box</code>, <code>el_team_add_werkstattbericht_fahrzeug_column</code>, <code>el_team_werkstattbericht_fahrzeug_column_content</code> und <code>el_team_get_werkstattberichte_for_fahrzeug</code>.</p>
            <p>Technik: <code>inc/setup.php</code> und <code>functions.php</code>; Inhaltstypen werden über <code>init</code> registriert. Die Fahrzeug-Detailansicht liegt in <code>single-fahrzeug.php</code>.</p>

            <h2>Linkempfehlungen</h2>
            <p>Für Seiten mit dem Template <strong>Linkempfehlungen</strong> gibt es im Editor ein Eingabefeld für mehrere Empfehlungen. Jede Empfehlung kann Titel, URL, Beschreibung, eine optionale Logo-Datei und eine Sortierreihenfolge enthalten. Links werden beim Speichern bereinigt; niedrigere Sortiernummern erscheinen auf der Seite zuerst.</p>
            <p>Die Logo-Auswahl verwendet die WordPress-Mediathek. Auf der Website werden die Einträge als Karten mit optionalem Logo und Beschreibung dargestellt; externe Links öffnen in einem neuen Tab.</p>
            <p>Funktionen: <code>el_team_register_link_recommendations_meta_box</code>, <code>el_team_render_link_recommendations_meta_box</code> und <code>el_team_save_link_recommendations</code>.</p>
            <p>Technik: <code>inc/setup.php</code>, <code>inc/enqueue.php</code> und <code>page-linkempfehlungen.php</code>. Die Eingabebox wird nur beim Seitentemplate <code>page-linkempfehlungen.php</code> eingeblendet; gespeichert werden die Daten unter <code>_el_team_links</code>.</p>

            <h2>Seitenleisten und Presse-Logos</h2>
            <p>Auf Seiten mit veröffentlichten Unterseiten zeigt die Seitenleiste eine automatisch erzeugte Liste dieser Unterseiten. Gibt es keine Unterseiten, wird stattdessen – sofern eingerichtet – der reguläre Widget-Bereich angezeigt. Die Unterseiten werden nach Menü-Reihenfolge und danach nach Titel sortiert.</p>
            <p>In den Presse-, SCM- und Werkstatt-Übersichten können Titel mit einem der konfigurierten Präfixe (zum Beispiel <code>wn:</code> oder <code>az:</code>) automatisch durch das passende Logo ersetzt werden. Die Zuordnung von Präfixen zu Bilddateien ist in <code>el_team_get_presselogo_map</code> hinterlegt; neue Logos gehören nach <code>assets/images/presselogo/</code>.</p>
            <p>Funktionen: <code>el_team_has_subpages</code>, <code>el_team_get_subpages</code>, <code>el_team_get_presselogo_map</code> und <code>el_team_replace_title_prefix_with_logo</code>.</p>
            <p>Technik: <code>functions.php</code>, <code>sidebar.php</code>, <code>page-presse.php</code>, <code>page-scm.php</code> und <code>page-werkstatt.php</code>.</p>

            <h2>Hierarchische Seitenmatrix</h2>
            <p>Zeigt die Unterseiten der aktuellen Seite horizontal nach Hierarchieebenen in einer Tabelle an. Die aktuelle Seite selbst wird nicht aufgelistet.</p>
            <h3>Shortcodes</h3>
            <p>Unterseiten der aktuellen Seite: <code>[seitenmatrix]</code></p>
            <p>Unterseiten einer bestimmten Seite: <code>[seitenmatrix id="123"]</code></p>
            <h3>Darstellung</h3>
            <ul style="list-style:disc;padding-left:22px">
                <li>Erste Spalte: direkte Unterseiten.</li>
                <li>Weitere Spalten: Unter-Unterseiten und tiefere Ebenen.</li>
                <li>Elternzellen überspannen die Zeilen aller Nachfahren (rowspan).</li>
                <li>Endseiten füllen übrige Spalten (colspan).</li>
                <li>Jede Seite ist auf ihre eigene URL verlinkt.</li>
                <li>Seiten ohne veröffentlichte Unterseiten zeigen keine Tabelle.</li>
            </ul>
            <h3>Pflege der Seitenstruktur</h3>
            <p>Unter <strong>Seiten → Alle Seiten</strong> lassen sich über die Einstellung <strong>Übergeordnete Seite</strong> die Hierarchie und über <strong>Reihenfolge</strong> die Sortierung festlegen. Bei gleicher Reihenfolge wird nach Titel sortiert.</p>
            <h3>Technik und Funktionen</h3>
            <p>PHP: <code>inc/seitenmatrix.php</code> – Shortcode: <code>seitenmatrix</code> – CSS: automatisch durch diese PHP-Datei eingebunden. Die Hilfsfunktionen <code>sm_build_tree</code>, <code>sm_leaf_count</code>, <code>sm_depth</code> und <code>sm_append_rows</code> erstellen den Seitenbaum und die Tabellenzeilen; <code>sm_seitenmatrix_shortcode</code> verarbeitet den Shortcode.</p>
            <p>Dokumentationsseite: <code>inc/theme-dokumentation.php</code></p>
            <p><strong>Hinweis:</strong> Die unterste Ebene wird derzeit als einzelne Tabellenzeilen dargestellt, nicht als Aufzählung in einer gemeinsamen Zelle.</p>
        </div>
        <?php
    }
}
