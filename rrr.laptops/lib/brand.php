<?php

namespace Rrr\Laptops;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;


Loc::loadMessages(__FILE__);

class BrandTable extends Entity\DataManager
{

    public static function getTableName()
    {
        return 'rrr_laptops_brand';
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
          (new OneToMany(
            'MODELS', ModelTable::class, 'MODEL'
          ))->configureJoinType('left'),
        ];
    }

}