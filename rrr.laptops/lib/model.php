<?php

namespace Rrr\Laptops;


use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;


Loc::loadMessages(__FILE__);

class ModelTable extends Entity\DataManager
{

    public static function getTableName()
    {
        return 'rrr_laptops_model';
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
            'BRAND_ID', [
                        'required'   => true,
                        'validation' => function () {
                            return [
                              new Entity\Validator\RegExp('/[\d]{1,11}/'),
                            ];
                        },
                      ]
          ),
          (new Reference(
            'BRAND',
            BrandTable::class,
            Join::on('this.BRAND_ID', 'ref.ID')
          ))->configureJoinType('left'),

          (new OneToMany(
            'LAPTOPS', LaptopTable::class, 'MODEL'
          ))->configureJoinType('left'),

        ];
    }

}