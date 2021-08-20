<?php

abstract class Animal {
    protected $uniqID;
    public $typeOfProduct;
    public $minProduceQuantity;
    public $maxProduceQuantity;

    public function collectProduced() {
        return rand($this->minProduceQuantity, $this->maxProduceQuantity);
    }
}

class Cow extends Animal {
    public function __construct() {
        $this->uniqID = uniqid('cow_', true);
        $this->typeOfProduct = 'milk';
        $this->minProduceQuantity = 8;
        $this->maxProduceQuantity = 12;
    }
}

class Chiken extends Animal {
    public function __construct() {
        $this->uniqID = uniqid('chiken_', true);
        $this->typeOfProduct = 'eggs';
        $this->minProduceQuantity = 0;
        $this->maxProduceQuantity = 1;
    }
}

class Barn {
    public $animals = [];
    public $animalTypes = [];

    public function __construct() {
        $this->animalTypes = ['Cow', 'Chiken'];
    }

    public function addAnimals($type, $count = 1) {
        $type = ucfirst(strtolower($type));
        if (in_array($type, $this->animalTypes)) {
            for ($i = 0; $i < $count; $i++) {
                $this->animals[] = new $type();
            }
        }

        return $this;
    }
}

class Farm {
    public $storage = [];

    public function collectProduction($barn) {
        foreach ($barn->animals as $animal) {
            if (!isset($this->storage[$animal->typeOfProduct])) {
                $this->storage[$animal->typeOfProduct] = 0;
            }
            $this->storage[$animal->typeOfProduct] += $animal->collectProduced();
        }
        echo 'Products have been successfully collected.' . PHP_EOL;
    }

    public function checkStorage() {
        if (array_sum($this->storage) === 0) {
            echo 'Storage is empty now :(' . PHP_EOL;
            return;
        }
        echo 'In storage now:' . PHP_EOL;
        foreach ($this->storage as $productName => $productCount) {
            echo "$productName - $productCount pcs" . PHP_EOL;
        }
    }
}

$farm = new Farm();
$barn = new Barn();
$barn->addAnimals('cow', 7)->addAnimals('chiken', 15);

$farm->checkStorage();
$farm->collectProduction($barn);
$farm->checkStorage();
