<?php
/*
Template Name: Werkstatt Blog Übersicht
Description: Listet alle Beiträge der Kategorie 'werkstatt' in einer Tabelle (Datum, Titel).
*/
get_template_part( 'template-parts/content/kategorie-uebersicht', null, array(
	'kategorie'   => 'werkstatt',
	'bezeichnung' => 'Werkstatt',
) );
