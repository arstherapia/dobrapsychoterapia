<?php

namespace MES\APP\FrontendBundle\Command;

use DateInterval;
use DateTime;
use MES\APP\FrontendBundle\Entity\UploadFile;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Bronisław Białek <bronislaw.bialek@gowork.pl>
 */
class CleanupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('gw:upload:cleanup')->setDescription('Czyści wgrane pliki, które nie były wykorzystane.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $repo = $em->getRepository('GoWorkFrontendUploadBundle:UploadFile');
        
        $olderThan = new DateTime();
        $olderThan->sub(new DateInterval('PT1H'));
        $filesToRemove = $repo->findFilesOlderThan($olderThan);
        
        $dir = $this->getContainer()->getParameter('kernel.root_dir') . '/../web/';
        
        foreach ($filesToRemove as $file) {
            /* @var $file UploadFile */
            $path = $dir . $file->getPath();
            
            if (file_exists($path)) {
                unlink($path);
            }
            
            $em->remove($file);
        }
        
        $em->flush();
    }
}
