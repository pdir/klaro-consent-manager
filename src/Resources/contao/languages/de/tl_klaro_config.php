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
$klaro = 'Klaro';

$GLOBALS['TL_LANG']['tl_klaro_config'] = [
    // Operations
    'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // title legend
    'title_legend' => 'Basis Einstellungen',
    'title' => ["Name der $sgl", "Geben Sie einen Namen für die $sgl ein."],
    'translation' => ['Übersetzung', "Wählen Sie hier eine Übersetzung. Ist keine Übersetzung zur Auswahl vorhanden, so legen Sie bitte eine neue unter &raquo;$klaro Übersetzungen&laquo; an. Sie können das Feld auch leer lassen. Dann verwendet $klaro die Übersetzung aus der $klaro-Config."],
    // services legend
    'services_legend' => 'Dienste konfigurieren',
    'services' => ['verwendete Dienste', "Wählen Sie hier die Dienste aus, die von $klaro verwendet werden sollen."],
    // config legend
    'script_legend' => 'Skript konfigurieren',
    'scriptLoadingMode' => ['Lademodus', 'Wählen Sie hier aus, wie das script geladen werden soll. Der Modus &raquo;defer&laquo; sollte bevorzugt werden!'],
    //'loding_mode_options' see default
    'myConfigVariableName' => ['Name der Konfigurationsvariable', 'Standardmäßig lädt Klaro die Konfiguration aus einer globalen Variable "klaroConfig". Sie können dies ändern, indem Sie einen neuen Variablennamen angeben.'],
    // consent legend
    'consent_legend' => 'Einwilligungserklärung konfigurieren',
    'noticeAsModal' => ["$klaro als Modal-Dialog starten", "Öffnet $klaro beim Laden &raquo;modal&laquo; (ein Modal-Window bzw. -Dialog o.ä. ist ein Objekt, dass über der Webseite angezeigt wird und das nicht umgangen werden kann. Die Benutzerin / der Benutzer müssen in irgend einer Weise auf dieses Objekt reagieren)."],
    'default' => ['Standard-Zustimmung für alle Dienste', "Legt die Standard-Zustimmung für alle Dienste fest (standardmäßig ist die Zustimmung deaktiviert). Sie können diese Einstellung unter &raquo;$klaro-Dienste&laquo; für jeden Dienst gesondert konfigurieren."],
    'mustConsent' => ['Modal erzwingen', 'Wenn Sie diese Option aktivieren, wird das Zustimmungs-Fenster als Modal-Dialog angezeigt. Es ist dann nicht möglich, dass es die Benutzerin/der Benutzer schließt, bevor sie/er nicht aktiv zugestimmt oder abgelehnt haben.'],
    'acceptAll' => ['&raquo;Alle akzeptieren&laquo;', 'Wenn Sie diese Option aktivieren, wird im Hinweis und im Overlay die Schaltfläche &raquo;Alle akzeptieren&laquo; angezeigt, über die Sie allen Diensten von Drittanbietern mit einem Klick zustimmen können. Wenn Sie diese Option deaktivieren, können Sie jedem Dienst einzeln zustimmen.'],
    'hideDeclineAll' => ['&raquo;Alle ablehnen&laquo; ausblenden', 'Wenn Sie diese Option aktivieren, wird die Schaltfläche &raquo;Ablehnen&laquo; im Overlay ausgeblendet und der Nutzer gezwungen, das Overlay gesondert zu öffnen, um seine Zustimmung zu ändern oder alle Drittanbieterdienste zu deaktivieren. Wir raten Ihnen dringend davon ab, diese Funktion zu verwenden, da sie den Grundsätzen &raquo;privacy by default&laquo; und &raquo;privacy by design&laquo; der Datenschutz-Grundverordnung zuwiderläuft.'],
    'hideModal' => ['Modal auf bestimmten Seiten deaktivieren', 'Hier können Sie festlegen, auf welchen Unterseiten das Modal nicht geöffnet werden soll.'],
    'hideLearnMore' => ['&raquo;Mehr erfahren&laquo; ausblenden', 'Wenn Sie diese Option aktivieren, wird der Link &raquo;mehr erfahren / anpassen&laquo; in der Einwilligungserklärung ausgeblendet. Wir raten dringend davon ab, dies zu tun, da es den Benutzer daran hindert, seine Einwilligungsentscheidungen anzupassen.'],
    // cookie legend
    'cookie_legend' => 'Cookies konfigurieren',
    'elementID' => ['DIV-Id', "Sie können hier die Id des DIV-Elements anpassen, das $klaro beim Start erstellt. Standardmäßig wird $klaro &raquo;klaro&laquo; verwenden."],
    'storageMethod' => ['Speichermethode', "Hier können Sie festlegen, wie $klaro die Zustimmungsinformationen speichert. Wählen Sie &raquo;Cookie Storage&laquo; (Voreinstellung) oder &raquo;Browser Local Storage&laquo;."],
    //'storage_method_options' see default
    'storageName' => ['Speicherschlüssel', "Sie können den Key (Schlüssel) des Cookies oder des localStorage-Eintrags anpassen, den $klaro für die Speicherung der Zustimmungsinformationen verwendet. Standardmäßig verwendet $klaro &raquo;klaro&laquo;."],
    'cookieDomain' => ['Cookie Domain', "Sie können die Cookie-Domain für den Zustimmungsmanager anpassen. Tun Sie dies, wenn Sie die Zustimmung für mehrere übereinstimmende Domänen nur einmal erhalten möchten. Standardmäßig verwendet $klaro die aktuelle Domain. Diese Einstellung ist nur relevant, wenn &raquo;Speichermethode&laquo; auf &raquo;Cookie Storage&laquo; eingestellt ist."],
    'cookieExpiresAfterDays' => ['Cookie Verfallszeit', "Hier können Sie Verfallszeit für das $klaro-Cookie festlegen. Voreinstellung ist 30 Tage (nur relevant, wenn &raquo;Speichermethode&laquo; auf &raquo;Cookie Storage&laquo; eingestellt ist)."],
    // callback legend
    'callback_legend' => 'Callback-Definition',
    'callback' => ['<b style="color:green">callback</b>: <b style="color:blue">function</b>(consent, service) {', "<b>}</b>\nSie können hier den Funktionskörper für eine optionale Callback-Funktion definieren, die jedes Mal aufgerufen wird, wenn sich der Zustimmungsstatus für einen bestimmten Dienst ändert. Der Zustimmungswert wird als als erster Parameter &raquo;consent&laquo; an die Funktion übergeben (true=einverstanden). Die &raquo;Service-Konfiguration&laquo; wird als zweiter Parameter &raquo;service&laquo; übergeben."],
    // expert legend
    'expert_legend' => 'Test und Wartung',
    'htmlTexts' => ['HTML-Modus', "Wenn diese Option aktiviert ist, rendert $klaro die Texte, die in den Feldern &raquo;Text in der Einwilligungsbox&laquo; und &raquo;Text im Modal-Dialog&laquo; angegeben sind als HTML. Das ermöglicht es Ihnen, z.B. benutzerdefinierte Links oder interaktive Inhalte hinzuzufügen. <b style='color:lawngreen;'>Sie finden diese Felder in den $klaro-Übersetzungen.</b>"],
    'testing' => ['Test-Modus aktivieren', "Wenn Sie testing aktivieren, so zeigt $klaro standardmäßig weder den Einwilligungshinweis noch das modal-Window an, es sei denn, sie fügen den spezielle Hashtag #klaro-testing an die URL an. Dann ist es möglich, $klaro auf Ihrer Live-Website zu testen, ohne den normalen Betrieb zu beeinträchtigen."],
];
