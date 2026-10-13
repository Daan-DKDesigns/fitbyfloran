# Fit by Floran - WordPress-thema

Klassiek WordPress-thema, gebouwd op de HTML/CSS-demo die de klant zelf heeft aangeleverd.
Kleuren, typografie en indeling zijn overgenomen; de tekst en de prijsopgaves zijn via ACF beheerbaar.

## Installatie

1. Plaats de map van dit thema in `wp-content/themes/` van je (lokale) WordPress
   (of upload de zip direct via **Weergave → Thema's → Nieuwe toevoegen → Thema uploaden**).
2. Activeer het thema onder **Weergave → Thema's**.
3. Installeer **Advanced Custom Fields (ACF)** — een gele melding in het admin herinnert je hieraan
   zolang de plugin nog niet actief is. ACF Pro is nodig voor de Opties-pagina
   Site-instellingen en voor de herhaalvelden (repeaters) op de voorpagina; zonder Pro werkt de site
   nog steeds, maar zijn die niet aan te passen via het admin. Prijsopgaves werken ook met gratis ACF.
4. Ga naar **Instellingen → Lezen** en zet "Homepage toont" op een statische pagina, met die pagina
   als voorpagina. De ACF-velden voor hero/about/aanpak verschijnen pas zodra dat is ingesteld.
5. Ga naar **Weergave → Aanpassen → Site-identiteit** en upload het logo van Floran (wordt gebruikt
   in zowel de header als de footer). Zonder logo toont het thema automatisch de tekst "Fit by Floran".

## Onderhoudsmodus

Zolang de site niet live is, zien bezoekers een "Binnenkort live"-pagina (`maintenance.php`,
met HTTP-status 503 en `noindex`). Ingelogde beheerders zien de echte site. Uitzetten bij livegang:
zet `FBF_MAINTENANCE` bovenin `functions.php` op `false`, of voeg in `wp-config.php` toe:

```php
define( 'FBF_MAINTENANCE', false );
```

## Menu aanmaken

Ga naar **Weergave → Menu's**, maak een nieuw menu met de volgende items (aangepaste links,
ankers naar de secties op de voorpagina), en wijs het toe aan locatie **Hoofdmenu**:

| Tekst | URL |
|---|---|
| Over Floran | `#over` |
| Aanpak | `#aanpak` |
| Diensten | `#diensten` |
| Specialisaties | `#specialisaties` |
| Samenwerkingen | `#partners` |
| Contact | `#contact` |
| Plan je intake | `#contact` |

Geef **"Plan je intake"** de CSS-klasse `nav-cta` (in het menu-item onder "CSS-classes" — zet
**Schermopties** rechtsboven aan als dat veld niet zichtbaar is) zodat hij als knop wordt getoond,
net als in de demo.

Maak je nog geen menu aan, dan toont het thema automatisch dezelfde 7 links als fallback.

## Wat is ACF-beheerbaar

**Op de voorpagina** (verschijnt zodra die als voorpagina is ingesteld):
- Hero: label, titel (2 regels), onderschrift, 2 knoppen, optionele achtergrondfoto
- "Over Floran"-blok: label, titel, tekst (met witregels tussen alinea's), knop, 2 foto's
- "Van analyse naar maximale prestaties": label, titel, introtekst, de 4 kaarten (repeater)
- Sectiekoppen van de dienstensectie (label/titel/introtekst) en de foto in de "Van herstel naar
  volledige performance"-sectie

**Menu-item "Prijsopgaves"** (links in het WP-admin, eigen kopje):
- Elk pakket (traject of membership) is een eigen item. Via **Prijsopgaves → Nieuwe prijsopgave**
  voegt de klant een pakket toe met: naam, korte beschrijving, prijs, periode-aanduiding (bijv. p.m.),
  wat er in het pakket zit (één kenmerk per regel), of het pakket uitgelicht moet worden (gouden
  rand + badge), en de knoptekst/link.
- De volgorde op de website stel je in met het veld **Volgorde** (rechts bij het item, laagste eerst).
- Een pakket tijdelijk verbergen: zet het op **Concept**. Verwijderen kan via de prullenbak.
- Bij het eerste bezoek aan het admin worden de vier pakketten uit de demo automatisch als items
  aangemaakt, zodat ze direct aan te passen zijn.
- Werkt met de gratis versie van ACF; de prijskaarten blijven zichtbaar als ACF even uit staat.

**Site-instellingen** (eigen kopje "Fit by Floran"):
- WhatsApp-nummer en voorinvultekst, contact-e-mailadres en telefoonnummer voor weergave.

Specialisaties, samenwerkingen (partnerlogo's) en de footer staan vast, zoals in de goedgekeurde
demo - makkelijk uit te breiden met extra ACF-velden op dezelfde manier als de rest.

## Foto's

Upload de foto's van Floran via de ACF-velden hierboven. Zolang een fotoveld leeg is, gebruikt het
thema de meegeleverde foto's uit `assets/images/` (hero, twee foto's bij "Over Floran" en de foto bij
"Van herstel naar volledige performance").

Het loginscherm en de onderhoudspagina gebruiken `assets/images/logo.svg`. Het favicon komt uit
`assets/images/favicon.svg`/`favicon.png`, tenzij er een site-icoon is ingesteld via
**Weergave → Aanpassen → Site-identiteit**.

## Bestandsstructuur

```
fitbyfloran/
├── style.css                      → theme-header + volledige CSS uit de demo
├── functions.php                  → theme setup, ACF-registratie, Opties-pagina's, menu-fallback,
│                                    contactformulier, onderhoudsmodus, loginstijl
├── maintenance.php                → "Binnenkort live"-pagina
├── header.php                     → nav, logo, hamburgermenu (mobiel)
├── footer.php                     → footer + WhatsApp-knop
├── front-page.php                 → hero t/m contact (homepage)
├── index.php / page.php           → fallback-templates
├── acf-fields-fitbyfloran.json    → alle ACF-velden, automatisch geregistreerd via code
├── assets/js/main.js              → hamburgermenu-logica
└── assets/images/                 → logo's, favicon en standaardfoto's
```
