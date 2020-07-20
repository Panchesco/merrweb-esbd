# Spanish-English Bilingual Dictionary

This plugin creates a WordPress shortcode for adding a bilingual Spanish-English dictionary to a post or page. 
It uses the free Merriam-Webster API, so you'll need to [create a free account and request an API Key](https://www.dictionaryapi.com/).

## Installation

* Clone the project into your WP plugins folder with a name of merrweb-esbd.
* Or ownload the zip archive of the repo. Extract it into your WP plugins folder, and rename the unzipped file merrweb-esbd.

## Activation and Settings

* Activate the plugin on the WP plugins page.
* Follow the settings link to the plugin's settings page where you'll add your Merriam-Webster Spanish-English Dictionary API key. If you like, you can configure some short code messaging, button text and CSS selectors here.

## Usage

Add the shortcode ```[merrweb-spanish-english]``` to a page or post where you would like the dictionary.

Visitors to the post or page will see an input field to enter a word or phrase. When the user clicks the submit button, the input is passed to the Merriam-Webster API and a list of Spanish and English definitions are displayed. If no results are found, a list of suggestions is displayed.  

## Styling Results

Results and suggestions render as unordered lists that should pick up whatever styling is in place in your theme. You can style them by making use of some CSS selectors.


* All shortcode contents are wrapped in a div with an id of merrweb-esbd-wrapper and a class of merrweb-esbd.

### Results

* Results are wrapped in a div with class of ```show```. Each result is an unordered list with 3 items: The language of the result; the "Functional Label" of the result, such as noun, verb, adjective; a nested list of one or more translated short definitions.

#### Example

```
<div id="merrweb-esbd-wrapper" class="merrweb-esbd">
    <form>
        <div class="form-group">
            <input type="hidden" value="0a4c4f5b67">
            <input placeholder="Enter a word or phrase" type="text" name="q" id="q" class="form-control">
            <button type="submit" class="btn btn-primary">Define</button>
        </div>
    </form>
    <div class="show">
        <p>We found <span class="total-results">2</span> definitions for <span class="search-query">tambor</span>.</p>
        <ul>
            <li class="lang">Spanish</li>
            <li class="fl">masculine noun</li>
            <li class="shortdef">
                <ul>
                    <li>drum</li>
                </ul>
            </li>
        </ul>
         <ul>
            <li class="lang">Spanish</li>
            <li class="fl">masculine noun</li>
            <li class="shortdef">
                <ul>
                    <li>mondadientes : toothpick</li>
                    <li>drumstick</li>
                    <li>chopsticks</li>
                </ul>
            </li>
        </ul>
    </div>
```




