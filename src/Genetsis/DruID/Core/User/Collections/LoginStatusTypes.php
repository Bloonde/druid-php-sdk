<?php
namespace Genetsis\DruID\Core\User\Collections;

use Genetsis\DruID\Core\Utils\Contracts\CollectionInterface;

/**
 * Class to group all login status types.
 *
 * @author Genetsis
 * @link http://developers.dru-id.com
 */
class LoginStatusTypes implements CollectionInterface
{

    const CONNECTED = 'connected';
    const NOT_CONNECTED = 'notConnected';
    const UNKNOWN = 'unknown';

    /**
     * {@inheritDoc}
     */
    public static function check($value)
    {
        return ($value && in_array($value, [self::CONNECTED, self::NOT_CONNECTED, self::UNKNOWN]));
    }
}
