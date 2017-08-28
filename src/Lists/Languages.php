<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 28/08/17
 * Time: 17.08
 */

namespace Webgriffe\LibTriveneto\Lists;

class Languages implements ValuesList
{
    const ITA_LANGUAGE_CODE = 'ITA';
    const USA_LANGUAGE_CODE = 'USA';
    const FRA_LANGUAGE_CODE = 'FRA';
    const DEU_LANGUAGE_CODE = 'DEU';
    const ESP_LANGUAGE_CODE = 'ESP';
    const SLO_LANGUAGE_CODE = 'SLO';
    const SRB_LANGUAGE_CODE = 'SRB';
    const POR_LANGUAGE_CODE = 'POR';
    const RUS_LANGUAGE_CODE = 'RUS';

    public function getList()
    {
        return array(
            self::ITA_LANGUAGE_CODE,
            self::USA_LANGUAGE_CODE,
            self::FRA_LANGUAGE_CODE,
            self::DEU_LANGUAGE_CODE,
            self::ESP_LANGUAGE_CODE,
            self::SLO_LANGUAGE_CODE,
            self::SRB_LANGUAGE_CODE,
            self::POR_LANGUAGE_CODE,
            self::RUS_LANGUAGE_CODE,
        );
    }
}
