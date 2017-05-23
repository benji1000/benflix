Benflix
======

Beautify your movie collection with a Netflix-like, one-file index page.

![Main page](https://pbs.twimg.com/media/C6f7qySWUAE89bT.png)

![Details of a movie](https://pbs.twimg.com/media/C6f7qyfWQAE1dmt.png)

Description
-----------

Benflix is a simple way to browse your collection of movie files. It was conceived with simplicity in mind: simple to install, simple to use. It generates a Netflix-like page of all your movies on-the-fly.

**Key features** include:
 - Filter your collection by genre, IMDb rating and runtime.
 - Search through your collection using Ctrl+F.
 - View the main properties of a movie: poster, cast, runtime, genre, IMDb score, etc.
 - Quickly access the IMDb page of a movie.
 - Quickly watch the trailer of a movie on YouTube.
 - Download the file from the server that hosts your collection.

Features do **NOT** include:
 - Download any movie that you want: you have to have obtained the video files first!
 - Browse your TV show collection: only movies are supported (for now at least...).
 - Filter your collection by video or sound quality.
 - Administration: there are no settings to set, except the UI language (at the very top of the file).

Requirements
---------------

To **install**, Benflix requires:
* PHP with the cURL extension enabled.
* The video files must be named with the official English title that can be found on IMDb.

To **use**, Benflix requires:
* Access to the Internet.
* Javascript enabled in the browser.
* An API key for the [OMDb API](http://www.omdbapi.com/).

The API key requirement is new and a bit annoying, but it is required to make Benflix work. I would be happy to add the support for a free API (if such a thing exists and is reliable...), but in the meantime, you have to get an API key. I am not the creator of the OMDb API.

Installation
------------------

[Support the OMDb project on Patreon](https://www.patreon.com/omdb/), and then claim your API key from [this page](http://www.omdbapi.com/apikey.aspx). Please note that you just need the basic API access, and not the poster API.

Your API key will be sent to your email, you then have to place it on line 8 of the file.

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