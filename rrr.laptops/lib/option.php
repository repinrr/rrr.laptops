<?php

namespace Rrr\Laptops;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

Loc::loadMessages(__FILE__);

class OptionTable extends Entity\DataManager
{

    public static function getTableName()
    {
        return 'rrr_laptops_option';
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
                  ]
          ),
          (new ManyToMany(
            'LAPTOPS',
            LaptopTable::class
          ))
            ->configureTableName('rrr_laptops_laptop_option'),
        ];
    }

}