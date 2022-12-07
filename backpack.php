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

function totalWeightInTheBackpack($backpack, $weights)
{
    $total = 0;

    foreach($backpack as $key => $b) {
        if($b === 1) {
            $total += $weights[$key];
        }
    }

    return $total;
}

function createANeighborOfTheBackpack($neighbor)
{
    $randomNumber = array_rand($neighbor, 1);

    if ($neighbor[$randomNumber] === 0) {
        $neighbor[$randomNumber] = 1;
    } else {
        $neighbor[$randomNumber] = 0;
    }

    return $neighbor;
};

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

    if($randomNumber === 0) {
        $backpack[] = $randomNumber;
        continue;
    }

    putInTheBackpack($backpack, $backpackCapacity, $weight);
}

echo PHP_EOL;
echo "Antes da subida" . PHP_EOL;
var_dump($backpack);

$neighbor = $backpack;

//Subida
//for($i = 0; $i < 3; $i++) {
while ($timesToNeighbor < 3) {
    $neighborCandidate = createANeighborOfTheBackpack($neighbor);
    $weightInNeighbor = totalWeightInTheBackpack($neighborCandidate, $weights);

    if ($weightInNeighbor > $backpackCapacityBkp) {
        $timesToNeighbor += 1;
    } else {
        $timesToNeighbor = 0;

        $neighbor = $neighborCandidate;

        $benefitInTheBackpack = totalBenefitInBackpack($backpack, $benefits);
        $benefitInTheNeighbor = totalBenefitInBackpack($neighbor, $benefits);

        if($benefitInTheNeighbor > $benefitInTheBackpack) {
            $backpack = $neighbor;
        }
    }
}
//}

echo PHP_EOL;
echo "Depois da subida" . PHP_EOL;
var_dump($backpack);
