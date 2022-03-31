<?php

declare(strict_types=1);

/*
 * Klaro Consent Manager bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 pdir / digital agentur // pdir GmbH
 *
 * @package    krpano-bundle
 * @link       https://pdir.de/krpano-bundle/
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
use Pdir\ContaoKlaroConsentManager\Model\KlaroConfigModel;
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

        dump('parentPageIds: ['.implode(',', $pp).']');

        $klaroConfig = KlaroConfigModel::findByPk(5);
        dump($klaroConfig);

        // prepare the css template
        $cssTemplate = new FrontendTemplate('fe_klaro_css');
        $cssTemplate->version = 'v0.7';

        // prepare the klaro config.js template
        $configJsTemplate = $this->twig->render(
            'fe_klaro_config.js.twig',
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
        $scriptTemplate->klaro_script = "<script $mode data-config='klaroConfig' type='application/javascript' src='bundles/pdircontaoklaroconsentmanager/js/klaro.js'></script>";

        //$GLOBALS['TL_CSS']['klaro'] = $cssTemplate->parse();
        $GLOBALS['TL_CSS']['klaro'] = "https://cdn.kiprotect.com/klaro/{$cssTemplate->version}/klaro.min.css";
        $GLOBALS['TL_BODY']['klaro'] = $scriptTemplate->parse();
    }

    private function isChildFromPage(): void
    {
    }
}
