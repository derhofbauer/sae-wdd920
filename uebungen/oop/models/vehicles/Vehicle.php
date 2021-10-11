<?php

namespace Models\Vehicles;

use Interfaces\VehicleInterface;
use Traits\OwnerTrait;

class Vehicle implements VehicleInterface
{

    use OwnerTrait;

    private ?string $signal = null;
    protected int $velocity = 0;
    protected int $topVelocity = 160;

    public function __construct(
        public string $model,
        public string $brand,
        public string $numberplate,
        public int $numberOfWheels = 4,
        public int $numberOfDoors = 3,
        $topVelocity = 160
    ) {
        $this->topVelocity = $topVelocity;
    }

    public function accelerate(int $kmh)
    {
        if ($this->velocity + $kmh >= $this->topVelocity) {
            $this->velocity = $this->topVelocity;
        } else {
            $this->velocity = $this->velocity + $kmh;
        }
    }

    public function brake(int $kmh)
    {
        if ($this->velocity - $kmh <= 0) {
            $this->velocity = 0;
        } else {
            $this->velocity = $this->velocity - $kmh;
        }
    }

    public final function doSignal(string $leftOrRight): ?string
    {
        if ($leftOrRight === 'left' || $leftOrRight === 'right') {
            $this->signal = $leftOrRight;
        } else {
            $this->signal = null;
        }

        return $this->signal;
    }

    public function getVelocity(): int
    {
        return $this->velocity;
    }

}
