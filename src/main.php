<?php
namespace App;

require_once(__DIR__."/../vendor/autoload.php");

$ingredients = [
    "tomate" => ["actual" => 100, "minimal" => 50],
    "cebola" => ["actual" => 200, "minimal" => 30],
    "queijo" => ["actual" => 100, "minimal" => 60]
];

$pizzaria = new Pizzaria($ingredients);

$pizzaria->useIngredient("tomate", 20); // 100 - 20 = 80
$pizzaria->useIngredient("tomate", 8); // 80 - 8 = 72
$pizzaria->useIngredient("tomate", 30); // 72 - 30 = 42
$pizzaria->useIngredient("cebola", 20);
$pizzaria->buyIngredients("tomate", 20);

$pizzaria->buyIngredients("cebola", 1);
$pizzaria->buyIngredients("queijo", 10);
$stock = $pizzaria->getStock();