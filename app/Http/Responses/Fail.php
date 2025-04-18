<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class Fail extends Base
{
    public int $statusCode = Response::HTTP_BAD_REQUEST;

    /**
     * ExceptionResponse constructor.
     *
     * @param $data
     * @param string|null $message
     * @param int $code
     */
    public function __construct($data, protected ?string $message = null, int $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($data, $code);
    }

    /**
     * Формирование содежимого ответа.
     *
     * @return array
     */
    protected function makeResponseData(): array
    {
        return [
            'message' => $this->message,
            'errors' => $this->prepareData(),
        ];
    }
}
