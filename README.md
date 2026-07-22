# Fit by Floran — WordPress-thema

Klassiek (niet-block) WordPress-thema, gebouwd op basis van het goedgekeurde designconcept.

## Installatie

1. Zip de map `fit-by-floran` (niet de losse bestanden, de hele map met die naam).
2. In je lokale WordPress: **Weergave → Thema's → Nieuwe toevoegen → Thema uploaden**, of plaats de map direct in `wp-content/themes/`.
3. Activeer het thema onder **Weergave → Thema's**.
4. Ga naar **Weergave → Menu's** en maak een menu met de items Aanpak, Diensten, Resultaten, Contact (met ankerlinks `#aanpak`, `#diensten`, `#resultaten`, `#contact`), en wijs het toe aan de locatie "Hoofdmenu". Doe je dit niet, dan gebruikt het thema automatisch een ingebouwde fallback met dezelfde links.

## Screenshot.png

Er zit bewust geen `screenshot.png` in deze levering — die zou ik anders kunstmatig moeten samenstellen, en dat is geen eerlijke weergave van de echte site. Maak zelf een schermafbeelding (1200×900px) van de homepage zodra hij in je lokale omgeving draait, en zet die als `screenshot.png` in de themamap. Dan verschijnt de juiste preview in het thema-overzicht.

## Benodigde/aanbevolen plugins

Het thema laat automatisch een melding zien bovenin het WordPress-admin zolang **Advanced Custom Fields (ACF)** niet actief is, met een directe link om de plugin te installeren. De site blijft ook zonder ACF gewoon werken (met de ingebouwde voorbeeldteksten) — de melding is een aanbeveling, geen harde blokkade.

## ACF-velden importeren (aanbevolen, scheelt handwerk)

In plaats van alle velden handmatig aan te maken, kun je het meegeleverde bestand `acf-fields-fitbyfloran.json` importeren. Dat maakt in één keer alle velden aan met exact de juiste namen die het thema al verwacht.

1. Installeer en activeer **Advanced Custom Fields** (de gratis versie werkt voor de voorpagina-velden; voor het WhatsApp-nummer via een Opties-pagina heb je **ACF Pro** nodig — zonder Pro kun je het nummer ook direct in `functions.php` aanpassen, zie verderop).
2. Ga naar **Aangepaste velden → Tools** (in het linkermenu, onder ACF).
3. Kies **Importeren**, selecteer het bestand `acf-fields-fitbyfloran.json` uit deze thema-map, en klik op **Importeren**.
4. Je ziet nu twee veldengroepen verschijnen onder **Aangepaste velden → Veldengroepen**:
   - **Voorpagina — Fit by Floran** (hero-tekst, diensten, werkwijze-stappen, praktijkcijfers, quote) — automatisch gekoppeld aan je ingestelde voorpagina.
   - **Site-instellingen — Fit by Floran** (WhatsApp-nummer en -bericht) — verschijnt als aparte Opties-pagina "Fit by Floran" in het linkermenu (vereist ACF Pro).
5. Ga naar **Pagina's → [jouw voorpagina] → Bewerken** en vul de velden in. Zodra je opslaat, gebruikt de site automatisch die tekst in plaats van de ingebouwde voorbeeldteksten.

**Let op — front page instellen:** de velden verschijnen alleen op de pagina die is ingesteld als voorpagina onder **Instellingen → Lezen → Homepage toont → Een statische pagina**. Heb je die nog niet ingesteld, doe dat eerst.

**Zonder ACF Pro:** de Opties-pagina voor het WhatsApp-nummer werkt alleen met ACF Pro. Heb je alleen de gratis versie, pas het nummer dan direct aan in `functions.php` zoals hieronder beschreven.

## Dynamische content via ACF

Na het importeren van `acf-fields-fitbyfloran.json` (zie hierboven) staan al deze velden klaar op de voorpagina-editor:

**Hero**
- `hero_gebruik_foto` (aan/uit) — staat standaard uit, zodat de bewegingsanimatie (het goedgekeurde ontwerp) altijd blijft staan totdat iemand bewust kiest voor een foto
- `hero_afbeelding` (afbeelding) — verschijnt pas in de editor zodra `hero_gebruik_foto` aanstaat
- `hero_eyebrow`, `hero_titel_regel1`, `hero_titel_regel2`, `hero_tekst`
- `hero_knop1_tekst` / `hero_knop1_link`, `hero_knop2_tekst` / `hero_knop2_link`

