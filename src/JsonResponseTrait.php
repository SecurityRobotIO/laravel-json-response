<?php
namespace SecurityRobot;

trait JsonResponseTrait
{
    /**
     * @var HTTP status code
     *
     * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     */
    protected $status_code = 200;

    /**
     * This method returns the HTTP status code
     *
     * @return string
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * This method sets the HTTP status code
     *
     * @param integer $status_code HTTP status code
     * @return JsonResponseTrait
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @param string $message
     * @return void
     */
    public function responseNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @param string $message
     * @return void
     */
    public function errorWrongArgs($message = 'Wrong Arguments!')
    {
        return $this->setStatusCode(400)->respondWithError($message);
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @param string $message
     * @return void
     */
    public function errorNotAuthorized($message = 'Not authorized!')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @param string $message
     * @return void
     */
    public function errorForbidden($message = 'Forbidden!')
    {
        return $this->setStatusCode(403)->respondWithError($message);
    }

    /**
     * Generates a Response with a 405 HTTP header and a given message.
     *
     * @param string $message
     * @return void
     */
    public function errorMethodNotAllowed($message = 'HTTP Method Not Allowed!')
    {
        return $this->setStatusCode(405)->respondWithError($message);
    }

    /**
     * Generates a Response with a 429 HTTP header and a given message.
     *
     * @param string $message
     * @return Http\JsonResponse
     */
    public function errorTooManyRequests($message = 'Too many requests')
    {
        return $this->setStatusCode(429)->respond([
            'error' => [
                'http_code' => $this->getStatusCode(),
                'message'   => $message,
            ]
        ]);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @param string $message
     * @return void
     */
    public function errorInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * @param array $data
     * @param array $headers
     * @return Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Method creates the error responds structure
     *
     * @param string $message The error message
     * @return Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'http_code' => $this->getStatusCode(),
                'message'   => $message,
            ]
        ]);
    }

    /**
     * @param array $validation_errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondValidationErrors(array $validation_errors)
    {
        $this->setStatusCode(422);

        return $this->respond([
            'errors' => $validation_errors
        ]);
    }
}
