Benflix
======

Beautify your movie collection with a Netflix-like, one-file index page.

![Main page](https://i.imgur.com/IrJKTRa.jpg)

![Details of a movie](https://i.imgur.com/oEVizwp.png)

Description
-----------

Benflix is a simple way to browse your collection of movie files. It was conceived with simplicity in mind: simple to install, simple to use. It generates a Netflix-like page of all your movies on-the-fly.

**Key features** include:
 - Sort your collection by movie title, release date, acquisition date.
 - Filter your collection by genre, IMDb rating and runtime.
 - Search through your collection using Ctrl+F.
 - View the main properties of a movie: poster, cast, runtime, genre, IMDb score, etc.
 - Quickly access the IMDb page of a movie.
 - Quickly watch the trailer of a movie on YouTube.
 - Download the file from the server that hosts your collection.

Features do **NOT** include:
 - Download any movie: you have to have obtained the video file first!
 - Browse your TV show collection: only movies are supported (for now at least...).
 - Filter your collection by video or sound quality.
 - Administration: there are no settings to set, except the UI language (at the very top of the file).

Requirements
---------------

To **install**, Benflix requires:
* PHP with the cURL extension enabled.
* The video files must be named with the official English title that can be found on IMDb.
* A free API key for the [OMDb API](http://www.omdbapi.com/).

To **use**, Benflix requires:
* Access to the Internet.
* Javascript enabled in the browser.

Installation
------------------

Get a free API key from [this page](http://www.omdbapi.com/apikey.aspx): it will be sent to your email, you then have to put it on line 8 of the file.

Just put the `index.php` file in the folder containing all your video files. That's it!

Configuration
------------------

You can change the language of the UI at the very beginning of the file, where the `LANGUAGE` constant is being set. There has to be a subarray corresponding to your language in the `$i18n` array though. More languages will be added with time (feel free to contribute to it!).

How does it work ?
------------------

The script fetches the properties of your movies from the [Open Movie Database API](http://www.omdbapi.com/).

The styling of the page relies on [Bootstrap](http://getbootstrap.com/) and [jQuery](https://jquery.com/).

Contribution
-------

Contributions are welcome, especially code optimizations and new features. Please keep simplicity in mind!

License
-------

Feel free to share or remix Benflix! Keep my name and a link to this page though.

[Creative Commons - Attribution-NonCommercial-ShareAlike 4.0 International](https://creativecommons.org/licenses/by-nc-sa/4.0/).