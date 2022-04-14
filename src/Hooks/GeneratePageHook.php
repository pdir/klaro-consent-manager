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
use Contao\Frontend;
use Contao\FrontendTemplate;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\StringUtil;
use Pdir\ContaoKlaroConsentManager\Model\KlaroConfigModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroPurposeModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroTranslationModel;
use Twig\Environment as TwigEnvironment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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

    /**
     * the Klaro fallback language code zz:.
     *
     * @var
     */
    private $translationZZ;

    /**
     * the Contao page language code de, en ... etc.
     *
     * @var
     */
    private $translationPage;

    /**
     * array of current translations, usually it contains two keys zz: and the current page locale.
     *
     * @var array
     */
    private $arrTranslations = [];

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
        global $objPage;

        $root = Frontend::getRootPageFromUrl();

        // ToDo: Optimize the procurement of the language variables
        // check for Klaro default translation zz
        if (($this->translationZZ = KlaroTranslationModel::findByLang_code('zz')) === null) {
            throw new \Exception();
        }
        // check for Klaro current page translation
        if (($this->translationPage = KlaroTranslationModel::findByLang_code($objPage->language)) === null) {
            throw new \Exception();
        }

        $this->arrTranslations = array_merge($this->translationZZ->fetchAll(), $this->translationPage->fetchAll());

        // Check if klaro must be loaded
        if (!$root->includeKlaro && 0 !== $root->klaroConfig) {
            return;
        }

        // check if current page is in exclude list
        if (null !== $root->klaroExclude) {
            $excludePages = unserialize($root->klaroExclude);
        }

        if (null !== $root->klaroExclude && \is_array($excludePages) && 0 !== $root->klaroConfig) {
            if (\in_array($objPage->id, $excludePages, true)) {
                return;
            }
        }

        $klaroConfig = KlaroConfigModel::findByPk($root->klaroConfig);

        if (null === $klaroConfig) {
            return;
        }

        // Check if the modal should not be opened on this page
        if ($klaroConfig->noticeAsModal && $klaroConfig->hideModal) {
            $hideModalPages = unserialize($klaroConfig->hideModal);

            if (\is_array($hideModalPages) && \in_array($objPage->id, $hideModalPages, true)) {
                $klaroConfig->noticeAsModal = false;
            }
        }

        // prepare the css template
        $cssTemplate = new FrontendTemplate('fe_klaro_css');
        $cssTemplate->version = 'v0.7'; // ToDo: test the version string

        // prepare translations
        $translationsTemplate = $this->buildConfigTranslations($klaroConfig);
        //dump($translationsTemplate);

        // prepare services
        $servicesTemplate = $this->buildConfigServices($klaroConfig);
        dump($servicesTemplate);

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
                    'noticeAsModal' => '1' === $klaroConfig->noticeAsModal ? 'true' : 'false',
                    'default' => '1' === $klaroConfig->default ? 'true' : 'false',
                    'mustConsent' => '1' === $klaroConfig->mustConsent ? 'true' : 'false',
                    'acceptAll' => '1' === $klaroConfig->acceptAll ? 'true' : 'false',
                    'hideDeclineAll' => '1' === $klaroConfig->hideDeclineAll ? 'true' : 'false',
                    'hideLearnMore' => '1' === $klaroConfig->hideLearnMore ? 'true' : 'false',

                    'translations' => $translationsTemplate,

                    'services' => $servicesTemplate,
                ],
            ]
        );
        //dump($configJsTemplate);
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
        dump($scriptTemplate->klaro_config);
        //$scriptTemplate->klaro_script = "<script $mode data-config='klaroConfig' type='application/javascript' src='https://cdn.kiprotect.com/klaro/{$scriptTemplate->version}/klaro.js'></script>";
        $scriptTemplate->klaro_script = "<script $mode data-config='{$klaroConfig->myConfigVariableName}' type='application/javascript' src='bundles/pdircontaoklaroconsentmanager/js/klaro.js'></script>";

        //$GLOBALS['TL_CSS']['klaro'] = $cssTemplate->parse();
        $GLOBALS['TL_CSS']['klaro'] = "https://cdn.kiprotect.com/klaro/{$cssTemplate->version}/klaro.min.css";
        $GLOBALS['TL_BODY']['klaro'] = $scriptTemplate->parse();
    }

    /**
     * builds a simple translation section for a single service
     * the section looks like this:.
     *
     * translations: {
     *      zz: {
     *          title: '',
     *      },
     *      en: {
     *          description: '',
     *      },
     *      ...
     * },
     */
    public function buildConfigServicesTranslations($strServiceName): string
    {
        $translations = '';

        foreach ($this->arrTranslations as $tr) {
            // get all service translations
            $services = StringUtil::deserialize($tr['services']);
            // get the translation for the current service
            $arrFound = array_filter($services ?? [], static function ($service) use ($strServiceName) { if ($service['key'] === $strServiceName) { return true; }});
            // decode the translation string
            $strTrService = \is_array($arrFound) && \count($arrFound) > 0 ? current(array_values($arrFound))['value'] : '';
            $translations .= 'zz' === $tr['lang_code'] ?
"{$tr['lang_code']}: {
                title: '$strTrService',
            },
            " :
"{$tr['lang_code']}: {
                description: '$strTrService',
            },
