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

/** Tekst van "Over Floran" zoals ingevuld (zie fbf_about_alineas()). */
function fbf_about_tekst() {
	return fbf_field( 'about_tekst', "Mijn naam is Floran, oprichter van Fit by Floran – High Performance Physiotherapy. Sport heeft altijd centraal gestaan in mijn leven. Juist daardoor weet ik hoe belangrijk het is om volledig op je lichaam te kunnen vertrouwen.\n\nEen blessure is zelden alleen een fysieke beperking. Het beïnvloedt je prestaties, je zelfvertrouwen en het plezier waarmee je sport. Mijn missie is daarom om sporters niet alleen klachtenvrij te maken, maar sterker terug te laten komen dan voorheen.\n\nIk kijk verder dan de pijnklacht alleen. Ik analyseer hoe jouw lichaam beweegt, wordt belast en optimaal kan presteren. Op basis daarvan ontwikkelen we samen een persoonlijk plan dat aansluit op jouw sport, niveau en ambities.\n\nGeen standaardprotocollen, maar maatwerk waarin wetenschappelijke inzichten, klinische expertise en persoonlijke begeleiding samenkomen.", fbf_front_id() );
}

/**
 * "Over Floran" als losse alinea's. Elke nieuwe regel in het tekstvak wordt een nieuwe alinea,
 * zodat Floran gewoon op Enter kan drukken (een lege regel ertussen mag ook).
 */
function fbf_about_alineas() {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\R+/',(string) fbf_about_tekst() ) ), 'strlen' ) );
}

/** De stappen van de aanpak (menu-item "Aanpak"): label "01 · ANALYSE", titel en tekst. */
function fbf_aanpak_stappen() {
	$stappen = array();
	foreach ( array_values( fbf_blokken( 'fbf_stap' ) ) as $i => $stap ) {
		$kopje     = trim( (string) ( $stap['label'] ?? '' ) );
		$stappen[] = array(
			'label' => sprintf( '%02d', $i + 1 ) . ( $kopje !== '' ? ' · ' . $kopje : '' ),
			'titel' => $stap['titel'],
			'tekst' => (string) ( $stap['tekst'] ?? '' ),
		);
	}
	return $stappen;
}

/** De specialisaties (menu-item "Specialisaties"): titel, tekst, knoptekst en knoplink. */
function fbf_specialisaties() {
	return fbf_blokken( 'fbf_specialisatie' );
}

/** De samenwerkingen (menu-item "Samenwerkingen"): naam, website, logo en initialen. */
function fbf_samenwerkingen() {
	$partners = array();
	foreach ( fbf_blokken( 'fbf_partner' ) as $partner ) {
		$partners[] = array(
			'naam'      => $partner['titel'],
			'url'       => (string) ( $partner['url'] ?? '' ),
			'initialen' => (string) ( $partner['initialen'] ?? '' ),
			'logo'      => fbf_blok_afbeelding( $partner['logo'] ?? 0, $partner['titel'] ),
		);
	}
	return $partners;
}

/**
 * Keuzes bij "Waar kan ik je mee helpen?" in het intakeformulier, gegroepeerd.
 * Specialisaties en trajecten komen uit hun eigen menu-items, dus een nieuw item verschijnt hier vanzelf.
 */
function fbf_hulpvragen() {
	$groepen = array(
		'Hulpvraag' => array( 'Blessure of klacht', 'Terug naar sport na een blessure', 'Blessures voorkomen & beter presteren' ),
	);
	$specials = array_filter( wp_list_pluck( fbf_specialisaties(), 'titel' ) );
	if ( $specials ) {
		$groepen['Specialisaties'] = array_values( $specials );
	}
	$trajecten = array_filter( wp_list_pluck( fbf_get_prijsopgaves(), 'titel' ) );
	if ( $trajecten ) {
		$groepen['Trajecten & memberships'] = array_values( $trajecten );
	}
	$groepen['Anders'] = array( 'Iets anders' );
	return $groepen;
}
