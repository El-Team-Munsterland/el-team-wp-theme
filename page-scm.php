<?php
/*
Template Name: Solarchallenge Übersicht
Description: Listet alle Beiträge der Kategorie 'solarchallenge' in einer Tabelle (Datum, Titel).
*/
get_template_part( 'template-parts/content/kategorie-uebersicht', null, array(
	'kategorie'   => 'solarchallenge',
	'bezeichnung' => 'Solarchallenge',
) );
