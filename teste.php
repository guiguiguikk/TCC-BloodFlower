<?php 

echo "Hello World!";
 $a = 5;
    $b = 10;
    $c = $a + $b;
    echo $c;

if ($a > $b){
    echo "A é maior que B";

}else{
    echo "B é maior que A";
}

$frutas = array("maçã", "banana", "laranja");

foreach ($frutas as $fruta) {
    echo $fruta;
}

$carros = array("Fusca", "Civic", "Corolla");

$n = count($carros);
for ($i = 0; $i < $n; $i++) {
    echo $carros[$i];
}