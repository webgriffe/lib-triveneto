<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 28/08/17
 * Time: 17.14
 */

namespace Webgriffe\LibTriveneto\Lists;

class Currencies implements ValuesList
{
    const EUR_CURRENCY_CODE = 978;

    public function getList()
    {
        return [self::EUR_CURRENCY_CODE => 'Euro'];
    }
}