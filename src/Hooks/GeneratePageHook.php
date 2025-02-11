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

use Contao\CoreBundle\Monolog\ContaoContext;
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
use Psr\Log\LoggerInterface;
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
    /**
     * @var TwigEnvironment
     */
    private $twig;

    /**
     * @var LoggerInterface
     */
    private $logger;

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

    public function __construct(TwigEnvironment $twig, LoggerInterface $logger)
    {
        $this->twig = $twig;
        $this->logger = $logger;
    }

    /**
     * @param PageModel   $pageModel   the current page object
     * @param LayoutModel $layout      the active page layout applied for rendering the page
     * @param PageRegular $pageRegular the current page type object
     */
    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        global $objPage;
        // build a logger context
        $arrContext = ['contao' => new ContaoContext(__METHOD__, ContaoContext::ERROR)];

        $root = Frontend::getRootPageFromUrl();

        // at first, check for Klaro current page translation
        if (($this->translationPage = KlaroTranslationModel::findByLang_code($objPage->language)) === null) {
            $this->logger->alert("Klaro is not properly configured at the moment. The page default language '{$objPage->language}' is missing. Please define the page default language for the locale '{$objPage->language}' in your 'Translations'.", $arrContext);
        }

        // check for Klaro default translation zz
        if (($this->translationZZ = KlaroTranslationModel::findByLang_code('zz')) === null) {
            $this->logger->alert("Klaro is not properly configured at the moment. The fallback translation 'zz' is missing. Please define an fallback language for the locale 'zz' in your 'Translations'.", $arrContext);
            return;
        }

        // prepare save merge
        $arrTranslationZZ   = is_null($this->translationZZ) ? [] : $this->translationZZ->fetchAll();
        $arrTranslationPage = is_null($this->translationPage) ? [] : $this->translationPage->fetchAll();
        // merge
        $this->arrTranslations = array_merge($arrTranslationZZ, $arrTranslationPage);

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
        $cssTemplate->version = 'v0.7'; // only for CDN

        // prepare translations
        $translationsTemplate = "\n" . $this->buildConfigTranslations($klaroConfig);

        // prepare services
        $servicesTemplate = $this->buildConfigServices($klaroConfig);

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
                    'callback' => $klaroConfig->callback,
                ],
            ]
        );

        // prepare the klaro script template: HTML5 not Twig!
        $scriptTemplate = new FrontendTemplate('fe_klaro_script');
        // lock to version
        $scriptTemplate->version = 'v0.7'; // only for CDN

        // a fallback config
        $configJsFallbackSrc = 'bundles/pdircontaoklaroconsentmanager/js/config.min.js';
        $configJsDebugSrc = 'bundles/pdircontaoklaroconsentmanager/js/config_debug.js';
        #$scriptTemplate->klaro_config = "<script type='application/javascript' src='$configJsDebugSrc'></script>";
        $scriptTemplate->klaro_config = "<script type='application/javascript'>$configJsTemplate</script>";

        // provide the klaro.js Script
        $scriptTemplate->klaro_script = "<script {$klaroConfig->scriptLoadingMode} data-config='{$klaroConfig->myConfigVariableName}' type='application/javascript' src='bundles/pdircontaoklaroconsentmanager/js/klaro.min.js'></script>";

        #$GLOBALS['TL_CSS']['klaro'] = 'bundles/pdircontaoklaroconsentmanager/css/klaro.min.css|static';
        $GLOBALS['TL_BODY']['klaro'] = $scriptTemplate->parse();
        $GLOBALS['TL_BODY'][] = "<script {$klaroConfig->scriptLoadingMode} type='application/javascript' src='bundles/pdircontaoklaroconsentmanager/js/fe.min.js'></script>";
    }

    /**
     * builds a translation section for a single service
     * the section looks like this:
     *
     * translations: {
     *      zz: {
     *          title: '',
     *      },
     *      en: {
     *          description: '',
     *      },
     * },
     *
     * 14.12.2022 it seems that the zz key here
     */
    public function buildConfigServiceTranslations($strServiceName): string
    {
        $translations = '';

        $removeLanguageZZ = function($value) { return !(strpos($value['lang_code'], 'zz') === 0); };

        $arrFilteredWithoutZZ = array_filter($this->arrTranslations, $removeLanguageZZ,  ARRAY_FILTER_USE_BOTH);

        foreach ($arrFilteredWithoutZZ as $tr) {
            // get all service translations
            $services = StringUtil::deserialize($tr['services']);
            // get the translation for the current service
            $arrFound = array_filter(
                $services ?? [],
                static function ($service) use ($strServiceName) {
                    if ($service['key'] === $strServiceName) {
                        return true;
                    }
                    return false;
                }
            );
            // decode the translation string
            $strTrService = \is_array($arrFound) && \count($arrFound) > 0 ? current(array_values($arrFound))['translation'] : '';
            $strTrServiceDescription = \is_array($arrFound) && \count($arrFound) > 0 ? current(array_values($arrFound))['description'] : '';

            $translations .= 'zz' === $tr['lang_code'] ?
                "'{$tr['lang_code']}': {
                title: '$strTrService',
            },
            " :
                "'{$tr['lang_code']}': {
                description: '$strTrServiceDescription',
                title: '$strTrService',
            },
