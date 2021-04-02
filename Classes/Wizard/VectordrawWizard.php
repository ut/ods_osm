<?php
declare(strict_types = 1);

namespace Bobosch\OdsOsm\Wizard;

/**
 * This file is part of the "ods_osm" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Localization\LanguageService;

/**
 * Adds a wizard for drawing vectors on a map
 */
class VectordrawWizard extends AbstractNode
{
    /**
     * @return array
     */
    public function render(): array
    {
        $row = $this->data['databaseRow'];
        $paramArray = $this->data['parameterArray'];
        $resultArray = $this->initializeResultArray();

        $nameDataField = $paramArray['itemFormElName'];

        // calculate center point or use Kopenhagen as fallback
        if (!empty((float)$row['max_lon']) && !empty((float)$row['min_lon'])) {
            $lon = ($row['max_lon'] + $row['min_lon']) / 2;
        } else {
            $lon = '12.5683371';
        }

        if (!empty((float)$row['max_lat']) && !empty((float)$row['min_lat'])) {
            $lat = ($row['max_lat'] + $row['min_lat']) / 2;
        } else {
            $lat = '55.6760968';
        }


        $resultArray['iconIdentifier'] = 'vectordraw-wizard';
        $resultArray['title'] = $this->getLanguageService()->sL('LLL:EXT:ods_osm/Resources/Private/Language/locallang_db.xlf:vectordrawWizard.draw');
        $resultArray['linkAttributes']['class'] = 'vectordrawWizard ';
        $resultArray['linkAttributes']['data-label-title'] = $this->getLanguageService()->sL('LLL:EXT:ods_osm/Resources/Private/Language/locallang_db.xlf:vectordrawWizard.draw');
        $resultArray['linkAttributes']['data-label-close'] = $this->getLanguageService()->sL('LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address.locationMapWizard.close');
        $resultArray['linkAttributes']['data-label-import'] = $this->getLanguageService()->sL('LLL:EXT:tt_address/Resources/Private/Language/locallang_db.xlf:tt_address.locationMapWizard.import');
        $resultArray['linkAttributes']['data-minlat'] = empty((float)$row['min_lat']) ? null : $row['min_lat'];
        $resultArray['linkAttributes']['data-maxlat'] = empty((float)$row['max_lat']) ? null : $row['max_lat'];
        $resultArray['linkAttributes']['data-minlon'] = empty((float)$row['min_lon']) ? null : $row['min_lon'];
        $resultArray['linkAttributes']['data-maxlon'] = empty((float)$row['max_lon']) ? null : $row['max_lon'];
        $resultArray['linkAttributes']['data-lat'] = $lat;
        $resultArray['linkAttributes']['data-lon'] = $lon;
        $resultArray['linkAttributes']['data-fieldName'] = htmlspecialchars($nameDataField);
        $resultArray['linkAttributes']['data-fieldValue'] = $row['data'];
        $resultArray['linkAttributes']['data-tiles'] = htmlspecialchars('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        $resultArray['linkAttributes']['data-copy'] = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
        $resultArray['stylesheetFiles'][] = 'EXT:ods_osm/Resources/Public/JavaScript/Leaflet/leaflet-draw/leaflet.draw.css';
        $resultArray['stylesheetFiles'][] = 'EXT:ods_osm/Resources/Public/JavaScript/Leaflet/Core/leaflet.css';
        $resultArray['stylesheetFiles'][] = 'EXT:ods_osm/Resources/Public/Css/Backend/drawvectorWizard.css';
        $resultArray['requireJsModules'][] = 'TYPO3/CMS/OdsOsm/Leaflet/Core/leaflet';
        $resultArray['requireJsModules'][] = 'TYPO3/CMS/OdsOsm/Backend/Vectordraw';

        return $resultArray;
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