**Vertrouwen-balk**
- `vertrouwen_items` (repeater met sub-veld `tekst`) — de vier regels direct onder de hero

**Diensten**
- `diensten_eyebrow`, `diensten_titel`, `diensten_intro`
- `diensten` (repeater met sub-velden `titel`, `tekst`)

**Werkwijze**
- `werkwijze_eyebrow`, `werkwijze_titel`
- `werkwijze_stappen` (repeater met sub-velden `titel`, `tekst`)

**Resultaten**
- `resultaten_eyebrow`, `resultaten_titel`
- `praktijkcijfers` (repeater met sub-velden `waarde`, `label`)

**Quote**
- `quote_tekst`, `quote_bron`

**Afsluitende CTA**
- `cta_titel`
- `cta_knop1_tekst` / `cta_knop1_link`, `cta_knop2_tekst` / `cta_knop2_link` (gebruik `tel:+31612345678` voor een klikbaar telefoonnummer)

**Site-instellingen (Opties-pagina, vereist ACF Pro)**
- `whatsapp_nummer`, `whatsapp_bericht`

Elk veld heeft in de template (`front-page.php`) een fallback naar de huidige ontwerptekst, dus niets ingevuld = de site ziet er nog steeds goed uit. Zodra een veld wordt ingevuld en opgeslagen, verschijnt die tekst automatisch op de site.

### Zelf nog een tekstveld toevoegen

Wil je later zelf nog een stukje tekst beheerbaar maken dat nu nog hardcoded in `front-page.php` staat?
1. Maak het veld aan in ACF (of voeg het toe aan `acf-fields-fitbyfloran.json` en importeer opnieuw).
2. Vervang in `front-page.php` de vaste tekst door: `<?php echo esc_html( fbf_field( 'jouw_veldnaam', 'Fallback-tekst' ) ); ?>`

De helper-functie `fbf_field()` (in `functions.php`) zorgt voor de ACF-koppeling mét fallback, dus je hoeft niet telkens `function_exists('get_field')` te checken.

## WhatsApp-nummer aanpassen zonder ACF

Standaard staat het placeholder-nummer `31600000000` in `functions.php` (functie `fbf_get_whatsapp_number()`). Vervang dat cijfer direct in het bestand, of gebruik de filter in je eigen `functions.php`-aanpassingen:

```php
add_filter( 'fbf_whatsapp_number', function() {
    return '31612345678'; // echte nummer van Floran
});
```

## Bestandsstructuur

```
fit-by-floran/
├── style.css              → theme-header + volledige CSS
├── functions.php          → theme setup, enqueues, ACF-helpers
├── header.php             → nav, logo, hamburgermenu, licht/donker-knop
├── footer.php             → footer + WhatsApp-knop
├── front-page.php         → hero t/m CTA (homepage)
├── index.php              → verplichte fallback-template
├── page.php               → standaardpagina's (privacyverklaring e.d.)
├── template-parts/
│   └── logo-icon.php      → herbruikbaar SVG-icoon uit het logo
└── assets/
    ├── css/                (leeg, ruimte voor toekomstige losse stylesheets)
    ├── js/
    │   └── main.js         → theme-toggle, hamburgermenu, scroll-reveal
    └── images/
        └── favicon.svg
```

## Bekende aandachtspunten

- De site-titel/tagline in **Instellingen → Algemeen** wordt nu niet automatisch getoond in de hero — die tekst staat vast in `front-page.php` zoals in het goedgekeurde concept. Wil je dat later koppelen aan de WordPress site-titel, dan pas je dat aan in `front-page.php`.
- Contactformulier ontbreekt nog — de huidige CTA-knoppen linken naar het contact-anker en de WhatsApp-knop. Wil je een echt formulier (Contact Form 7, WPForms, of een custom oplossing), dan is dat een losse vervolgstap.
- Custom Logo via **Weergave → Aanpassen → Site-identiteit** is voorbereid (`add_theme_support( 'custom-logo' )`) maar nog niet in de templates verwerkt — nu wordt altijd het SVG-icoon + tekstlogo getoond.
