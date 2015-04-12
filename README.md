# KirbyText Extension - Code

*Version:* 1.1

Don't mess up your content files with huge code blocks! This plugin let's you specify code files which will get embedded into code blocks within your content when rendering your page.

## Options

* *lang*: (optional) Code language description
* *caption*: (optional) Caption for the code block
* *caption_top*: (optional, Values: true/false, Default: true) Place the caption at the top of the code block
* *caption_class*: (optional) Class string for the figure element

## Examples

### Code with language description

```
(code: code.html lang: html)
```

### Code with caption

```
(code: code.html lang: html caption: HTML)
```

## Changelog

### v1.2

* Add different CSS class to `figcaption` for caption on the top or bottom

### Version 1.1 

* Feature: Add namespace to the core class, for better difference with other classes and plugins
* Feature: Add custom config parameter "kirby.extension.code.default_lang", default value is "false", possible values are "false" or a language string.
* Feature: Add custom config parameter "kirby.extemsion.code.default_caption", default value is "false", possible values are "false", "{filebasename}", "{filename}", "{filedescription}" or a custom text

### Version 1.0

* Intial release with complete rebuild code