<?php

namespace JKD\SSO\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class KeycloakResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->response['sub'] ?: null;
    }

    public function getEmail()
    {
        return $this->response['username']."@bps.go.id" ?: null;
    }

    public function getName()
    {
        return $this->response['name'] ?: null;
    }

    public function getNip()
    {
        return $this->response['nip-lama'] ?: null;
    }

    public function getUsername()
    {
        return $this->response['username'] ?: null;
    }

    public function getnamaDepan()
    {
        return $this->response['given_name'] ?: null;
    }

    public function getNamaBelakang()
    {
        return $this->response['family_name'] ?: null;
    }
    public function getProvinsi()
    {
        return $this->response['provinsi'] ?: null;
    }
    public function getKodeOrganisasi()
    {
        return $this->response['organisasi'] ?: null;
    }
    public function getKodeProvinsi()
    {
        return substr($this->response['organisasi'],0,2) ?: null;
    }
    public function getKodeKabupaten()
    {
        return substr($this->response['organisasi'],2,2) ?: null;
    }
    public function getAlamatKantor()
    {
        return $this->response['alamat-kantor'] ?: null;
    }
    public function getJabatan()
    {
        return $this->response['jabatan'] ?: null;
    }
    public function getGolongan()
    {
        return $this->response['golongan'] ?: null;
    }
    public function getKabupaten()
    {
        return $this->response['kabupaten'] ?: null;
    }
    public function getNipBaru()
    {
        return $this->response['nip'] ?: null;
    }
    public function getEselon()
    {
        return $this->response['eselon'] ?: null;
    }
    public function getUrlFoto()
    {
        return $this->response['foto'] ?: null;
    }
    public function toArray()
    {
        return $this->response;
    }
}
