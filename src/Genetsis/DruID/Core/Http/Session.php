<?php
namespace Genetsis\DruID\Core\Http;

use Genetsis\DruID\Core\Http\Contracts\SessionServiceInterface;

/**
 * Session handler implementation.
 *
 * @author Genetsis
 * @link http://developers.dru-id.com
 */
class Session implements SessionServiceInterface {

    /**
     * {@inheritDoc}
     */
    public function set($key, $data)
    {
        if (!$key || !isset($_SESSION) || !is_array($_SESSION)) {
            return false;
        }
        $_SESSION[$key] = $data;
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        return ($this->has($key) ? $_SESSION[$key] : $default);
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return (isset($_SESSION) && is_array($_SESSION)) ? $_SESSION : [];
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return ($key && isset($_SESSION) && is_array($_SESSION) && array_key_exists($key, $_SESSION));
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key)
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
        return $this->has($key);
    }

}