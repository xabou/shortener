<?php

namespace App\Middlewares;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ValidationMiddleware
{
    /**
     * The Request Validator.
     *
     * @var \Illuminate\Contracts\Validation\Factory
     */
    protected $validator;
    /**
     * The supported shortening providers.
     *
     * @var array
     */
    protected $providers = [
        'google',
        'bitly'
    ];

    /**
     * RegisterServicesMiddleware constructor.
     *
     * @param \Illuminate\Contracts\Validation\Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validate incoming request.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $validator = $this->validator->make($this->getData($request), $this->getRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $next($request, $response);
    }

    /**
     * Get the validation rules.
     *
     * @return array
     */
    protected function getRules()
    {
        return [
            'url'      => 'required|url',
            'provider' => 'in:' . implode(',', $this->providers),
        ];
    }

    /**
     * Get the data under validation.
     *
     * @param Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        return [
            'url'      => $request->getParsedBodyParam('url'),
            'provider' => $request->getParsedBodyParam('provider')
        ];
    }
}