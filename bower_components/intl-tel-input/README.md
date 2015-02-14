# International Telephone Input [![Build Status](https://travis-ci.org/Bluefieldscom/intl-tel-input.png)](https://travis-ci.org/Bluefieldscom/intl-tel-input)
A jQuery plugin for entering and validating international telephone numbers. It adds a flag dropdown to any input, which lists all the countries and their international dial codes next to their flags.

![alt tag](https://raw.github.com/Bluefieldscom/intl-tel-input/master/screenshot.png)


## Table of Contents

- [Demo and Examples](#demo-and-examples)
- [Features](#features)
- [Browser Compatibility](#browser-compatibility)
- [Getting Started](#getting-started)
- [Options](#options)
- [Public Methods](#public-methods)
- [Static Methods](#static-methods)
- [Utilities Script](#utilities-script)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [Attributions](#attributions)


## Demo and Examples
You can view a live demo and some examples of how to use the various options here: http://jackocnr.com/intl-tel-input.html, or try it for yourself using the included demo.html.


## Features
* Automatically format the number as the user types
* Automatically set the input placeholder to an example number for the selected country
* Navigate the country dropdown by typing a country's name, or using up/down keys
* Selecting a country from the dropdown will update the dial code in the input
* Typing a different dial code will automatically update the displayed flag
* Dropdown appears above or below the input depending on available space/scroll position
* Lots of initialisation options for customisation, as well as public methods for interaction


## Browser Compatibility
|            | Chrome | Firefox | Safari | IE  | Chrome for Android | Mobile Safari | IE Mobile |
| :--------- | :----: | :-----: | :----: | :-: | :----------------: | :-----------: | :-------: |
| Core       |    ✓   |    ✓    |    ✓   |  8  |          ✓         |       ✓       |     ✓     |
| autoFormat |    ✓   |    ✓    |    ✓   |  8  |          ✓         |       ✓       |     [✗](https://github.com/Bluefieldscom/intl-tel-input/issues/68)     |



## Getting Started
1. Download the [latest version](https://github.com/Bluefieldscom/intl-tel-input/archive/master.zip), or better yet install it with [Bower](http://bower.io): `bower install intl-tel-input`

2. Link the stylesheet (note that this references the included image flags.png)
  ```html
  <link rel="stylesheet" href="build/css/intlTelInput.css">
  ```

3. Add the plugin script and initialise it on your input element
  ```html
  <input type="tel" id="mobile-number">
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="build/js/intlTelInput.min.js"></script>
  <script>
    $("#mobile-number").intlTelInput();
  </script>
  ```
  
4. **Recommended:** initialise the plugin with the `utilsScript` option to enable formatting/validation, and to allow you to extract full international numbers using `getNumber`.


## Options
Note: any options that take country codes should be lower case [ISO 3166-1 alpha-2](http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) codes  

**autoFormat**  
Type: `Boolean` Default: `true`  
Format the number on each keypress according to the country-specific formatting rules. This will also prevent the user from entering invalid characters (triggering a red flash in the input - see [Troubleshooting](#troubleshooting) to customise this). Requires the `utilsScript` option.

**autoPlaceholder**  
Type: `Boolean` Default: `true`  
Add or remove input placeholder with an example number for the selected country. Requires the `utilsScript` option.

**autoHideDialCode**  
Type: `Boolean` Default: `true`  
If there is just a dial code in the input: remove it on blur, and re-add it on focus. This is to prevent just a dial code getting submitted with the form.

**defaultCountry**  
Type: `String` Default: `""`  
Set the default country by it's country code. You can also set it to `"auto"`, which will lookup the user's country based on their IP address - [see example](http://jackocnr.com/lib/intl-tel-input/examples/gen/default-country-ip.html). Otherwise it will just be the first country in the list.

**ipinfoToken**  
Type: `String` Default: `""`  
When setting `defaultCountry` to `"auto"`, we use a service called [ipinfo](http://ipinfo.io) which requires a special token to be used over https, or if you make >1000 requests/day. Use this option to pass in that token.

**nationalMode**  
Type: `Boolean` Default: `true`  
Allow users to enter national numbers (and not have to think about international dial codes). Formatting, validation and placeholders still work. Then you can use `getNumber` to extract a full international number - [see example](http://jackocnr.com/lib/intl-tel-input/examples/gen/national-mode.html).

**numberType**  
Type: `String` Default: `""`  
Specify one of the keys from the global enum `intlTelInputUtils.numberType` e.g. `"MOBILE"` to tell the plugin you're expecting that type of number. Currently this is only used to set the placeholder to the right type of number.

**onlyCountries**  
Type: `Array` Default: `undefined`  
Display only the countries you specify - [see example](http://jackocnr.com/lib/intl-tel-input/examples/gen/only-countries-europe.html).

**preferredCountries**  
Type: `Array` Default: `["us", "gb"]`  
Specify the countries to appear at the top of the list.

**utilsScript**  
Type: `String` Default: `""` Example: `"lib/libphonenumber/build/utils.js"`  
Enable formatting/validation etc. by specifying the path to the included utils.js script, which is fetched only when the page has finished loading (on window.load) to prevent blocking. See [Utilities Script](#utilities-script) for more information. _Note that if you're lazy loading the plugin script itself (intlTelInput.js) this will not work and you will need to use the `loadUtils` method instead._


## Public Methods
**destroy**  
Remove the plugin from the input, and unbind any event listeners.  
```js
$("#mobile-number").intlTelInput("destroy");
```

**getNumber**  
Get the current number formatted to the given type (defaults to [E.164 standard](http://en.wikipedia.org/wiki/E.164)). The different formatting types are available in the enum `intlTelInputUtils.numberFormat` - taken from [here](https://github.com/googlei18n/libphonenumber/blob/master/javascript/i18n/phonenumbers/phonenumberutil.js#L883). Requires the `utilsScript` option. _Note that even if `nationalMode` is enabled, this can still return a full international number._  
```js
var intlNumber = $("#mobile-number").intlTelInput("getNumber");
// or
var ntlNumber = $("#mobile-number").intlTelInput("getNumber", intlTelInputUtils.numberFormat.NATIONAL);
```
Returns a string e.g. `"+17024181234"`

**getNumberType**  
Get the type (fixed-line/mobile/toll-free etc) of the current number. Requires the `utilsScript` option.  
```js
var numberType = $("#mobile-number").intlTelInput("getNumberType");
```
Returns an integer, which you can match against the [various options](https://code.google.com/p/libphonenumber/source/browse/trunk/javascript/i18n/phonenumbers/phonenumberutil.js#891) in the global enum `intlTelInputUtils.numberType` e.g.  
```js
if (numberType == intlTelInputUtils.numberType.MOBILE) {
    // is a mobile number
}
```
_Note that in the US there's no way to differentiate between fixed-line and mobile numbers, so instead it will return `FIXED_LINE_OR_MOBILE`._

**getSelectedCountryData**  
Get the country data for the currently selected flag.  
```js
var countryData = $("#mobile-number").intlTelInput("getSelectedCountryData");
```
Returns something like this:
```js
{
  name: "Afghanistan (‫افغانستان‬‎)",
  iso2: "af",
  dialCode: "93"
}
```

**getValidationError**  
Get more information about a validation error. Requires the `utilsScript` option.  
```js
var error = $("#mobile-number").intlTelInput("getValidationError");
```
Returns an integer, which you can match against the [various options](https://github.com/Bluefieldscom/intl-tel-input/blob/master/lib/libphonenumber/src/utils.js#L175) in the global enum `intlTelInputUtils.validationError` e.g.  
```js
if (error == intlTelInputUtils.validationError.TOO_SHORT) {
    // the number is too short
}
```

**isValidNumber**  
Validate the current number - [see example](http://jackocnr.com/lib/intl-tel-input/examples/gen/is-valid-number.html). Expects an internationally formatted number (unless `nationalMode` is enabled). If validation fails, you can use `getValidationError` to get more information. Requires the `utilsScript` option. Also see `getNumberType` if you want to make sure the user enters a certain type of number e.g. a mobile number.  
```js
var isValid = $("#mobile-number").intlTelInput("isValidNumber");
```
Returns: true/false

**loadUtils**  
_Note: this is only needed if you're lazy loading the plugin script itself (intlTelInput.js). If not then just use the `utilsScript` option._  
Load the utils.js script (included in the lib directory) to enable formatting/validation etc. See [Utilities Script](#utilities-script) for more information.
```js
$("#mobile-number").intlTelInput("loadUtils", "lib/libphonenumber/build/utils.js");
```

**selectCountry**  
Change the country selection (e.g. when the user is entering their address).  
```js
$("#mobile-number").intlTelInput("selectCountry", "gb");
```

**setNumber**  
Insert a number, and update the selected flag accordingly.  
```js
$("#mobile-number").intlTelInput("setNumber", "+44 7733 123 456");
```


## Static Methods
**getCountryData**  
Get all of the plugin's country data - either to re-use elsewhere e.g. to populate a country dropdown - [see example](http://jackocnr.com/lib/intl-tel-input/examples/gen/country-sync.html), or to modify - [see example](http://jackocnr.com/lib/intl-tel-input/examples/gen/modify-country-data.html). Note that any modifications must be done before initialising the plugin.  
```js
var countryData = $.fn.intlTelInput.getCountryData();
```
Returns an array of country objects:
```js
[{
  name: "Afghanistan (‫افغانستان‬‎)",
  iso2: "af",
  dialCode: "93"
}, ...]
```


## Utilities Script
A custom build of Google's [libphonenumber](http://libphonenumber.googlecode.com) which enables the following features:

* As-you-type formatting with `autoFormat` option, which prevents you from entering invalid characters
* Validation with `isValidNumber`, `getNumberType` and `getValidationError` methods
* Placeholder set to an example number for the selected country - even specify the type of number (e.g. mobile) using the `numberType` option
* Extract the standardised (E.164) international number with `getNumber` even when using the `nationalMode` option

International number formatting/validation is hard (it varies by country/district, and we currently support ~230 countries). The only comprehensive solution I have found is libphonenumber, which I have precompiled into a single JavaScript file and included in the lib directory. Unfortunately even after minification it is still ~215KB, but if you use the `utilsScript` option then it will only fetch the script when the page has finished loading (to prevent blocking).


## Troubleshooting
**Image path**  
Depending on your project setup, you may need to override the path to flags.png in your CSS.  
```css
.iti-flag {background-image: url("path/to/flags.png");}
```

**Customise invalid key flash**  
Set the colour like this (or set to `none` to disable):  
```css
.intl-tel-input input.iti-invalid-key {background-color: #FFC7C7;}
```

**Full width input**  
If you want your input to be full-width, you need to set the container to be the same i.e.
```css
.intl-tel-input {width: 100%;}
```

**Input margin**  
For the sake of alignment, the default CSS forces the input's vertical margin to `0px`. If you want vertical margin, you should add it to the container (with class `intl-tel-input`).

**Displaying error messages**  
If your error handling code inserts an error message before the `<input>` it will break the layout. Instead you must insert it before the container (with class `intl-tel-input`).

**Dropdown position**  
The dropdown should automatically appear above/below the input depending on the available space. For this to work properly, you must only initialise the plugin after the `<input>` has been added to the DOM.

**Placeholders**  
In order to get the automatic country-specific placeholders, simply omit the placeholder attribute on the `<input>`.


## Contributing
I'm very open to contributions, big and small! For instructions on contributing to a project on Github, see this guide: [Fork A Repo](https://help.github.com/articles/fork-a-repo).

I use [Grunt](http://gruntjs.com) to build the project, which relies on [npm](https://www.npmjs.org). In the project directory, run `npm install` to install Grunt etc, then `grunt bower` to install other dependencies, then make your changes in the `src` directory and run `grunt build` to build the project.


## Attributions
* Flag images and CSS from [Flag Sprites](http://flag-sprites.com) (which uses [FamFamFam](https://github.com/tkrotoff/famfamfam_flags))
* Original country data from mledoze's [World countries in JSON, CSV and XML](https://github.com/mledoze/countries)
* Formatting/validation/example number code from [libphonenumber](http://libphonenumber.googlecode.com)
* Lookup user's country using [ipinfo.io](http://ipinfo.io)
* Feature contributions are listed in the wiki: [Contributions](https://github.com/Bluefieldscom/intl-tel-input/wiki/Contributions)
* List of [sites using intl-tel-input](https://github.com/Bluefieldscom/intl-tel-input/wiki/Sites-using-intl-tel-input)