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
    protected static $defaultName = 'app:product-data';
    const ERROR_OUTPUT = 'Invalid Id';

    /**
     * Service in charge of managing everything related to products
     */
    private $product;

    public function __construct(ProductService $product)
    {
        $this->product = $product;
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
        $productId = $input->getArgument('id');

        $description = $this->product->detail($productId);
        // if (!$this->validator->isValidInput($productId)) {
        //     $description = self::ERROR_OUTPUT;
        // } else {
        // }

        $output->writeln($description);
    }
}