";
        }

        return $translations;
    }

    /**
     * @param $value
     */
    private function bool($value): string
    {
        return '1' === $value ? 'true' : 'false';
    }

    /**
     * builds the Klaro config.translations.
     *
     * @param $klaroConfigModel
     *
     * @return string
     */
    private function buildConfigTranslations(KlaroConfigModel $klaroConfigModel)
    {
        global $objPage;

        $template = '';

        foreach ($this->arrTranslations as $t) {
            if (null !== $t['privacyPolicyUrl']) {
                $url = PageModel::findByPk($t['privacyPolicyUrl'])->getFrontendUrl();
                $ppu = "  privacyPolicyUrl: '/$url',\n";
            } else {
                $ppu = '';
            }

            $cn = "      consentNotice: { description: '{$t['consentNotice']}', },\n";
            $cm = "      consentModal: { description: '{$t['consentModal']}', },\n";

            $pp = "      purposes: {analytics:{title:'Hier Purposes Analytics Title'}},";

            $template .= "\n    {$t['lang_code']}: {\n    {$ppu}{$cn}{$cm}{$pp}    },";
        }
        //dump($template);

        return "$template\n ";
    }

    /**
     * builds the services section of the klaro config file.
     *
     * services: [
     *  {
     *      name: 'matomo',
     *      default: true,
     *      translations: {
     *          zz: { title: 'Matomo/Piwik' },
     *          en: { description: 'Matomo is a simple, self-hosted analytics service.' },
     *          de: { description: 'Matomo ist ein einfacher, selbstgehosteter Analytics-Service.' },
     *      },
     *      purposes: ['analytics', 'pourpose2', ...],
     *      cookies: [
     *          [/^_pk_.*$/, '/', 'klaro.kiprotect.com'],
     *          [/^_pk_.*$/, '/', 'localhost'],
     *          'piwik_ignore',
     *      ],
     *      callback: function(consent, service) {},
     *      required: false,
     *      optOut: false,
     *      onlyOnce: true,
     *  },
     * ]
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function buildConfigServices(KlaroConfigModel $klaroConfigModel): string
    {
        // get all services for the given config
        if (null !== $klaroConfigModel->services) {
            $services = $klaroConfigModel->getRelated('services');
        }

        // adjust fields
        $serviceFieldsCallback = static function (&$value, $key, $_this): void {
            switch ($key) {
                case 'default': $value = $_this->bool($value); break;

                case 'purposes':
                    // $value can never be NULL because the dca field mandatory => true
                    $purposes = KlaroPurposeModel::findMultipleByIds(StringUtil::deserialize($value))->fetchEach('klaro_key');
                    $value = \is_array($purposes) ? "'".implode("','", $purposes)."'" : '';
                    break;

                case 'required': $value = $_this->bool($value); break;

                case 'optOut': $value = $_this->bool($value); break;

                case 'onlyOnce': $value = $_this->bool($value); break;

                case 'contextualConsentOnly': $value = $_this->bool($value); break;
            }
        };

        $_this = $this;
        $serviceCallback = static function ($service) use ($serviceFieldsCallback, $_this) {
            // modify service parameters
            array_walk($service, $serviceFieldsCallback, $_this);
            // all other objects inside a service goes here
            $service['translations'] = $_this->buildConfigServicesTranslations($service['name']);

            return $service;
        };

        // prepare an array of service data
        $arrServices = null !== $services ? array_map($serviceCallback, $services->fetchAll()) : [];

        // render the services.js section with the service data as javascript
        return $this->twig->render(
            '@PdirContaoKlaroConsentManager/fe_klaro_config_services.js.twig',
            [
                'services' => $arrServices,
            ]
        );
    }
}
