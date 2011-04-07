<?php
    require '../src/grabbio.php';
	$grabbio = new Grabbio(YOUR_API_KEY, YOUR_API_SECRET);
	$grabbio->width(200);
    $grabbio->developerMode()->height(90)->createGif()->gifFramerate(30);
    $grabbio->createCapsheet(3, false, true)->createIndividual()->grab("http://test.com");


    $grabbio2 = new Grabbio(YOUR API KEY, YOUR API SECRET);
    $grabbio2->developerMode();
    $grabbio2->width(100);
    $grabbio2->height(90);
    $grabbio2->createGif(50);
    $grabbio2->createIndividual();
    $grabbio2->createCapsheet(3, false, true);
    var_dump($grabbio2->grab("http://tst.com", "http://tss.com"));

