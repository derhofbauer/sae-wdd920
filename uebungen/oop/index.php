<?php
/**
 * @todo: comment everything
 */

//require_once 'interfaces/VehicleInterface.php';
//require_once 'models/Vehicle.php';
//require_once 'models/Car.php';

spl_autoload_register(function ($namespaceAndClassname) {
    $namespaceAndClassnameArray = explode('\\', $namespaceAndClassname);
    $classname = array_pop($namespaceAndClassnameArray);
    $namespaceArray = $namespaceAndClassnameArray;

    $namespaceArray = array_map(function ($namespaceItem) {
        return strtolower($namespaceItem);
    }, $namespaceArray);

    $filepath = implode('/', $namespaceArray) . "/${classname}.php";

    require_once $filepath;
});

$car = new \Models\Vehicles\Car(
    'Golf',
    'VW',
    'W-1234567'
);

$car->accelerate(15);
$car->accelerate(15);
$car->accelerate(200);
$car->setOwner('Lea');

$house = new \Models\Houses\House();
$house->setOwner('Hao');
$house->updateMortgageInfoFromDb();

echo $house->getMortgageInfo();
