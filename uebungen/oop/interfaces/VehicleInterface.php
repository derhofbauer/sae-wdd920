<?php

namespace Interfaces;

interface VehicleInterface
{

    public function accelerate(int $kmh);

    public function brake(int $kmh);

    public function doSignal(string $leftOrRight): ?string;

}
