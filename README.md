# authorization-client

#installation
* services
```yaml

    authorization.client.user:
        class: JsonRpcClientBase\ValueObject\ClientUser
        arguments:
            - '%env(AUTH_USER)%'
            - '%env(AUTH_PASSWORD)%'

    AuthorizationClient\AuthorizationClient:
        class: AuthorizationClient\AuthorizationClient
        calls:
            -   method: setEndpointUrl
                arguments:
                    - '%env(AUTH_ENDPOINT)%'
            -   method: setUser
                arguments:
                    - '@authorization.client.user'

    JsonRpcClientBase\Contract\RequestHandlerInterface:
        class: JsonRpcClientBase\RequestHandler\CurlRequestHandler

    JsonRpcServerCommon\Contract\PasswordEncryptInterface:
        class: JsonRpcServerCommon\Service\DefaultPasswordEncryptService
```
