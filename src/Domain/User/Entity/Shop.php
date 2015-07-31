<?php

namespace UserApp\Domain\User\Entity;

class Shop
{
    protected $id;

    protected $organisationId;

    protected $url;

    protected $readinessWorkflowId;

    public function getId()
    {
        return $this->id;
    }

    public function getOrganisationId()
    {
        return $this->organisationId;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getReadinessWorkflowId()
    {
        return $this->readinessWorkflowId;
    }
}