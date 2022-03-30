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

namespace Pdir\ContaoKlaroConsentManager\EventListener;

use Contao\BackendUser;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Pdir\ContaoKlaroConsentManager\Model\KlaroServiceModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class KlaroConfigListener
{
    private ?Request $request = null;

    private ?SessionInterface $session = null;

    private ?LoggerInterface $logger = null;

    public function __construct(RequestStack $requestStack, SessionInterface $session, LoggerInterface $logger)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $session;
        $this->user = BackendUser::getInstance();
        $this->logger = $logger;

        // handle session bag
        $this->beBag = $this->session->getBag('contao_backend');
    }

    /**
     * @Callback(
     *     table="tl_klaro_config",
     *     target="fields.services.options"
     * )
     * builds the service options
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
