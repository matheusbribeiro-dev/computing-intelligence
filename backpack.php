<?php
//vezes possíveis de geração de vizinho viável
$timesToNeighbor = 0;
$timesToClimb = 0;

// Mochila que receberá ou não os objetos.
$backpack = [];

$backpackCapacity = (float) readline("Capacidade da mochila(kg): ");
$backpackCapacityBkp = $backpackCapacity;
$objectsQuantity = (int) readline("Quantidade de objetos: ");

//Peso e benefício de cada objeto
$weights = [];
$benefits = [];

for($i = 0; $i < $objectsQuantity; $i++) {
    echo PHP_EOL . "--------------" . PHP_EOL;
    $weights[] = (float) readline("Peso objeto $i: ");
    $benefits[] = (int) readline("Beneficio objeto $i: ");
}

function createANeighborOfTheBackpack($backpack, $weights, &$backpackCapacity, $backpackCapacityBkp, &$timesToNeighbor)
{
    $randomIndex = array_rand($backpack, 1);
    $weightObject = $weights[$randomIndex];

    if ($backpack[$randomIndex] === 0) {
        if ($weightObject > $backpackCapacity) {
            $timesToNeighbor += 1;

            if ($timesToNeighbor >= 3) {
                return $backpack;
            }

            echo "Vizinho inviável" . PHP_EOL;
            createANeighborOfTheBackpack($backpack, $weights, $backpackCapacity, $backpackCapacityBkp, $timesToNeighbor);
        }

        $timesToNeighbor = 0;

        $backpack[$randomIndex] = 1;
        $backpackCapacity -= $weightObject;
        return $backpack;
    }

    $backpack[$randomIndex] = 0;
    $newCapacity = $backpackCapacity + $weightObject;

    $backpackCapacity = min($newCapacity, $backpackCapacityBkp);

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
//Início
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
echo "Antes da subida" . PHP_EOL;
var_dump($backpack);
//Subida
$climb = true;
while ($climb) {
    $neighbor = createANeighborOfTheBackpack($backpack, $weights, $backpackCapacity, $backpackCapacityBkp, $timesToNeighbor);

    $benefitInTheBackpack = totalBenefitInBackpack($backpack, $benefits);
    $benefitInTheNeighbor = totalBenefitInBackpack($neighbor, $benefits);

    if($benefitInTheNeighbor > $benefitInTheBackpack) {
        $backpack = $neighbor;

        $timesToClimb = 0;
    } else {
        $timesToClimb += 1;

        if ($timesToClimb === 5) $climb = false;
    }
}

echo PHP_EOL;
echo "Depois da subida" . PHP_EOL;
var_dump($backpack);
