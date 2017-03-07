<?php

namespace SumoCoders\Teamleader\Files;

use SumoCoders\Teamleader\Exception;
use SumoCoders\Teamleader\Teamleader;

/**
 * Class File
 *
 * @author      Chiel Betting <chiel@mijnos.nl>
 * @version     1.0.0
 * @copyright   Copyright (c) Online Supporter. All rights reserved.
 * @license     BSD License
 * @package     SumoCoders\Teamleader\File
 */
class File
{
    private $id;
    private $filename;
    private $date_last_edited;
    private $filesize_bytes;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param int $id
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return int
     */
    public function getDateLastEdited()
    {
        return $this->date_last_edited;
    }

    /**
     * @param int $id
     */
    public function setDateLastEdited($date_last_edited)
    {
        $this->date_last_edited = $date_last_edited;
    }

    /**
     * @return int
     */
    public function getFilesizeBytes()
    {
        return $this->filesize_bytes;
    }

    /**
     * @param int $id
     */
    public function setFilesizeBytes($filesize_bytes)
    {
        $this->filesize_bytes = $filesize_bytes;
    }

    /**
     * Initialize an Product with raw data we got from the API
     *
     * @return File
     */
    public static function initializeWithRawData($data)
    {
        $file = new File();

        foreach ($data as $key => $value) {
            switch ($key) {
                default:
                    // Ignore empty values
                    if ($value == '') {
                        continue;
                    }

                    $methodName = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
                    if (!method_exists(__CLASS__, $methodName)) {
                        if (Teamleader::DEBUG) {
                            var_dump($key, $value);
                            throw new Exception('Unknown method (' . $methodName . ')');
                        }
                    } else {
                        call_user_func(array($file, $methodName), $value);
                    }
            }
        }

        return $file;
    }

    /**
     * This method will convert an invoice to an array that can be used for an
     * API-request
     *
     * @return array
     */
    public function toArrayForApi()
    {
        $return = array(
            'id' => $this->getId(),
            'filename' => $this->getFilename(),
            'date_last_edited' => $this->getDateLastEdited(),
            'filesize_bytes' => $this->getFilesizeBytes(),
        );

        return $return;
    }
}