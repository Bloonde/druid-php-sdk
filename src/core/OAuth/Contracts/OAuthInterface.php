<?php namespace Genetsis\core\OAuth\Contracts;

interface OAuthInterface {

    /**
     * Gets a "client_token" for the current web client.
     *
     * @param string $endpoint_url The endpoint where "client_token" is requested.
     * @return mixed An instance of {@link ClientToken} with data retrieved
     *     or FALSE.
     * @throws \Exception If there is an error.
     */
    public static function doGetClientToken ($endpoint_url);

    /**
     * Stores a token in a cookie
     *
     * @param StoredTokenInterface $token An object with token data to be stored.
     * @throws \Exception
     */
    public static function storeToken (StoredTokenInterface $token);

    /**
     * Gets an "access_token" for the current web client.
     *
     * @param string $endpoint_url The endpoint where "access_token" is requested.
     * @param string $code The authorization code returned by Genetsis ID.
     * @param string $redirect_url Where the user will be redirected.
     * @return mixed An instance of {@link AccessToken} with data retrieved
     *     or FALSE.
     * @throws \Exception If there is an error.
     */
    public static function doGetAccessToken ($endpoint_url, $code, $redirect_url);

    /**
     * Updates tokens.
     *
     * @param string $endpoint_url The endpoint where the request will be sent.
     * @return boolean TRUE if the tokens have been updated or FALSE
     *     otherwise.
     * @throws \Exception If there is an error.
     */
    public static function doRefreshToken ($endpoint_url);

    /**
     * Checks if user is logged.
     *
     * @param string $endpoint_url The endpoint where the request will be sent.
     * @return LoginStatus An object with user status.
     * @throws \Exception If there is an error.
     */
    public static function doValidateBearer ($endpoint_url);

    /**
     * Checks if user is logged by Exchange Session (SSO)
     *
     * @param string $endpoint_url The endpoint where the request will be sent.
     * @param string $cookie_value The content of the cookie that stores the SSO.
     * @return mixed An instance of {@link AccessToken} if its connected or
     *     NULL if not.
     * @throws \Exception If there is an error.
     */
    public static function doExchangeSession ($endpoint_url, $cookie_value);

    /**
     * Performs revocation process. Removes all tokens from that user.
     *
     * @param string $endpoint_url The endpoint where the request will be sent.
     * @return void
     * @throws \Exception If there is an error.
     */
    public static function doLogout ($endpoint_url);

    /**
     * Removes a specific token.
     *
     * It will removed from SESSION and COOKIE.
     *
     * @param string The token we want to remove. Are defined in {@link \Genetsis\core\OAuth\Collections\TokenTypes}
     * @return void
     */
    public static function deleteStoredToken ($name);


    /**
     * Checks if we have a specific token.
     *
     * @param string $name The token we want to check. Are defined in {@link \Genetsis\core\OAuth\Collections\TokenTypes}
     * @return bool TRUE if exists or FALSE otherwise.
     */
    public static function hasToken ($name);

    /**
     * Returns a specific stored token.
     * SESSION has more priority than COOKIE.
     *
     * @param string $name The token we want to recover. Are defined in {@link \Genetsis\core\OAuth\Collections\TokenTypes}
     * @return bool|AccessToken|ClientToken|RefreshToken|mixed|string An instance of {@link StoredToken} or FALSE if we
     *     can't recover it.
     * @throws \Exception
     */
    public static function getStoredToken ($name);

    /**
     * Get The Url for access to the Opinator.
     *
     * @param string $endpoint_url The endpoint where the request will be sent.
     * @param string $scope Section-key identifier of the web client propietary of Opinator
     * @param StoredTokenInterface $token Token
     * @return mixed $token Token, an access_token if user is logged, a client_token if user is not login
     * @throws \Exception If there is an error.
     */
    public static function doGetOpinator ($endpoint_url, $scope, StoredTokenInterface $token);

    /**
     * Checks if the user has completed all required data for the specified
     * section (scope).
     *
     * @param string $endpoint_url The endpoint where the request will be sent.
     * @param string $scope Section-key identifier of the web client. The
     *     section-key is located in "oauthconf.xml" file.
     * @return boolean TRUE if the user has completed all required data or
     *     FALSE if not.
     * @throws \Exception If there is an error.
     */
    public static function doCheckUserCompleted ($endpoint_url, $scope);

    /**
     * Checks if the user has accepted terms and conditions for the specified section (scope).
     *
     * @param string $endpoint_url The endpoint where the request will be sent.
     * @param string $scope Section-key identifier of the web client. The section-key is located in "oauthconf.xml" file.
     * @return boolean TRUE if the user need to accept the terms and conditions (not accepted yet) or
     *      FALSE if it has already accepted them (no action required).
     * @throws \Exception If there is an error.
     */
    public static function doCheckUserNeedAcceptTerms ($endpoint_url, $scope);
}