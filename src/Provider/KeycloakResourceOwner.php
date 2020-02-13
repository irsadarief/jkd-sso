<?php

namespace IrsadArief\OAuth2\Client\Provider;

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
        return $this->response['preferred_username']."@bps.go.id" ?: null;
    }

    public function getName()
    {
        return $this->response['name'] ?: null;
    }

    public function getNip()
    {
        return $this->response['nip'] ?: null;
    }

    public function getUsername()
    {
        return $this->response['preferred_username'] ?: null;
    }

    public function getnamaDepan()
    {
        return $this->response['given_name'] ?: null;
    }

    public function getNamaBelakang()
    {
        return $this->response['family_name'] ?: null;
    }
    public function toArray()
    {
        return $this->response;
    }
}
