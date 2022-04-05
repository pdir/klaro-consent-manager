<?php

declare(strict_types=1);

/*
 * Klaro Consent Manager bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 pdir / digital agentur // pdir GmbH
 *
 * @package    klaro-consent-manager
 * @link       https://pdir.de/consent/
 * @license    LGPL-3.0-or-later
 * @author     Mathias Arzberger <develop@pdir.de>
 * @author     Christian Mette <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$sgl = 'Konfiguration';
//$pl = 'Konfigurationen';
$klaro = 'Klaro&copy;';

$GLOBALS['TL_LANG']['tl_klaro_config'] = [
    // Operations
    'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // Naming
    'first_legend' => 'Basis Einstellungen',
    'title' => ["Name der $sgl", "Geben Sie einen Namen für die $sgl ein."],

    // Pages legend
    'pages_legend' => 'Seiten konfigurieren',
    'scope' => ['Scope' => 'Scope'],

    // Services legend
    'services_legend' => 'Dienste konfigurieren',
    'services' => ['Services' => 'Services'],

    // Config legend
    'script_legend' => 'Skript konfigurieren',
    'scriptLoadingMode' => ['Lademodus', 'Wählen Sie hier aus, wie das script geladen werden soll. Der Modus &raquo;defer&laquo; sollte bevorzugt werden!'],
    'loading_mode_options' => ['' => 'synchron', 'defer' => 'verzögert (defer)', 'async' => 'parallel (async)'],
    'myConfigVariableName' => ['Name of the configuration variable' => ''],

    // Consent legend
    'consent_legend' => 'Einwilligungserklärung konfigurieren',
    'default' => ['Modal starten', 'Öffnet das Overlay beim Start modal (standardmäßig deaktiviert). Sie können diese Einstellung in jedem Dienst außer Kraft setzen.'],
    'mustConsent' => ['Zustimmung erzwingen', 'Wenn Sie diese Option aktivieren, wird das Zustimmungs-Fenster modal angezeigt. Es ist dann nicht möglich, dass der Benutzer es schließt, bevor er nicht aktiv zugestimmt oder abgelehnt hat.'],
    'acceptAll' => ['&raquo;Alle akzeptieren&laquo;', 'Wenn Sie diese Option aktivieren, wird im Hinweis und im Overlay die Schaltfläche &raquo;Alle akzeptieren&laquo; angezeigt, über die Sie allen Diensten von Drittanbietern mit einem Klick zustimmen können. Wenn Sie diese Option deaktivieren, können Sie jedem Dienst einzeln zustimmen.'],
    'hideDeclineAll' => ['&raquo;Alle ablehnen&laquo; ausblenden', 'Wenn Sie diese Option aktivieren, wird die Schaltfläche &raquo;Ablehnen&laquo; im Overlay ausgeblendet und der Nutzer gezwungen, das Overlay gesondert zu öffnen, um seine Zustimmung zu ändern oder alle Drittanbieterdienste zu deaktivieren. Wir raten Ihnen dringend davon ab, diese Funktion zu verwenden, da sie den Grundsätzen &raquo;privacy by default&laquo; und &raquo;privacy by design&laquo; der Datenschutz-Grundverordnung zuwiderläuft.'],
    'hideLearnMore' => ['&raquo;Mehr erfahren&laquo; ausblenden', 'Wenn Sie diese Option aktivieren, wird der Link &raquo;mehr erfahren / anpassen&laquo; in der Einwilligungserklärung ausgeblendet. Wir raten dringend davon ab, dies zu tun, da es den Benutzer daran hindert, seine Einwilligungsentscheidungen anzupassen.'],

    // Cookie legend
    'cookie_legend' => 'Cookies konfigurieren',
    'elementID' => ['klaro-elementId', "Sie können hier die Id des DIV-Elements anpassen, das $klaro beim Start erstellt. Standardmäßig wird $klaro &raquo;klaro&laquo; verwenden."],
    'storageMethod' => ['Speichermethode', "Hier können Sie festlegen, wie $klaro die Zustimmungsinformationen speichert. Wählen Sie &raquo;Cookie Storage&laquo; (Voreinstellung) oder &raquo;Browser Local Storage&laquo;."],
    'storage_method_options' => ['cookie' => 'Cookie Storage', 'localStorage' => 'Browser Local Storage'],
    'storageName' => ['Speicher-Schlüssel', "Sie können den Key (Schlüssel) des Cookies oder des localStorage-Eintrags anpassen, den $klaro für die Speicherung der Zustimmungsinformationen verwendet. Standardmäßig verwendet $klaro &raquo;klaro&laquo;."],
    'cookieDomain' => ['Cookie-Domain', "Sie können die Cookie-Domain für den Zustimmungsmanager anpassen. Tun Sie dies, wenn Sie die Zustimmung für mehrere übereinstimmende Domänen nur einmal erhalten möchten. Standardmäßig verwendet $klaro die aktuelle Domain. Diese Einstellung ist nur relevant, wenn &raquo;Speichermethode&laquo; auf &raquo;Cookie Storage&laquo; eingestellt ist."],
    'cookieExpiresAfterDays' => ['Cookie Verfallszeit', "Hier können Sie Verfallszeit für das $klaro-Cookie festlegen. Voreinstellung ist 30 Tage (nur relevant, wenn &raquo;Speichermethode&laquo; auf &raquo;Cookie Storage&laquo; eingestellt ist)."],

    // Expert legend
    'expert_legend' => 'Experten Einstellungen',
    'testing' => ['Test-Modus aktivieren', "Wenn Sie testing aktivieren, so zeigt $klaro standardmäßig weder den Einwilligungshinweis noch das modal-Window an, es sei denn, sie fügen den spezielle Hashtag #klaro-testing an die URL an. Dann ist es möglich, $klaro auf Ihrer Live-Website zu testen, ohne den normalen Betrieb zu beeinträchtigen."],
    'htmlTexts' => ['HTML-Modus', "Wenn diese Option aktiviert ist, rendert $klaro die Texte, die in den Feldern `consentModal.description` und `consentNotice.description` angegebenen sind als HTML. Das ermöglicht es Ihnen, z.B. benutzerdefinierte Links oder interaktive Inhalte hinzuzufügen."],

    // Basic configuration
    'selectField' => ['Select Feld', 'Wählen Sie aus.'],
    'checkboxField' => ['Chosen Feld', 'Wählen Sie aus.'],
    'multitextField' => ['Multitext Feld', 'Geben Sie die Werte ein'],
    'addSubpalette' => ['Erweiterte Einstellungen aktivieren', 'Hier können Sie die erweiterten Einstellungen aktivieren.'],
    'textareaField' => ['Textarea', 'Geben Sie einen Text ein'],

    // Buttons
    'customButton' => 'Custom Routine starten',
];
