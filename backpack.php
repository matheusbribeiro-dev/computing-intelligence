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

function createANeighborOfTheBackpack($backpack, $weights, $backpackCapacity)
{
    $randomIndex = array_rand($backpack, 1);
    $weightObject = $weights[$randomIndex];

    if ($backpack[$randomIndex] === 0) {
        //Mudar para 1 se couber
    } else {
        createANeighborOfTheBackpack($backpack, $weights, $backpackCapacity);
    }
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
    
    if($randomNumber === 0) {
        $backpack[] = $randomNumber;
        continue;
    }

    putInTheBackpack($backpack, $backpackCapacity, $weight);
}

//$neighbor = createANeighborOfTheBackpack($backpack, $weights);

echo PHP_EOL;
var_dump($backpack);

echo PHP_EOL;
echo "Benefício total da mochila: " . totalBenefitInBackpack($backpack, $benefits) . PHP_EOL;