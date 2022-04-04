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
use Pdir\ContaoKlaroConsentManager\Model\KlaroPurposeModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class KlaroServiceListener
{
    private $request;

    private $session;

    private $logger;

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
     *     table="tl_klaro_service",
     *     target="fields.purposes.options"
     * )
     * builds the purposes options
     *
     * @return array
     */
    public function buildPurposesOptions(DataContainer $dc)
    {
        $options = [];

        $services = KlaroPurposeModel::findAll();

        if (null !== $services) {
            foreach ($services as $service) {
                $options[$service->id] = "$service->title";
            }
        }

        return $options;
    }
}
