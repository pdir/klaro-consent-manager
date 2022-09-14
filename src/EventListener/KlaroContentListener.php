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

namespace Pdir\ContaoKlaroConsentManager\EventListener;

use Contao\BackendUser;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Pdir\ContaoKlaroConsentManager\Model\KlaroServiceModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroTranslationModel;

class KlaroContentListener
{
    /**
     * @Callback(
     *     table="tl_content",
     *     target="fields.klaro_service.options"
     * )
     * collects all services and builds the options array
     *
     * @return array
     */
    public function buildKlaroServiceOptions(DataContainer $dc)
    {
        $options = $GLOBALS['TL_LANG']['klaro']['klaro_services']['options'];
        // get the translation for the current user language
        $translation = KlaroTranslationModel::findOneByLang_code(BackendUser::getInstance()->language);
        // flatten the purposes array
        $arrServiceTranslation = null !== $translation ? $translation->getServiceTranslations() : [];

        // get all defined services
        $services = KlaroServiceModel::findAll();

        if (null !== $services) {
            foreach ($services as $service) {
                // check available translation
                $options[$service->id] = \array_key_exists($service->name, $arrServiceTranslation) ?
                    $arrServiceTranslation[$service->name] :
                    "[$service->name] translation missing";
            }
        }

        return $options;
    }
}
