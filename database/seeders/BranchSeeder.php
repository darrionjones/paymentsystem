<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $absa_branches = [
            'Berekum', 'Swedru', 'Somanaya', 'AANDCMALL', 'ACCRAMALL', 'ABEKALAPAZ', 'DANSOMAN', 'GNPC', 'NIMA', 'LEGON',
            'ACHIMOTA', 'OSU', 'RINGROADCENTRAL', 'MOTORWAYEXT', 'SPINTEXMAIN', 'KNUTSFORDAVENUE', 'LEGONMAIN',
            'TEMAFISHINGHABOUR', 'MAKOLASQUARE', 'AIRPORTCITY', 'CIRCLE', 'HIGHSTREET', 'AVENUECENTRAL', 'TEMAMAIN',
            'HEADOFFICE', 'DARKUMAN', 'INDEPENDENCEAVENUE', 'ASAIMAN', 'KANESHIE', 'MATAHEKO', 'KOFORIDUA', 'ODA', 'NSAWAM',
            'CAPECOAST', 'OBUASI', 'HIGHSTEET-TAKPRADI', 'LIBERATIONROAD-TAKORADI', 'TARKWA', 'HO', 'ASAFO',
            'PREMPEH11STREET', 'KEJETIA-KUMASI', 'KROFOM', 'TANOSO', 'AHODWO', 'TECHIMAN', 'SUNYANI', 'TAMALE', 'BOLGATANGA',
            'ASANKRAGUA', 'KASOA', 'TARKWAMINES', 'IRECTSALES', 'SOPINTEXPRESTIGE', 'ACCRACORPORATESERVICECENTRE', 'NKAWKAW',
            'BCM', 'MNEWSUAMEMAGAZINE', 'AGOGO', 'GOASO', 'SMECENTRE', 'AGNOBLOSHIE', 'MADINA', 'WINNEBA', 'ADUM', 'MANKESIM',
            'TESHIENUNGUA', 'ACCRANEWTOWM', 'DOME', 'AFLAO', 'BANTAMA', 'SEFWI-WIASO', 'KONONGO', 'ATEBUBU', 'WEIJA', 'HAATSO',
            'WA', 'TEMAOILREFINERY', 'OFFSHOREBANKING', 'ADENTA', 'ABOSSEYOKAI', 'KOTOBABI', 'PALMWINEJUNCTION', 'WLUBO',
            'TWIFOPRASO', 'GUMANI', 'HOHOE',
        ];

        foreach ($absa_branches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 1,
            ]);
        }

        $access_branch = [
            'HEADOFFICE-STARLET91ROAD', 'ABEKALAPAZBRANCH', 'ACCRANEWTOWN', 'ACHIMOTA', 'IRIS', 'ATUMINI', 'ALAJO(AGENCY)',
            'AHAIMAN', 'CASTLEROAD', 'ADIRINGANOR', 'DARKUMAN', 'EASTCANTONMENT', 'GHANAAIRPORTCARGOCENTRE', 'HAATSO',
            'KANESHIE', 'KANESHIEPOSTOFFICE', 'KANTAMANTO', 'LASHIBI', 'LEGON', 'MADINA', 'NIMA', 'NIMA(AGENCY)',
            'NORTHINDUSTRIALAREA', 'ODORKOR', 'OSUOXFORDSTREET', 'OSUWATSONHOUSE', 'OKAISHIE', 'RINGROADCENTRAL',
            'SOUTHINDUSTRIALAREA', 'SPINTEXROAD', 'TEMACOMMUINITY1', 'TEMAINDUSTRIALAREA', 'TEMAMAIN', 'UPSA', 'OCTAGON',
            'UPSADIGITAL', 'ALABAR', 'SUAME', 'NEWAMAKOM', 'ADUM', 'KNUST', 'KEJETIA-KUMASI', 'aHODWO', 'ENCHI',
            'SEFWI-WIASO', 'TAKORADIMARKETCIRCLE', 'TARKWABRANCH', 'KASOA', 'KASOA(AGENCY)', 'TAMALE-NORTHERNREGION',
            'TECHIMAN', 'KOFORIDUA', 'HO', 'BOLGATANGA', 'WA',
        ];

        foreach ($access_branch as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 2,
            ]);
        }

        $adb_branches = [
            'ABEKALAPAZBRANCH', 'ACCRANEWTOWM', 'ACHIMOTA', 'ADABRAKA', 'ADBHOUSE', 'ADBBANKBURMACAMPATM', 'DANSOMAN',
            'GULFHOUSE', 'KANESHIE', 'WEIJA', 'KORLEBUATM', 'LABONEJUNCTION', 'LEGONCAMPUSATM', 'MADINA', 'MAKOLA', 'NIMA',
            'NUNGUA', 'OSU', 'RIDGEBRANCH', 'RINGROADCENTRAL', 'SPINTEXROAD', 'TEMAEAST', 'TEMAMAINBRANCH', 'TEMAMANKOADZE',
            'TEMAMERIDIAN', 'TESHIE', 'BUKOMARENAAGENCY', 'DIAMONDHOUSE', 'BEKWAI', 'KNUSTATM', 'ADUM', 'EJISU',
            'KUMASIMARKET', 'KUMASIPREMPEH11STREET,ADUM', 'NEWEDUBIASE', 'NHYIAESO', 'OBUASI', 'AGONASWEDRU', 'ASSINFOSU',
            'CAPECOASTMAIN', 'KASOA', 'MANKESIM', 'UNIVERSITYOFCAPECOAST(UCC)CAMPUS', 'WINNEBAATM', 'ASIAKWA', 'JADE',
            'KOFORIDUA', 'KOFORIDUATECHNICALUNIVERSITYAGENCY', 'NKAEKAW', 'SUHUM', 'BAWKU', 'BOLGATANGA', 'NAVRONGO', 'WA',
            'TUMU', 'GOASO', 'KENYASI', 'KWAPONG', 'TECHIMAN', 'NKORANZA', 'ATEBUBU', 'SUNYANI', 'DOMAAAHENKTAO',
            'BerekumBranch', 'DENU', 'HO', 'HOHOE', 'JUAPONG', 'KPEVEBRANCH', 'KPANDO', 'SOGAKOPE', 'NKWANTA', 'SAVELUGU',
            'ABOABO', 'TAMALEMAIN', 'TAMALWKALADAN', 'YENDIBRANCH', 'WALEWALE', 'BOLE', 'BUIPE', 'ENCHI', 'SEFWIESSAM',
            'BONSUNKWANTA', 'SEFWIWIAWSO', 'JUABOSOAGENCY', 'AGONANKWANTA', 'TAKORADI', 'GRELAPEMANI',
        ];

        foreach ($adb_branches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 3,
            ]);
        }

        $bank_of_africa = [
            'iOctagon', 'EastLegon', 'AccraCentral', 'AirportCity', 'BuisnessCentre', 'Dansoman', 'FarrarAvenue', 'Kwashiman',
            'MaamobiAccra', 'Tema', 'OperaSquare', 'Osu', 'TESHIENUNGUA', 'ABOSSEYOKAI', 'Spintex', 'MichelCamp', 'NewTown',
            'Adum', 'Amakom', 'Kejetia', 'Suame', 'Bolgatanga', 'Tamale', 'Takoradi', 'Wa', 'Madina', 'Ridge', 'Sokoban',
        ];

        foreach ($bank_of_africa as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 4,
            ]);
        }

        $callBankBranches = ['Achimota',
            'Airport City',
            'Dansoman',
            'Derby Avenue',
            'East Legon',
            'Graphic Road',
            'Accra',
            'Independence Avenue',
            'Labone',
            'Legon',
            'OSU OXFORD STREET',
            'RING ROAD CENTRAL',
            'Ring Road West',
            'Spintex Road',
            'TEMA COMMUNITY 1',
            'Tema Community 25',
            'Tema Industrial Area',
            'West Hills Mall',
            'Adum',
            'Asafo',
            'Kejetia',
            'Knust',
            'Nhyiaeso',
            'Suame',
            'Esiama',
            'Sekondi Road',
            'Takoradi Harbour',
            'Takoradi',
            'TAKORADI MARKET CIRCLE',
            'Tarkwa',
            'Tamale'];

        foreach ($callBankBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 5,
            ]);
        }
        $cbg_branch = [
            'ManetBuildingAirpot', 'AbboseyOkai', 'Abeka', 'OperaSquare', 'AccraCentral', 'Makola', 'AmericanHouse',
            'AnyaaMarket', 'AshaimanMarket', 'AshaimanMain', 'AshalleyBotwe', 'Ashiyea', 'DOME', 'Dzorwulu', 'EastLegon',
            'Gimpa', 'Kaneshie', 'KasoaMain', 'KasoaNewMarket', 'Korle-Bu', 'KorleDudor', 'Kwabenya', 'Labone', 'Lapaz',
            'Arena', 'Kokomlemle', 'Achimota', 'Adabraka', 'Adenta', 'AirpoortCity', 'ZongoJunction', 'madinaNewRoad',
            'MallamJunction', 'PigFam', 'Mamobi', 'NimaMain', 'NimaMarket', 'NORTHINDUSTRIALAREA', 'CASTLEROAD',
            'OxfordStreet', 'Pokuase', 'Ridge', 'Atomic', 'AtomicJunction', 'DansomanRound-About', 'DansomanExhibition',
            'DansomanRussiaRoad', 'DarkumanRoad', 'RomanHill', 'Sakumono', 'SouthLegon', 'Spintex', 'Baatsono',
            'TEMACOMMUINITY1', 'Temacommuinity25', 'Temacommunity2', 'tesano', 'Teshie', 'TradeFair', 'Tudu',
            'UniversityofGhana', 'Weija', 'Wisconsin', 'Zenu', 'SpintexBasketJunction', 'ALABAR', 'Asafo', 'Ashtown',
            'Asokwa', 'Atonsu', 'Bantama', 'KNUST', 'Nhyiaeso', 'Ejisu', 'Sokoban', 'SuameMaakro', 'SuameMottias', 'Tafo',
        ];

        foreach ($cbg_branch as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 6,
            ]);
        }

        $ecobankBranches = [
            'A&CMall', 'AccraMall', 'Labone', 'Tudu', 'SilverStarAirport', 'Katamanto', 'Dansoman', 'Legonmain', 'RingRoad',
            'Okponglo', 'Eastairport', 'osu', 'Madina', 'BurmaCamp', 'Kotababi', 'LegonAvandiHostel', 'Darkuman',
            'HarperRoad', 'Adum', 'Bantama', 'Tafo', 'StadiumAmacom', 'Kumasi', 'Abrepo', 'Kumasi-Cocobod', 'Maakro', 'Alao',
            'AdidogomeMadiba', 'Gdjagan', 'Ho', 'NewAbirem', 'TemaMotorway', 'Ashaiman', 'TakoradiharbourCommercialArea',
            'TakoradiMarketCircle', 'collinsStreet',
        ];

        foreach ($ecobankBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 7,
            ]);
        }

        $fbnBranches = [
            'Abosmankotereco-operativeCreditUnionKintampo',
            'Abosmankotereco-operativeCreditUnion,Sunyani',
            'Abosmankotereco-operativeCreditUnion,Techiman',
            'Achimota',
            'Adum',
            'AccraAirport',
            'Dansoman',
            'DOME',
            'Kaneshie',
            'KasoaAgency',
            'KasoaBranch',
            'Korle-BuTeachingHospital',
            'Korle-Bu',
            'KotokaInternationalAirport',
            'Makola',
            'Osu',
            'RINGROADCENTRAL',
            'SantaMaria',
            'Spintex1',
            'Spintex2',
            'Suame',
            'Swedru',
            'Takoradi',
            'Techiman',
            'Tema',
            'TexacoShellFillingStattion',
            'TipToeLaneAgency',
        ];
        foreach ($fbnBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 8,
            ]);
        }

        $fidelityBranches = [
            'Ho', 'Hohoe', 'Bolgatanga', 'Tamale', 'A&CMall', 'Abeka', 'AbboseyOkai', 'AccraCentral', 'AccraHighStrret',
            'Achimota', 'ActionChapelSpintexRoad', 'KwameNkrumahAvenueRoad', 'Adentan', 'AirportKoala', 'Ashaiman',
            'AshaimanMarket', 'DansomanMain', 'DOME', 'Dzorwulu', 'Haatso', 'IPSLegon', 'Kaneshie', 'KaneshieMarket',
            'Katamanto', 'Kokomlemle', 'KwameNkrumahAvenueRoad', 'Labone', 'Lapaz', 'Maamobi', 'MainaMarket', 'MadinaZongo',
            'MamprobiPost', 'NUngua', 'NunguaBrigade', 'Okaishie', 'OsuDanquahCircle', 'RegistrarGeneralsDepartment',
            'RidgeTower', 'RINGROADCENTRAL', 'Spintex', 'TemaCommuinity25', 'TemaMain', 'TemaSafeBond', 'Tesano',
            'TradeFair', 'TuduMain', 'Weija', 'Adum', 'AdumPost', 'AdumPZ', 'AdumSagoeLane', 'Ahodwo', 'Atonsu',
            'KoMethodist', 'Santasi', 'StadiumPost', 'SuameMain', 'TarkwaMaakro', 'Berekum', 'SunyaniMain', 'SunyaniPost',
            'Techiman', 'Koforidua', 'Nkawkaw', 'AssinFosu', 'CapeCoastUccNewSite', 'CapeCoast(Kotokoraba)', 'Kasoa',
        ];

        foreach ($fidelityBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 9,
            ]);
        }

        $firstAtlanticbranches = [
            'WestRidgeAccra', 'Airport,47PatriceLumumbaRoad', 'NorthRidge', 'ABEKALAPAZBRANCH', 'Weija', 'Kotobabi', 'Adum11',
            'Takoradi', 'Tamale', 'AccraCentral', 'AbbosseyOkai', 'MaxMart', 'TEMACOMMUINITY1', 'Ashaiman', 'Adum', 'Katamanto',
            'OSUOXFORDSTREET', 'NORTHINDUSTRIALAREA', 'EastLegon', 'TemaCentralMall', 'Suame', 'Nhyiaso', 'EastLegon-LagosAvenue',
            'Sakumono', 'akaman', 'Madina', 'RingRoad', 'Dzorwulu', 'Kasoa', 'Techiman', 'OsuMain', 'SpintexMain', 'TradeFair',
            'Manhyia', 'OsuMedium', 'TemaCommuinity25',
        ];

        foreach ($firstAtlanticbranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 10,
            ]);
        }

        $fnbBranches = [
            'Accra', 'JunctionShoppingCentre', 'AccraMall', 'AchimotaMallBranch', 'WestHillsMall', 'Makola', 'Tema',
        ];

        foreach ($fnbBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 11,
            ]);
        }

        $gcbBranches = [
            'Takoradimain', 'TakoradiHabour', 'TakoradiMarketCircle', 'Sekondi', 'Bogoso', 'Tarkwa', 'Prestea', 'Axim',
            'Half-Assini', 'Elubo', 'Dadieso', 'Enchi', 'Samreboi', 'Ho', 'Akatsi', 'HoMarket', 'Kadjebi', 'HoPolytechnic.',
            'Jasikan', 'Hohoe', 'Sogakope', 'Kpando', 'KrachiNkwanta', 'Aflao', 'Abor', 'Dzoze', 'Keta', 'Peki', 'Dambai',
            'Wa', 'Tumu', 'Lawra', 'Bawku', 'Bolgatanga', 'Navrongo', 'TamaleMain', 'TamaleHospitalRoad', 'TamaleMarket',
            'TamaleAboabo', 'Bimbilla', 'Damongo', 'Yendi', 'Bole', 'Walewale', 'Abelenkpe', 'AccraNewTown', 'BurmaCamp',
            'Labone', 'Dansoman', 'Kantamanto', 'Adabraka', 'AbboseyOkai', 'Okaishie', 'Dzoewulu', 'DOME',
            'KwameNkrumahCircle', 'KaneshieIndustrial', 'KaneshieMarket', 'Kasoamain', 'KasoaMarket', 'Kisseiman', 'Achimota',
            'Korle-Bu', 'Liberty', 'MakolaMarket', 'Ministries-Ghana', 'GCBNima', 'AirportCity', 'EastLegon', 'Osu',
            'OSUOXFORDSTREET', 'RepublicHouse', 'RingRoadwest', 'TantraHill', 'Abekalapaz', 'Tesano', 'MadinaZongoJunction',
            'TradeFair', 'TemaMain', 'TemaMarket', 'TemaCommuinity25', 'TemaIndustrialArea', 'TemaFishinhHabour',
            'Ashaiman', 'GulfHouse-TettehQuarshieCircle', 'Legoncampus', 'A&CMall', 'CentralUnviersityCollrge-CUC',
            'Madina', 'Spintex', 'MarteyTsuru', 'Nungua', 'TemaSafeBond', 'AshaimanMandelaPark', 'AdentaShoppingCentre',
            'Haatso', 'Adjiringanor', 'Amasaman', 'Weija', 'Agogo', 'Akimoda', 'Asamankese', 'Anyinam', 'Donkorkrom', 'Juaso',
            'Kade', 'Kibi', 'Koforidua', 'KoforiduaCentral', 'Konongo', 'Mpraeso', 'NewTafo', 'Nkawkaw', 'Nsawam', 'Suhum',
            'CapeCoastMain', 'CapeCoastUniversity', 'CapeCoastCoronationJunction', 'Saltpond', 'Mankesssim', 'AburaDunkwa',
            'AssinFosu', 'TwifuPraso', 'AgonaSwedru', 'Winneba', 'Elmina', 'Asikuma', 'SunyaniMain', 'SynyaniMarket',
            'Berekum', 'DomaaAhenkro', 'BankDrobo', 'Sampa', 'Wenchi', 'Kintampo', 'Nkoranza', 'TechimanMain', 'TechimanMarket',
            'Akumadan', 'DuayawNkwanta', 'Bechem', 'Tepa', 'Hwidiem', 'Goaso', 'Mim', 'Sankore', 'KumasiMain',
            'SuameMagazine', 'Suame', 'AsafoMarket', 'KNUST', 'Kejetia', 'MampongAshanti', 'BekwaiAshanti', 'EffiduaseAshanti',
            'Obuasi', 'Ejisu', 'NewOffinso', 'Ejura', 'Edubiase', 'Ahinsan', 'AgonaAshanti', 'JubileeHouse', 'Nkawie',
            'HarperRoad', 'Bantama', 'TechJunction', 'Dunkwa-on-offin', 'SefwiWiaso', 'Yeji',
        ];

        foreach ($gcbBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 12,
            ]);
        }

        $gtBranches = [
            'AbekaLapaz', 'AbekaLapaz2', 'ABOSSEYOKAI', 'Achimota', 'Adum', 'Aflao', 'Airport', 'Ashaiman', 'Baatsona',
            'Capecoast', 'Dansoman', 'DOME', 'EastLegon', 'Haatso', 'Kasoa', 'KNUST', 'Koforidua', 'kumasiMain', 'Labone',
            'Madina', 'NorthIndustrialarea', 'OneAirportSquare', 'Osu', 'RingRoad', 'SpintexRoad', 'Suame', 'Takoradi',
            'Tamale', 'Tarkwa', 'Techiman', 'TemaCommunity6', 'Temamain,Commuinity1', 'Tudu', 'Wa',
        ];

        foreach ($gtBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 13,
            ]);
        }

        $nibBranches = [
            'Abeka', 'AccraMain', 'AccraNewTown', 'Achimota', 'Adenta', 'Ashiaman', 'Asokawa', 'Akimoda', 'Bolgatanga',
            'Capecoast', 'Dansoman', 'Dunkwa-on-offin', 'EastLegon', 'HarbourArea', 'Ho', 'Hohoe', 'Kasoa', 'Kintampo',
            'Koforidua', 'Kejetia', 'Adum', 'Madina', 'Makola', 'MallamAgency', 'MampongAshanti', 'NKWANTA',
            'NorthIndustrialarea', 'AirportCity', 'LawComplex', 'Osu', 'Kokomlemle', 'Spintex', 'Asokwa', 'KumasiCityMall',
            'Adum', 'Obuasi', 'Suame', 'Tanoso', 'Sunyani', 'Techiman', 'Wenchi', 'Kasoa', 'SwedruBranch', 'Sawia', 'Tamale',
            'TamaleAgency', 'UDS', 'Yendi',
        ];

        foreach ($nibBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 14,
            ]);
        }

        $zenithBranches = [
            'GraphicRoad', 'Aboraagency', 'KojoThompson', 'Labone', 'KantamantoAgency', 'NorthIndustrialarea', 'Sakaman',
            'TradeFair', 'Achimota', 'Adum', 'Akosombo', 'BuiAgency', 'CapeCoast', 'EastLegon', 'FreeZones',
        ];

        foreach ($zenithBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 15,
            ]);
        }

        $ominibranches = [
            'GraphicRoad', 'Aboraagency', 'KojoThompson', 'Labone', 'KantamantoAgency', 'NorthIndustrialarea', 'Sakaman',
            'TradeFair', 'Achimota', 'Adum', 'Akosombo', 'BuiAgency', 'CapeCoast', 'EastLegon', 'FreeZones',
        ];

        foreach ($ominibranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 16,
            ]);
        }

        $prudentialBranches = [
            'Abeka', 'Aboabo', 'AbosseyOkai', 'Accra', 'Adentan', 'AffulNkwanta', 'AirportCity', 'Atonsu', 'Cantonments',
            'CapeCoastCentral', 'EastLegon', 'Gicel', 'Haatso', 'Koforidua', 'Adum', 'KumasiMain', 'Madina', 'Makola',
            'Mataheko', 'MethodistUniversityAgency', 'Nungua', 'Odorkor', 'Okaishie', 'Odorkor', 'RINGROADCENTRAL',
            'SantasiRoundabout', 'SpintexRoad', 'SuameMaakro', 'Sunyani', 'Taifa', 'TakoradiHarbour', 'TakoradiMarketCircle',
            'Tamale', 'Techiman', 'TemaCommunity1', 'TemaFishinhHabour', 'Tema', 'UniversityofCapecoastAgency',
            'UniversityofCapecoastmain', 'UniversityofGhana,Legon', 'ValleyView', 'Weija',
        ];

        foreach ($prudentialBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 17,
            ]);
        }

        $republicBrances = [
            'Ebankese', 'Ridge', 'PrivateBanking', 'Adabaraka', 'Accracentral', 'LegonNew', 'LegonOld', 'AbosseyOkai', 'Tema',
            'TemaCommuinity25', 'Tudu', 'Baatsona', 'PostOffice', 'Ashaiman', 'Newtown', 'Achimota', 'Madina',
            'Adjiringanor', 'Kasoa', 'KasoaAgency', 'SwedruBranch', 'Capecoast', 'Winneba', 'KumasiMain', 'Ku,asiMagazine',
            'KNUST', 'Asokwa', 'Techiman', 'Koforidua', 'Asamankese', 'Tamale', 'Bolgatanga', 'Takoradi', 'SefwiBekwae',
            'SefwiWIawso', 'Essam', 'Asankragua', 'Juaboso', 'Akontombra', 'Goaso', 'Asempaneye',
        ];

        foreach ($republicBrances as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 18,
            ]);
        }

        $societebranches = [
            'Adum', 'Asafo', 'Berekum', 'Kejetai', 'KumasiCentral', 'Tarkwa', 'Suame', 'Sunyani', 'AkimOda', 'CapeCoast',
            'Dunkwa', 'Kasoa', 'Koforidua', 'AccraMain', 'AccraNewTown', 'Achimota', 'AirportCity', 'Ashaiman', 'BurmaCamp',
            'Dansoman', 'Eastlegon', 'Faanofa', 'TakoradiMarketCircle', 'Korle-BunearChildrensBlock', 'LotteriesAccra',
            'madina', 'NorthIndustrialarea', 'NovotelBranch', 'Okaishie', 'Osu', 'PigfarmSpot', 'PremierTowers',
            'RoyalCatleRoad', 'SpintexRoad', 'TEMACOMMUINITY1', 'TemaCommuinity25', 'TemaFishinhHabour',
            'TotalFillingStation37', 'Kandaaoverpass', 'TotalFillingStationLaBeach', 'Tudu', 'WoolworthBranch', 'Tamale',
            'Wa', 'Bolgatanga', 'Bibiani', 'Takoradi',
        ];

        foreach ($societebranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 19,
            ]);
        }

        $stanbicBranches = [
            'AccraMainBranch', 'AirportCity', 'SpintexRoad', 'AccraMall', 'NorthIndustrialarea', 'TemaIndustrialArea',
            'GraphicRoad', 'Makola', 'RingRoad', 'Achimota', 'Kasoa', 'Movenpic', 'Madina', 'Dansoman', 'Ahaiman',
            'StanbicHeights', 'Eastlegon', 'AbekaLapaz', 'TEMACOMMUINITY1', 'TemaFishinhHabour', 'Ho', 'HarperRoad',
            'Suame', 'Adum', 'Ashtown', 'Takoradi', 'Tarkwa', 'Sunyani', 'Bolgatanga', 'Tamale', 'JunctionMall', 'KNUST',
            'Tudu', 'WestHillmall', 'Tudu', 'Achimota', 'UniversityofGhana', 'Asokwa',
        ];

        foreach ($stanbicBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 20,
            ]);
        }

        $standardChartered = [
            'Breeze@EastLegon', 'AccraHighStreet', 'KNUST', 'AchimotaRetailCentre', 'Dansoman', 'Tamale',
            'LegonUniversityofGhana', 'Abeka', 'SpintexRoad', 'HarperRoad', 'USTAgency', 'LiberiaRoad', 'Madina',
            'LiberiaRoad', 'NorthIndustrialarea', 'Obuasi', 'Opeibea', 'Osu', 'TEMACOMMUINITY1', 'SSNITCircle', 'Tudu',
            'TemaEast', 'TemaHabour', 'Westlands',
        ];

        foreach ($standardChartered as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 21,
            ]);
        }

        $unitedBankOfAfrica = [
            'AbekaLapazBuisnessoffice', 'AbosseyOkai', 'accraCentral', 'Aflao', 'Airport', 'Alabar', 'CorporateHeritageTower',
            'Dzorwulu', 'Labone', 'Eastlegon', 'Kantamanto', 'Kejetia', 'KNUST', 'Adum', 'Madina', 'RingRoad', 'Spintex',
            'Suame', 'Takoradi', 'TemaCommuinity4', 'TemaMain', 'Teshie', 'Tanoso', 'NorthIndustrialarea', 'Tamale', 'Achimota',
            'Tarkwa', 'Kasoa', 'jKejetia', 'Ashaiman',
        ];

        foreach ($unitedBankOfAfrica as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 22,
            ]);
        }

        $universalBranches = [
            'Abeka', 'AbosseyOkai', 'AccraMain', 'Achimota', 'Adabraka', 'AirportCityAccra', 'Eastlegon', 'JunctionMall',
            'Kaneshie', 'Labone', 'OSUOXFORDSTREET', 'NorthIndustrialarea', 'Ridge', 'Sakaman', 'SOUTHINDUSTRIALAREA',
            'SpintexRoad', 'TemaEast', 'TemaMain', 'UniversityofGhana', 'UniversityofProffessionalStudies', 'MadinaSMECentre',
            'PPPIncubatorCentre-Madina', 'Adum', 'Asafo', 'Bantama', 'Konongo', 'KumasiMain', 'CentreforBuisnesses-Ashtown',
            'Techiman', 'Koforidua', 'Bibiani', 'Takoradi', 'Tarkwa', 'CentreforBuisnesses-Kasoa', 'Tamale',
        ];

        foreach ($universalBranches as $key => $branch) {
            Branch::create([
                'branch_name' => $branch,
                'bank_id' => 23,
            ]);
        }

    }
}
