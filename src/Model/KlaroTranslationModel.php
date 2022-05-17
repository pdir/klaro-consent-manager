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

namespace Pdir\ContaoKlaroConsentManager\Model;

use Contao\Model;
use Contao\StringUtil;

/**
 * Class KlaroTranslationModel.
 */
class KlaroTranslationModel extends Model
{
    protected static $strTable = 'tl_klaro_translation';

    /**
     * @return array
     */
    public function getPurposeTranslations()
    {
        $result = [];
        $arrPurposes = StringUtil::deserialize($this->purposes);
        array_walk($arrPurposes, static function ($purpose) use (&$result): void { $result[$purpose['key']] = $purpose['value']; });

        return $result;
    }

    /**
     * @return array
     */
    public function getServiceTranslations()
    {
        $result = [];
        $arrServices = StringUtil::deserialize($this->services);
        array_walk($arrServices, static function ($service) use (&$result): void { $result[$service['key']] = $service['value']; });

        return $result;
    }
}
