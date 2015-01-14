<?php

namespace Frontend\OrderBundle\Services;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Frontend\OrderBundle\Entity\MesOrder;
use Frontend\OrderBundle\Entity\OrderState;
use MES\SecurityBundle\Security\MesUserInterface;
use MES\UserBundle\Entity\MesCompany;
use MES\UserBundle\Entity\MesProfile;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Description of OrderManager
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class OrderManager {

    /**
     *
     * @var EntityManager
     */
    private $em;

    /**
     *
     * @var SecurityContext
     */
    private $securityContext;

    public function __construct(EntityManager $em, SecurityContext $securityContext) {
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    public function handleOrder(MesProfile $profile, ArrayCollection $products, $email, MesUserInterface $user = null, MesCompany $company = null) {
        $order = new MesOrder();
        $order
                ->setBuilding($profile->getBuildingNumber())
                ->setDateCreated(new DateTime())
                ->setName($profile->getName())
                ->setPostalCode($profile->getPostalCode())
                ->setStreet($profile->getStreet())
                ->setSurname($profile->getSurname())
                ->setTown($profile->getCity())
                ->setOrderState($this->getOrderState(OrderState::RECIVED))
                ->setPhone($profile->getTelephone())
        ;
        if ($user instanceof MesUserInterface) {
            $order->setEmail($user->getEmail());
            $user->addMesUserOrder($order);
            $order->addMesUser($user);
        }else{
            $order->setEmail($email);
        }
        if($company){
            $order->setCompany($this->companyToArray($company));
        }
        foreach ($products as $product) {
            $order->addOrderProduct($product);
        }
        return $order;
    }

    private function companyToArray(MesCompany $company){
        return [
            'name' => $company->getName(),
            'nip' => $company->getNip(),
            'street' => $company->getStreet(),
            'buildingNumber' => $company->getBuildingNumber(),
            'apartmentNumber' => $company->getApartmentNumber(),
            'postalCode' => $company->getPostalCode(),
            'city' => $company->getCity(),
            'telephone' => $company->getTelephone()
        ];
    }

    public function saveOrder(MesOrder $order){
        $this->em->persist($order);
        $this->em->flush();
        return $this;
    }
    
    public function getOrderState($orderStateId = OrderState::RECIVED) {
        return $this->em->getRepository('Frontend\OrderBundle\Entity\OrderState')->findOneBy(['id' => $orderStateId]);
    }

}
