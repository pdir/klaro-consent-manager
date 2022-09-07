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

use Contao\DataContainer;
use Pdir\ContaoKlaroConsentManager\Model\KlaroServiceModel;

class KlaroConfigListener
{
    /**
     * Callback(
     *     table="tl_klaro_config",
     *     target="fields.services.options"
     * )
     * builds the service options.
     *
     * @return array
     */
    public function buildServicesOptions(DataContainer $dc)
    {
        $options = [];

        $services = KlaroServiceModel::findAll();

        if (null !== $services) {
            foreach ($services as $service) {
                $options[$service->id] = "$service->title";
            }
        }

        return $options;
    }
}
