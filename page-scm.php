<?php
/*
Template Name: Solarchallenge Übersicht
Description: Listet alle Beiträge der Kategorie 'solarchallenge' als Liste (Datum, Titel), nach Jahren gruppiert.
*/
get_template_part( 'template-parts/content/kategorie-uebersicht', null, array(
	'kategorie'   => 'solarchallenge',
	'bezeichnung' => 'Solarchallenge',
) );
