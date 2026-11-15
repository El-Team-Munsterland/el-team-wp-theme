<?php
/*
Template Name: Werkstatt Blog Übersicht
Description: Listet alle Beiträge der Kategorie 'werkstatt' als Liste (Datum, Titel), nach Jahren gruppiert.
*/
get_template_part( 'template-parts/content/kategorie-uebersicht', null, array(
	'kategorie'   => 'werkstatt',
	'bezeichnung' => 'Werkstatt',
) );
