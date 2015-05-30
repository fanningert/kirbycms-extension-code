# v1.5.2

* Add plugin at the first position of the array `pre` and at the last position of array `post`. This is a workaround to make it possible to ignore the kirbytags and markdowns inner the code block.
* Function to deactivate/activate parse content of code block with markdown and kirbytag

# v1.5.1

* Add option to activate and deactivate the parsing of the code content
* Add some kirby config parameters to set some default values.

# v1.5

* Changed project structure for easy integrate into projects (git submodules)
* Add Requirement `kirbycms-extension-webhelper`
* Support for inline source code

# v1.3
 
* Change name from `Code` to `CodeExt` (also the class name is changed to `CodeExt`)
* Code cleanup

# v1.2

* Add different CSS class to `figcaption` for caption on the top or bottom
* Changed option `class` to `caption_class`

# v1.1 

* Feature: Add namespace to the core class, for better difference with other classes and plugins
* Feature: Add custom config parameter "kirby.extension.code.default_lang", default value is "false", possible values are "false" or a language string.
* Feature: Add custom config parameter "kirby.extemsion.code.default_caption", default value is "false", possible values are "false", "{filebasename}", "{filename}", "{filedescription}" or a custom text

# v1.0

* Intial release with complete rebuild code