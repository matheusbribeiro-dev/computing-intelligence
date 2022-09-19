<?php

// Mochila que receberá ou não os objetos.
$backpack = [];

$backpackCapacity = (float) readline("Capacidade da mochila(kg): ");
$objectsQuantity = (int) readline("Quantidade de objetos: ");

//Peso e benefício de cada objeto
$weights = [];
$benefits = [];

for($i = 0; $i < $objectsQuantity; $i++) {
    echo PHP_EOL . "--------------" . PHP_EOL;
    $weights[] = (float) readline("Peso objeto $i: ");
    $benefits[] = (int) readline("Beneficio objeto $i: ");
}

function createANeighborOfTheBackpack($backpack, $weights, &$backpackCapacity)
{
    $randomIndex = array_rand($backpack, 1);
    $weightObject = $weights[$randomIndex];

    if ($backpack[$randomIndex] === 0) {
        if ($weightObject > $backpackCapacity) {
            echo "Vizinho inviável" . PHP_EOL;
            createANeighborOfTheBackpack($backpack, $weights, $backpackCapacity);
        }

        $backpack[$randomIndex] = 1;
        $backpackCapacity -= $weightObject;
        return $backpack;
    }

    $backpack[$randomIndex] = 0;
    $backpackCapacity += $weightObject;

    return $backpack;
}

function putInTheBackpack(&$backpack, &$backpackCapacity, $currentWeight)
{
    if($currentWeight <= $backpackCapacity) {
        $backpack[] = 1;
        $backpackCapacity -= $currentWeight;
        return;
    }

    $backpack[] = 0;
    return;
}

function totalBenefitInBackpack($backpack, $benefits) 
{
    $total = 0.0;

    foreach($backpack as $key => $b) {
        if($b === 1) {
            $total += $benefits[$key];
        }
    }

    return $total;
}

foreach($weights as $key => $weight) {
    $randomNumber = rand(0, 1);
    echo "Tentar colocar: {$randomNumber}" . PHP_EOL;
    if($randomNumber === 0) {
        $backpack[] = $randomNumber;
        continue;
    }

    putInTheBackpack($backpack, $backpackCapacity, $weight);
}

echo PHP_EOL;
echo "Antes do vizinho" . PHP_EOL;
var_dump($backpack);

echo PHP_EOL;
echo "Vizinho" . PHP_EOL;
$neighbor = createANeighborOfTheBackpack($backpack, $weights, $backpackCapacity);
var_dump($neighbor);


echo PHP_EOL;
echo "Capacidade atual da mochila: " . $backpackCapacity . PHP_EOL;