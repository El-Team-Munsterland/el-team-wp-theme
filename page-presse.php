<?php
/*
Template Name: Presse Übersicht
Description: Listet alle Beiträge der Kategorie 'presse' als Liste (Datum, Titel), nach Jahren gruppiert.
*/
get_template_part( 'template-parts/content/kategorie-uebersicht', null, array(
	'kategorie'    => 'presse',
	'bezeichnung'  => 'Presse',
	'eigenes_logo' => true,
) );
