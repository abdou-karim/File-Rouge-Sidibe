<?php
namespace App\EventListener;

use App\Entity\Promotion;
use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;


class JWTCreatedListener{

    private $requestStack;
    private $user;


    public function __construct(RequestStack $requestStack ,UserRepository $userRepository)
    {
        $this->requestStack = $requestStack;
        $this->user=$userRepository;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {

        $payload = $event->getData();
        $request= $this->user->findOneBy(["username"=>$payload['username']]);
        $payload['archivage']=$request->getArchivage();
        $event->setData($payload);
        $header  = $event->getHeader();
        $header['cty'] = 'JWT';

        $event->setHeader($header);
    }

}
