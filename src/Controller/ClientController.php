<?php

namespace App\Controller;

use App\UseCase\CreateClient\CreateClientDto;
use App\UseCase\CreateClient\CreateClientHandler;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/client", name="client_")
 */
class ClientController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="index", methods={"POST"})
     *
     * @param CreateClientHandler $createClientHandler
     * @param CreateClientDto $dto
     *
     * @return Response
     *
     * @ParamConverter("dto", converter="fos_rest.request_body")
     */
    public function create(CreateClientHandler $createClientHandler, CreateClientDto $dto): Response
    {
        $client = $createClientHandler->handle($dto);
        return $this->handleView($this->view($client,Response::HTTP_CREATED));
    }
}
