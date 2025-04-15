<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Request;

abstract class Base implements Responsable
{
    public function __construct(
        protected mixed $data = [],
        public int $statusCode = Response::HTTP_OK,
    ) {}

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        return response()->json($this->makeResponseData(), $this->statusCode);
    }

    /**
     * Преобразование возвращаемых данных к массиву.
     *
     * @return array
     */
    protected function prepareData(): array
    {
        if ($this->data instanceof Arrayable) {
            return $this->data->toArray();
        }

        return $this->data;
    }

    /**
     * Формирование содержимого ответа.
     *
     * @return array|null
     */
    abstract protected function makeResponseData(): ?array;
}
