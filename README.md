# KirbyText Extension - CodeExt

Don't mess up your content files with huge code blocks! This plugin let's you specify code files which will get embedded into code blocks within your content when rendering your page.

## Requirements

* [Kirby Extension - WebHelper](https://github.com/fanningert/kirbycms-extension-webhelper)

## Installation

### GIT

Go into the `{kirby_installation}/site/plugins` directory and execute following command.

```bash
$ git clone https://github.com/fanningert/kirbycms-extension-webhelper.git
$ git clone https://github.com/fanningert/kirbycms-extension-code.git
```

### GIT submodule

Go in the root directory of your git repository and execute following command to add the repository as submodule to your GIT repository.

```bash
$ git submodule add https://github.com/fanningert/kirbycms-extension-webhelper.git ./site/plugins/kirbycms-extension-webhelper
$ git submodule add https://github.com/fanningert/kirbycms-extension-code.git ./site/plugins/kirbycms-extension-code
$ git submodule init
$ git submodule update
```

### Manuell

## Update

### GIT

Go into the `{kirby_installation}/site/plugins/kirbycms-extension-code` directory and execute following command.

```bash
$ git pull
```
Don't forget to update the requirement `kirbycms-extension-webhelper`.

### GIT submodule

Go in the root directory of your git repository and execute following command to update the submodule of this extension.

```bash
$ git submodule update
```

## Documentation

### Kirby configuration values

| Kirby option | Default | Values | Description |
| ------------ | ------- | ------ | ----------- |
| `kirby.extension.codeext.lang` | false | false/{string} | Default code language |
| `kirby.extension.codeext.caption_top` | true | true/false | Place the caption at the top of the code block |
| `kirby.extension.codeext.caption_class` | 'code' | {string} | Class string for the figure element |
| `kirby.extension.codeext.parse` | false | true/false | Parse the code with kirbytag and markdown |

### KirbyTag attributes

| Option | Default | Values | Description |
| ------ | ------- | ------ | ----------- |
| lang |  | false/{string} | see `kirby.extension.codeext.lang` |
| caption | false | false/{string} | Caption of the code block |
| caption_top | `none` | {string} | see `kirby.extension.codeext.caption_top` |
| caption_class |  | {string} | see `kirby.extension.codeext.caption_class` |
| parse |  | true/false | see `kirby.extension.codeext.parse` |

## Examples

### Code with language description

```
(code: code.html lang: html)
```

### Code with caption

```
(code: code.html lang: html caption: HTML)
```

### Code with included source code

```
(code lang: html caption: HTML)
<html>
  <head>
    <title>test</title>
  </head>
  <body>
    Text
  </body>
</html>
(/code)
```