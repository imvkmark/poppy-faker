<?php

namespace Poppy\Faker\Provider\zh_TW;

class PhoneNumber extends \Poppy\Faker\Provider\PhoneNumber
{
    protected static array $formats = [
        '+8869########',
        '+886-9##-###-###',
        '09########',
        '09##-###-###',
        '(02)########',
        '(02)####-####',
        '(0#)#######',
        '(0#)###-####',
        '(0##)######',
        '(0##)###-###',
    ];
}
