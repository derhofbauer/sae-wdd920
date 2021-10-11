<?php

namespace Models\Vehicles;

class Bike extends Vehicle
{

    public function __construct(
        public string $model,
        public string $brand,
        public string $numberplate,
        public int $numberOfWheels = 2,
        public int $numberOfDoors = 0,
    ) {
        parent::__construct(
            $this->model,
            $this->brand,
            $this->numberplate,
            $this->numberOfWheels,
            $this->numberOfDoors
        );
    }

}
