<?php

namespace Traits;

trait OwnerTrait {

    private ?string $owner;

    public final function setOwner(string $owner)
    {
        $this->owner = $owner;
    }

    public final function getOwner(): ?string
    {
        return $this->owner;
    }

}
