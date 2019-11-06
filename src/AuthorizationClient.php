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
     * @param Request $request
     * @param string $loginPageType (default)
     * @return ResponseEntity ["success": 1, "url": "http://..."]
     */
    public function getLoginPage(
        string $sessionTransferUrl,
        string $redirectPage,
        Request $request,
        string $loginPageType = 'default'
    ): ResponseEntity {
        $request = $this->addGetLoginPage($sessionTransferUrl, $redirectPage, $request, $loginPageType);

        return $this->handle()->getResponseById($request->getId());
    }

    /**
     * @param string $sessionTransferUrl
     * @param string $redirectPage
     * @param Request $request
     * @param string $loginPageType (default)
     * @return RequestEntity ["success": 1, "url": "http://..."]
     */
    public function addGetLoginPage(
        string $sessionTransferUrl,
        string $redirectPage,
        Request $request,
        string $loginPageType = 'default'
    ): RequestEntity {
        return $this->addRequest(
            'getLoginPage',
            [
                'loginPageType'    => $loginPageType,
                'redirectPage'     => $redirectPage,
                'sessionTransferUrl' => $sessionTransferUrl,
                'sessionId'        => session_id(),
                'serverParams'     => $request->server->all(),
            ]
        );
    }

    /**
     * @param string $token
     * @param Request $request
     * @return ResponseEntity ["success": 1, "tokenExpiresIn": 3600]
     */
    public function isAuthorizedLoginToken(string $token, Request $request): ResponseEntity
    {
        $request = $this->addIsAuthorizedLoginToken($token, $request);

        return $this->handle()->getResponseById($request->getId());
    }

    /**
     * @param string $token
     * @param Request $request
     * @return RequestEntity
     */
    public function addIsAuthorizedLoginToken(string $token, Request $request): RequestEntity
    {
        return $this->addRequest(
            'isAuthorizedLoginToken',
            [
                'token'        => $token,
                'sessionId'    => session_id(),
                'serverParams' => $request->server->all(),
            ]
        );
    }
}
