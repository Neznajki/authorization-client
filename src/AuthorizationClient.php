<?php declare(strict_types=1);


namespace AuthorizationClient;


use JsonRpcClientBase\AbstractClient;
use JsonRpcClientBase\ValueObject\RequestEntity;
use JsonRpcClientBase\ValueObject\ResponseEntity;
use Symfony\Component\HttpFoundation\Request;

class AuthorizationClient extends AbstractClient
{

    /**
     * @param string $sessionTransferUrl
     * @param string $redirectPage
     * @param string $sessionId
     * @param Request $request
     * @param string $loginPageType (default)
     * @return ResponseEntity ["success": 1, "url": "http://..."]
     */
    public function getLoginPage(
        string $sessionTransferUrl,
        string $redirectPage,
        string $sessionId,
        Request $request,
        string $loginPageType = 'default'
    ): ResponseEntity {
        $request = $this->addGetLoginPage($sessionTransferUrl, $redirectPage, $sessionId, $request, $loginPageType);

        $responseCollection = $this->handle();
        $responseEntity     = $responseCollection->getResponseById($request->getId());

        return $responseEntity;
    }

    /**
     * @param string $sessionTransferUrl
     * @param string $redirectPage
     * @param string $sessionId
     * @param Request $request
     * @param string $loginPageType (default)
     * @return RequestEntity ["success": 1, "url": "http://..."]
     */
    public function addGetLoginPage(
        string $sessionTransferUrl,
        string $redirectPage,
        string $sessionId,
        Request $request,
        string $loginPageType = 'default'
    ): RequestEntity {
        return $this->addRequest(
            'getLoginPage',
            [
                'loginPageType'    => $loginPageType,
                'redirectPage'     => $redirectPage,
                'sessionTransferUrl' => $sessionTransferUrl,
                'sessionId'        => $sessionId,
                'serverParams'     => $request->server->all(),
            ]
        );
    }

    /**
     * @param string $token
     * @param string $sessionId
     * @param Request $request
     * @return ResponseEntity ["success": 1, "user": ["userName": "me@me.me"], "tokenExpiresIn": 3600]
     */
    public function isAuthorizedLoginToken(string $token, string $sessionId, Request $request): ResponseEntity
    {
        $request = $this->addIsAuthorizedLoginToken($token, $sessionId, $request);

        return $this->handle()->getResponseById($request->getId());
    }

    /**
     * @param string $token
     * @param string $sessionId
     * @param Request $request
     * @return RequestEntity
     */
    public function addIsAuthorizedLoginToken(string $token, string $sessionId, Request $request): RequestEntity
    {
        return $this->addRequest(
            'isAuthorizedLoginToken',
            [
                'token'        => $token,
                'sessionId'    => $sessionId,
                'serverParams' => $request->server->all(),
            ]
        );
    }
}
