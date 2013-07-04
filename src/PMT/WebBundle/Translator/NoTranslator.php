<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\WebBundle\Translator;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class NoTranslator is only used for testing.
 */
class NoTranslator implements TranslatorInterface
{
    public function trans($id, array $parameters = array(),
        $domain = null, $locale = null)
    {
        return $id;
    }

    public function transChoice($id, $number, array $parameters = array(),
        $domain = null, $locale = null)
    {
        return $id;
    }

    public function setLocale($locale)
    {
    }

    public function getLocale()
    {
        return '--';
    }

    public function setFallbackLocales($locale)
    {
    }

    public function addResource($resource)
    {
    }
}
