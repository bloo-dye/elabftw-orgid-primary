<?php

/**
 * @author    Nicolas CARPi <nico-git@deltablot.email>
 * @copyright 2012 Nicolas CARPi
 * @license   https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0
 * @see       https://www.elabftw.net Official website
 */

declare(strict_types=1);

namespace Elabftw\Exceptions;

use Exception;

/**
 * Throw this if the requested resource cannot be found
 * Should reply with status code 404
 */
final class ResourceNotFoundException extends ImproperActionException
{
    public function __construct(string $message = null, int $code = 404, Exception $previous = null)
    {
        if ($message === null) {
            $message = _('Nothing to show with this id');
        }
        parent::__construct($message, $code, $previous);
    }
}
