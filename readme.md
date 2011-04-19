grabbio PHP SDK
==============
The [grabbio platform](http://grabb.io) is an API that allows you to generate
video thumbnails in a variety of styles.

Installation
------------
Simply require [grabbio.php][grabbio_src] into your application and you are
then ready to use.

[grabbio_src]: https://github.com/Gazler/grabbio-php/blob/master/src/grabbio.php

Usage
-----

###Basic

In its most basic form, the only required parameters are source, upload_url and
your api keys.

    $Grabbio = new Grabbio(YOUR_API_KEY, YOUR_API_SECRET);
    $Grabbio->source(URL_TO_YOUR_VIDEO);
    $Grabbio->uploadUrl(URL_TO_UPLOAD_TO);
    $Grabbio->grab();

This SDK allows chaining, so the above could be rewritten as:

    $Grabbio = new Grabbio(YOUR_API_KEY, YOUR_API_SECRET);
    $Grabbio->source(URL_TO_YOUR_VIDEO)->uploadUrl(URL_TO_UPLOAD_TO)->grab();

This SDK also takes advantages of grabbio defaults, so the above could be rewritten
as:

    $Grabbio = new Grabbio(YOUR_API_KEY, YOUR_API_SECRET);
    $Grabbio->grab(URL_TO_YOUR_VIDEO, URL_TO_UPLOAD_TO);


###Advanced

All the parameters in the [grabbio documentation](http://grabb.io/documentation)
are supported.  Here are a few examples:

####320x240 Gif, Capsheet and Individual uploaded to an S3 bucket in developer mode
    $Grabbio = new Grabbio(YOUR_API_KEY, YOUR_API_SECRET);
    $Grabbio->developerMode();
    $Grabbio->createGif(30);
    $Grabbio->createCapsheet(3, false, true);
    $Grabbio->createIndividual();
    $Grabbio->grab("http://test.com/example.wmv", "s3://example_bucket",320, 240);


####180x240 Capsheet uploaded to FTP with a callback
    $Grabbio = new Grabbio(YOUR_API_KEY, YOUR_API_SECRET);
    $Grabbio->createCapsheet(3);
    $Grabbio->callback("http://test.com/grabbio_callback.php");
    $Grabbio->grab("http://test.com/example.wmv", "ftp://example:password@test.com",180, 240);


Example Thumbnails
------------------
###Individual
![Individual Thumbnail](http://grabb.io/images/individual_example_0.jpg)
![Individual Thumbnail](http://grabb.io/images/individual_example_1.jpg)
![Individual Thumbnail](http://grabb.io/images/individual_example_2.jpg)
![Individual Thumbnail](http://grabb.io/images/individual_example_3.jpg)
![Individual Thumbnail](http://grabb.io/images/individual_example_4.jpg)
![Individual Thumbnail](http://grabb.io/images/individual_example_5.jpg)

###Gif
![GIF](http://grabb.io/images/gif_example.gif)

###Capsheet
![Capsheet Example](http://grabb.io/images/capsheet_example.jpg)

