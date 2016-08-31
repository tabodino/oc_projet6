<?php

namespace OC\CoreBundle\Twig;


class CountryExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('country', array($this, 'countryFilter')),
        );
    }

    public function countryFilter($codeCountry)
    {

        switch ($codeCountry) {
            case "fr":
                return "France";
            case "gf":
                return "Guyanne-Francaise";
            case "mar":
                return "Martinique";
            case "gua":
                return "Guadeloupe";
            case "sm":
                return "Saint-Martin";
            case "sb":
                return "Saint-Berthélemy";
            case "spm":
                return "Saint-Pierre-et-Miquelon";
            case "may":
                return "Mayotte";
            case "reu":
                return "La Réunion";
            case "taaf":
                return "Terres Australes et Antarctiques Francaises";
            case "nc":
                return "Nouvelle-Calédonie";
            case "wf":
                return "Wallis-et-Futuna";
            case "pf":
                return "Polynésie Francaise";
            case "cli":
                return "Clipperton";
            default:
                return "France";
        }

    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'country_extension';
    }
}