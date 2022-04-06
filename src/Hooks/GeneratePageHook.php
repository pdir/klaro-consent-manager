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

namespace Pdir\ContaoKlaroConsentManager\Hooks;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\StringUtil;
use Contao\System;
use Pdir\ContaoKlaroConsentManager\Model\KlaroConfigModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroServiceModel;
use Twig\Environment as TwigEnvironment;

/**
 * The generatePage hook is triggered before the main layout (fe_page) is compiled.
 * It passes the page object, the layout object and a self-reference as arguments
 * and does not expect a return value.
 *
 * @Hook("generatePage")
 */
class GeneratePageHook
{
    private $twig;

    public function __construct(TwigEnvironment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param PageModel   $pageModel   the current page object
     * @param LayoutModel $layout      the active page layout applied for rendering the page
     * @param PageRegular $pageRegular the current page type object
     */
    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        $parentPages = $pageModel::findParentsById($pageModel->id);

        foreach ($parentPages as $page) {
            $pp[] = $page->id;
        }
        //dump('parentPageIds: ['.implode(',', $pp).']');

        $klaroConfig = KlaroConfigModel::findByPk(5); // ToDo: prevent empty collection

        //dump($klaroConfig);
        if (null === $klaroConfig) {
            return;
        }

        // prepare the css template
        $cssTemplate = new FrontendTemplate('fe_klaro_css');
        $cssTemplate->version = 'v0.7'; // ToDo: test the version string

        // prepare the klaro services.js template

        // get all services for the given config
        if (null !== $klaroConfig->services) {
            $services = KlaroServiceModel::findMultipleByIds(StringUtil::deserialize($klaroConfig->services));
        }
        // adjust fields
        $serviceFieldsCallback = static function (&$value, $key, $c): void {
            switch ($key) {
                case 'default': $value = $c->bool($value); break;

                case 'purposes':
                    $purposes = StringUtil::deserialize($value);
                    $value = \is_array($purposes) ? "'".implode("','", $purposes)."'" : '';
                    break;

                case 'required': $value = $c->bool($value); break;

                case 'optOut': $value = $c->bool($value); break;

                case 'onlyOnce': $value = $c->bool($value); break;

                case 'contextualConsentOnly': $value = $c->bool($value); break;
            }
        };

        $c = $this; // does the trick
        $serviceCallback = static function ($service) use ($serviceFieldsCallback, $c) {
            array_walk($service, $serviceFieldsCallback, $c);
            // add the key for translations here
            System::loadLanguageFile('tl_klaro_service');
            $serTranslation = '{}';
            $serTranslation = "{zz: {title: 'Matomo/Piwik'},en: {description: 'Matomo is a simple, self-hosted analytics service.'},de: {description: 'Matomo ist ein einfacher, selbstgehosteter Analytics-Service.'}}";
            $service['translations'] = $serTranslation;
            // dump($GLOBALS['TL_LANG']['tl_klaro_service']['purposes_translations'][$service['name']]);

            return $service;
        };

        // prepare a array of service data
        $arrServices = null !== $services ? array_map($serviceCallback, $services->fetchAll()) : [];

        //dump($arrServices);

        // render the services.js section with the service data as javascript
        $servicesPartial = $this->twig->render(
            '@PdirContaoKlaroConsentManager/fe_klaro_config_services.js.twig',
            [
                'services' => $arrServices,
            ]
        );
        //dump($servicesPartial);
        // render the config.js as javascript
        $configJsTemplate = $this->twig->render(
            '@PdirContaoKlaroConsentManager/fe_klaro_config.js.twig',
            [
                'myConfigVariableName' => $klaroConfig->myConfigVariableName,
                'config' => [
                    'testing' => '1' === $klaroConfig->testing ? 'true' : 'false',
                    'elementID' => $klaroConfig->elementID,
                    'storageMethod' => $klaroConfig->storageMethod,
                    'storageName' => $klaroConfig->storageName,
                    'htmlTexts' => '1' === $klaroConfig->htmlTexts ? 'true' : 'false',
                    'cookieDomain' => $klaroConfig->cookieDomain,
                    'cookieExpiresAfterDays' => $klaroConfig->cookieExpiresAfterDays,
                    'default' => '1' === $klaroConfig->default ? 'true' : 'false',
                    'mustConsent' => '1' === $klaroConfig->mustConsent ? 'true' : 'false',
                    'acceptAll' => '1' === $klaroConfig->acceptAll ? 'true' : 'false',
                    'hideDeclineAll' => '1' === $klaroConfig->hideDeclineAll ? 'true' : 'false',
                    'hideLearnMore' => '1' === $klaroConfig->hideLearnMore ? 'true' : 'false',

                    'services' => $servicesPartial,
                ],
            ]
        );
        dump($configJsTemplate);
        // prepare the klaro script template
        $scriptTemplate = new FrontendTemplate('fe_klaro_script');
        // lock to version
        $scriptTemplate->version = 'v0.7';
        $mode = 'defer'; // '' = synchronous, 'async' = asyncronous see: https://heyklaro.com/docs/integration/overview
        // a fallback config
        //$configJsFallbackSrc = 'bundles/pdircontaoklaroconsentmanager/js/config.js';
        //$config_plain = '';

        //$scriptTemplate->klaro_config = "<script $mode type='application/javascript' src='$configJsFallbackSrc'></script>";
        $scriptTemplate->klaro_config = "<script type='application/javascript'>$configJsTemplate</script>";

        //$scriptTemplate->klaro_script = "<script $mode data-config='klaroConfig' type='application/javascript' src='https://cdn.kiprotect.com/klaro/{$scriptTemplate->version}/klaro.js'></script>";
        $scriptTemplate->klaro_script = "<script $mode data-klaro-config='{$klaroConfig->myConfigVariableName}' type='application/javascript' src='bundles/pdircontaoklaroconsentmanager/js/klaro.js'></script>";

        //$GLOBALS['TL_CSS']['klaro'] = $cssTemplate->parse();
        $GLOBALS['TL_CSS']['klaro'] = "https://cdn.kiprotect.com/klaro/{$cssTemplate->version}/klaro.min.css";
        $GLOBALS['TL_BODY']['klaro'] = $scriptTemplate->parse();
    }

    /**
     * @param $value
     */
    private function bool($value): string
    {
        return '1' === $value ? 'true' : 'false';
    }
}
