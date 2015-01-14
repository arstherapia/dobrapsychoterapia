<?php
namespace MES\APP\FrontendBundle\Service\Upload\Adapters;

use Doctrine\Common\Persistence\ObjectManager;
use GoWork\Common\UserBundle\Entity\GwUser;
use MES\APP\FrontendBundle\Entity\UploadFile;
use MES\APP\FrontendBundle\Service\Upload\AdapterInterface;
use MES\APP\FrontendBundle\Service\Upload\UploadData;
use MES\APP\FrontendBundle\Service\Upload\UploadFileNamer;
use MES\APP\FrontendBundle\Service\Upload\UploadResponse;
use MES\APP\FrontendBundle\Service\Upload\UploadType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
/*
 * dodać tabelę,
 * zwrócić ID pliku,
 */
class UserProfileAdapter implements AdapterInterface
{
    protected $om;
    protected $securityContext;
    protected $session;
    
    public function __construct(ObjectManager $om, SecurityContext $securityContext, Session $session)
    {
        $this->om = $om;
        $this->securityContext = $securityContext;
        $this->session = $session;
    }
    
    public function storeUploadedFile(UploadData $data, UploadType $uploadType)
    {
        $response = new UploadResponse();
        $uploadFile = $this->createUploadFile($data);
        
        $id = $uploadFile->getId();
        $path = $data->getWebUrl();
        
        $sessionFiles = $this->session->get('files', []);
        if (!in_array($sessionFiles, $sessionFiles)) {
            $sessionFiles[] = [
                'path' => $path,
                'id' => $id,
            ];
        }
        $this->session->set('files', $sessionFiles);
        
        $response['success'] = true;
        $response['files'] = array(
            [
                'id' => null,
                'path' => $path,
                'url' => $data->getWebUrl(),
                'name' => $data->getOriginalName(),
            ]
        );
        
        return $response;
    }
    
    private function createUploadFile(UploadData $data) 
    {
        $uploadFile = new UploadFile();
        $uploadFile->setPath($data->getWebUrl());
        
        $token = $this->securityContext->getToken();
        
        if ($token instanceof TokenInterface) {
            $user = $token->getUser();
            
            if ($user instanceof UserInterface) {
                $uploadFile->setCreatedBy($user);
            }
        }
        
        $this->om->persist($uploadFile);
        $this->om->flush();
        
        return $uploadFile;
    }
}