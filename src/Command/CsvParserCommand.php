<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity\Beer;
use App\Repository\BeerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CsvParserCommand extends Command
{
    private $container;

    protected static $defaultName = 'app:parse';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine')->getManager();
        $beers = $this->container->get('doctrine')->getRepository(Beer::class);

        // $path = realpath($this->get('kernel')->getRootDir() . '/open-beer-database.csv');
        $flush = 0;
        if (($handle = fopen("open-beer-database.csv", "r")) !== FALSE) {
            $header = fgetcsv($handle, 0, ";");
            print_r($header);
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (count($data) == 22) {
                    $beer = $beers->createFromArray($data);
                    if ($beer) {
                        $em->persist($beer);
                        if (++$flush >= 100) {
                            $em->flush();
                            $flush = 0;
                        }
                    }
                } else {
                //     print_r($data);
                //     die;
                }
            }
            fclose($handle);
        }

        return Command::SUCCESS;
    }
}
