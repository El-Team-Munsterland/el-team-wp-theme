<?php
/*
Template Name: Presse Übersicht
Description: Listet alle Beiträge der Kategorie 'presse' in einer Tabelle (Datum, Titel).
*/
get_template_part( 'template-parts/content/kategorie-uebersicht', null, array(
	'kategorie'   => 'presse',
	'bezeichnung' => 'Presse',
) );
