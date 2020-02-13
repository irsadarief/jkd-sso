# Badan Pusat Statistik SSO (Single Sign-On)
[![Latest Version](https://img.shields.io/github/release/stevenmaguire/oauth2-keycloak.svg?style=flat-square)](https://github.com/irsadarief/jkd-sso/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/stevenmaguire/oauth2-keycloak.svg?style=flat-square)](https://scrutinizer-ci.com/g/irsadarief/jkd-sso/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/stevenmaguire/oauth2-keycloak.svg?style=flat-square)](https://scrutinizer-ci.com/g/irsadarief/jkd-sso)
[![Total Downloads](https://img.shields.io/packagist/dt/stevenmaguire/oauth2-keycloak.svg?style=flat-square)](https://packagist.org/packages/irsadarief/jkd-sso)

## Instalasi

Untuk menginstall, gunakan composer:

```
composer require irsadarief/jkd-sso
```
## Penggunaan

Untuk menggunakan library ini bisa dengan `\IrsadArief\OAuth2\Client\Provider\Keycloak` sebagai provider.

Untuk `authServerUrl` Anda dapat menuliskan https://sso.bps.go.id .

untuk `realm` anda dapat menuliskan `pegawai-bps`

## Contoh Kode

```php
$provider = new Stevenmaguire\OAuth2\Client\Provider\Keycloak([
    'authServerUrl'         => '{keycloak-server-url}',
    'realm'                 => '{keycloak-realm}',
    'clientId'              => '{keycloak-client-id}',
    'clientSecret'          => '{keycloak-client-secret}',
    'redirectUri'           => 'https://example.com/callback-url',
    'encryptionAlgorithm'   => 'RS256',                             // optional
    'encryptionKeyPath'     => '../key.pem'                         // optional
    'encryptionKey'         => 'contents_of_key_or_certificate'     // optional
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state, make sure HTTP sessions are enabled.');

} else {

    // Try to get an access token (using the authorization coe grant)
    try {
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
    } catch (Exception $e) {
        exit('Failed to get access token: '.$e->getMessage());
    }

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getName());

    } catch (Exception $e) {
        exit('Failed to get resource owner: '.$e->getMessage());
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

## Memperbarui Token

```php
$provider = new Stevenmaguire\OAuth2\Client\Provider\Keycloak([
    'authServerUrl'     => '{keycloak-server-url}',
    'realm'             => '{keycloak-realm}',
    'clientId'          => '{keycloak-client-id}',
    'clientSecret'      => '{keycloak-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

$token = $provider->getAccessToken('refresh_token', ['refresh_token' => $token->getRefreshToken()]);
```