";
        }

        return $translations;
    }

    /**
     * creates a javascript array for service.cookies as string.
     *
     * @param $service
     */
    public function buildConfigServiceCookies($service)
    {
        $arrCookies = StringUtil::deserialize($service['cookies']);

        if (null !== $arrCookies) {
            $arrResult = [];
            array_walk($arrCookies, static function ($cookie) use (&$arrResult): void { $arrResult[] = html_entity_decode(str_replace('&#39;', "'", $cookie)); });
            $result = implode(",\n          ", $arrResult);
        }

        if (null === $arrCookies) {
            $result = '';
        }


        return "\n          $result\n        ";
    }

    /**
     * creates config.translation section as string.
     *
     * @param $klaroConfigModel
     *
     * @return string
     */
    private function buildConfigTranslations(KlaroConfigModel $klaroConfigModel)
    {
        global $objPage;

        $template = '';

        foreach ($this->arrTranslations as $translation) {
            $pm = PageModel::findByPk($translation['privacyPolicyUrl']);

            $template .= $this->keyToObject(
                // the lang_code 'xx_XX':
                $translation['lang_code'],
                //  privacyPolicyUrl:
                $this->keyToString('privacyPolicyUrl', null === $pm ? '' : $pm->getFrontendUrl(), $klaroConfigModel, 12).
                //  consentNotice:
                $this->keyToObject(
                    'consentNotice',
                    $this->keyToString('description', $translation['consentNotice'], $klaroConfigModel, 16).
                    $this->keyToString('learnMore', $translation['learnMore'], $klaroConfigModel, 16)
                ).
                //  consentModal:
                $this->keyToObject('consentModal', $this->keyToString('description', $translation['consentModal'], $klaroConfigModel, 16), 12).
                //  More translations:
                $this->keyToString('decline', $translation['decline'], $klaroConfigModel, 12).
                $this->keyToString('ok', $translation['ok'], $klaroConfigModel, 12).
                $this->keyToString('acceptAll', $translation['acceptAll'], $klaroConfigModel, 12).
                $this->keyToString('acceptSelected', $translation['acceptSelected'], $klaroConfigModel, 12).
                //  contextualConsent: - not documented, see klaro.js line 1904 ff
                $this->buildContextualConsentTranslation($translation, $klaroConfigModel).
                //  purposes:
                $this->keyToObject('purposes', $this->buildConfigTranslationPurposes($klaroConfigModel), 12), 8);
        }
        return "$template\n   ";
    }

    /**
     * @param $translation
     *
     * @return string
     */
    private function buildContextualConsentTranslation($translation, $klaroConfigModel)
    {
        return $this->keyToObject(
            'contextualConsent',
            $this->keyToString('acceptAlways', $translation['ccAcceptAlways'], $klaroConfigModel, 16).
            $this->keyToString('acceptOnce', $translation['ccAcceptOnce'], $klaroConfigModel, 16).
            $this->keyToString('description', $translation['ccDescription'], $klaroConfigModel, 16),
            12
        );
    }

    /**
     * creates config.translation.purposes section as string.
     *
     * @return string
     */
    private function buildConfigTranslationPurposes($klaroConfigModel)
    {
        // checks the given translations - by default two translations should be available
        // standard page language given?
        if ($this->translationPage) {
            $arrPurposes = StringUtil::deserialize($this->translationPage->purposes) ?? [];
        }
        // fallback page language given?
        elseif ($this->translationZZ) {
            $arrPurposes = StringUtil::deserialize($this->translationZZ->purposes) ?? [];
        }
        else {
            $arrPurposes = [];
        }

        $strPurposes = '';

        foreach ($arrPurposes as $translation) {
            $strPurposes .= $this->keyToObject(
                $translation['key'],
                $this->keyToString('title', $translation['translation'], $klaroConfigModel, 20) .
                $this->keyToString('description', $translation['description'], $klaroConfigModel, 20),
                16
            );
        }

        return $strPurposes;
    }

    /**
     * creates the services section of the klaro config file.
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
     *      purposes: ['analytics', 'purpose2', ...],
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
        $services = !is_null($klaroConfigModel->services) ? $klaroConfigModel->getRelated('services') : null;

        // adjust fields
        $serviceFieldsCallback = static function (&$value, $key, $_this): void {
            switch ($key) {
                case 'default':
                case 'required':
                case 'optOut':
                case 'onlyOnce':
                case 'contextualConsentOnly':
                    $value = $_this->bool($value);
                    break;
            }
        };

        $_this = $this;
        $serviceCallback = static function ($service) use ($serviceFieldsCallback, $_this) {
            // modify service parameters
            array_walk($service, $serviceFieldsCallback, $_this);
            // all other objects inside a service goes here
            $service['translations'] = $_this->buildConfigServiceTranslations($service['name']);
            // purposes?
            $service['purposes'] = $_this->buildConfigServicePurposes($service);
            // cookies - must be an js array
            $service['cookies'] = $_this->buildConfigServiceCookies($service);

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

    /**
     * creates a javascript array for service.purposes as string.
     *
     * @param $service
     *
     * @return mixed
     */
    private function buildConfigServicePurposes($service)
    {
        $purposes = KlaroPurposeModel::findMultipleByIds(StringUtil::deserialize($service['purposes']));

        return null !== $purposes ? "'".implode("','", $purposes->fetchEach('klaro_key'))."'" : '';
    }

    /**
     * @param $value
     */
    private function bool($value): string
    {
        return '1' === $value ? 'true' : 'false';
    }

    /**
     * creates a javascript key-value string like 'key': 'value'
     *
     * @param $key
     * @param $value
     *
     * @return string
     */
    private function keyToString($key, $value, $klaroConfig, $pos = 0)
    {
        return '' === $value || empty($value) || null === $value ?
            '' :
            ('1' === $klaroConfig->htmlTexts ?
                str_repeat(' ', $pos)."'$key': '$value',\n" :
                strip_tags(str_repeat(' ', $pos)."'$key': '$value',\n")
            )
        ;
    }

    /**
     * creates a javascript object-string like 'key': { content }
     *
     * @param $key
     * @param $value
     * @param $pos
     *
     * @return string
     */
    private function keyToObject($key, $content, $pos = 0)
    {
        return empty($content) ?
            '' :
            str_repeat(' ', $pos)."'$key': {\n$content".str_repeat(' ', $pos)."},\n";
    }
}
