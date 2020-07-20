# Spanish-English Bilingual Dictionary

This plugin creates a WordPress shortcode for adding a bilingual Spanish-English dictionary to a post or page. 
It uses the free Merriam-Webster API, so you'll need to [create a free account and request an API Key](https://www.dictionaryapi.com/).

## Installation

* Clone the project into your WP plugins folder with a name of merrweb-esbd.
* Or ownload the zip archive of the repo. Extract it into your WP plugins folder, and rename the unzipped file merrweb-esbd.

## Activation and Settings

* Activate the plugin on the WP plugins page.
* Follow the settings link to the plugin's settings page where you'll add your Merriam-Webster Spanish-English Dictionary API key. If you like, you can configure some short code messaging, button text and CSS selectors there.

## Usage

Add the shortcode ```[merrweb-spanish-english]``` to a page or post where you would like the dictionary.

Visitors to the post or page will see an input field to enter a word or phrase. When the user clicks the submit button, the input is passed to the Merriam-Webster API and a list of Spanish and English definitions are displayed. If no results are found, a list of clickable suggestions is displayed.  

## Styling 

Results and suggestions render as unordered lists that should pick up your active theme's styles. You can further style them in your CSS with some selectors.

* All shortcode contents are wrapped in a div with an id of merrweb-esbd-wrapper and a class of merrweb-esbd.

### Results

* Results are wrapped in a div with class of ```show```. Each result is an unordered list with 3 items: The language label of the result; the functional label of the result (noun, verb, adjective, etc.); and a nested list of one or more translated short definitions.

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

### Suggestions

When no results are found, the shortcode displays a list of clickable suggestions rendered as a list.

#### Example 

```
<div id="merrweb-esbd-wrapper" class="merrweb-esbd">
    <form>
        <div class="form-group">
                <input placeholder="Enter a word or phrase" type="text" name="q" id="q" class="form-control">
                <button type="submit" class="btn btn-primary">Define</button>
        </div>
    </form>
    <div class="show">
        <p>Nothing found for <span class="search-query">tandori</span>. Some suggestions:</p>
        <ul class="suggestions">
            <li><a href="#">candor</a></li>
            <li><a href="#">candor</a></li>
            <li><a href="#">standard</a></li>
            <li><a href="#">candors</a></li>
            <li><a href="#">andorra</a></li>
            <li><a href="#">tango</a></li>
            <li><a href="#">tanda</a></li>
            <li><a href="#">tanto</a></li>
            <li><a href="#">tango</a></li>
        </ul>
    </ul>
</div>
```

### Spinner

The shortcode includes a default spinner that overlays the page while fetching results from the API. You can disable it by changing the loading element ID value in the plugin settings. It is visible if the 

Additionally, whenever an AJAX request to the API is being made, the ```window.merrweb_esbd.isLoading``` property is set to the value of the Loading Element Class setting. If you're customizing things with your own spinner, you can have it check that property for your loading class name.

### Branding 

Plugin results and suggestions display a footer with Merriam-Webster's required branding. See the [API FAQ](https://www.dictionaryapi.com/info/frequently-asked-questions) for more info.






