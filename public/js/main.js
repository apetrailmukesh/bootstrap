//Main JS file
var jqNC = jQuery.noConflict(); // define jQuery no conflict variable

// show/hide search box on mobile browsers only
jqNC("#open-mobile-search").on("click", function() {
	jqNC("#mobile-search-box").toggle();
})

// setting up foundation JS and overrides
jqNC(document).foundation();

// setting up autocomplete for search boxes
var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substrRegex;
 
    // an array that will be populated with substring matches
    matches = [];
 
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
 
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    jqNC.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        // the typeahead jQuery plugin expects suggestions to a
        // JavaScript object, refer to typeahead docs for more info
        matches.push({ value: str });
      }
    });
 
    cb(matches);
  };
};
 
var vehicleTypes = ["2 Door Coupe","4 Door Sedan","SUV/Crossover","Wagon","Convertible","Mini Van","Truck","Commercial","Full Size Van","Acura","Alfa Romeo","AM General","AMC","Aston Martin","Audi","Bentley","BMW","Bugatti","Buick","Cadillac","Chevrolet","Chrysler","Daewoo","Daihatsu","Datsun","Dodge","Eagle","Ferrari","FIAT","Fisker","Ford","Geo","GMC","Honda","HUMMER","Hyundai","Infiniti","Isuzu","Jaguar","Jeep","Kia","Lamborghini","Land Rover","Lexus","Lincoln","Lotus","Maserati","Maybach","Mazda","McLaren","Mercedes-Benz","Mercury","Merkur","MINI","Mitsubishi","Nissan","Oldsmobile","Panoz","Peugeot","Plymouth","Pontiac","Porsche","Ram","Renault","Rolls-Royce","Saab","Saturn","Scion","Smart","SRT","Sterling","Subaru","Suzuki","Tesla","Toyota","Volkswagen","Volvo","Yugo","Acura 2 Door Coupe","Acura 4 Door Sedan","Acura SUV/Crossover","Acura Wagon","Alfa Romeo 2 Door Coupe","Alfa Romeo 4 Door Sedan","Alfa Romeo Convertible","AM General SUV/Crossover","AMC 2 Door Coupe","AMC 4 Door Sedan","AMC Convertible","AMC Wagon","Aston Martin 2 Door Coupe","Aston Martin 4 Door Sedan","Aston Martin Convertible","Audi 2 Door Coupe","Audi 4 Door Sedan","Audi Convertible","Audi SUV/Crossover","Audi Wagon","Bentley 2 Door Coupe","Bentley 4 Door Sedan","Bentley Convertible","BMW 2 Door Coupe","BMW 4 Door Sedan","BMW Convertible","BMW SUV/Crossover","BMW Wagon","Bugatti 2 Door Coupe","Buick 2 Door Coupe","Buick 4 Door Sedan","Buick Convertible","Buick Mini Van","Buick SUV/Crossover","Buick Wagon","Cadillac 2 Door Coupe","Cadillac 4 Door Sedan","Cadillac Convertible","Cadillac SUV/Crossover","Cadillac Truck","Cadillac Wagon","Chevrolet 2 Door Coupe","Chevrolet 4 Door Sedan","Chevrolet Commercial","Chevrolet Convertible","Chevrolet Full Size Van","Chevrolet Mini Van","Chevrolet SUV/Crossover","Chevrolet Truck","Chevrolet Wagon","Chrysler 2 Door Coupe","Chrysler 4 Door Sedan","Chrysler Convertible","Chrysler Mini Van","Chrysler SUV/Crossover","Chrysler Wagon","Daewoo 2 Door Coupe","Daewoo 4 Door Sedan","Daewoo Wagon","Daihatsu 2 Door Coupe","Datsun 2 Door Coupe","Datsun 4 Door Sedan","Datsun Truck","Datsun Wagon","Dodge 2 Door Coupe","Dodge 4 Door Sedan","Dodge Commercial","Dodge Convertible","Dodge Full Size Van","Dodge Mini Van","Dodge SUV/Crossover","Dodge Truck","Dodge Wagon","Eagle 2 Door Coupe","Eagle 4 Door Sedan","Eagle Wagon","Ferrari 2 Door Coupe","Ferrari Convertible","FIAT 2 Door Coupe","FIAT Convertible","Fisker 4 Door Sedan","Ford 2 Door Coupe","Ford 4 Door Sedan","Ford Commercial","Ford Convertible","Ford Full Size Van","Ford Mini Van","Ford SUV/Crossover","Ford Truck","Ford Wagon","Geo 2 Door Coupe","Geo 4 Door Sedan","Geo Convertible","Geo SUV/Crossover","GMC Commercial","GMC Full Size Van","GMC Mini Van","GMC SUV/Crossover","GMC Truck","GMC Wagon","Honda 2 Door Coupe","Honda 4 Door Sedan","Honda Convertible","Honda Mini Van","Honda SUV/Crossover","Honda Truck","Honda Wagon","HUMMER SUV/Crossover","HUMMER Truck","Hyundai 2 Door Coupe","Hyundai 4 Door Sedan","Hyundai Mini Van","Hyundai SUV/Crossover","Hyundai Wagon","Infiniti 2 Door Coupe","Infiniti 4 Door Sedan","Infiniti Convertible","Infiniti SUV/Crossover","Infiniti Wagon","Isuzu 2 Door Coupe","Isuzu 4 Door Sedan","Isuzu Convertible","Isuzu Mini Van","Isuzu SUV/Crossover","Isuzu Truck","Jaguar 2 Door Coupe","Jaguar 4 Door Sedan","Jaguar Convertible","Jaguar Wagon","Jeep Convertible","Jeep SUV/Crossover","Jeep Truck","Kia 2 Door Coupe","Kia 4 Door Sedan","Kia Mini Van","Kia SUV/Crossover","Kia Wagon","Lamborghini 2 Door Coupe","Lamborghini Convertible","Land Rover Convertible","Land Rover SUV/Crossover","Lexus 2 Door Coupe","Lexus 4 Door Sedan","Lexus Convertible","Lexus SUV/Crossover","Lexus Wagon","Lincoln 2 Door Coupe","Lincoln 4 Door Sedan","Lincoln SUV/Crossover","Lincoln Truck","Lincoln Wagon","Lotus 2 Door Coupe","Lotus Convertible","Maserati 2 Door Coupe","Maserati 4 Door Sedan","Maserati Convertible","Maybach 4 Door Sedan","Mazda 2 Door Coupe","Mazda 4 Door Sedan","Mazda Convertible","Mazda Mini Van","Mazda SUV/Crossover","Mazda Truck","Mazda Wagon","McLaren 2 Door Coupe","McLaren Convertible","Mercedes-Benz 2 Door Coupe","Mercedes-Benz 4 Door Sedan","Mercedes-Benz Commercial","Mercedes-Benz Convertible","Mercedes-Benz Full Size Van","Mercedes-Benz SUV/Crossover","Mercedes-Benz Wagon","Mercury 2 Door Coupe","Mercury 4 Door Sedan","Mercury Convertible","Mercury Mini Van","Mercury SUV/Crossover","Mercury Wagon","Merkur 2 Door Coupe","MINI 2 Door Coupe","MINI Convertible","MINI Wagon","Mitsubishi 2 Door Coupe","Mitsubishi 4 Door Sedan","Mitsubishi Convertible","Mitsubishi Mini Van","Mitsubishi SUV/Crossover","Mitsubishi Truck","Mitsubishi Wagon","Nissan 2 Door Coupe","Nissan 4 Door Sedan","Nissan Convertible","Nissan Full Size Van","Nissan Mini Van","Nissan SUV/Crossover","Nissan Truck","Nissan Wagon","Oldsmobile 2 Door Coupe","Oldsmobile 4 Door Sedan","Oldsmobile Convertible","Oldsmobile Mini Van","Oldsmobile SUV/Crossover","Oldsmobile Wagon","Panoz 2 Door Coupe","Panoz Convertible","Peugeot Wagon","Plymouth 2 Door Coupe","Plymouth 4 Door Sedan","Plymouth Convertible","Plymouth Full Size Van","Plymouth Mini Van","Plymouth SUV/Crossover","Plymouth Truck","Plymouth Wagon","Pontiac 2 Door Coupe","Pontiac 4 Door Sedan","Pontiac Convertible","Pontiac Mini Van","Pontiac SUV/Crossover","Pontiac Wagon","Porsche 2 Door Coupe","Porsche 4 Door Sedan","Porsche Convertible","Porsche SUV/Crossover","Ram Commercial","Ram Full Size Van","Ram Mini Van","Ram Truck","Renault 2 Door Coupe","Renault 4 Door Sedan","Renault Wagon","Rolls-Royce 2 Door Coupe","Rolls-Royce 4 Door Sedan","Rolls-Royce Convertible","Saab 2 Door Coupe","Saab 4 Door Sedan","Saab Convertible","Saab SUV/Crossover","Saab Wagon","Saturn 2 Door Coupe","Saturn 4 Door Sedan","Saturn Convertible","Saturn Mini Van","Saturn SUV/Crossover","Saturn Wagon","Scion 2 Door Coupe","Scion Wagon","Smart 2 Door Coupe","Smart Convertible","SRT 2 Door Coupe","Sterling 2 Door Coupe","Sterling 4 Door Sedan","Subaru 2 Door Coupe","Subaru 4 Door Sedan","Subaru SUV/Crossover","Subaru Truck","Subaru Wagon","Suzuki 2 Door Coupe","Suzuki 4 Door Sedan","Suzuki Convertible","Suzuki SUV/Crossover","Suzuki Truck","Suzuki Wagon","Tesla 4 Door Sedan","Tesla Convertible","Toyota 2 Door Coupe","Toyota 4 Door Sedan","Toyota Convertible","Toyota Full Size Van","Toyota Mini Van","Toyota SUV/Crossover","Toyota Truck","Toyota Wagon","Undefined ","Volkswagen 2 Door Coupe","Volkswagen 4 Door Sedan","Volkswagen Convertible","Volkswagen Mini Van","Volkswagen SUV/Crossover","Volkswagen Truck","Volkswagen Wagon","Volvo 2 Door Coupe","Volvo 4 Door Sedan","Volvo Convertible","Volvo SUV/Crossover","Volvo Wagon","Yugo 2 Door Coupe","Acura CL","Acura ILX","Acura Integra","Acura Legend","Acura MDX","Acura NSX","Acura RDX","Acura RL","Acura RLX","Acura RSX","Acura SLX","Acura TL","Acura TLX","Acura TSX","Acura TSX Sport Wagon","Acura Vigor","Acura ZDX","Alfa Romeo 4C","Alfa Romeo GTV6","Alfa Romeo Milano","Alfa Romeo Spider","AM General Hummer","AMC Alliance","AMC Concord","AMC Eagle 30","AMC Eagle 50","AMC Encore","AMC Spirit","Aston Martin DB7","Aston Martin DB9","Aston Martin DBS","Aston Martin Rapide","Aston Martin Rapide S","Aston Martin V12 Vanquish","Aston Martin V12 Vantage","Aston Martin V12 Vantage S","Aston Martin V8 Vantage","Aston Martin Vanquish","Aston Martin Virage","Audi 100","Audi 200","Audi 4000","Audi 5000","Audi 80","Audi 90","Audi A3","Audi A4","Audi A5","Audi A6","Audi A7","Audi A8","Audi Allroad","Audi allroad quattro","Audi Cabriolet","Audi Coupe","Audi Q3","Audi Q5","Audi Q5 Hybrid","Audi Q7","Audi R8","Audi RS 5","Audi RS 6","Audi RS 7","Audi RS4","Audi RS7","Audi S3","Audi S4","Audi S5","Audi S6","Audi S7","Audi S8","Audi SQ5","Audi TT","Audi TT RS","Audi TTS","Audi V8","Bentley Arnage","Bentley Azure","Bentley Azure T","Bentley Brooklands","Bentley Continental","Bentley Continental Flying Spur","Bentley Continental Flying Spur Speed","Bentley Continental GT","Bentley Continental GT Speed","Bentley Continental GT V8","Bentley Continental GT V8 S","Bentley Continental GTC","Bentley Continental GTC Speed","Bentley Continental GTC V8","Bentley Continental GTC V8 S","Bentley Continental Supersports","Bentley Flying Spur","Bentley Flying Spur V8","Bentley Flying Spur W12","Bentley Mulsanne","Bentley Mulsanne Speed","BMW 1 Series","BMW 2 Series","BMW 3 Series","BMW 4 Series","BMW 5 Series","BMW 6 Series","BMW 7 Series","BMW 8 Series","BMW ActiveE","BMW i3","BMW i8","BMW M","BMW M3","BMW M4","BMW M5","BMW M6","BMW X1","BMW X3","BMW X4","BMW X5","BMW X5 M","BMW X6","BMW X6 M","BMW Z3","BMW Z4","BMW Z4 M","BMW Z8","Bugatti Veyron 16.4","Buick Century","Buick Electra","Buick Enclave","Buick Encore","Buick Estate Wagon","Buick LaCrosse","Buick LeSabre","Buick Lucerne","Buick Park Avenue","Buick Rainier","Buick Reatta","Buick Regal","Buick Rendezvous","Buick Riviera","Buick Roadmaster","Buick Skyhawk","Buick Skylark","Buick Somerset","Buick Somerset Regal","Buick Terraza","Buick Verano","Cadillac Allante","Cadillac ATS","Cadillac Brougham","Cadillac Catera","Cadillac Cimarron","Cadillac CTS","Cadillac CTS-V","Cadillac DeVille","Cadillac DTS","Cadillac DTS Pro","Cadillac Eldorado","Cadillac ELR","Cadillac Escalade","Cadillac Escalade ESV","Cadillac Escalade EXT","Cadillac Escalade Hybrid","Cadillac Fleetwood","Cadillac Fleetwood Brougham","Cadillac Seville","Cadillac Sixty Special","Cadillac SRX","Cadillac STS","Cadillac STS-V","Cadillac XLR","Cadillac XLR-V","Cadillac XTS","Cadillac XTS Pro","Chevrolet Astro","Chevrolet Astro Cargo","Chevrolet Avalanche","Chevrolet Aveo","Chevrolet Beretta","Chevrolet Black Diamond Avalanche","Chevrolet Blazer","Chevrolet C/K 10 Series","Chevrolet C/K 1500 Series","Chevrolet C/K 20 Series","Chevrolet C/K 2500 Series","Chevrolet C/K 30 Series","Chevrolet C/K 3500 Series","Chevrolet Camaro","Chevrolet Caprice","Chevrolet Captiva Sport","Chevrolet Captiva Sport Fleet","Chevrolet Cavalier","Chevrolet Celebrity","Chevrolet Chevette","Chevrolet Chevy Van","Chevrolet Chevy Van Classic","Chevrolet Citation","Chevrolet City Express Cargo","Chevrolet Classic","Chevrolet Cobalt","Chevrolet Colorado","Chevrolet Corsica","Chevrolet Corvette","Chevrolet Corvette Stingray","Chevrolet Cruze","Chevrolet El Camino","Chevrolet Equinox","Chevrolet Express","Chevrolet Express Cargo","Chevrolet Express Cutaway","Chevrolet HHR","Chevrolet Impala","Chevrolet Impala Limited","Chevrolet Impala Limited Police","Chevrolet Lumina","Chevrolet Lumina Minivan","Chevrolet LUV","Chevrolet Malibu","Chevrolet Malibu Classic","Chevrolet Malibu Hybrid","Chevrolet Malibu Maxx","Chevrolet Metro","Chevrolet Monte Carlo","Chevrolet Nova","Chevrolet Prizm","Chevrolet R/V 10 Series","Chevrolet R/V 20 Series","Chevrolet R/V 2500 Series","Chevrolet R/V 30 Series","Chevrolet R/V 3500 Series","Chevrolet S-10","Chevrolet S-10 Blazer","Chevrolet Silverado 1500","Chevrolet Silverado 1500 Classic","Chevrolet Silverado 1500 Hybrid","Chevrolet Silverado 1500 SS","Chevrolet Silverado 1500 SS Classic","Chevrolet Silverado 1500HD","Chevrolet Silverado 1500HD Classic","Chevrolet Silverado 2500","Chevrolet Silverado 2500HD","Chevrolet Silverado 2500HD Classic","Chevrolet Silverado 3500","Chevrolet Silverado 3500 Classic","Chevrolet Silverado 3500HD","Chevrolet Silverado 3500HD CC","Chevrolet Sonic","Chevrolet Spark","Chevrolet Spark EV","Chevrolet Spectrum","Chevrolet Sportvan","Chevrolet Sprint","Chevrolet SS","Chevrolet SSR","Chevrolet Suburban","Chevrolet Tahoe","Chevrolet Tahoe Hybrid","Chevrolet Tahoe Limited/Z71","Chevrolet Tracker","Chevrolet TrailBlazer","Chevrolet TrailBlazer EXT","Chevrolet Traverse","Chevrolet Trax","Chevrolet Uplander","Chevrolet Venture","Chevrolet Volt","Chrysler 200","Chrysler 200 Convertible","Chrysler 300","Chrysler 300C SRT-8","Chrysler 300M","Chrysler Aspen","Chrysler Aspen Hybrid","Chrysler Cirrus","Chrysler Concorde","Chrysler Conquest","Chrysler Cordoba","Chrysler Crossfire","Chrysler Crossfire SRT-6","Chrysler E Class","Chrysler Fifth Avenue","Chrysler Grand Voyager","Chrysler Imperial","Chrysler Laser","Chrysler Le Baron","Chrysler LHS","Chrysler New Yorker","Chrysler Newport","Chrysler Pacifica","Chrysler Prowler","Chrysler PT Cruiser","Chrysler Sebring","Chrysler TC","Chrysler Town and Country","Chrysler Voyager","Daewoo Lanos","Daewoo Leganza","Daewoo Nubira","Daihatsu Charade","Datsun 200SX","Datsun 210","Datsun 280ZX","Datsun 310","Datsun 510","Datsun 810","Datsun Maxima","Datsun Pickup","Datsun Pulsar","Datsun Sentra","Datsun Stanza","Dodge 400","Dodge 600","Dodge Aries America","Dodge Aries K","Dodge Avenger","Dodge Caliber","Dodge Caravan","Dodge Challenger","Dodge Charger","Dodge Charger SRT-8","Dodge Colt","Dodge Conquest","Dodge Dakota","Dodge Dart","Dodge Daytona","Dodge Diplomat","Dodge Durango","Dodge Dynasty","Dodge Grand Caravan","Dodge Intrepid","Dodge Journey","Dodge Lancer","Dodge Magnum","Dodge Magnum SRT-8","Dodge Mini Ram Van","Dodge Mirada","Dodge Monaco","Dodge Neon","Dodge Neon SRT-4","Dodge Nitro","Dodge Omni","Dodge Omni 024","Dodge Raider","Dodge RAM 100","Dodge RAM 150","Dodge RAM 250","Dodge RAM 350","Dodge Ram 50 Pickup","Dodge Ram Cargo","Dodge Ram Chassis 3500","Dodge Ram Chassis 4500","Dodge Ram Pickup 1500","Dodge Ram Pickup 1500 SRT-10","Dodge Ram Pickup 2500","Dodge Ram Pickup 3500","Dodge Ram Van","Dodge Ram Wagon","Dodge Ramcharger","Dodge Rampage","Dodge Shadow","Dodge Spirit","Dodge Sprinter","Dodge Sprinter Cargo","Dodge SRT Viper","Dodge St. Regis","Dodge Stealth","Dodge Stratus","Dodge Viper","Eagle Eagle 30","Eagle Medallion","Eagle Premier","Eagle Summit","Eagle Talon","Eagle Vision","Ferrari 360","Ferrari 430 Scuderia","Ferrari 430 Scuderia Spider","Ferrari 456M","Ferrari 458 Italia","Ferrari 458 Speciale","Ferrari 458 Spider","Ferrari 550","Ferrari 575M","Ferrari 599","Ferrari 599 GTB Fiorano","Ferrari 599 GTO","Ferrari 612 Scaglietti","Ferrari California","Ferrari California T","Ferrari Enzo","Ferrari F12berlinetta","Ferrari F430","Ferrari F430 Spider","Ferrari FF","Ferrari Superamerica","FIAT 500","FIAT 500c","FIAT 500e","FIAT 500L","FIAT 500T","Fisker Karma","Ford Aerostar","Ford Aspire","Ford Bronco","Ford Bronco II","Ford C-MAX Energi","Ford C-MAX Hybrid","Ford Contour","Ford Contour SVT","Ford Courier","Ford Crown Victoria","Ford E-100","Ford E-150","Ford E-250","Ford E-350","Ford E-Series Cargo","Ford E-Series Chassis","Ford E-Series Wagon","Ford Edge","Ford Escape","Ford Escape Hybrid","Ford Escort","Ford Excursion","Ford EXP","Ford Expedition","Ford Expedition EL","Ford Explorer","Ford Explorer Sport","Ford Explorer Sport Trac","Ford F-100","Ford F-150","Ford F-150 Heritage","Ford F-150 SVT Lightning","Ford F-250","Ford F-250 Super Duty","Ford F-350","Ford F-350 Super Duty","Ford F-450 Super Duty","Ford F-550 Super Duty","Ford Fairmont","Ford Festiva","Ford Fiesta","Ford Five Hundred","Ford Flex","Ford Focus","Ford Focus SVT","Ford Freestar","Ford Freestyle","Ford Fusion","Ford Fusion Energi","Ford Fusion Hybrid","Ford Granada","Ford GT","Ford LTD","Ford LTD Crown Victoria","Ford Mustang","Ford Mustang SVT Cobra","Ford Probe","Ford Ranger","Ford Shelby GT500","Ford Taurus","Ford Taurus X","Ford Tempo","Ford Thunderbird","Ford Transit Cargo","Ford Transit Chassis Cab","Ford Transit Connect","Ford Transit Connect Cargo","Ford Transit Connect Electric","Ford Transit Connect Wagon","Ford Transit Cutaway","Ford Transit Wagon","Ford Windstar","Ford Windstar Cargo","Geo Metro","Geo Prizm","Geo Spectrum","Geo Storm","Geo Tracker","GMC Acadia","GMC C/K 1500 Series","GMC C/K 2500 Series","GMC C/K 3500 Series","GMC Caballero","GMC Canyon","GMC Envoy","GMC Envoy XL","GMC Envoy XUV","GMC Jimmy","GMC R/V 1500 Series","GMC R/V 2500 Series","GMC R/V 3500 Series","GMC Rally Wagon","GMC S-15","GMC S-15 Jimmy","GMC Safari","GMC Safari Cargo","GMC Savana","GMC Savana Cargo","GMC Savana Cutaway","GMC Savana Passenger","GMC Sierra 1500","GMC Sierra 1500 Classic","GMC Sierra 1500 Hybrid","GMC Sierra 1500HD","GMC Sierra 1500HD Classic","GMC Sierra 2500","GMC Sierra 2500HD","GMC Sierra 2500HD Classic","GMC Sierra 3500","GMC Sierra 3500 Classic","GMC Sierra 3500HD","GMC Sierra 3500HD CC","GMC Sierra C3","GMC Sierra Classic 1500","GMC Sierra Classic 2500","GMC Sierra Classic 3500","GMC Sonoma","GMC Suburban","GMC Syclone","GMC Terrain","GMC Typhoon","GMC Vandura","GMC Yukon","GMC Yukon Denali","GMC Yukon XL","Honda Accord","Honda Accord Crosstour","Honda Accord Hybrid","Honda Accord Plug-In","Honda Civic","Honda Civic CRX","Honda Civic del Sol","Honda CR-V","Honda CR-Z","Honda Crosstour","Honda Element","Honda FCX Clarity","Honda Fit","Honda Fit EV","Honda Insight","Honda Odyssey","Honda Passport","Honda Pilot","Honda Prelude","Honda Ridgeline","Honda S2000","HUMMER H1","HUMMER H1 Alpha","HUMMER H2","HUMMER H2 SUT","HUMMER H3","HUMMER H3T","Hyundai Accent","Hyundai Azera","Hyundai Elantra","Hyundai Elantra Coupe","Hyundai Elantra GT","Hyundai Elantra Touring","Hyundai Entourage","Hyundai Equus","Hyundai Excel","Hyundai Genesis","Hyundai Genesis Coupe","Hyundai Santa Fe","Hyundai Santa Fe Sport","Hyundai Scoupe","Hyundai Sonata","Hyundai Sonata Hybrid","Hyundai Tiburon","Hyundai Tucson","Hyundai Tucson Fuel Cell","Hyundai Veloster","Hyundai Veloster Turbo","Hyundai Veracruz","Hyundai XG300","Hyundai XG350","Infiniti EX35","Infiniti EX37","Infiniti FX35","Infiniti FX37","Infiniti FX45","Infiniti FX50","Infiniti G20","Infiniti G25 Sedan","Infiniti G35","Infiniti G37","Infiniti G37 Convertible","Infiniti G37 Coupe","Infiniti G37 Sedan","Infiniti I30","Infiniti I35","Infiniti IPL G Convertible","Infiniti IPL G Coupe","Infiniti J30","Infiniti JX35","Infiniti M30","Infiniti M35","Infiniti M35h","Infiniti M37","Infiniti M45","Infiniti M56","Infiniti Q40","Infiniti Q45","Infiniti Q50","Infiniti Q50 Hybrid","Infiniti Q60 Convertible","Infiniti Q60 Coupe","Infiniti Q60 IPL Convertible","Infiniti Q60 IPL Coupe","Infiniti Q70","Infiniti Q70 Hybrid","Infiniti Q70L","Infiniti QX4","Infiniti QX50","Infiniti QX56","Infiniti QX60","Infiniti QX60 Hybrid","Infiniti QX70","Infiniti QX80","Isuzu Amigo","Isuzu Ascender","Isuzu Axiom","Isuzu Hombre","Isuzu I-Mark","Isuzu i-Series","Isuzu Impulse","Isuzu Oasis","Isuzu Pickup","Isuzu Rodeo","Isuzu Rodeo Sport","Isuzu Stylus","Isuzu Trooper","Isuzu Trooper II","Isuzu VehiCROSS","Jaguar F-TYPE","Jaguar S-Type","Jaguar S-Type R","Jaguar X-Type","Jaguar XF","Jaguar XJ","Jaguar XJ-Series","Jaguar XJL","Jaguar XJR","Jaguar XK","Jaguar XK-Series","Jaguar XKR","Jeep Cherokee","Jeep CJ-5","Jeep CJ-7","Jeep Comanche","Jeep Commander","Jeep Compass","Jeep Grand Cherokee","Jeep Grand Cherokee SRT-8","Jeep Grand Wagoneer","Jeep J-10 Pickup","Jeep J-20 Pickup","Jeep Liberty","Jeep Patriot","Jeep Scrambler","Jeep Wagoneer","Jeep Wrangler","Jeep Wrangler Unlimited","Kia Amanti","Kia Borrego","Kia Cadenza","Kia Forte","Kia Forte 5-door","Kia Forte Koup","Kia K900","Kia Optima","Kia Optima Hybrid","Kia Rio","Kia Rio5","Kia Rondo","Kia Sedona","Kia Sephia","Kia Sorento","Kia Soul","Kia Soul EV","Kia Spectra","Kia Sportage","Lamborghini Aventador","Lamborghini Diablo","Lamborghini Gallardo","Lamborghini Huracan","Lamborghini Murcielago","Land Rover Defender","Land Rover Discovery","Land Rover Discovery Series II","Land Rover Freelander","Land Rover LR2","Land Rover LR3","Land Rover LR4","Land Rover Range Rover","Land Rover Range Rover Evoque","Land Rover Range Rover Evoque Coupe","Land Rover Range Rover Sport","Lexus CT 200h","Lexus ES 250","Lexus ES 300","Lexus ES 300h","Lexus ES 330","Lexus ES 350","Lexus GS 300","Lexus GS 350","Lexus GS 400","Lexus GS 430","Lexus GS 450h","Lexus GS 460","Lexus GX 460","Lexus GX 470","Lexus HS 250h","Lexus IS 250","Lexus IS 250C","Lexus IS 300","Lexus IS 350","Lexus IS 350C","Lexus IS F","Lexus LFA","Lexus LS 400","Lexus LS 430","Lexus LS 460","Lexus LS 600h L","Lexus LX 450","Lexus LX 470","Lexus LX 570","Lexus NX 200t","Lexus NX 300h","Lexus RC 350","Lexus RC F","Lexus RX 300","Lexus RX 330","Lexus RX 350","Lexus RX 400h","Lexus RX 450h","Lexus SC 300","Lexus SC 400","Lexus SC 430","Lincoln Aviator","Lincoln Blackwood","Lincoln Continental","Lincoln LS","Lincoln Mark LT","Lincoln Mark VI","Lincoln Mark VII","Lincoln Mark VIII","Lincoln MKC","Lincoln MKS","Lincoln MKT","Lincoln MKT Town Car","Lincoln MKX","Lincoln MKZ","Lincoln MKZ Hybrid","Lincoln Navigator","Lincoln Navigator L","Lincoln Town Car","Lincoln Zephyr","Lotus Elise","Lotus Esprit","Lotus Evora","Lotus Exige","Maserati Coupe","Maserati Ghibli","Maserati GranSport","Maserati GranTurismo","Maserati Quattroporte","Maserati Spyder","Maybach 57","Maybach 62","Mazda 323","Mazda 626","Mazda 929","Mazda B-Series Pickup","Mazda B-Series Truck","Mazda CX-5","Mazda CX-7","Mazda CX-9","Mazda GLC","Mazda MAZDA2","Mazda MAZDA3","Mazda MAZDA5","Mazda MAZDA6","Mazda MAZDASPEED MX-5","Mazda MAZDASPEED Protege","Mazda MAZDASPEED3","Mazda MAZDASPEED6","Mazda Millenia","Mazda MPV","Mazda MX-3","Mazda MX-5 Miata","Mazda MX-6","Mazda Navajo","Mazda Protege","Mazda Protege5","Mazda RX-7","Mazda RX-8","Mazda Tribute","Mazda Tribute Hybrid","Mazda Truck","McLaren 650S","McLaren 650S Coupe","McLaren 650S Spider","McLaren MP4-12C","McLaren MP4-12C Spider","McLaren P1","Mercedes-Benz 190-Class","Mercedes-Benz 240-Class","Mercedes-Benz 260-Class","Mercedes-Benz 280-Class","Mercedes-Benz 300-Class","Mercedes-Benz 350-Class","Mercedes-Benz 380-Class","Mercedes-Benz 400-Class","Mercedes-Benz 420-Class","Mercedes-Benz 500-Class","Mercedes-Benz 560-Class","Mercedes-Benz 600-Class","Mercedes-Benz B-Class","Mercedes-Benz C-Class","Mercedes-Benz CL-Class","Mercedes-Benz CLA-Class","Mercedes-Benz CLK-Class","Mercedes-Benz CLS-Class","Mercedes-Benz E-Class","Mercedes-Benz G-Class","Mercedes-Benz GL-Class","Mercedes-Benz GLA-Class","Mercedes-Benz GLK-Class","Mercedes-Benz M-Class","Mercedes-Benz R-Class","Mercedes-Benz S-Class","Mercedes-Benz SL-Class","Mercedes-Benz SLK-Class","Mercedes-Benz SLR-Class","Mercedes-Benz SLS-Class","Mercedes-Benz Sprinter","Mercedes-Benz Sprinter Cargo","Mercury Capri","Mercury Cougar","Mercury Grand Marquis","Mercury LN7","Mercury Lynx","Mercury Marauder","Mercury Mariner","Mercury Mariner Hybrid","Mercury Marquis","Mercury Milan","Mercury Milan Hybrid","Mercury Montego","Mercury Monterey","Mercury Mountaineer","Mercury Mystique","Mercury Sable","Mercury Topaz","Mercury Tracer","Mercury Villager","Mercury Zephyr","Merkur Scorpio","Merkur XR4Ti","MINI Clubman","MINI Convertible","MINI Cooper","MINI Cooper Clubman","MINI Cooper Convertible","MINI Cooper Countryman","MINI Cooper Coupe","MINI Cooper Hardtop","MINI Cooper Paceman","MINI Cooper Roadster","MINI Countryman","MINI Coupe","MINI Hardtop","MINI Mini E","MINI Paceman","MINI Roadster","Mitsubishi 3000GT","Mitsubishi Cordia","Mitsubishi Diamante","Mitsubishi Eclipse","Mitsubishi Eclipse Spyder","Mitsubishi Endeavor","Mitsubishi Expo","Mitsubishi Galant","Mitsubishi i-MiEV","Mitsubishi Lancer","Mitsubishi Lancer Evolution","Mitsubishi Lancer Sportback","Mitsubishi Mighty Max Pickup","Mitsubishi Mirage","Mitsubishi Montero","Mitsubishi Montero Sport","Mitsubishi Outlander","Mitsubishi Outlander Sport","Mitsubishi Precis","Mitsubishi Raider","Mitsubishi Sigma","Mitsubishi Starion","Mitsubishi Tredia","Mitsubishi Truck","Mitsubishi Vanwagon","Nissan 200SX","Nissan 240SX","Nissan 300ZX","Nissan 350Z","Nissan 370Z","Nissan Altima","Nissan Altima Hybrid","Nissan Armada","Nissan Axxess","Nissan cube","Nissan Frontier","Nissan GT-R","Nissan JUKE","Nissan LEAF","Nissan Maxima","Nissan Murano","Nissan Murano CrossCabriolet","Nissan NV Cargo","Nissan NV Passenger","Nissan NV200","Nissan NX","Nissan Pathfinder","Nissan Pathfinder Hybrid","Nissan Pickup","Nissan Pulsar","Nissan Quest","Nissan Rogue","Nissan Rogue Select","Nissan Sentra","Nissan Stanza","Nissan Titan","Nissan Truck","Nissan Van","Nissan Versa","Nissan Versa Note","Nissan Xterra","Oldsmobile Achieva","Oldsmobile Alero","Oldsmobile Aurora","Oldsmobile Bravada","Oldsmobile Ciera","Oldsmobile Custom Cruiser","Oldsmobile Cutlass","Oldsmobile Cutlass Calais","Oldsmobile Cutlass Ciera","Oldsmobile Cutlass Cruiser","Oldsmobile Cutlass Salon","Oldsmobile Cutlass Supreme","Oldsmobile Delta Eighty-Eight","Oldsmobile Delta Eighty-Eight Royale","Oldsmobile Eighty-Eight","Oldsmobile Eighty-Eight Royale","Oldsmobile Firenza","Oldsmobile Intrigue","Oldsmobile LSS","Oldsmobile Ninety-Eight","Oldsmobile Omega","Oldsmobile Regency","Oldsmobile Silhouette","Oldsmobile Toronado","Panoz Esperante","Peugeot 405","Plymouth Acclaim","Plymouth Arrow Pickup","Plymouth Breeze","Plymouth Caravelle","Plymouth Champ","Plymouth Colt","Plymouth Gran Fury","Plymouth Grand Voyager","Plymouth Horizon","Plymouth Laser","Plymouth Neon","Plymouth Prowler","Plymouth Reliant K","Plymouth Reliant K America","Plymouth Scamp","Plymouth Sundance","Plymouth TC3","Plymouth Trailduster","Plymouth Turismo","Plymouth Voyager","Plymouth Voyager Wagon","Pontiac 1000","Pontiac 2000","Pontiac 6000","Pontiac Aztek","Pontiac Bonneville","Pontiac Catalina","Pontiac Fiero","Pontiac Firebird","Pontiac G3","Pontiac G5","Pontiac G6","Pontiac G8","Pontiac Grand Am","Pontiac Grand Le Mans","Pontiac Grand Prix","Pontiac GTO","Pontiac Le Mans","Pontiac Montana","Pontiac Montana SV6","Pontiac Parisienne","Pontiac Phoenix","Pontiac Safari","Pontiac Solstice","Pontiac Sunbird","Pontiac Sunfire","Pontiac T1000","Pontiac Torrent","Pontiac Trans Sport","Pontiac Vibe","Porsche 911","Porsche 918 Spyder","Porsche 924","Porsche 928","Porsche 944","Porsche 968","Porsche Boxster","Porsche Carrera GT","Porsche Cayenne","Porsche Cayman","Porsche Cayman S","Porsche Macan","Porsche Panamera","Ram C/V","Ram Dakota","Ram Doblo Cargo","Ram Doblo Wagon","Ram ProMaster Cab Chassis","Ram ProMaster Cargo","Ram ProMaster Cutaway Chassis","Ram ProMaster Window","Ram Ram Chassis 3500","Ram Ram Chassis 4500","Ram Ram Pickup 1500","Ram Ram Pickup 2500","Ram Ram Pickup 3500","Renault 18i","Renault Fuego","Renault Le Car","Renault Sportwagon","Rolls-Royce Corniche","Rolls-Royce Ghost","Rolls-Royce Ghost Series II","Rolls-Royce Park Ward","Rolls-Royce Phantom","Rolls-Royce Phantom Coupe","Rolls-Royce Phantom Drophead Coupe","Rolls-Royce Silver Seraph","Rolls-Royce Wraith","Saab 9-2X","Saab 42250","Saab 9-3 Griffin","Saab 9-3X","Saab 9-4X","Saab 42252","Saab 9-7X","Saab 900","Saab 9000","Saturn Astra","Saturn Aura","Saturn Ion","Saturn Ion Red Line","Saturn L-Series","Saturn L300","Saturn Outlook","Saturn Relay","Saturn S-Series","Saturn SKY","Saturn Vue","Scion FR-S","Scion iQ","Scion iQ EV","Scion tC","Scion xA","Scion xB","Scion xD","Smart fortwo","SRT Viper","Sterling 825","Sterling 827","Subaru B9 Tribeca","Subaru Baja","Subaru Brat","Subaru BRZ","Subaru DL","Subaru Forester","Subaru GL","Subaru GL-10","Subaru GLF","Subaru Impreza","Subaru Justy","Subaru Legacy","Subaru Loyale","Subaru Outback","Subaru RX","Subaru Standard","Subaru SVX","Subaru Tribeca","Subaru WRX","Subaru XT","Subaru XV Crosstrek","Suzuki Aerio","Suzuki Equator","Suzuki Esteem","Suzuki Forenza","Suzuki Grand Vitara","Suzuki Kizashi","Suzuki Reno","Suzuki Samurai","Suzuki Sidekick","Suzuki Swift","Suzuki SX4","Suzuki SX4 Crossover","Suzuki SX4 Sport","Suzuki SX4 Sportback","Suzuki Verona","Suzuki Vitara","Suzuki X-90","Suzuki XL7","Tesla Model S","Tesla Roadster","Tesla Tesla Roadster","Toyota 4Runner","Toyota Avalon","Toyota Avalon Hybrid","Toyota Camry","Toyota Camry Hybrid","Toyota Camry Solara","Toyota Celica","Toyota Corolla","Toyota Corona","Toyota Cressida","Toyota ECHO","Toyota FJ Cruiser","Toyota Highlander","Toyota Highlander Hybrid","Toyota Land Cruiser","Toyota Matrix","Toyota MR2","Toyota MR2 Spyder","Toyota Paseo","Toyota Pickup","Toyota Previa","Toyota Prius","Toyota Prius c","Toyota Prius Plug-in Hybrid","Toyota Prius v","Toyota RAV4","Toyota RAV4 EV","Toyota Sequoia","Toyota Sienna","Toyota Starlet","Toyota Supra","Toyota T100","Toyota Tacoma","Toyota Tercel","Toyota Tundra","Toyota Van","Toyota Venza","Toyota Yaris","Undefined Undefined","Volkswagen Beetle","Volkswagen Cabrio","Volkswagen Cabriolet","Volkswagen CC","Volkswagen Corrado","Volkswagen Dasher","Volkswagen e-Golf","Volkswagen Eos","Volkswagen EuroVan","Volkswagen Fox","Volkswagen GLI","Volkswagen Golf","Volkswagen Golf GTI","Volkswagen Golf R","Volkswagen GTI","Volkswagen Jetta","Volkswagen New Beetle","Volkswagen Passat","Volkswagen Phaeton","Volkswagen Pickup","Volkswagen Quantum","Volkswagen R32","Volkswagen Rabbit","Volkswagen Routan","Volkswagen Scirocco","Volkswagen Tiguan","Volkswagen Touareg","Volkswagen Touareg 2","Volkswagen Vanagon","Volvo 240","Volvo 260","Volvo 740","Volvo 760","Volvo 780","Volvo 850","Volvo 940","Volvo 960","Volvo C30","Volvo C70","Volvo Coupe","Volvo S40","Volvo S60","Volvo S60 R","Volvo S70","Volvo S80","Volvo S90","Volvo V40","Volvo V50","Volvo V60","Volvo V70","Volvo V70 R","Volvo V90","Volvo XC","Volvo XC60","Volvo XC70","Volvo XC90","Yugo GV"];

jqNC(document).ready(function() {
	jqNC('.typeahead').typeahead({
		hint: true,
  		highlight: true,
  		minLength: 1
	},
	{
  		name: 'vehicleTypes',
  		displayKey: 'value',
  		source: substringMatcher(vehicleTypes)
	});
});