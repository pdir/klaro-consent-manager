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

use Contao\ContentModel;
use Contao\CoreBundle\ServiceAnnotation\Hook;

/**
 * @Hook("getContentElement")
 */
class GetContentElementHook
{
    public function __invoke(ContentModel $contentModel, string $buffer, $element)
    {
        $arrConsentValues = ['1' => 'agreed', '2' => 'rejected'];
        $arrStateValues = ['1' => 'show', '2' => 'hide'];

        $serviceId = (int) $element->klaro_service;
        // Check if element is bound to Klaro
        if (0 === $serviceId) {
            // unbound
            return $buffer;
        }

        if ($serviceId < 0) {
            // special services ToDo: handle services
            $serviceName = 'servicesall';
        } else {
            // klaro services
            $serviceName = $contentModel->getRelated('klaro_service')->name;
        }

        // get consent and state
        $consent = $arrConsentValues[$element->klaro_consent];
        $state = $arrStateValues[$element->klaro_state];
        $dataName = "{$serviceName}-{$consent}-{$state}";

        switch ($element->type) {
            case 'text':
            case 'headline':
            case 'html':
            case 'list':
            case 'table':
            case 'code':
            case 'image':
            case 'youtube':
            case 'vimeo':
            case 'download':
            case 'downloads':
            case 'form':
                $buffer = $element->Template->parse();
                $buffer = preg_replace('/(class=\".+\")/', 'data-name="'.$dataName.'" \1', $buffer);
                break;
            # case 'module':

            default:
        }

        return $buffer;
    }
}
