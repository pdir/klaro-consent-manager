<?php

declare(strict_types=1);

/*
 * Klaro Consent Manager bundle for Contao Open Source CMS
 *
 * Copyright (c) 2023 pdir / digital agentur // pdir GmbH
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

$sgl = 'Dienst';
//$pl = 'Dienste';
$klaro = 'Klaro';

$GLOBALS['TL_LANG']['tl_klaro_service'] = [
    // Operations
    'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // title legend
    'title_legend' => 'Name',
    'title' => ["Name der $sgl-Konfiguration", 'Geben Sie einen Namen für diese Konfiguration ein.'],
    // service legend
    'service_legend' => "$sgl-Name, Zwecke und Cookie-Regeln",
    'name' => ["Name des {$sgl}es", "Geben Sie den Namen für den $sgl ein, den $klaro intern als Symbol für diesen Dienst verwendet."],
    'purposes' => ['Zwecke', "Wählen Sie hier mindestens einen Zweck, dem dieser Dienst zugeordnet ist. Ist die Liste leer, so müssen Sie zuerst unter dem Menüpunkt &raquo;$klaro-Zwecke&laquo; mindestens einen Zweck definieren."],
    'cookies' => ['Cookie-Regeln', "Die Cookie-Regeln sind etwas kompliziert. <a style='color:green;' href='https://heyklaro.com/docs/integration/annotated-configuration'>Hier finden Sie nähere Informationen zu den $klaro-Cookie-Regeln.</a>"],
    // standard legend
    'standard_legend' => 'Voreinstellungen dieses Dienstes',
    'default' => ['zugestimmt', 'Wenn diese Option aktiviert ist, wird die Zustimmung für diesen Dienst beim Laden voreingestellt.'],
    'required' => ['erforderlich', "Wenn diese Option aktiviert ist, lässt $klaro nicht zu, dass dieser Dienst vom Benutzer deaktiviert wird. Verwenden Sie diese Option für Dienste, die nötig sind, damit Ihre Website grundsätzlich funktioniert (z.B. Einkaufswagen-Cookies)."],
    'optOut' => ['erzwingen', "Wenn diese Option aktiviert ist, lädt $klaro diesen Dienst auch dann, wenn der Nutzer nicht ausdrücklich zugestimmt hat. Wir raten dringend davon ab!"],
    'onlyOnce' => ['einmalig', "Wenn diese Option aktiviert ist, wird der Dienst nur einmal ausgeführt, unabhängig davon, wie oft der Benutzer ihn ein- und ausschaltet. Dies ist z.B. wichtig für Tracking-Skripte, die jedes Mal neue Seitenaufruf-Ereignisse erzeugen würden, wenn $klaro eine Änderung der Zustimmung des Benutzers bemerkt."],
    'contextualConsentOnly' => ['kontextabhängig', "Wenn diese Option aktiviert ist, wird der Dienst von $klaro als &raquo;kontextabhängig&laquo; betrachtet. Das bedeutet, dass an den entsprechenden Positionen im Layout, eine gesonderte Zustimmung erfragt wird, bevor das Element an dieser Position für diesen Dienst aktiviert wird."],
    // callback legend
    'callback_legend' => 'Callback-Definition',
    'callback' => ['<b style="color:green">callback</b>: <b style="color:blue">function</b>(consent, service) {', "<b>}</b>\nSie können hier den Funktionskörper für eine optionale Callback-Funktion definieren, die jedes Mal aufgerufen wird, wenn sich der Zustimmungsstatus für einen bestimmten Dienst ändert. Der Zustimmungswert wird als als erster Parameter &raquo;consent&laquo; an die Funktion übergeben (true=einverstanden). Die &raquo;Service-Konfiguration&laquo; wird als zweiter Parameter &raquo;service&laquo; übergeben."],
    // event_handler_legend
    'event_handler_legend' => 'Event-Handler-Definitionen',
    'onAccept' => ['<b style="color:green">onAccept</b>: <b style="color:blue">function</b>() {', '<b>}</b>Sie können hier den Funktionskörper für eine optionale Event-Handler definieren.'],
    'onInit' => ['<b style="color:green">onInit</b>: <b style="color:blue">function</b>() {', '<b>}</b>Sie können hier den Funktionskörper für eine optionale Event-Handler definieren.'],
    'onDecline' => ['<b style="color:green">onDecline</b>: <b style="color:blue">function</b>() {', '<b>}</b>Sie können hier den Funktionskörper für eine optionale Event-Handler definieren.'],
    'vars' => ['<b style="color:green">vars</b>: {', '<b>}</b>Sie können hier zusätzliche Variablen definieren.'],
];
