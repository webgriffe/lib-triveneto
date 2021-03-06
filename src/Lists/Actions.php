<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 28/08/17
 * Time: 17.16
 */

namespace Webgriffe\LibTriveneto\Lists;

class Actions implements ValuesList
{
    const ACTION_PURCHASE = 1;
    const ACTION_AUTHORIZATION = 4;

    public function getList()
    {
        return [
            self::ACTION_PURCHASE => 'Purchase',
            self::ACTION_AUTHORIZATION => 'Authorization',
        ];
    }
}
