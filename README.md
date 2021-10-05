

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
 - Administration: there are only a few settings to set, and they are grouped at the top of the file.

Requirements
---------------

To **install**, Benflix requires:
* PHP with the cURL extension enabled.
* The video files must be named with the official English title that can be found on IMDb.
* A free API key for the [OMDb API](https://www.omdbapi.com/ "Visit the API's website").

To **use**, Benflix requires:
* Access to the Internet.
* Javascript enabled in the browser.

Installation
------------------

Get a free API key from [this page](https://www.omdbapi.com/apikey.aspx): it will be sent to your email, and you then have to put it on line 8 of `index.php`.

Then, just put the `index.php` file in the folder containing all your video files. That's it!

Configuration
------------------

You can change the language of the UI at the very beginning of the file, where the `LANGUAGE` constant is being set. There has to be a sub-array corresponding to your language in the `$i18n` array though. More languages will be added with time (feel free to contribute to it!).

You can also set some options if you want, like the page title, the movies default ordering, and the "recently added" functionality.

Local database mode
------------------

Instead of performing an API call for every movie each time the page is loaded (which is obviously time and resource consuming), a local database mode has been added. Benflix now checks if the database is available when the page is launched in a browser, and if so, only calls the API when the movie is not already listed within the database.

The database is a simple JSON file. It stores approximately 500 bytes of data per movie, so it remains lightweight even for a collection of a few hundreds movies.

There are two ways of updating this database file in order to query the API for newly-added movies:
 - From the web: `index.php?updateLocalDatabase=true` (followed by optional `&verbose=true` parameter)
 - From the CLI (perfect for a cron task): `index.php updateLocalDatabase` (followed by optional `verbose` parameter)

If the file ownership and permissions are appropriate, the update process will automatically attempt to create the database file, named `benflix.json` per default. To manually instantiate this file, you can create it in the same folder as Benflix. Don't forget to set the file ownership to the one of the web server user (usually `www-data`), as well as proper write permissions so it can be edited by this user.

It is also possible to purge the current database before updating it. In that case, the database file is emptied and then fully reconstructed using API calls.

By default, for security reasons, the purge can only be done when updating from CLI, using the optional `purge` parameter. If you want to enable purge via web browser, set the `ALLOW_PURGE_FROM_WEB` constant to `true` at the beginning of the file. Be aware that this can obviously be easily abused to take up resources.

How does it work ?
------------------

The script fetches the properties of your movies from the [Open Movie Database API](http://www.omdbapi.com/).

The styling of the page relies on [Bootstrap](http://getbootstrap.com/) and [jQuery](https://jquery.com/).

Contribution
-------

Contributions are welcome, especially code optimizations and new features. Please keep simplicity in mind!

If you like Benflix, please considering to the creator of the OMDb API via [Patreon](https://www.patreon.com/omdb "Donate via OMDb") or [PayPal](https://www.paypal.com/paypalme/FritzAPI "Donate via PayPal").

License
-------

Feel free to share or remix Benflix! Keep my name and a link to this page though.

[Creative Commons - Attribution-NonCommercial-ShareAlike 4.0 International](https://creativecommons.org/licenses/by-nc-sa/4.0/).
