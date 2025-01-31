<?php

declare(strict_types=1);

namespace App\Tests\Functionnal;

use App\Tests\Assert\AssertResponse;
use App\Tests\Assert\AssertWellFormedSuccessResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractTodoWebTestCase extends AbstractTodoFunctionnalTestCase
{
    /**
     * @return string
     */
    abstract protected function getRoute(): string;

    /**
     * @param string      $uri
     * @param string|null $content
     * @param array       $parameters
     */
    protected function requestGET(string $uri, ?string $content = null, array $parameters = []): void
    {
        $this->request(Request::METHOD_GET, $uri, $content, $parameters);
    }

    /**
     * @param string      $uri
     * @param string|null $content
     * @param array       $parameters
     * @param array       $files
     * @param array       $server
     */
    protected function requestPOST(string $uri, ?string $content = null, array $parameters = [], array $files = [], array $server = []): void
    {
        $this->request(Request::METHOD_POST, $uri, $content, $parameters, $files, $server);
    }

    /**
     * @param string      $uri
     * @param string|null $content
     * @param array       $parameters
     */
    protected function requestDELETE(string $uri, ?string $content = null, array $parameters = []): void
    {
        $this->request(Request::METHOD_DELETE, $uri, $content, $parameters);
    }

    /**
     * @param string      $uri
     * @param string|null $content
     * @param array       $parameters
     */
    protected function requestPATCH(string $uri, ?string $content = null, array $parameters = []): void
    {
        $this->request(Request::METHOD_PATCH, $uri, $content, $parameters);
    }

    /**
     * @param string      $method
     * @param string      $uri
     * @param string|null $content
     * @param array       $parameters
     * @param array       $files
     * @param array       $server
     */
    protected function request(string $method, string $uri, ?string $content = null, array $parameters = [], array $files = [], array $server = []): void
    {
        $this->client->catchExceptions(true);
        $this->client->request($method, $uri, $parameters, $files, server: $server, content: $content);
    }

    /**
     * @return Response
     */
    protected function getResponse(): Response
    {
        return $this->client->getResponse();
    }

    /**
     * @throws JsonException
     */
    protected function assertWellFormedSuccessResponse(): void
    {
        $content = $this->getResponseAsArray();
        AssertWellFormedSuccessResponse::assert($content);
    }

    protected function assertOKResponse(): void
    {
        AssertResponse::assertOK($this->getResponse(), $this->getResponseContent());
    }

    protected function assertUnprocessableResponse(): void
    {
        AssertResponse::assertUnprocessable($this->getResponse(), $this->getResponseContent());
    }

    protected function assertBadRequestResponse(): void
    {
        AssertResponse::assertBadRequest($this->getResponse(), $this->getResponseContent());
    }

    protected function assertNotFoundResponse(): void
    {
        AssertResponse::assertNotFound($this->getResponse(), $this->getResponseContent());
    }

    protected function assertForbiddenResponse(): void
    {
        AssertResponse::assertForbidden($this->getResponse(), $this->getResponseContent());
    }

    protected function assertCreatedResponse(): void
    {
        AssertResponse::assertCreated($this->getResponse(), $this->getResponseContent());
    }

    protected function assertUnauthorizedResponse(): void
    {
        AssertResponse::assertUnauthorizedResponse($this->getResponse(), $this->getResponseContent());
    }

    protected function assertConflictResponse(): void
    {
        AssertResponse::assertConflictResponse($this->getResponse(), $this->getResponseContent());
    }

    /**
     * @throws JsonException
     */
    protected function getResponseAsArray(): array
    {
        try {
            return json_decode($this->getResponseContent(), true, flags: \JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            dump($this->getResponseContent());

            throw $exception;
        }
    }

    /**
     * @return string
     */
    protected function getResponseContent(): string
    {
        return $this->getResponse()->getContent();
    }

    /**
     * @template  T of ServiceEntityRepository
     *
     * @param class-string<T> $className
     *
     * @return T
     */
    protected function getRepository(string $className): ServiceEntityRepository
    {
        return $this->get($className);
    }
}
