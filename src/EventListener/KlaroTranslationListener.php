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

use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Contao\Message;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Pdir\ContaoKlaroConsentManager\Model\KlaroPurposeModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroServiceModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroTranslationModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class KlaroTranslationListener
{

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @Callback(
     *     table="tl_klaro_translation",
     *     target="fields.purposes.load"
     * )
     */
    public function purposesLoad($value, DataContainer $dc)
    {
        //
        $arrStoredPurposes = StringUtil::deserialize($value ?? []);
        $availablePurposes = KlaroPurposeModel::findAll();
        $lang = $dc->activeRecord->lang_code;
        $buffer = [];

        if (null !== $availablePurposes)
        {
            foreach ($availablePurposes as $ap)
            {
                // are some purposes already saved?
                $sp = $this->isInPurposes($ap->klaro_key, $arrStoredPurposes);

                // the purpose key is already stored
                if(\count($sp) > 0)
                {
                    // fill the buffer with the stored values
                    $buffer[] = [
                        'key' => $ap->klaro_key,
                        'translation' => empty($sp['translation']) ? "translation $lang missing" : $sp['translation'],
                        'description' => empty($sp['description']) ? "description $lang missing" : $sp['description'],
                    ];
                } else
                {
                    // fill the buffer only with the available keys
                    $buffer[] = [
                        'key' => $ap->klaro_key,
                        'translation' => "translation $lang missing",
                        'description' => "description $lang missing",
                    ];
                }
            }
            // rebuild the value from the buffer
            $value = serialize($buffer);
        } else {
            // there are no purposes defined yet
            $GLOBALS['TL_DCA']['tl_klaro_translation']['fields']['purposes']['eval']['disabled'] = true;
            Message::addError($GLOBALS['TL_LANG']['tl_klaro_translation']['purposes_empty']);
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
        // tolerant treatment of missing parameters
        if (null === $purposeModel = KlaroPurposeModel::findAll()) {
            return $value;
        }
        // check purpose keys
        $availablePurposes = $purposeModel->fetchEach('klaro_key');
        $savedPurposesValues = array_map(static fn ($value) => $value['key'], StringUtil::deserialize($value ?? []));
        $arrDifferences = array_diff($savedPurposesValues, $availablePurposes);

        if (0 !== \count($arrDifferences)) {
            $strMsg = $GLOBALS['TL_LANG']['tl_klaro_translation']['purposesSaveError'];
            $arrPns = $GLOBALS['TL_LANG']['tl_klaro_translation']['purposesSavePronouns'];
            $strDifferences = implode(', ', $arrDifferences);
            $strPurposes = implode(', ', $availablePurposes);
            [$a,$b] = 1 === \count($arrDifferences) ? $arrPns['sgl'] : $arrPns['pl'];

            Message::addError(sprintf($strMsg, $a, $strDifferences, $b, $strPurposes));

            throw new \Exception();
        } else {
            $this->connection->update($dc->table, ['purposes' => $value], ['id' => $dc->id]);
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
        //
        $arrStoredServices = StringUtil::deserialize($value ?? []);
        $availableServices = KlaroServiceModel::findAll();
        $lang = $dc->activeRecord->lang_code;
        $buffer = [];

        if (null !== $availableServices)
        {
            foreach ($availableServices as $as)
            {
                // is the currend purpose already saved?
                $sp = $this->isInServices($as->name, $arrStoredServices);
                // the purpose key is already stored
                if(\count($sp) > 0)
                {
                    // fill the buffer with the stored values
                    $buffer[] = [
                        'key' => $as->name,
                        'translation' => empty($sp['translation']) ? "translation $lang missing" : $sp['translation'],
                        'description' => empty($sp['description']) ? "description $lang missing" : $sp['description'],
                    ];
                } else
                {
                    // fill the buffer only with the available keys
                    $buffer[] = [
                        'key' => $as->name,
                        'translation' => "translation $lang missing",
                        'description' => "description $lang missing",
                    ];
                }
            }
            // rebuild the value from the buffer
            $value = serialize($buffer);
        } else {
            // there are no purposes defined yet
            $GLOBALS['TL_DCA']['tl_klaro_translation']['fields']['services']['eval']['disabled'] = true;
            Message::addError($GLOBALS['TL_LANG']['tl_klaro_translation']['services_empty']);
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
        // tolerant treatment of missing parameters
        if (null === $serviceModel = KlaroServiceModel::findAll()) {
            return $value;
        }

        $availableServices = $serviceModel->fetchEach('name');
        $savedServicesValues = array_map(static fn ($value) => $value['key'], StringUtil::deserialize($value ?? []));
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

    /**
     * /**
     * @Callback(
     *     table="tl_klaro_translation",
     *     target="fields.ccMonitor.input_field"
     * )
     */
    public function ccMonitorInputField(DataContainer $dc)
    {
        [$label, $tip] = $GLOBALS['TL_LANG']['tl_klaro_translation']['ccMonitor'];

        return <<< HTML
            <div class="clr widget">
                <h3>
                    <label for="ctrl_ccAcceptAlways">$label</label>
                </h3>
                <div data-type="placeholder">
                    <div class="klaro cm-as-context-notice" lang="de" >
                        <div class="context-notice" >
                            <p id="ccmQuestion">Translation?</p>
                            <p class="cm-buttons">
                                <button id="ccmButtonOnce" class="cm-btn cm-btn-success" type="button">Ja</button>
                                <button id="ccmButtonAlways" class="cm-btn cm-btn-success-var" type="button">Immer</button>
                            </p>
                        </div>
                    </div>
                </div>
                <p class="tl_help tl_tip" title="">$tip</p>
            </div>
            HTML;
    }

    /**
     * transforms the result of the key-value-wizzard from
     *
     *      [
     *          0 => [key1 => value],
     *          1 => [key2 => value],
     *          n => [key3 => value],
     *      ]
     * to
     *      [key1 => value, key2 => value, keyn => value]
     *
     * the keys must be unique!
     *
     * @param $arr
     * @return array
     */
    private function flatten($arr):array
    {
        $buffer = [];

        foreach($arr as $i => $data) { $buffer[$data['key']] = $data['value']; }

        return $buffer;
    }

    private function isInPurposes($value, array $purposes): array
    {
        $result = [];

        if(count($purposes) > 0 )
        {
            foreach ($purposes as $i => $data)
            {
                #"{$data['key']} === $value"
                if($data['key'] === $value) {
                    return $data;
                }
            }
        }
        return $result;
    }

    private function isInServices($value, array $services): array
    {
        $result = [];

        if(count($services) > 0 )
        {
            foreach ($services as $i => $data)
            {
                if($data['key'] === $value) {
                    return $data;
                }
            }
        }
        return $result;
    }
}
