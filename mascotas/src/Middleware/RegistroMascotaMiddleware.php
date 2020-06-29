<?php
namespace App\Middleware;

//use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as Response;
use \Firebase\JWT\JWT;
use App\Models\Usuario;

class RegistroMascotaMiddleware
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

        $header = getallheaders();
        $token = $header['token'];
        $decoded = JWT::decode($token, 'usuario', array('HS256'));
        $usuarioEncontrado = json_decode(Usuario::whereRaw('email = ? AND password = ?',array($decoded->email,$decoded->password))->get());

        if ($usuarioEncontrado[0]->tipo == "cliente")
        {
            if ((isset($headers['nombre']) && $headers['nombre']!="") && (isset($headers['edad']) && $headers['edad']!=""))
            {
                $response = $handler->handle($request);
                $existingContent = (string) $response->getBody();
                $resp = new Response();
                $resp->getBody()->write('Los datos se encuentran bien' . $existingContent);
                return $resp->withHeader('Content-type', 'application/json');
                
            } else 
            {
                $response = new Response();
                $response->getBody()->write("No se pudo completar el registro, faltan datos");
                return $response->withHeader('Content-type', 'application/json');
            }
        }else
        {
            $response = new Response();
            $response->getBody()->write("Usted es veterinario, registro de mascotas solo para clientes");
            return $response->withHeader('Content-type', 'application/json');
        }
    }
}