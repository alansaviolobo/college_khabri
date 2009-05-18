alter table fees 
add column lodging integer NOT NULL default 0, 
add column boarding integer NOT NULL default 0;

truncate table fees;

insert into fees (`institute_code`, `tuition`, `development`, `total`, `year`, `lodging`, `boarding`) values
("EN204",48500,3000,51500,"2008-09",36000,0),
("EN205",61750,5050,66800,"2008-09",15600,24000),
("EN206",50130,2730,52860,"2008-09",0,0),
("EN206",45611,3270,48881,"2008-09",0,0),
("EN209",52820,2180,55000,"2008-09",0,0),
("EN210",86250,5750,92000,"2008-09",40000,40000),
("EN211",62880,7120,70000,"2008-09",0,0),
("EN212",51100,2100,53200,"2008-09",0,0),
("EN213",36680,2480,39160,"2008-09",0,0),
("EN217",52360,1640,54000,"2008-09",0,0),
("EN218",40450,3800,44250,"2008-09",0,0),
("EN219",48580,1420,50000,"2008-09",0,0),
("EN220",41300,1300,42600,"2008-09",18050,18050),
("EN221",64350,2200,66550,"2008-09",0,0),
("En222",49910,3980,53890,"2008-09",0,0),
("EN223",54756,3244,58000,"2008-09",0,0),
("En224",41550,1640,43190,"2008-09",0,0),
("EN225",50210,1550,51760,"2008-09",15000,15000),
("EN226",41410,3170,44580,"2008-09",0,0),
("EN227",39580,2320,41900,"2008-09",0,0),
("EN228",43710,1760,45470,"2008-09",0,0),
("EN229",39850,3050,42900,"2008-09",0,0),
("EN230",44920,1380,46300,"2008-09",0,0),
("EN231",32430,2570,35000,"2008-09",7000,13200),
("EN232",30970,1600,32570,"2008-09",4200,4200),
("EN233",43320,1680,45000,"2008-09",0,0),
("EN234",39052,1948,41000,"2008-09",0,0),
("EN235",66700,3300,70000,"2008-09",35000,12000),
("EN236",66430,5570,72000,"2008-09",9600,9600),
("EN237",72240,5390,77630,"2008-09",9000,9000),
("EN238",57200,2800,60000,"2008-09",0,0),
("EN239",46920,4640,51560,"2008-09",15600,24000),
("EN240",64140,1650,65790,"2008-09",0,0),
("EN241",47070,9930,57000,"2008-09",0,0),
("EN242",56331,1949,58280,"2008-09",0,0),
("EN243",48940,11060,60000,"2008-09",0,0),
("EN244",51378,1622,53000,"2008-09",10000,10000),
("EN245",45030,2970,48000,"2008-09",0,0),
("EN246",50320,1220,51540,"2008-09",10000,30000),
("EN248",45848,3152,49000,"2008-09",0,0),
("EN302",58320,1680,60000,"2008-09",7000,9600),
("EN303",40565,1360,41925,"2008-09",7000,12000),
("EN304",51720,3540,55260,"2008-09",8500,10000),
("EN305",47647,2353,50000,"2008-09",10000,12000),
("EN306",37350,4800,42150,"2008-09",0,0),
("EN307",37330,2670,40000,"2008-09",8400,9000),
("En308",50350,1650,52000,"2008-09",18000,18000),
("EN309",48790,6200,54990,"2008-09",13500,10835),
("EN310",47050,2950,50000,"2008-09",0,0),
("EN311",58000,12000,70000,"2008-09",20000,15500),
("EN312",39827,1550,41377,"2008-09",18000,11500),
("EN313",41158,1950,43108,"2008-09",11900,11900),
("EN314",59886,5114,65000,"2008-09",0,0),
("EN315",65100,1900,67000,"2008-09",0,0),
("EN316",45510,4040,49550,"2008-09",20000,12000),
("EN317",49680,3700,53380,"2008-09",8500,10000),
("EN318",37140,2600,39740,"2008-09",0,0),
("EN319",43220,2280,45500,"2008-09",0,10200),
("EN320",40850,2030,42880,"2008-09",12000,12000),
("EN321",75400,7600,83000,"2008-09",0,0),
("EN323",46730,1170,47900,"2008-09",9250,9250),
("EN324",38000,2000,40000,"2008-09",12000,10800),
("EN325",40150,1870,42020,"2008-09",14000,21000),
("EN326",33748,2802,36550,"2008-09",12500,10800),
("EN327",60680,4320,65000,"2008-09",0,0),
("EN328",48600,4400,53000,"2008-09",0,0),
("EN329",59800,1800,61600,"2008-09",12500,12500),
("EN330",38560,1240,39800,"2008-09",0,0),
("EN331",72458,3542,76000,"2008-09",32000,16800),
("EN332",64180,2900,67080,"2008-09",10000,0),
("EN333",41690,4400,46090,"2008-09",0,0),
("EN334",63400,4600,68000,"2008-09",0,0),
("EN335",69073,5007,74080,"2008-09",0,0),
("EN336",53070,2430,55500,"2008-09",0,0),
("EN337",56700,3300,60000,"2008-09",12000,12000),
("EN338",58100,1900,60000,"2008-09",0,0),
("EN339",38170,2150,40320,"2008-09",0,0),
("EN340",45000,25000,70000,"2008-09",21000,21000),
("EN341",43380,2650,46030,"2008-09",0,0),
("EN342",48000,14000,62000,"2008-09",20000,16800),
("EN343",58936,6064,65000,"2008-09",30000,20000),
("EN344",58800,13200,72000,"2008-09",0,0),
("EN345",44640,5360,50000,"2008-09",0,0),
("EN346",53000,5000,58000,"2008-09",0,0),
("EN403",48540,2660,51200,"2008-09",0,0),
("EN404",39200,5800,45000,"2008-09",0,0),
("EN405",42920,2080,45000,"2008-09",0,0),
("EN406",31760,4240,36000,"2008-09",0,0),
("EN407",43510,3480,46990,"2008-09",0,0),
("EN408",45090,2300,47390,"2008-09",0,0),
("EN409",40960,3830,44790,"2008-09",0,0),
("EN410",36030,2570,38600,"2008-09",0,0),
("EN412",37000,3000,40000,"2008-09",0,0),
("EN413",65600,4400,70000,"2008-09",0,0),
("EN414",48600,16400,65000,"2008-09",0,0),
("EN503",55495,2775,58270,"2008-09",0,0),
("EN504",36920,2080,39000,"2008-09",0,0),
("EN505",28753,1607,30360,"2008-09",0,0),
("EN506",31050,2000,33050,"2008-09",0,0),
("EN507",30900,2050,32950,"2008-09",0,0),
("EN508",38000,1000,39000,"2008-09",0,0),
("EN509",39490,4900,44390,"2008-09",0,0),
("EN511",32400,2800,35200,"2008-09",0,0),
("EN512",26210,3290,29500,"2008-09",0,0),
("EN513",21974,1800,23774,"2008-09",0,0),
("EN602",32682,2078,34760,"2008-09",0,0),
("EN603",36000,0,36000,"2008-09",0,0),
("EN605",42454,2746,45200,"2008-09",0,0),
("EN703",46677,2223,48900,"2008-09",0,0),
("EN704",46070,2020,48090,"2008-09",0,0),
("EN705",36660,1000,37660,"2008-09",0,0),
("EN706",39160,2270,41430,"2008-09",0,0),
("EN707",43104,1240,44344,"2008-09",0,0),
("EN708",42470,2580,45050,"2008-09",0,0),
("EN709",44130,4870,49000,"2008-09",0,0),
("EN710",40434,1000,41434,"2008-09",0,0),
("EN711",42500,2500,45000,"2008-09",0,0),
("EN712",53240,2460,55700,"2008-09",0,0),
("EN713",26620,4000,30620,"2008-09",0,0),
("EN714",30750,2250,33000,"2008-09",0,0),
("EN715",43050,4950,48000,"2008-09",0,0),
("EN716",38720,2480,41200,"2008-09",0,0),
("EN803",46000,0,46000,"2008-09",0,0),
("EN804",50000,1000,51000,"2008-09",0,0),
("EN805",40570,2900,43470,"2008-09",0,0),
("EN806",52500,6200,58700,"2008-09",0,0),
("EN807",53200,5200,58400,"2008-09",0,0),
("EN808",31700,3300,35000,"2008-09",0,0),
("EN809",34442,1758,36200,"2008-09",0,0),
("EN810",24100,19200,43300,"2008-09",0,0),
("EN811",41670,2700,44370,"2008-09",0,0),
("EN904",48950,2820,51770,"2008-09",0,0),
("EN905",51480,1850,53330,"2008-09",0,0),
("EN906",54400,3500,57900,"2008-09",0,0),
("EN907",43000,2000,45000,"2008-09",0,0),
("EN908",55960,1540,57500,"2008-09",0,0),
("EN909",56965,2935,59900,"2008-09",0,0),
("EN910",57920,500,58420,"2008-09",0,0),
("EN911",44200,1800,46000,"2008-09",0,0),
("EN912",39400,600,40000,"2008-09",0,0),
("EN913",36020,2220,38240,"2008-09",0,0),
("EN914",39030,1400,40430,"2008-09",0,0),
("EN915",48630,1470,50100,"2008-09",0,0),
("EN916",31600,1400,33000,"2008-09",0,0),
("EN918",50266,3234,53500,"2008-09",0,0),
("EN919",45280,4720,50000,"2008-09",0,0),
("EN920",40200,9800,50000,"2008-09",0,0),
("EN921",47860,4140,52000,"2008-09",0,0),
("EN922",46520,5480,52000,"2008-09",0,0);