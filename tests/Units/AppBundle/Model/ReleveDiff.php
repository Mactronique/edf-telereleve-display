<?php

namespace Tests\Units\AppBundle\Model;

use atoum;

class ReleveDiff extends atoum
{
    public function testEmptyArray()
    {
        $this->given($objT = \AppBundle\Model\ReleveDiff::from([], []))
            ->then
            ->error(function () use ($objT) {
                $objT->hcDiff();
            })->withPattern('/[.*]index[.*]$')
        ;
    }

    protected function testWithDatasDataProvider()
    {
        return [[
            ['hchc'=> 10.5,'hchp'=> 0.0, 'base'=> 0.0],
            ['hchc'=> 13.60, 'hchp'=> 0.0, 'base'=> 0.0],
            ['hc'=> 3.10, 'hp'=> 0.0, 'base'=> 0.0]
        ]];
    }


    public function testWithDatas(array $left, array $right, array $result)
    {

        $this->given($objT = \AppBundle\Model\ReleveDiff::from($left, $right))
            ->then
            ->float($objT->hcDiff())->isNearlyEqualTo($result['hc'])
            ->float($objT->hpDiff())->isNearlyEqualTo($result['hp'])
        ;
    }
}
