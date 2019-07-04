<?php

namespace App\Services;

use Symfony\Component\Dotenv\Dotenv;

use App\Interfaces\FileReaderInterface;
use App\Interfaces\FileWriterInterface;
use App\Exceptions\TrackingWritingException;

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

    /**
     * Perform a tracking for a product
     *
     * @param string $id
     * @return bool Whether the tracking was succesful or not
     */
    public function track($id)
    {
        $trackings = $this->getTrackings();

        if (empty($trackings)) {
            $res = $this->writer->writeRow(array($id, 1));
        } else {
            $res = $this->updateTrackings($trackings, $id);
        }

        if (false == $res) { 
            throw new TrackingWritingException("Error tracking product $id"); 
        } else {
            return $res;
        }
    }

    /**
     * Perform a tracking for a product where it already exists
     *
     * @param array $trackings The list of all the trackings
     * @param string $id
     * @return bool Whether the tracking was succesful or not
     */
    protected function updateTrackings($trackings, $id)
    {
        $present = false;
        $updatedTrackings = [];

        foreach ($trackings as $key => $tracking) {
            if ($tracking[0] == $id) {
                $present = true;
                $tracking[1]++;
            }

            $updatedTrackings[] = [
                $tracking[0],
                $tracking[1]
            ];
        }

        if (!$present) {
            $updatedTrackings[] = [$id, 1];
        }

        $this->writer->truncate();

        foreach ($updatedTrackings as $key => $tracking) {
            $res = $this->writer->writeRow($tracking);
        }

        return $res;
    }

    /**
     * Gets all the trackings from the data model
     *
     * @return array Trackings loaded
     */
    public function getTrackings()
    {
        $rows = [];

        while ($row = $this->reader->getFileRow()) {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Gets all the trackings from the data model
     *
     * @return array Trackings loaded
     */
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