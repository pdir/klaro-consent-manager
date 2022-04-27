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
use Contao\Message;
use Contao\StringUtil;
use Pdir\ContaoKlaroConsentManager\Model\KlaroPurposeModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroServiceModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class KlaroTranslationListener
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
     *     table="tl_klaro_translation",
     *     target="fields.purposes.load"
     * )
     */
    public function purposesLoad($value, DataContainer $dc)
    {
        $storedPurposes = StringUtil::deserialize($value ?? []);
        $availablePurposes = KlaroPurposeModel::findAll();

        $arr = [];

        if (0 === \count($storedPurposes)) {
            foreach ($availablePurposes as $i => $ap) {
                $arr[$i] = ['key' => $ap->klaro_key, 'value' => '?'];
            }
            $value = serialize($arr);
        }

        return $value;
    }

    /**
     * @Callback(
     *     table="tl_klaro_translation",
     *     target="fields.purposes.save"
     * )
     * checks if all available purpose keys are specified,
     * invalid keys are not stored, if an invalid key is present
     * an exception is thrown
     */
    public function purposesSave($value, DataContainer $dc)
    {
        $savedPurposes = StringUtil::deserialize($value ?? []);
        $availablePurposes = KlaroPurposeModel::findAll()->fetchEach('klaro_key');
        $savedPurposesValues = array_map(static function ($value) { return $value['key']; }, $savedPurposes);
        $arrDifferences = array_diff($savedPurposesValues, $availablePurposes);

        if (0 !== \count($arrDifferences)) {
            $strMsg = $GLOBALS['TL_LANG']['tl_klaro_translation']['purposesSaveError'];
            $arrPns = $GLOBALS['TL_LANG']['tl_klaro_translation']['purposesSavePronouns'];
            $strDifferences = implode(', ', $arrDifferences);
            $strPurposes = implode(', ', $availablePurposes);
            [$a,$b] = 1 === \count($arrDifferences) ? $arrPns['sgl'] : $arrPns['pl'];

            Message::addError(sprintf($strMsg, $a, $strDifferences, $b, $strPurposes));

            throw new \Exception();
        }

        return $value;
    }

    /**
     * @Callback(
     *     table="tl_klaro_translation",
     *     target="fields.services.load"
     * )
     */
    public function servicesLoad($value, DataContainer $dc)
    {
        $storedServices = StringUtil::deserialize($value ?? []);
        $availableServices = KlaroServiceModel::findAll();

        $arr = [];

        if (0 === \count($storedServices)) {
            foreach ($availableServices as $i => $as) {
                $arr[$i] = ['key' => $as->name, 'value' => '?'];
            }
            $value = serialize($arr);
        }

        return $value;
    }

    /**
     * @Callback(
     *     table="tl_klaro_translation",
     *     target="fields.services.save"
     * )
     * checks whether all available services keys are specified,
     * invalid keys are not stored, if an invalid key is present
     * an exception is thrown
     */
    public function servicesSave($value, DataContainer $dc)
    {
        $savedServices = StringUtil::deserialize($value ?? []);
        $availableServices = KlaroServiceModel::findAll()->fetchEach('name');
        $savedServicesValues = array_map(static function ($value) { return $value['key']; }, $savedServices);
        $arrDifferences = array_diff($savedServicesValues, $availableServices);

        if (0 !== \count($arrDifferences)) {
            $strMsg = $GLOBALS['TL_LANG']['tl_klaro_translation']['servicesSaveError'];
            $arrPns = $GLOBALS['TL_LANG']['tl_klaro_translation']['servicesSavePronouns'];
            $strDifferences = implode(', ', $arrDifferences);
            $strServices = implode(', ', $availableServices);
            [$a,$b] = 1 === \count($arrDifferences) ? $arrPns['sgl'] : $arrPns['pl'];

            Message::addError(sprintf($strMsg, $a, $strDifferences, $b, $strServices));

            throw new \Exception();
        }

        return $value;
    }
}
