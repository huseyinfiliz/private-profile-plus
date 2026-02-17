<?php

namespace huseyinfiliz\PrivateProfilePlus\Middleware;

use Flarum\User\UserRepository;
use huseyinfiliz\PrivateProfilePlus\Helper\VisibilityResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;

class CheckProfileVisibility implements MiddlewareInterface
{
    protected UserRepository $users;
    protected VisibilityResolver $resolver;

    public function __construct(UserRepository $users, VisibilityResolver $resolver)
    {
        $this->users = $users;
        $this->resolver = $resolver;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['filter']['author'])) {
            return $handler->handle($request);
        }

        $authorUsername = $queryParams['filter']['author'];
        $profileOwner = $this->users->query()
            ->where('username', $authorUsername)
            ->first();

        if (!$profileOwner) {
            return $handler->handle($request);
        }

        $actor = $request->getAttribute('actor');

        if ($this->resolver->canView($profileOwner, $actor)) {
            return $handler->handle($request);
        }

        return new JsonResponse(['data' => []], 200);
    }
}
