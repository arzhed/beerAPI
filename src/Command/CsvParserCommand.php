<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Entity\Beer;
use App\Entity\Brewery;
use App\Entity\Category;
use App\Entity\Style;
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
        $categories = $this->container->get('doctrine')->getRepository(Category::class);
        $styles = $this->container->get('doctrine')->getRepository(Style::class);
        $breweries = $this->container->get('doctrine')->getRepository(Brewery::class);

        // $path = realpath($this->get('kernel')->getRootDir() . '/open-beer-database.csv');
        $flush = 0;
        $count = 0;

        if (($handle = fopen("open-beer-database.csv", "r")) !== FALSE) {
            $header = fgetcsv($handle, 0, ";");
            print_r($header);
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                if ($count % 100 == 0) {

                    echo $count . PHP_EOL;
                }

                if (count($data) == 22) {

                    $cat = $categories->findOrCreate($data[14]);
                    $style = $styles->findOrCreate($data[13]);
                    $brewer = $breweries->findOrCreateFromArray($data);
                    $beer = $beers->createFromArray($data, $brewer, $cat, $style);

                    if ($beer) {
                        $em->persist($beer);
                    }

                    if (++$flush >= 500 || $cat || $style) {
                        $em->flush();
                        $flush = 0;
                    }
                } else {
                //     die;
                }
                $count++;
            }
            fclose($handle);
        }

        return Command::SUCCESS;
    }
}
