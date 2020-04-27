# Badan Pusat Statistik SSO (Single Sign-On)
[![Latest Version](https://img.shields.io/github/release/irsadarief/jkd-sso.svg?style=flat-square)](https://github.com/irsadarief/jkd-sso/releases)
[![Software License](https://img.shields.io/github/license/irsadarief/jkd-sso?style=flat-square)](LICENSE.md)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/irsadarief/jkd-sso.svg?style=flat-square)](https://scrutinizer-ci.com/g/irsadarief/jkd-sso/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/irsadarief/jkd-sso.svg?style=flat-square)](https://scrutinizer-ci.com/g/irsadarief/jkd-sso)
[![Total Downloads](https://img.shields.io/packagist/dt/irsadarief/jkd-sso.svg?style=flat-square)](https://packagist.org/packages/irsadarief/jkd-sso)

## Instalasi

Untuk menginstall, anda dapat menggunakan composer:

```
composer require irsadarief/jkd-sso
```
Untuk yang belum menginstall composer, informasi mengenai instalasi dan penggunaan composer dapat diakses [disini](https://github.com/composer/composer).

## Penggunaan

Untuk menggunakan library ini bisa dengan `\JKD\SSO\Client\Provider\Keycloak` sebagai provider.

Untuk `authServerUrl` Anda dapat menuliskan https://sso.bps.go.id .

untuk `realm` anda dapat menuliskan `pegawai-bps`


## Contoh Kode

```php
$provider = new JKD\SSO\Client\Provider\Keycloak([
    'authServerUrl'         => 'https://sso.bps.go.id',
    'realm'                 => 'pegawai-bps',
    'clientId'              => '{client-id}',
    'clientSecret'          => '{client-secret}',
    'redirectUri'           => 'https://example.com/callback-url'
]);

if (!isset($_GET['code'])) {

    // Untuk mendapatkan authorization code
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Mengecek state yang disimpan saat ini untuk memitigasi serangan CSRF
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    try {
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
    } catch (Exception $e) {
        exit('Gagal mendapatkan akses token : '.$e->getMessage());
    }

    // Opsional: Setelah mendapatkan token, anda dapat melihat data profil pengguna
    try {

        $user = $provider->getResourceOwner($token);
            echo "Nama : ".$user->getName();
            echo "E-Mail : ". $user->getEmail();
            echo "Username : ". $user->getUsername();
            echo "NIP : ". $user->getNip();
            echo "NIP Baru : ". $user->getNipBaru();
            echo "Kode Organisasi : ". $user->getKodeOrganisasi();
            echo "Kode Provinsi : ". $user->getKodeProvinsi();
            echo "Kode Kabupaten : ". $user->getKodeKabupaten();
            echo "Alamat Kantor : ". $user->getAlamatKantor();
            echo "Provinsi : ". $user->getProvinsi();
            echo "Kabupaten : ". $user->getKabupaten();
            echo "Golongan : ". $user->getGolongan();
            echo "Jabatan : ". $user->getJabatan();
            echo "Eselon : ". $user->getEselon();

    } catch (Exception $e) {
        exit('Gagal Mendapatkan Data Pengguna: '.$e->getMessage());
    }

    // Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
    echo $token->getToken();
}
```
Penggunaan API untuk mengakses data pegawai dapat melihat pada [api-pegawai](https://git.bps.go.id/jkd-repo/api-pegawai).

## Mendapatkan link Logout
```php
$url_logout = $provider->getLogoutUrl()
```


## Memperbarui Token

```php
$provider = new JKD\SSO\Client\Provider\Keycloak([
    'authServerUrl'         => 'https://sso.bps.go.id',
    'realm'                 => 'pegawai-bps',
    'clientId'              => '{keycloak-client-id}',
    'clientSecret'          => '{keycloak-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

$token = $provider->getAccessToken('refresh_token', ['refresh_token' => $token->getRefreshToken()]);
```

