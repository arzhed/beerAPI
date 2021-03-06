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

    protected function convertData(array $data) {
        return [
            'name'        => $data[0],
            'id'          => $data[1],
            'abv'         => $data[5],
            'ibu'         => $data[6],
            'description' => $data[10],
            'last_mod'    => $data[12],
            'created_at'  => $data[12],
            'style'       => $data[13],
            'category'    => $data[14],
            'brewery'     => $data[15],
            'address'     => $data[16],
            'city'        => $data[17],
            'state'       => $data[18],
            'country'     => $data[19],
            'coordinates' => $data[20],
            'website'     => $data[21]
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine')->getManager();
        $beers = $this->container->get('doctrine')->getRepository(Beer::class);
        $categories = $this->container->get('doctrine')->getRepository(Category::class);
        $styles = $this->container->get('doctrine')->getRepository(Style::class);
        $breweries = $this->container->get('doctrine')->getRepository(Brewery::class);

        $flush = 0;
        $count = 0;

        if (($handle = fopen("open-beer-database.csv", "r")) !== FALSE) {
            $header = fgetcsv($handle, 0, ";");
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                if ($count % 100 == 0) {
                    echo $count . PHP_EOL;
                }

                if (count($data) == 22) {
                    $data = $this->convertData($data);
                    $cat = $categories->findOrCreate($data['category']);
                    $style = $styles->findOrCreate($data['style']);
                    $brewer = $breweries->findOrCreateFromArray($data);
                    $beer = $beers->createFromArray($data, $brewer, $cat, $style);

                    if ($beer) {
                        $em->persist($beer);
                    }

                    if (++$flush >= 500 || $cat || $style) {
                        $em->flush();
                        $flush = 0;
                    }
                }
                $count++;
            }
            fclose($handle);
        }

        return Command::SUCCESS;
    }
}
