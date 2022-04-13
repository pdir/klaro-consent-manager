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
        dump("value: $value");
        $storedPurposes = StringUtil::deserialize($value ?? []);
        dump(\count($storedPurposes));
        $availablePurposes = KlaroPurposeModel::findAll();

        $arr = [];

        if (0 === \count($storedPurposes)) {
            dump('init');

            foreach ($availablePurposes as $i => $ap) {
                $arr[$i] = ['key' => $ap->klaro_key, 'value' => '?'];
            }
            $value = serialize($arr);
        } else {
            dump('schon Daten vorhanden');
        }

        /*
                $r = array_map(function($value) { return $value['key']; }, $storedPurposes);

        dump($r);

                foreach ($availablePurposes as $ap)
                {
        dump("in_array($ap->klaro_key, [". implode(',', $r) ."])");
                    if($ap->klaro_key === $r['key']) {
        dump("found $ap->id $ap->klaro_key  $ap->title");
                        $b[] = ['key' => $storedPurposes['key'], 'value' => $storedPurposes['value']];
                    } else {
                        $b[] = ['key' => $ap->klaro_key, 'value' => ''];
                    }
                }
        */
        dump("return $value");

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
            $strDifferences = implode(', ', $arrDifferences);
            $strPurposes = implode(', ', $availablePurposes);
            Message::addError("Die Übersetzungsschlüssel $strDifferences sind unbekannt. Sie können nur folgende Schlüssel übersetzen: $strPurposes.");

            throw new \InvalidArgumentException('Es befindet sich ein fehlerhafter Schlüssel in der Liste!');
        }

        return $value;
    }
}
