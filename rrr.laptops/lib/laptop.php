<?php

namespace Rrr\Laptops;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

class LaptopTable extends Entity\DataManager
{

    public static function getTableName()
    {
        return 'rrr_laptops_laptop';
    }

    public static function getMap()
    {
        return [
          new Entity\IntegerField(
            'ID', [
                  'primary'      => true,
                  'autocomplete' => true,
                ]
          ),
          new Entity\StringField(
            'NAME', [
            'required'   => true,
            'validation' => function () {
                return [
                  new Entity\Validator\Length(null, 255),
                ];
            },
          ],
          ),
          new Entity\StringField(
            'CODE', [
            'required'   => true,
            'unique'     => true,
            'validation' => function () {
                return [
                  new Entity\Validator\Length(null, 255),
                ];
            },
          ],
          ),
          new Entity\IntegerField(
            'YEAR', [
                    'required'   => true,
                    'validation' => function () {
                        return [
                          new Entity\Validator\RegExp('/[\d]{4}/'),
                        ];
                    },
                  ]
          ),
          new Entity\IntegerField(
            'PRICE', [
                     'required'   => true,
                     'validation' => function () {
                         return [
                           new Entity\Validator\RegExp('/[\d]{1,30}/'),
                         ];
                     },
                   ]
          ),
          new Entity\IntegerField(
            'MODEL_ID', [
                        'required'   => true,
                        'validation' => function () {
                            return [
                              new Entity\Validator\RegExp('/[\d]{1,11}/'),
                            ];
                        },
                      ]
          ),
          (new Reference(
            'MODEL',
            ModelTable::class,
            Join::on('this.MODEL_ID', 'ref.ID')
          ))->configureJoinType('left'),

          (new ManyToMany(
            'OPTIONS',
            OptionTable::class
          ))->configureTableName('rrr_laptops_laptop_option'),
        ];
    }

}