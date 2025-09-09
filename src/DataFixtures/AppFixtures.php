<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\PriceOffer;
use App\Entity\Sport;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\bg_BG\PhoneNumber;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setFirstName('Abderrahmane');
        $user->setLastName('AYYADI');
        $user->setAdress1('7 Résidence des Acacias');
        $user->setPostalCode('78360');
        $user->setCity('Montesson');
        $user->setCountry('FRANCE');
        $user->setPhoneNumber('0658452564');
        $user->setEmail('abdel.ayyadi@gmail.com');
        $user->setPassword('aaaaaaaaaa');
        $user->setPlainPassword('aaaaaaaaaa');
        $user->setRoles(['ROLE_USER']);            
        $manager->persist($user);

        $sport = new Sport();
        $sport->setName('L’athlétisme');
        $sport->setImage('athletisme.png');
        $sport->setTitle('L’athlétisme est un sport qui comprend de nombreuses épreuves impliquant la course, le saut, le lancer ou la marche.');
        $sport->setDescription('L’athlétisme et les Jeux Olympiques : 
                                Les Jeux Olympiques de l’Antiquité disposaient dans leur programme d’un certain nombre d’épreuves d’athlétisme que les passionnés 
                                d’aujourd’hui reconnaîtraient, comme la course, le saut en longueur, le lancer de poids et de javelot. À l’occasion des premiers 
                                Jeux Olympiques de l’ère moderne d’Athènes 1896, l’athlétisme avait une part déjà prédominante dans le programme, avec des épreuves 
                                sur piste allant du 100m au 1500m en passant par le marathon, et des épreuves telles que le saut en longueur et le saut à la perche. 
                                À Tokyo 2020, les athlètes ont pris part à 26 épreuves, soit le même nombre que celui du programme de Paris 2024.');
        $manager->persist($sport);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Samedi 05 juin - Matin');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-05 08:00:00'));
        $event->setLocation('Stade de France');
        $event->setSport($sport);
        $event->setTicketPrice(70.00);
        $event->setProgramEvent(['8h00 : 35 km marche hommes - Finale', 
                                '8h00 : 35 km marche femmes - Finale', 
                                '9h00 : Lancer de disque femmes - Qualifications groupe A',
                                '10h55 : Lancer de poids hommes - Qualifications', 
                                '10h55 : Lancer de disque femmes - Qualifications groupe B', 
                                '11h23 : 100 m hommes - Tour préliminaire, 11h55 : 4x400 m mixte - Séries'
                                ]);
        $manager->persist($event);
        
        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Samedi 05 juin - Soir');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-05 18:00:00'));
        $event->setLocation('Stade de France');
        $event->setSport($sport);
        $event->setTicketPrice(80.00);
        $event->setProgramEvent(['19h35 : 400 m haies hommes - Séries',
                                '19h40 : Saut en longueur hommes - Qualifications', 
                                '20h10 : Saut à la perche hommes - Finale', 
                                '20h20 : 110 m haies hommes - Séries', 
                                '21h00 : Lancer de marteau femmes - Finale', 
                                '21h05 : 100 m haies femmes - Demi-finales', 
                                '21h30 : 1 500 m hommes - Demi-finales', 
                                '21h55 : 3 000 m steeple hommes - Finale', 
                                '22h20 : 100 m haies femmes - Finale', 
                                '11h55 : 4x400 m mixte - Séries'
                                ]);
        $manager->persist($event);

        $sport = new Sport();
        $sport->setName('La natation');
        $sport->setImage('natation.png');
        $sport->setTitle('La natation est un sport aussi bien individuel que d’équipe dans lequel les concurrents propulsent leur corps dans l’eau d’une piscine, 
                            en salle ou en plein air, en utilisant l’une des nages suivantes : nage libre, dos, brasse et papillon.');
        $sport->setDescription('La natation est l’un des plus anciens sports de l’histoire olympique, elle qui a été présente à chaque édition des Jeux de l’ère moderne depuis 
                                Athènes 1896. Les femmes ont été intégrées à la compétition à partir de Stockholm 1912, alors que les relais mixte quatre nages ont connu leurs 
                                débuts olympiques à Tokyo 2020. L’épreuve individuelle la plus courte des Jeux Olympiques est le 50m nage libre, tandis que la course 
                                la plus courte de dos, brasse et papillon est le 100m. Les États-Unis sont la nation la plus titrée de l’histoire avec un total de 257 médailles 
                                d’or après Tokyo 2020, loin devant l’Australie, deuxième avec ses 69 titres olympiques. Le nageur olympique masculin le plus titré de tous les temps 
                                est l’Américain Michael Phelps qui, avec ses 23 médailles d’or (dont 13 titres individuels) et 28 médailles au total, est également l’olympien le plus 
                                décoré de tous les temps toutes disciplines confondues. Sa compatriote Katie Ledecky est pour sa part la nageuse olympique la plus médaillée de tous 
                                les temps, avec ses sept titres olympiques (dont six en individuel) et ses 10 médailles au total. Après l’athlétisme, la natation est le deuxième sport 
                                le plus important du programme olympique de Paris 2024 en termes d’épreuves décernant des médailles, avec 35.');
        $manager->persist($sport);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Dimanche 10 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-01 10:00:00'));
        $event->setLocation('Piscine Olympique');
        $event->setSport($sport);
        $event->setTicketPrice(90.50);
        $event->setProgramEvent(['19h35 : Séries du 400 m 4 nages',
                                '19h40 : Finale du 400 m 4 nages',
                                '20h10 : Séries du 200 m 4 nages', 
                                '20h20 : Demi-finales du 200 m 4 nages', 
                                '21h00 : Finale du 200 m 4 nages', 
                                '21h05 : 50 m nage libre', 
                                '21h30 : 100 m nage libre', 
                                '21h55 : 50 m brasse', 
                                '22h20 : 100 m brasse', 
                                '11h55 : 200 m brasse'
                                ]);
        $manager->persist($event);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Dimanche 11 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-01 10:00:00'));
        $event->setLocation('Piscine Olympique');
        $event->setSport($sport);
        $event->setTicketPrice(110.50);
        $event->setProgramEvent(['19h35 : 50 m papillon', 
                                '19h40 : 100 m papillon', 
                                '20h10 : Séries 200 m quatre nages', 
                                '20h20 : 200 m dos', 
                                '21h00 : Finale du 200 m 4 nages', 
                                '21h05 : 50 m nage libre', 
                                '21h30 : 100 m nage libre', 
                                '21h55 : 50 m brasse', 
                                '22h20 : 100 m brasse', 
                                '11h55 : 200 m brasse'
                                ]);
        $manager->persist($event);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Lundi 12 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-12 10:00:00'));
        $event->setLocation('Piscine Olympique');
        $event->setSport($sport);
        $event->setTicketPrice(90.50);
        $event->setProgramEvent(['10h30 : 50 m papillon', 
                                '10h40 : 100 m papillon', 
                                '11h10 : Séries 200 m quatre nages', 
                                '12h20 : 200 m dos', 
                                '13h00 : Finale du 200 m 4 nages', 
                                '13h05 : 50 m nage libre', 
                                '13h30 : 100 m nage libre', 
                                '14h55 : 50 m brasse', 
                                '15h20 : 100 m brasse', 
                                '16h55 : 200 m brasse'
                                ]);
        $manager->persist($event);

        $sport = new Sport();
        $sport->setName('Le football');
        $sport->setImage('football.png');
        $sport->setTitle('Le football est le sport le plus populaire au monde. 
                            Dans la pratique, deux équipes adverses composées de 11 joueurs tentent de marquer dans le but adverse en utilisant principalement leurs pieds.');
        $sport->setDescription('Le football et les Jeux Olympiques : 
                                Le football a fait ses débuts olympiques à Paris 1900 et a répondu présent à chaque édition des Jeux depuis lors, à l’exception de Los Angeles 1932.
                                Les joueurs professionnels ont été admis pour la toute première fois à Los Angeles 1984, avec certaines restrictions, tandis que depuis Barcelone 1992, 
                                le tournoi est réservé aux joueurs de moins de 23 ans. Quatre ans plus tard, à Atlanta, trois joueurs plus âgés ont été autorisés à intégrer une équipe, 
                                ce qui demeure encore aujourd’hui la situation en matière d’éligibilité. Atlanta 1996 a également marqué la grande première du football féminin aux 
                                Jeux Olympiques, les États-Unis remportant le premier titre. Depuis lors, Team USA s’est adjugé quatre des sept compétitions olympiques de football féminin.');
        $manager->persist($sport);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Dimanche 10 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-10 10:00:00'));
        $event->setLocation('Stade La Beaujoire - Nantes');
        $event->setSport($sport);
        $event->setTicketPrice(90.50);
        $event->setProgramEvent(['Match de poule A', 
                                '16h00 : Maroc - Argentine'
                                ]);
        $manager->persist($event);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Dimanche 10 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-10 10:00:00'));
        $event->setLocation('Stade Véllodrome - Marseille');
        $event->setSport($sport);
        $event->setTicketPrice(60.00);
        $event->setProgramEvent(['Match de poule B', 
                                '20h00 : France - Espagne'
                                ]);
        $manager->persist($event);
        
        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Samedi 09 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-10 10:00:00'));
        $event->setLocation('Groupama Sadium - Lyon');
        $event->setSport($sport);
        $event->setTicketPrice(50);
        $event->setProgramEvent(['Match de poule C', 
                                '18h00 : Allemagne - Belgique'
                                ]);
        $manager->persist($event);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Samedi 09 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-10 10:00:00'));
        $event->setLocation('Roazhon Park - Rennes');
        $event->setSport($sport);
        $event->setTicketPrice(50);
        $event->setProgramEvent(['Match de poule D', 
                                '18h00 : Italie - Pays-Bas'
                                ]);
        $manager->persist($event);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Lundi 12 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-12 10:00:00'));
        $event->setLocation('Roazhon Park - Rennes');
        $event->setSport($sport);
        $event->setTicketPrice(50);
        $event->setProgramEvent(['Match de poule D', 
                                '18h00 : Portugal - Angleterre'
                                ]);
        $manager->persist($event);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Samedi 09 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-10 10:00:00'));
        $event->setLocation('Stade Océane - Le Havre');
        $event->setSport($sport);
        $event->setTicketPrice(50);
        $event->setProgramEvent(['Match de poule E', 
                                '18h00 : Ghana - Croatie'
                                ]);
        $manager->persist($event);

        $event = new Event();
        $event->setName($sport->getName());
        $event->setTitle('Lundi 12 juillet');
        $event->setDateEvent(new \DateTimeImmutable('2024-07-12 10:00:00'));
        $event->setLocation('Stade de la Meinau - Strasbourg');
        $event->setSport($sport);
        $event->setTicketPrice(50);
        $event->setProgramEvent(['Match de poule E', 
                                '18h00 : Mexique - Japon'
                                ]);
        $manager->persist($event);

        $sport = new Sport();
        $sport->setName('Le handball');
        $sport->setImage('handball.png');
        $sport->setTitle('Le handball est un sport en salle rapide dans lequel deux équipes tentent de marquer en lançant le ballon dans la cage adverse, comme au football, 
                            formée par des poteaux et une barre transversale..');
        $sport->setDescription('Le handball à onze n’a fait qu’une seule apparition officielle aux Jeux, lors de ceux de Munich 1972, même s’il a été un sport de démonstration 
                                à Helsinki 1952. Le handball en salle a été présenté pour la première fois à Munich 1972 avec le sacre de la Yougoslavie dans un tournoi masculin 
                                à 16 équipes. Le handball féminin a intégré le programme olympique lors des Jeux de 1976, l’Union soviétique récoltant la médaille d’or chez les 
                                femmes comme chez les hommes à Montréal. Au cours des Jeux précédents, toutes les médailles ont été remportées par des nations européennes, 
                                à l’exception notable de la République Corée, sacrée chez les femmes à Séoul 1988 et à Barcelone 1992, et en argent chez les hommes à Séoul. 
                                Le Danemark a décroché trois médailles d’or de rang chez les femmes entre Atlanta 1996 et Athènes 2004, mais c’est bien la France qui s’est imposée à Tokyo 2020. 
                                Les Français ont également décroché l’or chez les hommes à Tokyo grâce à leur succès sur les champions olympiques en titre danois en finale pour 
                                s’assurer leur troisième titre en quatre Jeux.');
        $manager->persist($sport);

        $sport = new Sport();
        $sport->setName('Le basketball');
        $sport->setImage('basketball.png');
        $sport->setTitle('Le basketball est un sport d’équipe pratiqué sur un terrain rectangulaire, sur lequel deux équipes composées de cinq joueurs s’affrontent et tentent de 
                            marquer en lançant le ballon dans le cerceau et le filet de l’adversaire, à savoir dans le panier.');
        $sport->setDescription('Le basketball a fait ses débuts olympiques à St. Louis 1904 en tant que sport de démonstration, avant que le tournoi masculin ne soit formellement 
                                introduit aux Jeux Olympiques de Berlin 1936. Le tournoi de basketball féminin a ensuite rejoint le programme olympique à partir des Jeux de Montréal 1976.
                                Les États-Unis ont historiquement dominé le basketball international. Pour preuve, ils ont remporté tous les titres olympiques masculins jusqu’en 1972, année où ils 
                                ont été battus par l’Union soviétique aux Jeux de Munich. Chez les femmes, les Soviétiques ont remporté l’or en 1976, 1980 et 1992, avant que les Américaines ne prennent 
                                le relais et ne s’imposent à toutes les éditions des Jeux de 1984 à 2020, à l’exception donc de celle de 1992. Aux Jeux de Barcelone 1992, les joueurs professionnels de 
                                la National Basketball Association (NBA) ont pour la première fois été autorisés à représenter leur sélection nationale. L’équipe de 1992 des États-Unis a ainsi reçu 
                                le surnom de « Dream Team » de la part des médias internationaux, elle qui est toujours considérée comme la plus grande équipe de basketball de tous les temps. 
                                Elle a conquis le public mondial et a survolé le tournoi olympique de 1992. Depuis lors, les joueurs professionnels ont toujours continué à être autorisés à prendre 
                                part aux Jeux. Depuis Tokyo 2020 en 2021, une seconde compétition de basketball, le 3x3, a été introduit comme sport olympique.');
        $manager->persist($sport);

        $sport = new Sport();
        $sport->setName('Le volleyball');
        $sport->setImage('volleyball.png');
        $sport->setTitle('Le volleyball est un sport pratiqué sur un terrain par deux équipes de six joueurs. Initialement, ce sport était nommé « Mintonette », 
                        un nom dérivé du badminton, en raison de sa ressemblance avec cette discipline.');
        $sport->setDescription('Le volleyball est apparu pour la première fois aux Jeux Olympiques comme un sport de démonstration à Paris 1924. Il a dû attendre 
                                les Jeux Olympiques de Tokyo 1964 avant d’être officiellement inscrit au programme olympique, avec des compétitions chez les femmes 
                                et chez les hommes qui n’ont plus cessé d’y figurer depuis lors.');
        $manager->persist($sport);

        $sport = new Sport();
        $sport->setName('Le judo');
        $sport->setImage('judo.png');
        $sport->setTitle('Le judo est un art martial japonais qui repose sur des techniques de projection et de lutte qui permettent de maîtriser l’adversaire, avec un focus mis sur 
                            la condition physique, la discipline mentale et l’esprit sportif.');
        $sport->setDescription('Le judo a fait sa toute première apparition aux Jeux Olympiques de Tokyo 1964. Cependant, absent du programme olympique de Mexico 1968, il y revient 
                                pour ne plus jamais le quitter lors des Jeux de Munich 1972. Le judo féminin a dû attendre les Jeux de Barcelone 1992 pour faire son apparition. 
                                Les femmes comme les hommes concourent désormais dans sept catégories de poids. Initialement, une catégorie masculine était ouverte à tous les poids, 
                                cette épreuve étant finalement retirée après les Jeux de Los Angeles 1984. Le Japon est la nation la plus titrée des de l’histoire olympique avec un 
                                total de 96 médailles, dont 48 en or. La France et la Corée du Sud le suivent avec respectivement 57 et 46 médailles. 
                                La Russie, la Géorgie, l’Italie et le Brésil sont d’autres nations aux illustres passés olympiques.');
        $manager->persist($sport);

        $sport = new Sport();
        $sport->setName('La boxe');
        $sport->setImage('boxe.png');
        $sport->setTitle('La boxe est une forme de combat à mains nues où un athlète essaye de porter des coups de poing à la tête ou au corps (au-dessus de la taille) de son 
                            adversaire afin de marquer des points, décomptés par les juges, ou de faire en sorte que son adversaire soit incapable de poursuivre le combat.');
        $sport->setDescription('La boxe a fait ses débuts olympiques à St. Louis 1904 et, à l’exception de Stockholm 1912, où ce sport était illégal à l’époque en Suède, 
                                a été présente à chaque édition des Jeux. La boxe féminine a été introduite à Londres 2012 avec seulement trois catégories de poids. Depuis, 
                                ce nombre de catégories de poids a progressivement augmenté quand celui des hommes n’a cessé de diminuer. Cuba et les États-Unis sont les deux 
                                puissances historiques de la boxe olympique, même si la Grande-Bretagne et la Russie ne sont pas en reste. La Grande-Bretagne, 
                                l’Irlande et les États-Unis sont jusqu’à présent les nations les plus titrées de l’histoire de la boxe olympique féminine.');
        $manager->persist($sport);

        $sport = new Sport();
        $sport->setName('Le karaté');
        $sport->setImage('karate.png');
        $sport->setTitle('Le karaté est un art martial japonais qui utilise des techniques de frappe avec les mains, les pieds, les coudes et les genoux, 
                            ainsi que le blocage et le grappin, ce pour développer la discipline physique et mentale.');
        $sport->setDescription('Le karaté et les Jeux Olympiques : le karaté a fait ses débuts olympiques à Tokyo 2020 après avoir été inscrit au programme des 
                                Jeux Olympiques de la Jeunesse de Buenos Aires 2018. À Tokyo, le sport a proposé les épreuves de Kumite et Kata, avec 80 athlètes prenant part 
                                aux compétitions, ces derniers étant répartis de façon égale entre hommes et femmes. La compétition olympique s’est déroulée dans le légendaire 
                                Nippon Budokan de Tokyo, qui est considéré comme le centre névralgique des pratiquants et amoureux d’arts martiaux.');
        $manager->persist($sport);

        $sport = new Sport();
        $sport->setName('La gymnastique');
        $sport->setImage('gymnastique.png');
        $sport->setTitle('Introduite en 1894, la gymnastique artistique était l’une des disciplines des premiers Jeux Olympiques de l’ère moderne. 
                            Les gymnastes artistiques doivent développer leurs compétences sur des agrès, comme la poutre ou le sol.');
        $sport->setDescription('LLa gymnastique artistique et les Jeux Olympiques La gymnastique artistique a été introduite lors des tous premiers Jeux Olympiques 
                                de l’ère moderne d’Athènes 1896 et, depuis lors, a été présente à chaque édition des Jeux. À ses débuts, elle comprenait des disciplines 
                                difficilement qualifiables comme « artistiques », telles que l’escalade et l’acrobatie. Les bases du programme olympique de gymnastique 
                                ont été posées aux Jeux de Paris 1924, avec l’apparition des compétitions masculines aux agrès, en individuel et par équipes. 
                                En 1928, les femmes ont été intégrées aux Jeux d’Amsterdam. Et ce n’est qu’à partir de 1952 que le programme féminin s’est développé, 
                                avec sept épreuves, avant de se stabiliser à six épreuves à partir des Jeux de Rome 1960.');
        $manager->persist($sport);

        $sport = new Sport();
        $sport->setName('L’escrime');
        $sport->setImage('escrime.png');
        $sport->setTitle('L’escrime est un sport de combat dans lequel deux athlètes utilisent des armes blanches pour s’attaquer et se défendre dans le but de frapper son 
                        adversaire et, donc, de marquer des points. Les trois disciplines de l’escrime moderne sont le fleuret, l’épée et le sabre. Chaque discipline utilise un 
                        type de lame différent (qui porte le même nom) et a ses propres règles.');
        $sport->setDescription('L’escrime et les Jeux Olympiques : L’escrime est l’un des cinq sports à toujours avoir fait partie intégrante du programme olympique depuis les 
                                tous premiers Jeux Olympiques de l’ère moderne en 1896. Lors de ces Jeux d’Athènes 1896, seules trois épreuves ont été disputées 
                                (fleuret masculin en individuel, sabre masculine en individuel et fleuret pour maîtres d’armes). Désormais, ce nombre est passé à 12, 
                                vec des compétitions en individuel et par équipe dans chaque discipline pour les femmes et les hommes.');
        $manager->persist($sport);

        $sport = new Sport();
        $sport->setName('Le Patinage');
        $sport->setImage('patinage.png');
        $sport->setTitle('Le patinage artistique, comme son nom l’indique, consiste à patiner tout en réalisant des « figures artistiques » sur la glace. Ce sport exige de 
                            ses pratiquants qu’ils exécutent des mouvements, ou des figures, dans le cadre de leurs enchaînements.');
        $sport->setDescription('L’histoire oylmpique du patinage artistique Le patinage artistique est le plus ancien sport au programme des Jeux d’hiver. 
                                Il était déjà présent aux JO de Londres 1908 (en été) puis à nouveau à ceux d’Anvers 1920 (également en été), avant même la création des Jeux Olympiques 
                                d’hiver. Le patinage artistique masculin, féminin et en couple ont été les trois épreuves au programme jusqu’en 1972. Depuis 1976, la danse sur glace 
                                est la quatrième épreuve du programme. Sonja Henie a fait ses débuts olympiques à Chamonix 1924 à tout juste 11 ans. Elle était si nerveuse qu’elle a dû 
                                demander à son entraîneur quoi faire en plein milieu de ses enchaînements. Toutefois, elle a remporté l’or des trois Jeux Olympiques suivants tout en se 
                                construisant une énorme popularité. Elle s’est ensuite tournée vers le cinéma, où elle a considérablement participé à la notoriété de son sport. 
                                Dick Button et Hanyu Yuzuru sont les seuls hommes à avoir remporté deux médailles d’or olympiques consécutives dans ce sport.');
        $manager->persist($sport);

        
        $priceOffer = new PriceOffer();
        $priceOffer->setName('Solo');
        $priceOffer->setNumberPerson(1);
        $priceOffer->setRateDiscount(0);
        $manager->persist($priceOffer);

        $priceOffer = new PriceOffer();
        $priceOffer->setName('Duo');
        $priceOffer->setNumberPerson(2);
        $priceOffer->setRateDiscount(5);
        $manager->persist($priceOffer);

        $priceOffer = new PriceOffer();
        $priceOffer->setName('Famille');
        $priceOffer->setNumberPerson(4);
        $priceOffer->setRateDiscount(10);
        $manager->persist($priceOffer);

        $manager->flush();

    }

    

}


