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

namespace Pdir\ContaoKlaroConsentManager\Tests;

use Pdir\ContaoKlaroConsentManager\DependencyInjection\PdirContaoKlaroConsentManagerExtension;
use Pdir\Pdir\ContaoKlaroConsentManager\PdirContaoKlaroConsentManager;
use PHPUnit\Framework\TestCase;

class PdirContaoKlaroConsentManagerTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new PdirContaoKlaroConsentManager();
        $this->assertInstanceOf(PdirContaoKlaroConsentManager::class, $bundle);
    }

    public function testGetContainerExtension(): void
    {
        $bundle = new PdirContaoKlaroConsentManager();
        $this->assertInstanceOf(PdirContaoKlaroConsentManagerExtension::class, $bundle->getContainerExtension());
    }
}
