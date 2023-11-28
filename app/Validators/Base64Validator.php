<?php

namespace App\Validators;

class Base64Validator
{
    /**
     * Check if the file is in base64 pdf format and within size constraints
     */
    public function validateBase64Pdf($attribute, $value, $parameters, $validator)
    {
        $explode = $this->explodeString($value);
        $allow = $this->allowedFormat();
        $format = $this->dataFormat($explode);

        // check file format
        if (!in_array($format, $allow)) {
            return false;
        }

        // check file size
        $maxSize = $parameters[0] ?? 51200; // default to 50MB
        $minSize = $parameters[1] ?? 1024;  // default to 1KB

        $decodedFileSize = $this->getDecodedFileSize($explode[1]);

        if ($decodedFileSize > $maxSize || $decodedFileSize < $minSize) {
            return false;
        }

        return true;
    }

    /**
     * Get the size of the decoded file from base64 string
     */
    private function getDecodedFileSize($base64String)
    {
        // Use rtrim to remove padding characters
        $decodedData = base64_decode(rtrim($base64String, '='));
        return mb_strlen($decodedData, '8bit');
    }

    /**
     * Check the data format
     */
    public function dataFormat($explode)
    {
        return str_replace(
            [
                'data:application/',
                ';base64',
            ],
            [
                '', '',
            ],
            $explode[0]
        );
    }

    /**
     * The allowed format in base 64 pdf
     */
    public function allowedFormat()
    {
        return ['pdf'];
    }

    /**
     * Explode base 64 pdf
     */
    public function explodeString($value)
    {
        return explode(',', $value);
    }
}
