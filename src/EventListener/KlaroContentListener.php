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
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class KlaroContentListener
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
        // get all defined purposes
        $services = KlaroServiceModel::findAll();

        if (null !== $services) {
            foreach ($services as $service) {
                $options[$service->id] =
                    null === $arrServiceTranslation[$service->name] ||
                    '' === $arrServiceTranslation[$service->name] ||
                    '?' === $arrServiceTranslation[$service->name] ?
                    "[$service->name] translation missing" :
                    $arrServiceTranslation[$service->name];
            }
        }

        return $options;
    }
}
