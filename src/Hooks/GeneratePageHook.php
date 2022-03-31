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
     * @param PageModel   $pageModel   the current page object
     * @param LayoutModel $layout      the active page layout applied for rendering the page
     * @param PageRegular $pageRegular the current page type object
     */
    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        dump($pageModel::findParentsById($pageModel->id));

        //$configJsTemplate = new FrontendTemplate('fe_klaro_config');
        $configJsTemplate = $this->render('@Contao/ce_my_content_element.html.twig', [
            'text' => 'text',
            'my_variable' => 'foobar',
        ]);

        dump($configJsTemplate->parse());

        $cssTemplate = new FrontendTemplate('fe_klaro_css');
        $cssTemplate->version = 'v0.7';

        $scriptTemplate = new FrontendTemplate('fe_klaro_script');
        // lock to version
        $scriptTemplate->version = 'v0.7';
        $mode = 'defer'; // '' = synchronous, 'async' = asyncronous see: https://heyklaro.com/docs/integration/overview
        // a fallback config
        $config_fallback = 'bundles/pdircontaoklaroconsentmanager/js/config.js';
        //$config_plain = '';

        $scriptTemplate->klaro_config = "<script $mode type='application/javascript' src='$config_fallback'></script>";
        //$scriptTemplate->klaro_config = "<script type='application/javascript'>$config_plain</script>";

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
