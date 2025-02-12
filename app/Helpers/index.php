<?php

if (! function_exists('firstWord')) {
    /**
     * Take first word from passed value
     *
     * @param string value
     * @param bool capitalize
     */
    function firstWord(string $value, ?bool $capitalize = false): string
    {
        $result = str()->of(strtolower($value))->explode(' ')->get(0);

        return $capitalize ? ucfirst($result) : strtolower($result);
    }
}

if (! function_exists('firstLetter')) {
    /**
     * Take first letter from passed value
     *
     * @param string value
     * @param bool capitalize
     */
    function firstLetter(string $value, ?bool $capitalize = true): string
    {
        $result = str(string: $value)->substr(start: 0, length: 1);

        return $capitalize ? $result->upper() : $result->lower();
    }
}

if (! function_exists('generateUsername')) {
    /**
     * Take first letter from passed value
     *
     * @param string value
     * @param ?int number_length
     */
    function generateUsername(string $value, ?int $number_length = 5): string
    {
        $max = (int) str_pad(string: '9', length: $number_length, pad_string: '9');

        $result = firstWord(value: $value, capitalize: false) . mt_rand(min: 11111, max: $max);

        return $result;
    }
}

if (! function_exists('generateSlug')) {
    /**
     * Take first letter from passed value
     *
     * @param string value
     * @param ?int number_length
     */
    function generateSlug(string $value, ?int $number_length = 5): string
    {
        $max = (int) str_pad(string: '9', length: $number_length, pad_string: '9');

        $result = str($value)->lower()->slug() . '-' . mt_rand(min: 11111, max: $max);

        return $result;
    }
}

if (! function_exists('sendFile')) {
    /**
     * Send file to business logic
     *
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null image
     */
    function sendFile($image): array
    {
        $result = [
            'image' => $image,
            'extension' => $image?->extension(),
        ];

        return $result;
    }
}

if (! function_exists('sendSuccessData')) {
    function sendSuccessData(mixed $data = null, ?string $message = 'Success'): array
    {
        if ($data != null) {
            return [
                'message' => $message,
                'data' => $data,
            ];
        }

        return [
            'message' => $message,
        ];
    }
}

if (! function_exists('sendFailedData')) {
    function sendFailedData(mixed $data = null, ?string $message = 'Failed'): array
    {
        $result = [
            'message' => $message,
            'data' => $data,
        ];

        return $result;
    }
}
