<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use App\Services\ProductService;
use App\Exceptions\InvalidInputArguments;
use App\Exceptions\InvalidInputException;

class InputCommand extends Command
{
	// the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:product-data';

    /**
     * Service in charge of managing everything related to products
     */
    private $product;

    public function __construct(ProductService $product)
    {
        $this->calculatorManager = $calculator;
        // $this->validator = $validator;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Return the json representation of product data');
        $this->addArgument('id', InputArgument::REQUIRED, 'The id of the product.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bottles = $input->getArgument('bottles');
        $heights = explode(",", $input->getArgument('heights'));

        if (!$this->validator->isValidInput($bottles, $heights)) {
            $bottlesThrown = self::DEFAULT_OUTPUT;
        } else {
            $bottlesThrown = $this->calculatorManager->calculate($heights);
        }

        $output->writeln($bottlesThrown);
    }
}
