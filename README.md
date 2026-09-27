# Fit by Floran — WordPress-thema (op basis van de aangeleverde demo)

Klassiek WordPress-thema, gebouwd op de HTML/CSS-demo die de klant zelf heeft aangeleverd.
Kleuren, typografie en indeling zijn overgenomen; de tekst en de prijsopgaves zijn via ACF beheerbaar.

## Installatie

1. Pak de map `fit-by-floran-demo` uit en plaats hem in `wp-content/themes/` van je local WordPress
   (of upload de zip direct via **Weergave → Thema's → Nieuwe toevoegen → Thema uploaden**).
2. Activeer het thema onder **Weergave → Thema's**.
3. Installeer **Advanced Custom Fields (ACF)** — een gele melding in het admin herinnert je hieraan
   zolang de plugin nog niet actief is. ACF Pro is nodig voor de twee Opties-pagina's
   (Site-instellingen en Prijsopgaves); zonder Pro werkt de site nog steeds, maar zijn die twee
   niet aan te passen via het admin.
4. Ga naar **Instellingen → Lezen** en zet "Homepage toont" op een statische pagina, met die pagina
   als voorpagina. De ACF-velden voor hero/about/aanpak verschijnen pas zodra dat is ingesteld.
5. Ga naar **Weergave → Aanpassen → Site-identiteit** en upload het logo van Floran (wordt gebruikt
   in zowel de header als de footer). Zonder logo toont het thema automatisch de tekst "Fit by Floran".

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

**Los menu-item "Prijsopgaves"** (links in het WP-admin, eigen kopje):
- Alle trajecten/memberships compleet in te vullen: titel, beschrijving, prijs, periode-aanduiding,
  een lijst met kenmerken, of het traject uitgelicht moet worden (gouden rand + badge), en de
  knoptekst/link. Voeg of verwijder trajecten vrij — de website past zich automatisch aan.

**Site-instellingen** (eigen kopje "Fit by Floran"):
- WhatsApp-nummer en voorinvultekst, contact-e-mailadres en telefoonnummer voor weergave.

Specialisaties, samenwerkingen (partnerlogo's) en de footer staan vast, zoals in de goedgekeurde
demo — makkelijk uit te breiden met extra ACF-velden op dezelfde manier als de rest.

## Foto's

Het thema bevat geen hardcoded foto's uit de demo (die stonden als losse base64-tekst in de HTML,
niet geschikt om in een thema te verwerken). Upload de foto's van Floran via de ACF-velden
hierboven; zolang een veld leeg is, toont de betreffende sectie een duidelijke placeholder in
plaats van een gebroken afbeelding.

## Bestandsstructuur

```
fit-by-floran-demo/
├── style.css                      → theme-header + volledige CSS uit de demo
├── functions.php                  → theme setup, ACF-registratie, Opties-pagina's, menu-fallback
├── header.php                     → nav, logo, hamburgermenu (mobiel)
├── footer.php                     → footer + WhatsApp-knop
├── front-page.php                 → hero t/m contact (homepage)
├── index.php / page.php           → fallback-templates
├── acf-fields-fitbyfloran.json    → alle ACF-velden, automatisch geregistreerd via code
└── assets/js/main.js              → hamburgermenu-logica
```
