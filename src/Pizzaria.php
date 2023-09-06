<?php
namespace App;

use App\Logging\ActionsLog;
use App\Logging\GlobalEventName;
use MadeiraMadeira\Logger\Core\LoggerStatic as Logger;

class Pizzaria {
    public $ingredients = [];

    public function __construct(array $ingredients) {
        $this->ingredients = $ingredients;
    }

    public function getStock()
    {
        return $this->ingredients;
    }

    public function useIngredient(string $type, int $quantity)
    {
        // [...] omitindo checagem de estoque negativo

        $this->ingredients[$type]["actual"] = $this->ingredients[$type]["actual"] - $quantity;
        $this->checkStockQuantity($type);
    }

    private function checkStockQuantity(string $type)
    {
        if ($this->ingredients[$type]["actual"] <= $this->ingredients[$type]["minimal"]) {
            Logger::warning(
                "o estoque de {$type} está prestes a acabar, verifique os ingredientes",
                ["stock" => $this->ingredients[$type]],
                GlobalEventName::APPLICATION_EVENT
            );
        }
    }

    public function buyIngredients(string $type, int $quantity)
    {
        // [...] simulate a fake request
        $buyed = mt_rand(0,1); // random true or false
        $fakeResponseTime = rand(1,3);
        sleep($fakeResponseTime);
        if ($buyed) {
            $this->ingredients[$type]["actual"] = $this->ingredients[$type]["actual"] + $quantity;
            Logger::info(
                "adicionado {$quantity} {$type}(s) ao estoque",
                [
                    "stock" => $this->ingredients[$type],
                    "time_spent_ms" => $fakeResponseTime * 1000
                ],
                GlobalEventName::APPLICATION_EVENT
            );
            return;
        }
        Logger::error(
            "poxa vida, deu algum erro para adicionar {$type}",
            [
                "service" => "pizzaria-service",
                "action" => ActionsLog::SUPERMARKET_REQUEST,
                "reason" => "request failed",
                "stock" => $this->ingredients[$type],
                "time_spent_ms" => $fakeResponseTime * 1000
            ],
            GlobalEventName::SERVICE_REQUEST_FAILED
        );
    }
}