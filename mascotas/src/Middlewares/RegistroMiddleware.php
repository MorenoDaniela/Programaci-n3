<?php
namespace App\Middlewares;

//use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as Response;

class RegistroMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        
        $headers = $request->getParsedBody();

        if ((isset($headers['email']) && $headers['email']!="") && (isset($headers['password']) && $headers['password']!="") && (isset($headers['tipo'])&& $headers['tipo']!=""))
        {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $response = new Response();
            $response->getBody()->write('Los datos se encuentran bien' . $existingContent);
            return $response->withHeader('Content-type', 'application/json');;
        } else {
            $response = new Response();
            $response->getBody()->write('No se pudo completar el registro, faltan datos');
            //throw new \Slim\Exception\HttpForbiddenException($request);
		    $response->withStatus(403);
            return $response->withHeader('Content-type', 'application/json');;
        }

    }
}