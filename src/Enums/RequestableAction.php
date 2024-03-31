<?php declare(strict_types=1);
/**
 * @author Nicolas CARPi <nico-git@deltablot.email>
 * @copyright 2024 Nicolas CARPi
 * @see https://www.elabftw.net Official website
 * @license AGPL-3.0
 * @package elabftw
 */

namespace Elabftw\Enums;

enum RequestableAction: int
{
    case Archive = 10;
    case Lock = 20;
    case Sign = 40;
    case Timestamp = 50;

    public static function getAssociativeArray(): array
    {
        $all = array();
        foreach (self::cases() as $case) {
            $all[$case->value] = _($case->name);
        }
        return $all;
    }
}
