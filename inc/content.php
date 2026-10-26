<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inhoud van de voorpagina met de standaardteksten uit de demo als terugval.
 * Op één plek, zodat de voorpagina en /llms.txt altijd hetzelfde tonen.
 */

/** ID van de voorpagina, zodat de velden ook buiten de voorpagina zelf (bijv. /llms.txt) gelezen worden. */
function fbf_front_id() {
	$id = (int) get_option( 'page_on_front' );
	return $id ? $id : false;
}

/** Tekst van "Over Floran" (alinea's gescheiden door een lege regel). */
function fbf_about_tekst() {
	return fbf_field( 'about_tekst', "Mijn naam is Floran, oprichter van Fit by Floran – High Performance Physiotherapy. Sport heeft altijd centraal gestaan in mijn leven. Juist daardoor weet ik hoe belangrijk het is om volledig op je lichaam te kunnen vertrouwen.\n\nEen blessure is zelden alleen een fysieke beperking. Het beïnvloedt je prestaties, je zelfvertrouwen en het plezier waarmee je sport. Mijn missie is daarom om sporters niet alleen klachtenvrij te maken, maar sterker terug te laten komen dan voorheen.\n\nIk kijk verder dan de pijnklacht alleen. Ik analyseer hoe jouw lichaam beweegt, wordt belast en optimaal kan presteren. Op basis daarvan ontwikkelen we samen een persoonlijk plan dat aansluit op jouw sport, niveau en ambities.\n\nGeen standaardprotocollen, maar maatwerk waarin wetenschappelijke inzichten, klinische expertise en persoonlijke begeleiding samenkomen.", fbf_front_id() );
}

/** De stappen van de aanpak: label, titel en tekst. */
function fbf_aanpak_stappen() {
	$stappen = function_exists( 'get_field' ) ? get_field( 'aanpak_stappen', fbf_front_id() ) : false;
	if ( $stappen ) {
		return $stappen;
	}
	return array(
		array( 'label' => '01 · ANALYSE', 'titel' => 'Inzicht', 'tekst' => 'Uitgebreide intake en performance screening van mobiliteit, kracht, belastbaarheid, blessuregeschiedenis en sportdoelen.' ),
		array( 'label' => '02 · HERSTEL', 'titel' => 'Belastbaarheid', 'tekst' => 'Gericht herstel met aandacht voor pijn, functie, kracht en het opnieuw opbouwen van vertrouwen in je lichaam.' ),
		array( 'label' => '03 · PREVENTIE', 'titel' => 'Behouden', 'tekst' => 'Gerichte training, monitoring en slim belastingmanagement om terugkerende klachten te helpen voorkomen.' ),
		array( 'label' => '04 · PERFORMANCE', 'titel' => 'Presteren', 'tekst' => 'Van klachtenvrij naar sterker, sneller en beter voorbereid op de eisen van jouw sport.' ),
	);
}

/** De specialisaties: titel, tekst, knoptekst en knoplink. */
function fbf_specialisaties() {
	$specials = function_exists( 'get_field' ) ? get_field( 'specialisaties', fbf_front_id() ) : false;
	if ( $specials ) {
		return $specials;
	}
	return array(
		array(
			'titel'      => 'Second Opinion',
			'tekst'      => 'Twijfel je over een diagnose of behandelplan? We bekijken jouw situatie objectief en vertalen dit naar een helder advies.',
			'knop_tekst' => 'Plan second opinion',
			'knop_link'  => '#contact',
		),
		array(
			'titel'      => 'Performance Screening',
			'tekst'      => 'Krijg inzicht in je huidige fysieke capaciteit, aandachtspunten en de volgende stap richting jouw prestatiedoel.',
			'knop_tekst' => 'Plan screening',
			'knop_link'  => '#contact',
		),
		array(
			'titel'      => 'Return-to-Sport & Running',
			'tekst'      => 'Van sportspecifieke screening en running analysis tot videoanalyse en return-to-performance testing.',
			'knop_tekst' => 'Plan analyse',
			'knop_link'  => '#contact',
		),
	);
}
