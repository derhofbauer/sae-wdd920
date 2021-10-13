<?php

namespace Models\Vehicles;

class Bike extends Vehicle
{
    public string $model;
    public string $brand;
    public string $numberplate;
    public int $numberOfWheels = 2;
    public int $numberOfDoors = 0;

    public function __construct(
        $model,
        $brand,
        $numberplate,
        $numberOfWheels = 2,
        $numberOfDoors = 0,
        $topVelocity = 220
    ) {
        $this->model = $model;
        $this->brand = $brand;
        $this->numberplate = $numberplate;
        $this->numberOfWheels = $numberOfWheels;
        $this->numberOfDoors = $numberOfDoors;

        parent::__construct(
            $this->model,
            $this->brand,
            $this->numberplate,
            $this->numberOfWheels,
            $this->numberOfDoors,
            $topVelocity
        );
    }

}
