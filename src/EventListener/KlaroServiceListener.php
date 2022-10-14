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
use Pdir\ContaoKlaroConsentManager\Model\KlaroPurposeModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroTranslationModel;

class KlaroServiceListener
{
    /**
     * @Callback(
     *     table="tl_klaro_service",
     *     target="fields.purposes.options"
     * )
     * builds the service options
     *
     * @return array
     */
    public function buildPurposesOptions(DataContainer $dc)
    {
        $options = [];
        // get the translation for the current user language
        $translation = KlaroTranslationModel::findOneByLang_code(BackendUser::getInstance()->language);
        // flatten the purposes array
        $arrPurposeTranslation = null !== $translation ? $translation->getPurposeTranslations() : [];
        // get all defined purposes
        $purposes = KlaroPurposeModel::findAll();

        if (null !== $purposes) {
            foreach ($purposes as $purpose) {
                $options[$purpose->id] =
                    \array_key_exists($purpose->klaro_key, $arrPurposeTranslation) &&
                    !empty($arrPurposeTranslation[$purpose->klaro_key])
                        ?
                    $arrPurposeTranslation[$purpose->klaro_key] :
                    "[$purpose->klaro_key] translation missing";
            }
        }
        return $options;
    }
}
