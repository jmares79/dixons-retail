<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use App\Services\ProductService;
use Symfony\Component\Dotenv\Dotenv;

class InputCommand extends Command
{
    protected static $defaultName = 'app:product-data';
    const CONFIGURATION_ERROR = 'Invalid data models set. Please add a valid configuration.';

    /**
     * Service in charge of managing everything related to products
     */
    protected $product;

    protected $dotenv;

    public function __construct(ProductService $product)
    {
        $this->dotenv = new Dotenv();
        $this->product = $product;
        
        $this->dotenv->load(__DIR__.'/../../.env');

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

        if (!isset($_ENV['MODEL_DEFAULT']) || !isset($_ENV['MODEL_FALLBACK'])) {
            $detail = self::CONFIGURATION_ERROR;
        } else {
            $detail = $this->product->detail($productId);
        }

        $output->writeln($detail);
    }
}
