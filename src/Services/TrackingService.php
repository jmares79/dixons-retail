<?php

namespace App\Services;

use App\Interfaces\FileReaderInterface;
use App\Interfaces\FileWriterInterface;
use App\Exceptions\TrackingWritingException;

use Symfony\Component\Dotenv\Dotenv;

class TrackingService
{
    protected static $tracking = [];
    protected $reader;
    protected $writer;

    public function __construct(FileReaderInterface $reader, FileWriterInterface $writer)
    {
        $this->dotenv = new Dotenv();
        $this->dotenv->load(__DIR__.'/../../.env');

        $this->reader = $reader;
        $this->writer = $writer;

        $this->reader->prepareFiles($_ENV['DATA_DIR'], $_ENV['TRACKING_FILE']);
        $this->writer->prepareFiles($_ENV['DATA_DIR'], $_ENV['TRACKING_FILE']);
    }

    public function track($id)
    {
        $trackings = $this->getTrackings();
        $present = false;

        if (empty($trackings)) {
            $res = $this->writer->writeRow(array($id, 1));
        } else {
            foreach ($trackings as $key => $tracking) {
                if ($tracking[0] == $id) {
                    var_dump($tracking);
                    $amount = $tracking[1];
                    $tracking[1] = ++$amount;
                    $present = true;
                    var_dump($tracking);
                }
            }

            if (!$present) {
                $trackings[] = [$id, 1];
            }

            // var_dump($trackings);

            $this->writer->truncate();
            
            foreach ($trackings as $key => $tracking) {
                $res = $this->writer->writeRow($tracking);
            }
        }

        if (false == $res) { 
            throw new TrackingWritingException("Error tracking product $id"); 
        } else {
            return $res;
        }
    }

    public function getTrackings()
    {
        $rows = [];

        while ($row = $this->reader->getFileRow()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function getById($id)
    {
        $row = null;

        while ($row = $this->reader->getFileRow()) {
            if ($id == $row[0]) { 
                return $row; 
            }
        }

        return $row;
    }
}